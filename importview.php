<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

defined('MOODLE_INTERNAL') || die();

require('../../../config.php');

global $OUTPUT, $PAGE;

$context = context_system::instance();
require_login();

// TODO define some new capability require_capability('define some capability', $context);.

$url = new moodle_url('/admin/tool/mcds/importview.php');
$PAGE->set_url($url);
$PAGE->set_context($context);
$PAGE->set_title(get_string('importview', 'tool_mcds'));
$PAGE->set_heading(get_string('importview', 'tool_mcds'));
$PAGE->set_pagelayout('admin');

echo $OUTPUT->header();

$ws    = new \tool_mcds\service_call();
$mform = new \tool_mcds\courselist_form(null, ['courses' => $ws->list_all_courses()]);

if (!compare_version($version = json_decode($ws->connect_to_server()))) {
    print_error('required version:', 'error', '', $version); // TODO use moodle_exception instead.
} else if ($mform->is_cancelled()) {
    redirect($url);
} else if ($mform->is_submitted()) {
    $data   = $mform->get_data();
    $import = [];
    foreach ($data as $id => $checked) {
        if ($id == "submitbutton") {
            continue;
        }
        if ($checked == 1) {
            $import[] = $id;
        }
    }
    $courses = json_decode($ws->import_courses($import));

    foreach ($courses as $course) {
        $file = json_decode($ws->download_file($course[0]->pathnamehash)); // TODO why is there an array?

        $context = context_system::instance();
        $fs = get_file_storage();
        $filerecord = array(
            'contextid'     => $context->id,
            'component'     => 'mcds',
            'filearea'      => 'backup',
            'itemid'        => 0,
            'filepath'      => '/',
            'filename'      => $file->filename,
            'timecreated'   => time(),
            'timemodified'  => time()
        );

        $storedfile = $fs->create_file_from_string($filerecord, base64_decode($file->filecontent));
        $restoreurl = new moodle_url("/backup/restore.php?contextid=" . $storedfile->get_contextid() .
                               "&pathnamehash=" . $storedfile->get_pathnamehash() .
                               "&contenthash="  . $storedfile->get_contenthash()
                       );
        redirect($restoreurl);
    }
    // TODO import courses.
} else if (isset($_POST['listcoursesbutton'])) {
    $mform->display();
} else {
    ?>
    <div>
        <form action="<?php echo $url ?>" method="post">
            <input type="submit" value="List all courses" name="listcoursesbutton" class="btn"></input>
        </form>
    </div>

    <?php
}

echo $OUTPUT->footer();

function compare_version($server) {
    $own = new \tool_mcds\version_information();
    // TODO implement a useful version control.
    $bool = true;

    return $bool;
}
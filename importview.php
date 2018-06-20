<?php

require('../../../config.php');

global $OUTPUT, $PAGE;

$context = context_system::instance();
require_login();
//TODO require_capability('define some capability', $context);

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
    print_error('required version:', 'error', '', $version);//TODO
} else if ($mform->is_cancelled()) {
    redirect($url);
} else if ($mform->is_submitted()) {
    $data = $mform->get_data();
    $import = [];
    foreach ($data as $id => $checked) {
        if($id == "submitbutton") continue;
        if($checked == 1) $import[] = $id;
    }
    $courses = $ws->import_courses($import);
    //TODO import courses
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

function compare_version($server)
{
    $own = new \tool_mcds\version_information();
    //TODO implement a usefull version control
    $bool = true;

    return $bool;
}
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

/**
 * Created by PhpStorm.
 * User: ewappis
 * Date: 6/19/18
 * Time: 4:17 PM
 */

namespace tool_mcds;

defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir.'/clilib.php');
require_once($CFG->dirroot . '/backup/util/includes/backup_includes.php');

class mcds_file {

    public function devliver_course($courseid) {

        $course = $this->check_courses_exitst($courseid);
        $hashes = $this->create_mbzfile($course);

        return $hashes;

    }

    private function check_courses_exitst($courseid) {
        global $DB;

        $course = $DB->get_record('course', array('id' => $courseid), '*', MUST_EXIST);

        return $course;

    }

    private function create_mbzfile ($course) {

        $admin = get_admin();
        if (!$admin) {
            mtrace("Error: No admin account was found");
            die;
        }

        $bc = new \backup_controller(backup::TYPE_1COURSE, $course->id, backup::FORMAT_MOODLE,
            backup::INTERACTIVE_YES, backup::MODE_GENERAL, $admin->id);

        $format = $bc->get_format();
        $type = $bc->get_type();
        $id = $bc->get_id();
        $users = $bc->get_plan()->get_setting('users')->get_value();
        $anonymised = $bc->get_plan()->get_setting('anonymize')->get_value();
        $filename = backup_plan_dbops::get_default_backup_filename($format, $type, $id, $users, $anonymised);
        $bc->get_plan()->get_setting('filename')->set_value($filename);
        $bc->finish_ui();
        $bc->execute_plan();
        $results = $bc->get_results();

        $file = $results['backup_destination']; // May be empty if file already moved to target location.
        $bc->destroy();
        $contenthash = $file->get_contenthash();
        $pathnamehash = $file->get_pathnamehash();
        $hashes = [
            'contenthash' => $contenthash,
            'pathnamehash' => $pathnamehash
        ];
        return $hashes;
    }

}
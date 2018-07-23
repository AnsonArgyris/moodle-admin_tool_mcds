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
 * TeachCenter2.0
 * Sync Layer Plugin for Moodle
 *
 * form for synclayer_course_mapping table
 *
 * @package     synclayer
 * @author      Christian Ortner
 */

namespace tool_mcds;

defined('MOODLE_INTERNAL') || die();

// Moodleform is defined in formslib.php.
require_once("$CFG->libdir/formslib.php");

class courselist_form extends \moodleform {
    // Add elements to form.
    public function definition() {
        $mform = $this->_form;

        $courses = json_decode($this->_customdata['courses']);

        foreach ($courses as $course) {
            $mform->addElement('advcheckbox', $course->id, '',
                               $course->id . ', ' . $course->idnumber . ', ' . $course->shortname . ', ' . $course->fullname,
                               ['group' => 1], [0, 1]);
        }

        $this->add_action_buttons();
    }

    // Custom validation should be added here.
    public function validation($data, $files) {
        // TODO.
        return [];
    }
}
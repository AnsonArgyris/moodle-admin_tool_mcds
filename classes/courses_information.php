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
 * Courses information class
 * @package tool_mcds
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace tool_mcds;

defined('MOODLE_INTERNAL') || die();

class courses_information {
    public function get_courselist() {
        $courses = \get_courses('all', 'id ASC');
        $retval  = [];
        foreach ($courses as $course) {
            // Skip frontpage course.
            if ($course->id == 1) {
                continue;
            }
            $retval[] = [
                'id'        => $course->id,
                'shortname' => $course->shortname,
                'fullname'  => $course->fullname,
                'idnumber'  => $course->idnumber,
            ];
        }
        return $retval;
    }
}
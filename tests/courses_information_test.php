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

/**
 * Class get_courses_test
 *
 * @group mcds
 */
class _courses_information_test extends advanced_testcase {
    public function test_get_courselist() {
        $this->resetAfterTest(true);

        $course1 = $this->getDataGenerator()->create_course();
        $course2 = $this->getDataGenerator()->create_course();
        $course3 = $this->getDataGenerator()->create_course();

        $crss = new \tool_mcds\courses_information();
        $courses = $crss->get_courselist();

        $this->assertEquals($course1->shortname, $courses[0]['shortname']);
        $this->assertEquals($course2->shortname, $courses[1]['shortname']);
        $this->assertEquals($course3->shortname, $courses[2]['shortname']);
    }
}
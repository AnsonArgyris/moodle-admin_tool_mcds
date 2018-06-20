<?php
/**
 * Class get_courses_test
 *
 * @group mcds
 */

class _courses_information_test extends advanced_testcase {
    function test_get_courselist() {
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
<?php
/**
 * Class get_courses_test
 *
 * @group mcds
 */

class get_courses_test extends advanced_testcase {
    function test_get_shared_courses() {
        $this->resetAfterTest(true);

        $course1 = $this->getDataGenerator()->create_course();
        $course2 = $this->getDataGenerator()->create_course();
        $course3 = $this->getDataGenerator()->create_course();

        $ws = new \tool_mcds\webservice\get_courses();
        $courses = $ws->get_shared_courses();

        $this->assertEquals($course1->shortname, $courses[0]['shortname']);
        $this->assertEquals($course2->shortname, $courses[1]['shortname']);
        $this->assertEquals($course3->shortname, $courses[2]['shortname']);
    }
}
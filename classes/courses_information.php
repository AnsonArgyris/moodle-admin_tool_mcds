<?php

namespace tool_mcds;

class courses_information {
    public function get_courselist() {
        $courses = \get_courses('all', 'id ASC');
        $retval  = [];
        foreach ($courses as $course) {
            if($course->id == 1) continue; //skip frontpage course
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
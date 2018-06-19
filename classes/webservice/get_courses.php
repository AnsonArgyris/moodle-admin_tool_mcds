<?php

namespace tool_mcds\webservice;
use tool_mcds\courses_information;

/**
 * Class get_courses
 * @package tool_mcds\webservice
 */
class get_courses extends \external_api
{
    /**
     *
     */
    public function get_shared_courses_parameters()
    {

    }

    /**
     * @return \external_value
     */
    public function get_shared_courses_returns()
    {
        return new \external_multiple_structure(
            new \external_single_structure(
                [
                    'id'        => new \external_value(PARAM_INT),
                    'shortname' => new \external_value(PARAM_RAW),
                    'fullname'  => new \external_value(PARAM_RAW),
                    'idnumber'  => new \external_value(PARAM_RAW),
                ]
            )
        );
    }

    /**
     * @return array
     */
    public function get_shared_courses()
    {
        //TODO - should there be some parameters? security things?
        //$params = self::validate_parameters(self::get_shared_courses_parameters(), []);

        $courses = new courses_information();

        return $courses->get_courselist();
    }
}
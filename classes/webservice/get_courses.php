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
    public function service_parameters()
    {
        return new \external_function_parameters([]);
    }

    /**
     * @return \external_value
     */
    public function service_returns()
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
    public function service()
    {
        //TODO - should there be some parameters? security things?
        $params = self::validate_parameters(self::service_parameters(), []);

        $courses = new courses_information();

        return $courses->get_courselist();
    }
}
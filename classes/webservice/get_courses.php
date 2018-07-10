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

namespace tool_mcds\webservice;

use tool_mcds\courses_information;

defined('MOODLE_INTERNAL') || die();

/**
 * Class get_courses
 * @package tool_mcds\webservice
 */
class get_courses extends \external_api {

    /**
     * Returns description of method parameters
     *
     * @return external_function_parameters
     */
    public function service_parameters() {
        return new \external_function_parameters([]);
    }

    /**
     * Returns description of method result value
     *
     * @return external_description
     */
    public function service_returns() {
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
    public function service() {
        // TODO - should there be some parameters for security things?
        $params = self::validate_parameters(self::service_parameters(), []);

        $courses = new courses_information();

        return $courses->get_courselist();
    }
}
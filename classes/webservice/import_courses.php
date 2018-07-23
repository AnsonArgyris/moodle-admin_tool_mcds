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
 * Get exported course data
 *
 * @package   tool_mcds
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace tool_mcds\webservice;

defined('MOODLE_INTERNAL') || die();

require_once(__DIR__.'/../../../../../lib/externallib.php');
require_once(__DIR__.'/../mcds_file.php');


class import_courses extends \external_api {

    /**
     * Returns description of method parameters
     *
     * @return external_function_parameters
     */
    public static function service_parameters() {
        return new \external_function_parameters(
            array(
                'courseids' => new \external_multiple_structure(
                    new \external_value(PARAM_INT, 'course id'),
                    'array of course ids'
                )
            )
        );
    }

    /**
     * Returns description of method result value
     * See this plugin's github wiki for example usage
     * {@link https://github.com/AnsonArgyris/moodle-admin_tool_mcds/wiki/tool_mcds_import_courses}.
     *
     * @return external_description
     */
    public static function service_returns() {
        return new \external_single_structure(
            array(
                'courses' => new \external_multiple_structure(
                    new \external_single_structure(
                        array(
                            'id'           => new \external_value(PARAM_INT, 'id of course'),
                            'checksum'     => new \external_value(PARAM_TEXT, 'checksum of the backup data'),
                            'contenthash'  => new \external_value(PARAM_TEXT, 'contenthash the backup data'),
                            'pathnamehash' => new \external_value(PARAM_TEXT, 'pathnamehashgit  the backup data'),
                        ),
                        'course data'
                    ),
                    'list of courses'
                )
            )
        );
    }


    /**
     * @return array $courses
     */
    public static function service(array $input0) {
        $params = self::validate_parameters(self::service_parameters(), array('courseids' => $input0));
        $courseids = $params['courseids'];

        $courses = [
            'courses'  => []
        ];

        for ($i = 0; $i < count($courseids); $i++) {

            $coursebak = new \mcds_file();

            $hashes = $coursebak->devliver_course($courseids[$i]);

            $c = [
                "id"           => $courseids[$i],
                "checksum"     => '120EA8A25E5D487BF68B5F7096440019',
                "contenthash"  => $hashes['contenthash'],
                "pathnamehash" => $hashes['pathnamehash'],
            ];
            array_push($courses['courses'], $c);
        }

        return $courses;
    }
}
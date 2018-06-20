<?php

namespace tool_mcds\webservice;

defined('MOODLE_INTERNAL') || die();

require_once(__DIR__.'/../../../../../lib/externallib.php');
require_once(__DIR__.'/../mcds_file.php');
/**
 * Get exported course data
 *
 * @package   tool_mcds
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

class import_courses extends \external_api {

    /**
     * @return array
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
                "id" =>  $courseids[$i],
                "checksum" =>  '120EA8A25E5D487BF68B5F7096440019',
                "contenthash" => $hashes['contenthash'],
                "pathnamehash" => $hashes['pathnamehash'],
            ];
            array_push($courses['courses'], $c);
        }
        
        return $courses;
    }

    
    
    public static function service_parameters() {
        return new \external_function_parameters(array(
            'courseids' => new \external_multiple_structure(
                new \external_value(PARAM_INT, 'course id'), 'array of course ids')));
    }
    
    /**
     * @return \external_single_structure

        Example response:
        {
            "courses": [
                {
                    "id": 123,
                    "checksum": "120EA8A25E5D487BF68B5F7096440019",
                    "backupfile": "https://abc.com"
                },
                {
                    "id": 456,
                    "checksum": "120EA8A25E5D487BF68B5F7096440019",
                    "backupfile": "https://abc.com"
                }
            ]
        }
     */
    public static function service_returns() {
        return new \external_single_structure([
            'courses' => new \external_multiple_structure(
                    new \external_single_structure(array(
                        'id' => new \external_value(PARAM_INT, 'id of course'),
                        'checksum'  => new \external_value(PARAM_TEXT, 'checksum of the backup data'),
                        'contenthash' => new \external_value(PARAM_TEXT, 'contenthash the backup data'),
                        'pathnamehash' => new \external_value(PARAM_TEXT, 'pathnamehashgit  the backup data'),
                    ),
                    'course data'),
                'list of courses')
        ]);
    }
}
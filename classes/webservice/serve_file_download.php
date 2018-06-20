<?php

namespace tool_mcds\webservice;

defined('MOODLE_INTERNAL') || die();

require_once(__DIR__.'/../../../../../lib/externallib.php');
require_once(__DIR__.'/../../../../../lib/filelib.php');

/**
 * Get exported course data
 *
 * @package   tool_mcds
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

class serve_file_download extends \external_api {

    /**
     * @return array
     */
    public static function service(array $input0) {
        $params = self::validate_parameters(self::service_parameters(), array('filepaths' => $input0));
        $filepaths = $params['filepaths'];
        
        $files = [
            'filedownload'  => []
        ];
        
        for ($i = 0; $i < count($filepaths); $i++) {
            $f = [
                //"file" => external_util::get_area_files($context->id, 'mod_forum', 'intro', false, false)
                "file" => file_pluginfile($filepaths[$i], true)
            ];
            array_push($files['filedownload'], $f);
        }
        
        return $files;
    }

    
    
    public static function service_parameters() {
        return new \external_function_parameters(array(
            'filepaths' => new \external_multiple_structure(
                new \external_value(PARAM_TEXT, 'file path'), 'list of file paths')));
    }
    
    /**
     * @return \external_single_structure

        Example response:

     */
    public static function service_returns() {
        return new \external_single_structure([
            'filedownload' => new \external_multiple_structure(
                    new \external_single_structure(array(
                        'file' => new \external_value(PARAM_INT, 'id of course')
                    ),
                    'filedownload'),
                'list of file downloads')
        ]);
    }
}
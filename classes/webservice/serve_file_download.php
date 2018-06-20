<?php

namespace tool_mcds\webservice;

defined('MOODLE_INTERNAL') || die();

require_once(__DIR__ . '/../../../../../lib/externallib.php');
require_once(__DIR__ . '/../../../../../lib/filelib.php');

/**
 * Get exported course data
 *
 * @package   tool_mcds
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class serve_file_download extends \external_api
{

    /**
     * @return array
     */
    public static function service($input0)
    {
        $params = self::validate_parameters(self::service_parameters(), ['filepath' => $input0]);

        $fs   = new \file_storage();
        $file = $fs->get_file_by_hash($params['filepath']);

        return [
            "filename"    => $file->get_filename(),
            "filecontent" => base64_encode($file->get_content()),
        ];
    }


    public static function service_parameters()
    {
        return new \external_function_parameters(
            [
                'filepath' => new \external_value(PARAM_TEXT, 'file path'),
            ]);
    }

    /**
     * @return \external_single_structure
     *
     * Example response:
     */
    public static function service_returns()
    {
        return new \external_single_structure(
            [
                'filename'    => new \external_value(PARAM_RAW, 'filename'),
                'filecontent' => new \external_value(PARAM_RAW, 'content of file'),
            ]);
    }
}
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

defined('MOODLE_INTERNAL') || die();

require_once(__DIR__ . '/../../../../../lib/externallib.php');
require_once(__DIR__ . '/../../../../../lib/filelib.php');

/**
 * Get exported course data
 *
 * @package   tool_mcds
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class serve_file_download extends \external_api {

    /**
     * Returns description of method parameters
     *
     * @return external_function_parameters
     */
    public static function service_parameters() {
        return new \external_function_parameters(
            [
                'filepath' => new \external_value(PARAM_TEXT, 'file path'),
            ]
        );
    }

    /**
     * Returns description of method result value
     *
     * @return external_description
     */
    public static function service_returns() {
        return new \external_single_structure(
            [
                'filename'    => new \external_value(PARAM_RAW, 'filename'),
                'filecontent' => new \external_value(PARAM_RAW, 'content of file'),
            ]
        );
    }

    /**
     * @return array
     */
    public static function service($input0) {
        $params = self::validate_parameters(self::service_parameters(), ['filepath' => $input0]);

        $fs   = new \file_storage();
        $file = $fs->get_file_by_hash($params['filepath']);

        return [
            "filename"    => $file->get_filename(),
            "filecontent" => base64_encode($file->get_content()),
        ];
    }
}
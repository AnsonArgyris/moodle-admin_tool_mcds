<?php

namespace tool_mcds\webservice;

defined('MOODLE_INTERNAL') || die();

use tool_mcds\version_information;

require_once(__DIR__.'/../../../../../lib/externallib.php');

/**
 * Get version information.
 *
 * @package   tool_mcds
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class version_info extends \external_api {
    /**
     * @return \external_function_parameters - no parameters!
     */
    public static function service_parameters() {
        return new \external_function_parameters([]);
    }

    /**
     * @return \external_single_structure
     */
    public static function service_returns() {
        return new \external_single_structure([
            'tool_mcds' => new \external_single_structure([
                'version'  => new \external_value(PARAM_FLOAT, 'Ally admin tool version'),
                'requires' => new \external_value(PARAM_FLOAT, 'Ally admin tool requires Moodle version'),
                'release'  => new \external_value(PARAM_TEXT, 'Ally admin tool release'),
            ]),
            'moodle' => new \external_single_structure([
                'version' => new \external_value(PARAM_FLOAT, 'Moodle version'),
                'release' => new \external_value(PARAM_TEXT, 'Moodle release'),
                'branch'  => new \external_value(PARAM_FLOAT, 'Moodle branch')
            ])
        ]);
    }

    /**
     * @return array
     */
    public static function service() {

        $versioninfo = new version_information();

        return [
            'tool_mcds'       => $versioninfo->toolmcds,
            'moodle'          => $versioninfo->core
        ];
    }
}
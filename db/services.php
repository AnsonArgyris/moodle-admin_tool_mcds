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

defined('MOODLE_INTERNAL') || die();

$functions = array(
        'tool_mcds_get_plugin_version' => array(
            'classname' => 'tool_mcds\\webservice\\version_info',
            'methodname' => 'service',
            'description' => 'get moodle and plugin version information',
            'type' => 'read'

        ),
        'tool_mcds_get_shared_courses' => array(
            'classname' => 'tool_mcds\\webservice\\get_courses',
            'methodname' => 'service',
            'description' => 'Get all courses where I have those roles',
            'type' => 'read'

        ),
        'tool_mcds_import_courses' => array(
            'classname' => 'tool_mcds\\webservice\\import_courses',
            'methodname' => 'service',
            'description' => 'import moodle courses content',
            'type' => 'write'

        ),
        'tool_mcds_serve_file_download' => array(
            'classname' => 'tool_mcds\\webservice\\serve_file_download',
            'methodname' => 'service',
            'description' => 'download a moodle file from a given url',
            'type' => 'write'

        )
    );

$services = array(
    'MCDS integration services' => [
        'functions'       => [
            'tool_mcds_get_plugin_version',
            'tool_mcds_get_shared_courses',
            'tool_mcds_import_courses',
            'tool_mcds_serve_file_download',
        ],
        'restrictedusers' => 0,
        'enabled'         => 1,
        'shortname'       => 'tool_mcds',
    ],
);
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
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle. If not, see <http://www.gnu.org/licenses/>.

defined('MOODLE_INTERNAL') || die();

// @formatter:off
$functions = array(
                'tool_mcds_get_plugin_version' => array( // web service function name
                    'classname' => 'tool_mcds\\webservice\\version_info', // class containing the external function
                    'methodname' => 'service', // external function name
                    'description' => 'get moodle and plugin version information', // human readable description of the web service function
                    'type' => 'read' // database rights of the web service function (read, write)
        
                ),
                'tool_mcds_get_shared_courses' => array( // web service function name
                    'classname' => 'tool_mcds\\webservice\\get_courses', // class containing the external function
                    'methodname' => 'service', // external function name
                    'description' => 'Get all courses where I have those roles', // human readable description of the web service function
                    'type' => 'read' // database rights of the web service function (read, write)
        
                ),
                'tool_mcds_import_courses' => array( // web service function name
                    'classname' => 'tool_mcds\\webservice\\import_courses', // class containing the external function
                    'methodname' => 'service', // external function name
                    'description' => 'import moodle courses content', // human readable description of the web service function
                    'type' => 'write' // database rights of the web service function (read, write)
        
                ),
                
            );
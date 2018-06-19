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
 * Version information class
 * @package tool_mcds
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace tool_mcds;

defined('MOODLE_INTERNAL') || die();

use core_component,
    core_plugin_manager;

/**
 * Version information class
 * @package tool_mcds
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class version_information {

    /**
     * @var bool|stdClass
     */
    public $core;

    /**
     * @var bool|stdClass
     */
    public $toolmcds;

    /**
     * Constructor.
     */
    public function __construct() {
        $this->core = $this->get_component_version('core');
        $this->toolmcds = $this->get_component_version('tool_ally');
    }

    /**
     * Returns the version information of an installed component.
     *
     * @param string $component component name
     * @return stdClass|bool version data or false if the component is not found
     */
    private function get_component_version($component) {
        global $CFG;

        list($type, $name) = core_component::normalize_component($component);

        // Get Moodle core version.
        if ($type === 'core') {
            return (object) [
                'version' => $CFG->version,
                'release' => $CFG->release,
                'branch' => $CFG->branch
            ];
        }

        // Get plugin version.
        $pluginman = core_plugin_manager::instance();
        $plug = $pluginman->get_plugin_info($component);
        if (!$plug) {
            return false;
        }
        $plugin = new \stdClass();
        $plugin->version = $plug->versiondb;
        $plugin->requires = $plug->versionrequires;
        $plugin->release = $plug->release;

        return $plugin;
    }
}

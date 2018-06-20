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
 * Plugin administration pages are defined here.
 *
 * @package     tool_mcds
 * @category    admin
 * @copyright   MoodleDACH18
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot.'/admin/tool/mcds/classes/adminsetting/mcds_config_link.php');

use tool_mcds\adminsetting\mcds_config_link;

if ($hassiteconfig) {
    $settings = new admin_settingpage('tool_mcds', get_string('pluginname', 'tool_mcds'));

    $settings->add(new admin_setting_configtext('tool_mcds/subscribeurl', new lang_string('subscribeurl', 'tool_mcds'),
        new lang_string('subscribeurl', 'tool_mcds'), '', PARAM_URL, 60));
    $settings->add(new admin_setting_configtext('tool_mcds/token', new lang_string('token', 'tool_mcds'),
                                                new lang_string('token', 'tool_mcds'), '', PARAM_RAW, 60));

    $settings->add(new mcds_config_link('tool_mcds/autconf', new lang_string('autoconfigure', 'tool_mcds'),
        new moodle_url('/admin/tool/mcds/autoconfigws.php')));

    $ADMIN->add('tools', $settings);
}
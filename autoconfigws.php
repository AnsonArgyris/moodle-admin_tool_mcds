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
 * Web service auto configuration page
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

use tool_mcds\auto_config;

require(__DIR__.'/../../../config.php');

$PAGE->set_url(new moodle_url('/admin/tool/mcds/autoconfigws.php'));
$PAGE->set_context(context_system::instance());
$PAGE->set_title(get_string('autoconfigure', 'tool_mcds'));

require_login();
require_capability('moodle/site:config', context_system::instance());

$action = optional_param('action', null, PARAM_ALPHA);

echo $OUTPUT->header();

echo $OUTPUT->heading(get_string('autoconfigure', 'tool_mcds'));

if ($action === 'confirm') {
    $ac = new auto_config();
    $ac->configure();
    $sampleapicall = $CFG->wwwroot.'/webservice/rest/server.php?wstoken='.$ac->token.
            '&wsfunction=tool_mcds_version_info&'.'moodlewsrestformat=json';
    $context = (object) ['token' => $ac->token, 'sampleapicall' => $sampleapicall];
    echo $OUTPUT->render_from_template('tool_mcds/auto_conf_result', $context);
    echo $OUTPUT->continue_button(new moodle_url('/admin/settings.php', ['section' => 'tool_mcds']));
} else {
    $continueurl = new moodle_url('/admin/tool/mcds/autoconfigws.php', ['action' => 'confirm']);
    $cancelurl = new moodle_url('/admin/settings.php', ['section' => 'tool_mcds']);
    echo $OUTPUT->confirm(get_string('autoconfigureconfirmation', 'tool_mcds'), $continueurl, $cancelurl);
}

echo $OUTPUT->footer();

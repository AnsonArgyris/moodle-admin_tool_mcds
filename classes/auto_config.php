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
 * Web service auto configuration tool.
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace tool_mcds;

defined('MOODLE_INTERNAL') || die();

require_once(__DIR__ . "/../../../../webservice/lib.php");
require_once(__DIR__ . "/../../../../user/lib.php");

class auto_config {

    /**
     * @var \stdClass - web user
     */
    public $user;

    /**
     * @var \stdClass - role
     */
    public $role;

    /**
     * @var string - token
     */
    public $token;

    /**
     * Main configuration.
     */
    public function configure() {
        $this->create_user();
        $this->create_role();
        $this->enable_web_service();
    }

    /**
     * Create web service user.
     * @throws \moodle_exception.
     */
    private function create_user() {
        global $DB;

        $webuserpwd = strval(new password());

        $user = $DB->get_record('user', ['username' => 'mcds_webuser']);
        if ($user) {
            $user->password = $webuserpwd;
            $user->policyagreed = 1;
            user_update_user($user);
            $this->user = $user;
            return;
        }

        $user = create_user_record('mcds_webuser', $webuserpwd);
        $user->policyagreed = 1;
        $user->password = $webuserpwd;
        $user->firstname = 'MCDS';
        $user->lastname = 'Webservice';
        $user->email = 'mcdswebservice@test.local'; // Fake email address.
        user_update_user($user);
        $this->user = $user;
    }

    /**
     * Create web service role.
     * @throws \coding_exception
     * @throws \dml_exception
     */
    private function create_role() {
        global $DB;

        $role = $DB->get_record('role', ['shortname' => 'mcds_webservice']);
        if ($role) {
            $roleid = $role->id;
            $this->role = $role;
        } else {
            $roleid = create_role('MCDS webservice', 'mcds_webservice', 'Role for MCDS web service', 'manager');
            $this->role = $DB->get_record('role', ['id' => $roleid]);
        }

        $contextid = \context_system::instance()->id;

        // TODO - REVIEW WHAT CAPS WE NEED FOR BACKUPS.
        // Add capabilities to role.
        $caps = [
            "moodle/backup:backupcourse",
            "moodle/course:ignorefilesizelimits",
            "moodle/course:managefiles",
            "moodle/course:update",
            "moodle/course:useremail",
            "moodle/course:view",
            "moodle/course:viewhiddencourses",
            "moodle/course:viewhiddenactivities",
            "moodle/course:viewparticipants",
            "moodle/question:useall",
            "moodle/site:configview",
            "moodle/site:viewparticipants",
            "moodle/site:accessallgroups",
            "moodle/user:update",
            "moodle/user:viewdetails",
            "moodle/user:viewhiddendetails",
            "webservice/rest:use",
            "mod/resource:view"
        ];
        foreach ($caps as $cap) {
            assign_capability($cap, CAP_ALLOW, $roleid, $contextid);
        }

        // Add manager archetype caps to role.
        $caps = get_default_capabilities('manager');
        foreach ($caps as $cap => $permission) {
            assign_capability($cap, $permission, $roleid, $contextid);
        }

        // Allow role to be allocated at system level.
        set_role_contextlevels($roleid, [CONTEXT_SYSTEM]);

        // Assign user to role.
        role_assign($roleid, $this->user->id, $contextid);
    }

    /**
     * Enable web service.
     */
    private function enable_web_service() {
        global $CFG;

        set_config('enablewebservices', 1);

        // Enable REST protocol.
        $webservice = 'rest'; // We want to enable the rest web service protocol.
        $availablewebservices = \core_component::get_plugin_list('webservice');
        $activewebservices = empty($CFG->webserviceprotocols) ? array() : explode(',', $CFG->webserviceprotocols);
        foreach ($activewebservices as $key => $active) {
            if (empty($availablewebservices[$active])) {
                unset($activewebservices[$key]);
            }
        }
        if (!in_array($webservice, $activewebservices)) {
            $activewebservices[] = $webservice;
            $activewebservices = array_unique($activewebservices);
        }
        set_config('webserviceprotocols', implode(',', $activewebservices));

        $this->enable_mcds_web_service();
        $this->create_ws_token();
    }

    /**
     * Enable mcds web service.
     * @throws \coding_exception
     */
    private function enable_mcds_web_service() {
        global $DB;

        $webservicemanager = new \webservice;

        $servicedata = (object) [
            'name' => 'MCDS integration services',
            'component' => 'tool_mcds',
            'timecreated' => time(),
            'timemodified' => time(),
            'shortname' => 'tool_mcds',
            'restrictedusers' => 0,
            'enabled' => 1,
            'downloadfiles' => 1,
            'uploadfiles' => 1
        ];

        $row = $DB->get_record('external_services', ['component' => 'tool_mcds']);
        if (!$row) {
            $servicedata->id = $webservicemanager->add_external_service($servicedata);
            $servicedata->timecreated = time();
            $params = array(
                'objectid' => $servicedata->id
            );
            $event = \core\event\webservice_service_created::create($params);
            $event->trigger();
        } else {
            $servicedata->id = $row->id;
            $webservicemanager->update_external_service($servicedata);
            $params = array(
                'objectid' => $servicedata->id
            );
            $event = \core\event\webservice_service_updated::create($params);
            $event->trigger();
        }
    }

    /**
     * Create web service token.
     * @throws \dml_exception
     * @throws \moodle_exception
     */
    private function create_ws_token() {
        global $DB;

        // Create token for MCDS.
        $webservicemanager = new \webservice();
        $service = $webservicemanager->get_external_service_by_shortname('tool_mcds');
        $context = \context_system::instance();
        $existing = $DB->get_record('external_tokens', [
                'userid' => $this->user->id,
                'externalserviceid' => $service->id,
                'contextid' => $context->id
            ]
        );
        if ($existing) {
            $this->token = $existing->token;
        } else {
            $this->token = external_generate_token(EXTERNAL_TOKEN_PERMANENT, $service->id,
                $this->user->id, $context);
        }
    }
}

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

namespace tool_mcds;

defined('MOODLE_INTERNAL') || die();

class service_call {
    private $url   = '';
    private $token = '';
    private $json = '&moodlewsrestformat=json';

    public function __construct() {
        $this->url   = get_config('tool_mcds', 'subscribeurl');
        $this->token = get_config('tool_mcds', 'token');
    }

    private function build_url($function, $json = true, $params = '') {
        return $this->url . '/webservice/rest/server.php?wstoken=' .
                $this->token . '&wsfunction=' . $function .
                $params . ($json ? $this->json : '');
    }

    public function connect_to_server() {
        // TODO error handling.
        return file_get_contents($this->build_url('tool_mcds_get_plugin_version'));
    }

    public function list_all_courses() {
        // TODO error handling.
        return file_get_contents($this->build_url('tool_mcds_get_shared_courses'));
    }

    public function import_courses($courseids) {
        // TODO error handling.
        $param = '';
        foreach ($courseids as $index => $id) {
            $param .= "&courseids[$index]=$id";
        }

        return file_get_contents($this->build_url('tool_mcds_import_courses', true, $param));
    }

    public function download_file($path) {
        // TODO error handling.
        return file_get_contents($this->build_url('tool_mcds_serve_file_download', true, '&filepath=' . $path));
    }
}
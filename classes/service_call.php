<?php

namespace tool_mcds;

class service_call {
    private $url = '';

    public function __construct()
    {
        $this->url = get_config('tool_mcds', 'subscribeurl');
    }

    public function connect_to_server() {
        //TODO error handling
        return file_get_contents($this->url . '&wsfunction=tool_mcds_get_plugin_version');
    }
}
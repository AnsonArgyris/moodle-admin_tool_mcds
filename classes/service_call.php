<?php

namespace tool_mcds;

class service_call
{
    private $url   = '';
    private $token = '';
    private $json = '&moodlewsrestformat=json';

    public function __construct()
    {
        $this->url   = get_config('tool_mcds', 'subscribeurl');
        $this->token = get_config('tool_mcds', 'token');
    }

    private function build_url($function, $json = true, $params = '')
    {
        return $this->url . '/webservice/rest/server.php?wstoken='
               . $this->token . '&wsfunction=' . $function
                . $params . ($json ? $this->json : '');
    }

    public function connect_to_server()
    {
        //TODO error handling
        return file_get_contents($this->build_url('tool_mcds_get_plugin_version'));
    }

    public function list_all_courses()
    {
        //TODO error handling
        return file_get_contents($this->build_url('tool_mcds_get_shared_courses'));
    }

    public function import_courses($courseids)
    {
        //TODO error handling
        $param = '';
        foreach ($courseids as $index => $id) {
            $param .= "&courseids[$index]=$id";
        }

        return file_get_contents($this->build_url('tool_mcds_import_courses', false, $param));
    }

    public function download_file($file)
    {
        //TODO error handling
        return file_get_contents($this->build_url('tool_mcds_serve_file_download', false, "&filename=$file->filename"));
    }
}
<?php
define('CLI_SCRIPT', true);

require(__DIR__.'/../../../../config.php');

$ws = new \tool_mcds\service_call();
var_dump($ws->connect_to_server());
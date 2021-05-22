<?php

require_once("./ReportServiceHandler.php");
require_once("./settings.config.php");

$page_key = filter_input(INPUT_GET, 'page_key', FILTER_SANITIZE_SPECIAL_CHARS);

switch($page_key){
    case "create":
    $handler = new ReportServiceHandler($connectionConfig);
    $result = $handler->createReport();
    break;

    case "viewByDate":
    $handler = new ReportServiceHandler($connectionConfig);
    $result = $handler->fetchLogByDate();
    break;    
}
?>
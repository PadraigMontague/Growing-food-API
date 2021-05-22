<?php
require_once("Handler.php");
require_once("settings.config.php");

$page_key = filter_input(INPUT_GET, 'page_key', FILTER_SANITIZE_SPECIAL_CHARS);

switch ($page_key) {

    case "register":
        $authHandler = new Handler($connectionConfig);
        $authHandler->userReg();
        break;

    case "validate":
        $authHandler = new Handler($connectionConfig);
        $authHandler->tokenValidation();
        break;

    case "login":
        $authHandler = new Handler($connectionConfig);
        $authHandler->userLogin();
        break;

    case "renew":
        $authHandler = new Handler($connectionConfig);
        $authHandler->renewToken();
        break;

    case "revoke":
        $authHandler = new Handler($connectionConfig);
        $authHandler->revokeToken();
        break;
    
    case "newCall":
        $authHandler = new Handler($connectionConfig);
        $authHandler->logCallAmount();
        break;
}

?>
<?php

require_once("FruitServiceHandler.php");
require_once("settings.config.php");

$page_key = filter_input(INPUT_GET, 'page_key', FILTER_SANITIZE_SPECIAL_CHARS);

switch($page_key){
    case "create":
    $handler = new FruitServiceHandler($connectionDetails);
    $result = $handler->createFruit();
    break;

    case "fetchAll":
    $handler = new FruitServiceHandler($connectionDetails);
    $result = $handler->fetchAllFruit();
    break;

    case "fetchByName":
    $handler = new FruitServiceHandler($connectionDetails);
    $result = $handler->fetchFruitByName();
    break;

    case "update":
    $handler = new FruitServiceHandler($connectionDetails);
    $result = $handler->updateFruitById();
    break;

    case "delete":
    $handler = new FruitServiceHandler($connectionDetails);
    $result = $handler->deleteFruitById();
    break;

    case "calculate":
    $handler = new FruitServiceHandler($connectionDetails);
    $result = $handler->calculatePlantsNeeded();
    break;

    case "plantingMonth":
    $handler = new FruitServiceHandler($connectionDetails);
    $result = $handler->searchByPlantingMonth();
    break;


}
?>
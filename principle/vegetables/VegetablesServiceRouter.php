<?php

require_once("VegetablesServiceHandler.php");
require_once("settings.config.php");

$page_key = filter_input(INPUT_GET, 'page_key', FILTER_SANITIZE_SPECIAL_CHARS);

switch($page_key){
    case "create":
    $handler = new VegetablesServiceHandler($connectionDetails);
    $result = $handler->createVegetable();
    break;

    case "fetchAll":
    $handler = new VegetablesServiceHandler($connectionDetails);
    $result = $handler->fetchAllVegetables();
    break;

    case "fetchByName":
    $handler = new VegetablesServiceHandler($connectionDetails);
    $result = $handler->fetchVegByName();
    break;

    case "update":
    $handler = new VegetablesServiceHandler($connectionDetails);
    $result = $handler->updateVegetableById();
    break;

    case "delete":
    $handler = new VegetablesServiceHandler($connectionDetails);
    $result = $handler->deleteVegetableById();
    break;

    case "searchByTemp":
    $handler = new VegetablesServiceHandler($connectionDetails);
    $result = $handler->searchByTemp();
    break;

    case "sowMonth":
    $handler = new VegetablesServiceHandler($connectionDetails);
    $result = $handler->searchBySowMonth();
    break;

    case "calculate":
    $handler = new VegetablesServiceHandler($connectionDetails);
    $result = $handler->calculatePlantsNeeded();
    break;

    case "weather":
    $handler = new VegetablesServiceHandler($connectionDetails);
    $result = $handler->getWeatherData();
    break;
}
?>
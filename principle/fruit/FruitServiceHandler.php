<?php

require_once("../rest/Rest.php");
require_once("Fruit.php");

Class FruitServiceHandler extends Rest {
    private $databaseConfig;

    public function __construct(array $databaseConfig){
        $this->databaseConfig = $databaseConfig;
    }

    function setHeaders($data){
        if(empty($data)){
            $httpCode = 404;
            $data = array('success' => 0);
        }else{
            $httpCode = 200;
        }
        $contentType = $_SERVER['HTTP_ACCEPT'];
        $this->setHttpHeaders($contentType, $httpCode);
        if(strpos($contentType,'application/json') !== false){
            $result = $data;
            $this->setResponseContent($contentType, $result);
		}else if(strpos($contentType,'application/xml') !== false){
			$result = $this->convertToXML($data);
            echo $result;
		}
    }

    function createFruit(){
        $fruit = new Fruit();
        $data = $fruit->createFruit($this->databaseConfig);
        $this->setHeaders($data);
    }

    function fetchAllFruit(){
        $fruit = new Fruit();
        $data = $fruit->fetchAllFruit($this->databaseConfig);
        $this->setHeaders($data);
    }

    function fetchFruitByName(){
        $fruit = new Fruit();
        $data = $fruit->fetchByName($this->databaseConfig);
        $this->setHeaders($data);
    }

    function updateFruitById(){
        $fruit = new Fruit();
        $data = $fruit->updateFruit($this->databaseConfig);
        $this->setHeaders($data);
    }

    function deleteFruitById(){
        $fruit = new Fruit();
        $data = $fruit->deleteFruit($this->databaseConfig);
        $this->setHeaders($data);
    }

    public function calculatePlantsNeeded(){
        $fruit = new Fruit();
        $data = $fruit->calcNumberOfPlants();
        $this->setHeaders($data);
    }

    public function searchByPlantingMonth(){
        $fruit = new fruit();
        $data = $fruit->plantingMonth($this->databaseConfig);
        $this->setHeaders($data);       
    }

    public function convertToXML($data) {
        $jsonData = $data;
        
        $xml = new SimpleXMLElement('<?xml version="1.0"?><fruits></fruits>');
        foreach ($jsonData as $key => $rawData) {
            $fruit = $xml->addChild('fruit');
            foreach($rawData as $key => $value) {
                 $fruit->addChild($key, $value);
           }
        }
        return $xml->asXML();
    }
}

?>
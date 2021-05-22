<?php

require_once("../rest/Rest.php");
require_once("Vegetables.php");

Class VegetablesServiceHandler extends Rest {
    private $databaseConfig;

    public function __construct(array $databaseConfig){
        $this->databaseConfig = $databaseConfig;
    }

    public function setHeaders($data){
        if(empty($data)){
            $httpCode = 404;
            $data = array('success' => 0);
        }else{
            $httpCode = 200;
        }
        $contentType = $_SERVER['HTTP_ACCEPT'];
        $this->setHttpHeaders($contentType, $httpCode);
        if(strpos($contentType,'application/json') !== false){
            $result = json_decode(json_encode($data));
            $this->setResponseContent($contentType, $result);
		}else if(strpos($contentType,'application/xml') !== false){
			$result = $this->convertToXML($data);
            echo $result;
		}
    }

    public function createVegetable(){
        $vegetable = new Vegetables();
        $data = $vegetable->createVegetable($this->databaseConfig);
        $this->setHeaders($data);
    }

    public function fetchAllVegetables(){
        $vegetable = new Vegetables();
        $data = $vegetable->fetchAllVeg($this->databaseConfig);
        $this->setHeaders($data);
    }

    public function fetchVegByName(){
        $vegetable = new Vegetables();
        $data = $vegetable->fetchByName($this->databaseConfig);
        $this->setHeaders($data);
    }
    public function updateVegetableById(){
        $vegetable = new Vegetables();
        $data = $vegetable->updateVegetables($this->databaseConfig);
        $this->setHeaders($data);
    }

    public function deleteVegetableById(){
        $vegetable = new Vegetables();
        $data = $vegetable->deleteVegetables($this->databaseConfig);
        $this->setHeaders($data);
    }

    public function searchByTemp(){
        $vegetable = new Vegetables();
        $data = $vegetable->searchByTemp($this->databaseConfig);
        $this->setHeaders($data);       
    }

    public function searchBySowMonth(){
        $vegetable = new Vegetables();
        $data = $vegetable->sowMonth($this->databaseConfig);
        $this->setHeaders($data);       
    }

    public function calculatePlantsNeeded(){
        $vegetable = new Vegetables();
        $data = $vegetable->calcNumberOfPlants();
        $this->setHeaders($data);
    }

    public function getWeatherData(){
        $vegetable = new Vegetables();
        $data = $vegetable->getWeather();
        $this->setHeaders($data);
    }

    public function convertToXML($data) {
        $jsonData = $data;
        
        $xml = new SimpleXMLElement('<?xml version="1.0"?><vegetables></vegetables>');
        foreach ($jsonData as $key => $rawData) {
            $vegetable = $xml->addChild('vegetable');
            foreach($rawData as $key => $value) {
                 $vegetable->addChild($key, $value);
           }
        }
        return $xml->asXML();
	}
}

?>
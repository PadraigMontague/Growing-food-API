<?php
require_once("../db/databaseController.php");



Class Fruit {
	
	private $fruit = array();
	
	public function createFruit(array $databaseConfig) {
		
		if(isset($_POST['name']) && isset($_POST['type']) && isset($_POST['plantingMonth'])
		&& isset($_POST['harvestMonth']) && isset($_POST['soilType'])){
            $validation = $this->authentication($_POST['token'], $_POST['username']);
            if($validation === '"Authorised"'){
                $name = htmlspecialchars($_POST['name']);
                $type = htmlspecialchars($_POST['type']);
                $plantingMonth = htmlspecialchars($_POST['plantingMonth']);
                $harvestMonth = htmlspecialchars($_POST['harvestMonth']);
                $soilType = htmlspecialchars($_POST['soilType']);
                $this->reportingUserActivity($_POST['username']);
                $this->logCall($_POST['username']);
                $dbcontroller = new DatabaseController($databaseConfig);
                $sqlQuery = "INSERT INTO fruit (name, type, plantingMonth, harvestMonth, soilType) 
                VALUES ('" . $name . "','" . $type . "','" . $plantingMonth . "','" . $harvestMonth . "','"
                . $soilType . "')";
    
                $result = $dbcontroller->execQuery($sqlQuery);
                return $this->ifSuccessful($result);
            }else{
                return 'Unauthorised';                
            }
        }else{
            return $this->acceptJsonOnCreate($databaseConfig);
        }
}

    public function acceptJsonOnCreate(array $databaseConfig){
        $contentType = file_get_contents('php://input');
        $data = json_decode($contentType, true);
        $token = $data['token'];
        $username = $data['username'];
        if(!empty($data['name']) && !empty($data['type']) && !empty($data['plantingMonth'])
		&& !empty($data['harvestMonth']) && !empty($data['soilType'])){
            $validation = $this->authentication($token, $username);
            if($validation === '"Authorised"'){
                $name = htmlspecialchars($data['name']);
                $type = htmlspecialchars($data['type']);
                $plantingMonth = htmlspecialchars($data['plantingMonth']);
                $harvestMonth = htmlspecialchars($data['harvestMonth']);
                $soilType = htmlspecialchars($data['soilType']);
                $this->reportingUserActivity($username);
                $this->logCall($username);
                $dbcontroller = new DatabaseController($databaseConfig);
                $sqlQuery = "INSERT INTO fruit (name, type, plantingMonth, harvestMonth, soilType) 
                VALUES ('" . $name . "','" . $type . "','" . $plantingMonth . "','" . $harvestMonth . "','"
                . $soilType . "')";
    
                $result = $dbcontroller->execQuery($sqlQuery);
                return $this->ifSuccessful($result);
            }else{
                return 'Unauthorised';                
            }
        }else{
            return 'Required fields not filled';
        }        
    }

    public function fetchAllFruit(array $databaseConfig){
        $contentType = file_get_contents('php://input');
        $data = json_decode($contentType, true);
        $token = $data['token'];
        $username = $data['username'];
        if(isset($token) && isset($username)){
            $validation = $this->authentication($token, $username);
            if($validation === '"Authorised"'){
                $sqlQuery = 'SELECT * FROM fruit';
                $dbcontroller = new DatabaseController($databaseConfig);
                $sqlStatement = $dbcontroller->queryData($sqlQuery);
                $this->reportingUserActivity($username);
                $this->logCall($username);
                $this->fruit = $sqlStatement;
                return $this->fruit;
            }else{
                return 'Unauthorised';
            }
        } else{
            return 'Unauthorised';
        }
}

    public function fetchByName(array $databaseConfig){
        if(isset($_POST['name']) && isset($_POST['token']) && isset($_POST['username'])){
            $validation = $this->authentication($_POST['token'], $_POST['username']);
            if($validation === '"Authorised"'){
                $name = $_POST['name'];
                $sqlQuery = 'SELECT * FROM fruit WHERE name LIKE "%' . $name . '%"';
                $this->reportingUserActivity($_POST['username']);
                $this->logCall($_POST['username']);
                $dbcontroller = new DatabaseController($databaseConfig);
                $sqlStatement = $dbcontroller->queryData($sqlQuery);
                $this->fruit = $sqlStatement;
                return $this->fruit;
            }else{
                return  'Unauthorised';
            }
        } else{
            return $this->fetchByNameWithJson($databaseConfig);
        }
    }
    public function fetchByNameWithJson(array $databaseConfig){
        $contentType = file_get_contents('php://input');
        $data = json_decode($contentType, true);
        if(!empty($data['name']) && !empty($data['token']) && !empty($data['username'])){
            $token = $data['token'];
            $username = $data['username'];
            $this->reportingUserActivity($username);
            $validation = $this->authentication($token, $username);
            if($validation === '"Authorised"'){
                $this->reportingUserActivity($username);
                $this->logCall($username);
                $name = $data['name'];
                $sqlQuery = 'SELECT * FROM fruit WHERE name LIKE "%' . $name . '%"';
                $dbcontroller = new DatabaseController($databaseConfig);
                $sqlStatement = $dbcontroller->queryData($sqlQuery);
                $this->fruit = $sqlStatement;
                return $this->fruit;
            }else{
                return  'Unauthorised';
            }
        }else{
                return 'Required fields not filled';
        }
    }

    public function plantingMonth(array $databaseConfig){
        if(isset($_POST['sowMonth']) && isset($_POST['token']) && isset($_POST['username'])){
            $token = $_POST['token'];
            $username = $_POST['username'];
            $this->reportingUserActivity($username);
            $this->logCall($username);
            $validation = $this->authentication($token, $username);
            if($validation === '"Authorised"'){
                $plantingMonth = $_POST['plantingMonth'];
                $sqlQuery = 'SELECT * FROM fruit WHERE plantingMonth LIKE "%' . $plantingMonth . '%"';
                $dbcontroller = new DatabaseController($databaseConfig);
                $sqlStatement = $dbcontroller->queryData($sqlQuery);
                $this->fruit = $sqlStatement;
                return $this->fruit;
            }else{
                return  'Unauthorised';
            }
        }else{
            return $this->ifNotPost('plantingMonth', $databaseConfig);
        } 
    }
    public function ifNotPost($parameterOne, array $databaseConfig){
        $contentType = file_get_contents('php://input');
        $data = json_decode($contentType, true);
        $dynamicVar = $data[$parameterOne];
        $token = $data['token'];
        $username = $data['username'];
        if(!empty($token) && !empty($username) && !empty($dynamicVar)){
           $this->reportingUserActivity($username);
           $this->logCall($username);
           $validation = $this->authentication($token, $username);
           if($validation === '"Authorised"'){
                $sqlQuery = 'SELECT * FROM fruit WHERE plantingMonth LIKE "%' . $dynamicVar . '%"';           
                $dbcontroller = new DatabaseController($databaseConfig);
                $sqlStatement = $dbcontroller->queryData($sqlQuery);
                $this->fruit = $sqlStatement;
                return $this->fruit;        
            }else{
                return  'Unauthorised';
            }
           }else{
               return  'Required fields not filled';
           }
    }


    public function updateFruit($databaseConfig) {
        if(isset($_POST['id']) && isset($_POST['token']) && isset($_POST['username'])) {
            $validation = $this->authentication($_POST['token'], $_POST['username']);
            if($validation === '"Authorised"'){
                $name = htmlspecialchars($_POST['name']);
                $type = htmlspecialchars($_POST['type']);
                $plantingMonth = htmlspecialchars($_POST['plantingMonth']);
                $harvestMonth = htmlspecialchars($_POST['harvestMonth']);
                $soilType = htmlspecialchars($_POST['soilType']);

                $sqlQuery = "UPDATE fruit SET name = '" . $name . "',type ='" . $type . "',plantingMonth = '" . $plantingMonth . 
                "',harvestMonth = '" . $harvestMonth . "',soilType = '" . $soilType . "' WHERE id = " . $id;
                $this->reportingUserActivity($_POST['username']);
                $this->logCall($_POST['username']);
                $dbcontroller = new DatabaseController($databaseConfig);
                $result = $dbcontroller->execQuery($sqlQuery);
                return $this->ifSuccessful($result);        
            }else{
                return  'Unauthorised';
            }
        } else {
            return $this->acceptJson($databaseConfig);
        }
    }

    public function acceptJson(array $databaseConfig){
        $contentType = file_get_contents('php://input');
        $data = json_decode($contentType, true);
        $token = $data['token'];
        $username = $data['username'];
        if(!empty($token) && !empty($username) && !empty($data['id']) && !empty($data['name']) && !empty($data['type'])
        && !empty($data['plantingMonth']) && !empty($data['harvestMonth']) && !empty($data['soilType'])){
           $validation = $this->authentication($token, $username);
           if($validation === '"Authorised"'){
                $id = htmlspecialchars($data['id']);
                $name = htmlspecialchars($data['name']);
                $type = htmlspecialchars($data['type']);
                $plantingMonth = htmlspecialchars($data['plantingMonth']);
                $harvestMonth = htmlspecialchars($data['harvestMonth']);
                $soilType = htmlspecialchars($data['soilType']);

                $sqlQuery = "UPDATE fruit SET name = '" . $name . "',type ='" . $type . "',plantingMonth = '" . $plantingMonth . 
                "',harvestMonth = '" . $harvestMonth . "',soilType = '" . $soilType . "' WHERE id = " . $id;
                $this->reportingUserActivity($username);
                $this->logCall($username);
                $dbcontroller = new DatabaseController($databaseConfig);
                $result = $dbcontroller->execQuery($sqlQuery);
                return $this->ifSuccessful($result);                  
           }else{
                return  'Unauthorised';
           }
        }else{
            return 'Required fields not filled';
        }
    }

    public function deleteFruit($databaseConfig){
        if(isset($_POST['id']) && isset($_POST['token']) && isset($_POST['username'])){
            $validation = $this->authentication($_POST['token'], $_POST['username']);
            if($validation === '"Authorised"'){
                $id = $_POST['id'];
                $sqlQuery = "DELETE FROM fruit WHERE id=" . $id;
                $this->reportingUserActivity($_POST['username']);
                $this->logCall($_POST['username']);
                $dbcontroller = new DatabaseController($databaseConfig);
                $result = $dbcontroller->execQuery($sqlQuery);
                return $this->ifSuccessful($result);
            } else{
                return  'Unauthorised';                 
            }
        }else{
            return $this->deleteUsingJson($databaseConfig);
        }
    }

    public function deleteUsingJson(array $databaseConfig){
        $contentType = file_get_contents('php://input');
        $data = json_decode($contentType, true);
        $token = $data['token'];
        $username = $data['username'];
        if(isset($data['id']) && isset($token) && isset($username)){
           $validation = $this->authentication($token, $username);
           if($validation === '"Authorised"'){
                $id = $data['id'];
                $sqlQuery = "DELETE FROM fruit WHERE id=" . $id;
                $this->reportingUserActivity($username);
                $this->logCall($username);
                $dbcontroller = new DatabaseController($databaseConfig);
                $result = $dbcontroller->execQuery($sqlQuery);
                return $this->ifSuccessful($result);           
            }else{
                return  'Unauthorised';              
            }
        }
    }

    public function reportingUserActivity($username){
        $data = array(
            'username' => $username,
            'timeReq' => $_SERVER['REQUEST_TIME'],
            'request_type' => $_SERVER['REQUEST_METHOD'], 
            'request_format' => $_SERVER['CONTENT_TYPE'], 
            'status_code' => $_SERVER['REDIRECT_STATUS'], 
            'request_url' => $_SERVER['REQUEST_URI'],
            'clientIP' => $_SERVER['REMOTE_ADDR']
        );                                                                    
        $covertedToString = json_encode($data);
        $endpoint =  'http://localhost/Reporting/report/create/';
        return $this->callExternalAPI($endpoint, $covertedToString);
    }

    public function authentication($token, $username){
        $data = array(
            'token' => $token,
            'username' => $username
        );                                                                    
        $covertedToString = json_encode($data);                                                                                   
        $endpoint =  'http://localhost/authentication/auth/validate/';
        return $this->callExternalAPI($endpoint, $covertedToString);
    }

    public function logCall($username){
        $data = array(
            'username' => $username
        );                                                                    
        $covertedToString = json_encode($data);                                                                                   
        $endpoint =  'http://localhost/authentication/auth/newCall/';
        return $this->callExternalAPI($endpoint, $covertedToString);  
    }

    public function callExternalAPI($endpoint, $covertedToString){
        $ch = curl_init($endpoint);                                                                      
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
        curl_setopt($ch, CURLOPT_POSTFIELDS, $covertedToString);                                                                  
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Accept: application/json',                                                                            
            'Content-Type: application/json',                                                                                
            'Content-Length: ' . strlen($covertedToString))                                                                       
        );                                                                                                                                                                                                                        
        return curl_exec($ch);
    }

    public function ifSuccessful($result){
        if($result != 'unsuccessful'){
            $result = array('Status' => 'Success');
            return $result;
        }else{
            $result = array('Status' => 'Unsuccessful');
            return $result;
        }   
    } 

    public function calcNumberOfPlants(){
        $contentType = file_get_contents('php://input');
        $data = json_decode($contentType, true);
        $token = $data['token'];
        $username = $data['username'];
        $squareFeet = $data['squareFeet'];
        $spacing = $data['spacing'];
        if(isset($token) && isset($username) && isset($squareFeet) && isset($spacing)){
           $this->reportingUserActivity($username);
           $this->logCall($username);
           $validation = $this->authentication($token, $username);
           if($validation === '"Authorised"'){  
                $this->reportingUserActivity($username);
                $totalSquareFeet = $squareFeet * 144;
                $totalSpacing = $spacing * $spacing;
                $totalPlants = $totalSquareFeet / $totalSpacing;
                if($totalPlants < 0 || $spacing < 0){
                    return array(array("NumberOfPlants" => 0));
                }else{
                    return array(array("NumberOfPlants" => $totalPlants));
                }
           }else{
                return  'Unauthorised';           
           }
        }
    }
}
?>
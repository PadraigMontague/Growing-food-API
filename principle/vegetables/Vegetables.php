<?php
require_once("../db/databaseController.php");
require_once("./json_path/json.php");
require_once("./json_path/jsonpath-0.8.1.php");

Class Vegetables {
	
    private $vegetables = array();
    private $opts = array( 
                    'http'=>array(
                    'method'=>"GET",
                    'header' => "Content-Type: application/json"
                    ));

	public function createVegetable(array $databaseConfig) {
		
		if(isset($_POST['token']) && isset($_POST['username']) && isset($_POST['name']) && isset($_POST['type']) && isset($_POST['sowMonth'])
		&& isset($_POST['harvestMonth']) && isset($_POST['minTemp']) && isset($_POST['soilType'])){
            $validation = $this->authentication($_POST['token'], $_POST['username']);
            if($validation === '"Authorised"'){
                $name = htmlspecialchars($_POST['name']);
                $type = htmlspecialchars($_POST['type']);
                $sowMonth = htmlspecialchars($_POST['sowMonth']);
                $harvestMonth = htmlspecialchars($_POST['harvestMonth']);
                $minTemp = htmlspecialchars($_POST['minTemp']);
                $soilType = htmlspecialchars($_POST['soilType']);

                $dbcontroller = new DatabaseController($databaseConfig);
                $sqlQuery = "INSERT INTO vegetables (name, type, sowMonth, harvestMonth, minTemp, soilType) 
                VALUES ('" . $name . "','" . $type . "','" . $sowMonth . "','" . $harvestMonth . "','" . $minTemp
                . "','" . $soilType . "')";
                $this->reportingUserActivity($_POST['username']);
                $this->logCall($_POST['username']);
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
        if(!empty($token) && !empty($username) && !empty($data['name']) && !empty($data['type']) && !empty($data['sowMonth'])
		&& !empty($data['harvestMonth']) && !empty($data['minTemp']) && !empty($data['soilType'])){
            $validation = $this->authentication($token, $username);
            if($validation === '"Authorised"'){
                $name = htmlspecialchars($data['name']);
                $type = htmlspecialchars($data['type']);
                $sowMonth = htmlspecialchars($data['sowMonth']);
                $harvestMonth = htmlspecialchars($data['harvestMonth']);
                $minTemp = htmlspecialchars($data['minTemp']);
                $soilType = htmlspecialchars($data['soilType']);
                $dbcontroller = new DatabaseController($databaseConfig);
                $sqlQuery = "INSERT INTO vegetables (name, type, sowMonth, harvestMonth, minTemp, soilType) 
                VALUES ('" . $name . "','" . $type . "','" . $sowMonth . "','" . $harvestMonth . "','" . $minTemp
                . "','" . $soilType . "')";
                $this->reportingUserActivity($username);
                $this->logCall($username);
                $result = $dbcontroller->execQuery($sqlQuery);
                return $this->ifSuccessful($result);
            }else{
                return 'Unauthorised';
            }
        }
    }

    public function fetchAllVeg(array $databaseConfig){
        $contentType = file_get_contents('php://input');
        $data = json_decode($contentType, true);
        $token = $data['token'];
        $username = $data['username'];
        if(isset($token) && isset($username)){
            $validation = $this->authentication($token, $username);
            if($validation === '"Authorised"'){
                $sqlQuery = 'SELECT * FROM vegetables';
                $this->reportingUserActivity($username);
                $this->logCall($username);
                $dbcontroller = new DatabaseController($databaseConfig);
                $sqlStatement = $dbcontroller->queryData($sqlQuery);
                $this->vegetables = $sqlStatement;
                return $this->vegetables;
            }else{
                return 'Unauthorised';
            }
        } else{
            return 'Unauthorised';
        }
    }
    
    public function fetchByName(array $databaseConfig){
        if(isset($_POST['name']) && isset($_POST['token']) && isset($_POST['username'])){
            $this->reportingUserActivity($_POST['username']);
            $this->logCall($_POST['username']);
            $token = $_POST['token'];
            $username = $_POST['username'];
            $validation = $this->authentication($token, $username);
            if($validation === '"Authorised"'){
                $name = $_POST['name'];
                $sqlQuery = 'SELECT * FROM vegetables WHERE name LIKE "%' . $name . '%"';
                $dbcontroller = new DatabaseController($databaseConfig);
                $sqlStatement = $dbcontroller->queryData($sqlQuery);
                $this->vegetables = $sqlStatement;
                return $this->vegetables;
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
            $this->logCall($username);
            $validation = $this->authentication($token, $username);
            if($validation === '"Authorised"'){
                $name = $data['name'];
                $sqlQuery = 'SELECT * FROM vegetables WHERE name LIKE "%' . $name . '%"';
                $dbcontroller = new DatabaseController($databaseConfig);
                $sqlStatement = $dbcontroller->queryData($sqlQuery);
                $this->vegetables = $sqlStatement;
                return $this->vegetables;
            }else{
                return  'Unauthorised';
            }
        }else{
            return 'Required fields not filled';
        } 
    }

    public function updateVegetables(array $databaseConfig) {
        if(isset($_POST['id']) && isset($_POST['token']) && isset($_POST['username'])) {
            $validation = $this->authentication($_POST['token'], $_POST['username']);
            if($validation === '"Authorised"'){
                $id = htmlspecialchars($_POST['id']);
                $name = htmlspecialchars($_POST['name']);
                $type = htmlspecialchars($_POST['type']);
                $sowMonth = htmlspecialchars($_POST['sowMonth']);
                $harvestMonth = htmlspecialchars($_POST['harvestMonth']);
                $minTemp = htmlspecialchars($_POST['minTemp']);
                $soilType = htmlspecialchars($_POST['soilType']);

                $sqlQuery = "UPDATE vegetables SET name = '" . $name . "',type ='" . $type . "',sowMonth = '" . $sowMonth . 
                "',harvestMonth = '" . $harvestMonth . "',minTemp = '" . $minTemp . "',soilType = '" . $soilType . "' WHERE id = " . $id;
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
        $type = $data['type'];
        if(isset($token) && isset($username) && !empty($type)){
           $validation = $this->authentication($token, $username);
           if($validation === '"Authorised"'){
           $id = htmlspecialchars($data['id']);
           $name = htmlspecialchars($data['name']);
           $type = htmlspecialchars($data['type']);
           $sowMonth = htmlspecialchars($data['sowMonth']);
           $harvestMonth = htmlspecialchars($data['harvestMonth']);
           $minTemp = htmlspecialchars($data['minTemp']);
           $soilType = htmlspecialchars($data['soilType']);

           $sqlQuery = "UPDATE vegetables SET name = '" . $name . "',type ='" . $type . "',sowMonth = '" . $sowMonth . 
           "',harvestMonth = '" . $harvestMonth . "',minTemp = '" . $minTemp . "',soilType = '" . $soilType . "' WHERE id = " . $id;
           $this->reportingUserActivity($username);
           $this->logCall($username);
           $dbcontroller = new DatabaseController($databaseConfig);
           $result = $dbcontroller->execQuery($sqlQuery);
           return $this->ifSuccessful($result);

           }else{
               return  'Unauthorised';
           }
        } else{
            return 'Required fields not filled';
        }
    }

    public function deleteVegetables(array $databaseConfig){
        if(isset($_POST['id']) && isset($_POST['token']) && isset($_POST['username'])){
            $validation = $this->authentication($_POST['token'], $_POST['username']);
            if($validation === '"Authorised"'){
                $id = $_POST['id'];
                $sqlQuery = "DELETE FROM vegetables WHERE id=" . $id;
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
                $sqlQuery = "DELETE FROM vegetables WHERE id=" . $id;
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
            'request_format' => $_SERVER['HTTP_ACCEPT'], 
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

    public function searchByTemp(array $databaseConfig){
        if(isset($_POST['minTemp']) && isset($_POST['token']) && isset($_POST['username'])){
            $token = $_POST['token'];
            $username = $_POST['username'];
            $this->reportingUserActivity($username);
            $this->logCall($username);
            $validation = $this->authentication($token, $username);
            if($validation === '"Authorised"'){
                $temperature = $_POST['minTemp'];
                $sqlQuery = "SELECT * FROM vegetables WHERE minTemp = '$temperature'";
                $dbcontroller = new DatabaseController($databaseConfig);
                $sqlStatement = $dbcontroller->queryData($sqlQuery);
                $this->vegetables = $sqlStatement;
                return $this->vegetables;
            }else{
                return  'Unauthorised';
            }
        } else{
            return $this->ifNotPost('minTemp', $databaseConfig);
        }  
    }

    public function sowMonth(array $databaseConfig){
        if(isset($_POST['sowMonth']) && isset($_POST['token']) && isset($_POST['username'])){
            $token = $_POST['token'];
            $username = $_POST['username'];
            $this->reportingUserActivity($username);
            $this->logCall($username);
            $validation = $this->authentication($token, $username);
            if($validation === '"Authorised"'){
                $sowMonth = $_POST['sowMonth'];
                $sqlQuery = 'SELECT * FROM vegetables WHERE sowMonth LIKE "%' . $sowMonth . '%"';
                $dbcontroller = new DatabaseController($databaseConfig);
                $sqlStatement = $dbcontroller->queryData($sqlQuery);
                $this->vegetables = $sqlStatement;
                return $this->vegetables;
            }else{
                return  'Unauthorised';
            }
        }else{
            return $this->ifNotPost('sowMonth', $databaseConfig);
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
               if($parameterOne != 'sowMonth'){
                $sqlQuery = "SELECT * FROM vegetables WHERE $parameterOne = '$dynamicVar'";
               } else{
                $sqlQuery = 'SELECT * FROM vegetables WHERE sowMonth LIKE "%' . $dynamicVar . '%"';                   
               }
               $dbcontroller = new DatabaseController($databaseConfig);
               $sqlStatement = $dbcontroller->queryData($sqlQuery);
               $this->vegetables = $sqlStatement;
               return $this->vegetables;

           }else{
               return  'Unauthorised';
           }
        } else {
            return 'Required fields not filled';
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

    public function getWeather(){
        $contentType = file_get_contents('php://input');
        $data = json_decode($contentType, true);
        $placename = $data['placename'];
        if(empty($placename)){
            return 'Required fields not filled';      	
        }else{
            $searchPlaceName = "" . $placename;
            $context = stream_context_create($this->opts);
            $json_data = @file_get_contents($searchPlaceName, false, $context);
            if(!empty($json_data)){
                if ($http_response_header[0] === 'HTTP/1.1 400 Bad Request'){
                    return 'Unable To Fetch Data';
                }else{
                    $parser = new Services_JSON(SERVICES_JSON_LOOSE_TYPE);
                    $json_object = $parser->decode($json_data);
                    $temp = jsonPath($json_object, "$.[current].[temp_c]");
                    if($temp[0] >= 10 && $temp[0] <= 18){
                        return array(array(
                            "temperature" => $temp[0],
                            "plantingConditions" => "Planting Conditions are very good, especially for tender vegetables.",
                            "tips" => "Remember not to have your seeds in direct sunlight!!!"
                        ));
                    } else if($temp[0] >18){
                        return array(array(
                            "temperature" => $temp[0],
                            "plantingConditions" => "Planting Conditions are not good, especially for seeds and young plants as the temperature is much too hot.",
                            "tips" => "If you have a Polytunnel or Greenhouse open it early in the morning to ensure there is not a heat build up."
                        ));                       
                    } else{
                        return array(array(
                            "temperature" => $temp[0],
                            "plantingConditions" => "Planting Conditions are not good, too cold to plant any seeds.",
                            "tips" => "Don't water your plants if the temperature is 5 degrees or under as it may cause them to freeze which could kill them."
                        ));
                    }
                }
            }else{
                return 'No Data Available';
            }
        }
    }
}

?>
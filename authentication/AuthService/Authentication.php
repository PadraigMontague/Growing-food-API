<?php
require_once("../db/databaseController.php");
include_once '../libs/BeforeValidException.php';
include_once '../libs/ExpiredException.php';
include_once '../libs/SignatureInvalidException.php';
include_once '../libs/JWT.php';
use \Firebase\JWT\JWT;

Class Authentication{

    private $jwtToken = array();
    private $key = "this is a very long secret key for encrypting tokens";
    public function tokenDetails($username, $email){
        date_default_timezone_set('Europe/Dublin');
        $iss = "http://CBWS-gardening-api.com/tokens";
        $aud = "http://cbws-horticulture.com";
        $iat = time() - 1000;
        $nbf = $iat + 1000;
        $expiryDate = strtotime("+12 months", time()); 
        
        $token = array(
            "iss" => $iss,
            "aud" => $aud,
            "iat" => $iat, 
            "nbf" => $nbf,
            "data" => array(
                "username" => $username,
                "email" => $email,
                "expiryDate" => date('d/m/Y',$expiryDate)
            )
        );

        return $token;
    }
    public function userRegistration(array $connectionConfig){

        $contentType = file_get_contents('php://input');
        $data = json_decode($contentType, true);

        $username = $data['username'];
        $email = $data['email'];

        if(!empty($username) && !empty($email)){
            $token = $this->tokenDetails($username, $email);
            $exists = $this->usernameExists($username, $connectionConfig);
            if($exists === "Authorised"){
               $jwt = JWT::encode($token, $this->key);
               $configSettings = new DatabaseController($connectionConfig);
               $sqlStatement = $configSettings->connection->prepare("insert into user_tokens (username, email, token) values (?,?,?)");
               $result = $sqlStatement->execute(array($username, $email, $jwt));
               $expiryDate = strtotime("+12 months", time()); 
              if ($result != 0) {
                   return array(array(
                       "message" => "Successful registration.",
                       "email" => $email,
                       "expiryDate" => $expiryDate,
                       "jwt" => $jwt));
               }
            } else{
               return 'Username Already Exists';
            }
        } else{
            return 'Required fields not filled';
        }
    }
    public function usernameExists($username, array $connectionConfig) {
            $sqlQuery = "SELECT COUNT(`username`) AS data FROM user_tokens WHERE username= '$username'";
            $dbcontroller = new DatabaseController($connectionConfig);
            $sqlStatement = $dbcontroller->queryData($sqlQuery);
             if ($sqlStatement[0]['data'] > 0) {
                 return 'Unauthorised';
             } else {
                 return 'Authorised';
             }
    }

    public function renew(array $connectionConfig){
        $key = "this is a very long secret key for encrypting tokens";
        $contentType = file_get_contents('php://input');
        $data = json_decode($contentType, true);
        if(!empty($data['username']) && !empty($data['token'])){
            $username = $data['username'];
            $token = $data['token'];
            $expiryDate = strtotime("+ 1 week", time()); 
            $tokenData = JWT::decode($token, $key, array('HS256'));
            $renewed = array(
                "iss" => $tokenData->iss,
                "aud" => $tokenData->aud,
                "iat" => $tokenData->iat, 
                "nbf" => $tokenData->nbf,
                "data" => array(
                    "username" => $tokenData->data->username,
                    "email" => $tokenData->data->email,
                    "expiryDate" => date('d/m/Y',$expiryDate)
                )
            );

            $jwt = JWT::encode($renewed, $this->key);
            $configSettings = new DatabaseController($connectionConfig);
            $sqlStatement = "UPDATE user_tokens SET token  = '$jwt' WHERE username = '$username'";
            $result = $configSettings->execute($sqlStatement);
            if ($result != 0) {
                return array(array(
                    "message" => "Renewed.",
                    "email" => $tokenData->data->email,
                    "expiryDate" => $expiryDate,
                    "jwt" => $jwt));
            }

            return $result;
        }else{
            return 0;
        }
    }

    public function revoke(array $connectionConfig){
        $key = "this is a very long secret key for encrypting tokens";
        $contentType = file_get_contents('php://input');
        $data = json_decode($contentType, true);
        if(!empty($data['username']) && !empty($data['token'])){
        $username = $data['username'];
        $token = $data['token'];
        $tokenData = JWT::decode($token, $key, array('HS256'));
        $revoked = array(
            "iss" => $tokenData->iss,
            "aud" => $tokenData->aud,
            "iat" => $tokenData->iat, 
            "nbf" => $tokenData->nbf,
            "data" => array(
                "username" => $tokenData->data->username,
                "email" => $tokenData->data->email,
                "blacklist" => true
            )
        );
        $jwt = JWT::encode($revoked, $this->key);
        $configSettings = new DatabaseController($connectionConfig);
        $sqlStatement = "UPDATE user_tokens SET token  = '$jwt' WHERE username = '$username'";
        $result = $configSettings->execute($sqlStatement);
        if ($result != 0) {
            return array(array(
                "message" => "Revoked",
                "username" => $tokenData->data->username,
                "email" => $tokenData->data->email,
                ));
        }

            return $result;
        } else{
            return 0;
        }
    }
    public function validateUser(){
        $contentType = file_get_contents('php://input');
        $data = json_decode($contentType, true);
        $token = $data['token'];
        $username = $data['username'];
        $key = "this is a very long secret key for encrypting tokens";
        if(isset($token) && isset($username)){
            $token = JWT::decode($token, $key, array('HS256'));
            if(array_key_exists('blacklist',$token->data)){
                return 'Unauthorised';
            }else{
                if($username === $token->data->username && strtotime($token->data->expiryDate) > strtotime('now')){
                    return 'Authorised';
                }else{
                    return 'Unauthorised';
                }
            }
        }else {
            return 'Unauthorised';
        }
    }

    public function validateTokenOnLogin($token, $username){
        $key = "this is a very long secret key for encrypting tokens";
       $token = JWT::decode($token[0]['token'], $key, array('HS256'));
        if(array_key_exists('blacklist',$token->data)){
           return 'Revoked';
        }else{
           if($username === $token->data->username && strtotime($token->data->expiryDate) > strtotime('now')){
               return 'Authorised';
           }else{
               return 'Unauthorised';
           }
       }
    }
    public function login(array $connectionConfig){
        $contentType = file_get_contents('php://input');
        $data = json_decode($contentType, true);
        $username = $data['username'];
        $email = $data['email'];
        if(isset($username) && isset($email)){
            $sqlQuery = 'SELECT token FROM user_tokens WHERE username LIKE "%' . $username . '%"' . 'AND email LIKE"%' . $email . '%"';
            $dbcontroller = new DatabaseController($connectionConfig);
            $sqlStatement = $dbcontroller->queryData($sqlQuery);
            if(!empty($sqlStatement)){
                $this->jwtToken = $sqlStatement;
                if($this->validateTokenOnLogin($this->jwtToken, $username) === 'Unauthorised'){
                    return 'Unauthorised';
                }else if($this->validateTokenOnLogin($this->jwtToken, $username) === 'Revoked'){
                    return 'Revoked';
                }else{
                    if($this->checkCallAmount($username, $connectionConfig) > 500){
                        return array(array("Status" => "You have exceeded your call allowance"));
                    }else{
                        return $this->jwtToken;
                    }
                }
            }else{
                return 'Unauthorised';                 
            }
        }else{
            return 'Unauthorised';  
       }
    }

    public function addCall(array $connectionConfig){
        $contentType = file_get_contents('php://input');
        $data = json_decode($contentType, true);
        $username = $data['username'];
        if(isset($username)){
            $sqlQuery = 'UPDATE user_tokens SET noOfCalls = noOfCalls + 1 WHERE username LIKE "%' . $username . '%"';
            $dbcontroller = new DatabaseController($connectionConfig);
            $stored = $dbcontroller->execute($sqlQuery);
            if ($stored != 0) {
                return array("Status" => "logged");
            } else{
                return array("Staus" => "Not logged");
            }
        }
    }

    public function checkCallAmount($username, array $connectionConfig){
        $sqlQuery = "SELECT noOfCalls FROM user_tokens WHERE username = '$username'";
        $dbcontroller = new DatabaseController($connectionConfig);
        $count = $dbcontroller->queryData($sqlQuery);
        return $count[0]['noOfCalls'];
    }
}

?>
<?php
require_once("../rest/Rest.php");
require_once("Authentication.php");
Class Handler extends Rest {
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
        $result = $data;
        $this->setResponseContent($contentType, $result);
    }

    function userReg(){
        $authentication = new Authentication();
        $data = $authentication->userRegistration($this->databaseConfig);
        $this->setHeaders($data);
    }

    function renewToken(){
        $authentication = new Authentication();
        $data = $authentication->renew($this->databaseConfig);
        $this->setHeaders($data);
    }

    function revokeToken(){
        $authentication = new Authentication();
        $data = $authentication->revoke($this->databaseConfig);
        $this->setHeaders($data);
    }

    function tokenValidation(){
        $authentication = new Authentication();
        $data = $authentication->validateUser();
        $this->setHeaders($data);      
    }

    function userLogin(){
        $authentication = new Authentication();
        $data = $authentication->login($this->databaseConfig);
        $this->setHeaders($data);
    }

    function logCallAmount(){
        $authentication = new Authentication();
        $data = $authentication->addCall($this->databaseConfig);
        $this->setHeaders($data);
    }
}

?>
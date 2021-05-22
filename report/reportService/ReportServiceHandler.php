<?php

require_once("./Report.php");
require_once("../rest/Rest.php");

Class ReportServiceHandler extends Rest {
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
        $result["output"] = $data;
        $this->setResponseContent($contentType, $result);
    }

    function createReport(){
        $report = new Report();
        $data = $report->createLog($this->databaseConfig);
        $this->setHeaders($data);
    }

    function fetchLogByDate(){
        $report = new Report();
        $data = $report->fetchLogByDate($this->databaseConfig);
        $this->setHeaders($data); 
    }

}

?>
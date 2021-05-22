<?php

require_once("../database/databaseController.php");

Class Report {

    private $reports = array();

    public function createLog(array $databaseConfig){
            $contentType = file_get_contents('php://input');
            $data = json_decode($contentType, true);
            
            $username = htmlspecialchars($data['username']);
            $date = date('d-m-Y');
            $time = htmlspecialchars($data['timeReq']);
            $request_type = htmlspecialchars($data['request_type']);
            $request_format = htmlspecialchars($data['request_format']);
            $status_code = htmlspecialchars($data['status_code']);
            $request_url = htmlspecialchars($data['request_url']);
            $clientIP = htmlspecialchars($data['clientIP']);

            $database = new DatabaseController($databaseConfig);
            $sqlStatement = "INSERT INTO logs (username, dateReq, timeReq, request_type, request_format, status_code, request_url, clientIP)
            VALUES ('" . $username . "','" . $date . "','" . $time . "','" . $request_type . "','" . $request_format . "','" . $status_code . "','" . $request_url . "','" . $clientIP ."')";
            $count = $database->execQuery($sqlStatement);

            if($count !=0){
                $count = array('success' => 1);
                return $count;
            }
    }

    public function fetchLogByDate(array $databaseConfig){
        $contentType = file_get_contents('php://input');
        $data = json_decode($contentType, true);
            $dateOne = $data['dateOne'];
            $dateTwo = $data['dateTwo'];
            $request_type = $data['request_type'];
            $sqlQuery = "SELECT * FROM logs WHERE dateReq BETWEEN '$dateOne' AND '$dateTwo' AND request_type = '$request_type'";
        $database = new DatabaseController($databaseConfig);
        $sqlStatement = $database->queryData($sqlQuery);
        $this->reports = $sqlStatement;
        return $sqlStatement;
    }
}

?>
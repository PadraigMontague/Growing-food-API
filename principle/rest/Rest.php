<?php

Class Rest {
	
    private $httpVersion = "HTTP/1.1";
    
    public function setHttpHeaders($contentType, $statusCode) {

        $statusMessage = $this->getHttpStatusMessage($statusCode);

        header($this->httpVersion . " " . $statusCode . " " . $statusMessage);
        header("Content-Type:" . $contentType);
    }

	public function getHttpStatusMessage($statusCode) {
		
		$httpStatus = array(
			200 => 'OK',
			201 => 'Created',
			400 => 'Bad Request',
			401 => 'Unauthorized',
			403 => 'Forbidden',
			404 => 'Not Found',
			405 => 'Method Not Allowed',
			408 => 'Request Timeout',
			500 => 'Internal Server Error',
			502 => 'Bad Gateway',
			503 => 'Service Unavailable',
			504 => 'Gateway Timeout',
			505 => 'HTTP Version Not Supported'
		);
		
		return ($httpStatus[$statusCode]) ? $httpStatus[$statusCode] : $status[500];
		
    }

    function setResponseContent($requestContentType, $data) {
        if (strpos($requestContentType, 'application/json') !== false) {
            $response = $this->encodeJson($data);
            echo $response;
        }
    }
    
    public function encodeJson($responseData) {
        $jsonResponse = json_encode($responseData);
        return $jsonResponse;
    }
	
}



?>
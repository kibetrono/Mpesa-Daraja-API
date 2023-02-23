<?php
 		
    header("Content-Type: application/json");
    $response = '{
        "ResultCode": 0, 
        "ResultDesc": "Confirmation Received Successfully"
    }';

    $confirmationresponse= file_get_contents('php://input');

    $jsonFile="confirmation-response.json";
    $log=fopen($jsonFile,'a');
    fwrite($log,$confirmationresponse);
    fclose($log);

    echo $response;
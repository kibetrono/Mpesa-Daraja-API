<?php
 		
    header("Content-Type: application/json");

    $stkcallbackresponse= file_get_contents('php://input');

    $jsonFile="mpesa-response.json";
    $log=fopen($jsonFile,'a');
    fwrite($log,$stkcallbackresponse);
    fclose($log);

    $data =json_decode($stkcallbackresponse);

    $MerchantRequestID = $data->Body->MerchantRequestID;
    $CheckoutRequestID = $data->Body->CheckoutRequestID;
    $ResultCode = $data->Body->ResultCode;
    $ResultDesc = $data->Body->ResultDesc;
    $Amount = $data->Body->CallbackMetadata->Item[0]->Value;
    $TransactionId = $data->Body->CallbackMetadata->Item[1]->Value;
    $UserPhoneNumber = $data->Body->CallbackMetadata->Item[4]->Value;

    // check if transaction if succesful
    if($ResultCode == 0){
        // save details in db
    }
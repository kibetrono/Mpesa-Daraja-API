<?php
include 'access-token.php';
$register_url= 'https://sandbox.safaricom.co.ke/mpesa/c2b/v1/registerurl';
$BusinessShortCode = '174379';
$confirmation_url = 'https://dev.softwareske.net/confirmation_url.php';
$validation_url= 'https://dev.softwareske.net/validation_url.php';


$registerheader = ['Content-Type:application/json','Authorization:Bearer '.$access_token];


# initiating the transaction
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $register_url);
curl_setopt($curl, CURLOPT_HTTPHEADER, $registerheader); //setting custom header


$curl_post_data = array(
    //Fill in the request parameters with valid values
    'ShortCode' => $BusinessShortCode,
    'ResponseType' => 'Completed',
    'ConfirmationURL' => $confirmation_url,
    'ValidationURL' => $validation_url,

  );
  
  $data_string = json_encode($curl_post_data);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
    $curl_response = curl_exec($curl);
  
    $data =json_decode($curl_response);
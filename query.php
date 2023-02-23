<?php

include 'access-token.php';

$query_url = 'https://sandbox.safaricom.co.ke/mpesa/stkpushquery/v1/query';
date_default_timezone_set('Africa/Nairobi');

$passKey = 'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919';
$BusinessShortCode = '174379';
$Timestamp = date('YmdHis');
$Password = base64_encode($BusinessShortCode.$passKey.$Timestamp);

// unigue id generated when the stk push was successful
$checkOutRequestId = 'ws_CO_23022023120918005728234794';

$queryheader = ['Content-Type:application/json','Authorization:Bearer '.$access_token];


# initiating the transaction
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $processrequestUri);
curl_setopt($curl, CURLOPT_HTTPHEADER, $queryheader); //setting custom header

$curl_post_data = array(
  //Fill in the request parameters with valid values
  'BusinessShortCode' => $BusinessShortCode,
  'Password' => $Password,
  'Timestamp' => $Timestamp,
  'CheckoutRequestID' => $checkOutRequestId
  
);

$data_string = json_encode($curl_post_data);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_POST, true);
  curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
  $curl_response = curl_exec($curl);

  $data =json_decode($curl_response);


  if(isset($data->ResultCode)){

    $resultCode = $data->ResultCode;

    if($resultCode == '1037'){
        $message = 'Timeout is completing transaction';
    }
    if($resultCode == '1032'){
        $message = 'Transaction was cancelled by user';
    }
    if($resultCode == '1'){
        $message = 'Insufficient balance to complete the transaction';
    }
    if($resultCode == '0'){
        $message = 'Succeful Transaction';
    }
    
  }

  echo $message;
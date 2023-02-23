<?php
// including the access token file
include 'access-token.php';
date_default_timezone_set('Africa/Nairobi');

$processrequestUri='https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest'; // from stimulate on mpesa express
$CallBackURL = 'https://dev.softwareske.net/callback.php';
$passKey = 'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919';
$BusinessShortCode = '174379';
$Timestamp = date('YmdHis');
$Password = base64_encode($BusinessShortCode.$passKey.$Timestamp);
$phone = '254728234794';
$money = '1';
$PartyA = $phone;
$PartyB = '254728234794';
$AccountReference = 'SoftwaresKe';
$TransactionDesc = 'stk push test';
$Amount = $money;
$stkheader = ['Content-Type:application/json','Authorization:Bearer '.$access_token];


# initiating the transaction
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $processrequestUri);
curl_setopt($curl, CURLOPT_HTTPHEADER, $stkheader); //setting custom header

$curl_post_data = array(
  //Fill in the request parameters with valid values
  'BusinessShortCode' => $BusinessShortCode,
  'Password' => $Password,
  'Timestamp' => $Timestamp,
  'TransactionType' => 'CustomerPayBillOnline',
  'Amount' => $Amount,
  'PartyA' => $PartyA,
  'PartyB' => $BusinessShortCode,
  'PhoneNumber' => $PartyA,
  'CallBackURL' => $CallBackURL,
  'AccountReference' => $AccountReference,
  'TransactionDesc' => $TransactionDesc
);

$data_string = json_encode($curl_post_data);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_POST, true);
  curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
  $curl_response = curl_exec($curl);

  $data =json_decode($curl_response);

  $MerchantRequestID = $data->MerchantRequestID;
  $CheckoutRequestID = $data->CheckoutRequestID;
  $ResponseCode = $data->ResponseCode;

  if($ResponseCode == '0'){
    echo $CheckoutRequestID;
  }
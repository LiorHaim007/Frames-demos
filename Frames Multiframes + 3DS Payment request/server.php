<?php 
// Display errors to screen
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// The token that you got from Frames
$card_token = $_POST['cko-card-token'];    

$url = 'https://api.sandbox.checkout.com/payments';
$api_key = 'sk_test_6866cc6c-0f30-4aa5-9157-e2296b5bfb52';
$body = '{
    "source": {
        "type": "token",
        "token": "' . $card_token . '",
        "name": "Sarah Mitchell"
    },
    "amount": 1000,
    "currency": "USD",
    "3ds": {
        "enabled": true
      },
    "success_url": "https://i.imgflip.com/5ox1rv.jpg",
    "reference": "ORD-5023-4E89"
}';

// Curl POST request
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Authorization: '.$api_key,
    'Content-Type:application/json;charset=UTF-8'
));
curl_setopt($ch, CURLOPT_POSTFIELDS,$body);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$server_output = curl_exec($ch);
curl_close ($ch);

// The $response variable contains the API response
$response = json_decode($server_output);

// Print Response
echo('<pre>'.print_r($response, true).'</pre>');
header("Location: ".$response->_links->redirect->href);
exit();

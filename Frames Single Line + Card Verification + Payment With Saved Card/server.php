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
    "currency": "USD",
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
// echo('<pre>'.print_r($response, true).'</pre>');
echo '<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha/css/bootstrap.css" rel="stylesheet">';

echo "<div class='container' style='margin-top: 20px;'>
        <div class='jumbotron'>
            <h1>Done</h1></h1>
            <p>At this point the customer has been created, and the card has been linked. This is the Source Id that you can use to charge the customer now or in the future: <mark>".$response->source->id."</mark></p>
            <p> Click the button bellow to charge the customer:</p>
            
            <form action='charge_with_source.php'>
                <input type='hidden' name='source-id' value='".$response->source->id."'><br>
                <input class='btn btn-success' type='submit' value='CHARGE'>
            </form>
       
        </div>
      </div>";
exit();

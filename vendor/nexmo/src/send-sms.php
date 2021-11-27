<?php

require_once "vendor/autoload.php";
$client = new Nexmo\Client(new Nexmo\Client\Credentials\Basic("855de446", "iKYHA4zYzabA4VKb"));
try {
    $message = $client->message()->send([
        'to' => 255746553132,
        'from' => 'Rental House Management System',
        'text' => 'Your rent is due niqqa'
    ]);
    $response = $message->getResponseData();

    if($response['messages'][0]['status'] == 0) {
        echo "The message was sent successfully\n";
    } else {
        echo "The message failed with status: " . $response['messages'][0]['status'] . "\n";
    }
} catch (Exception $e) {
    echo "The message was not sent. Error: " . $e->getMessage() . "\n";
}

 ?>

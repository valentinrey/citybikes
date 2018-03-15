<?php
header('Content-Type: */*; charset=utf-8');
define('KEY', 'YOUR_KEY');

require __DIR__ . '/slim/vendor/autoload.php';

$app = new Slim\App;

$app->get('/stations[/availability]', function ($request,$response, $args) {
    $endpoint = $request->getUri()->getPath();
    $response->withHeader('Content-Type', 'application/json');
    return $response->write(getCall($endpoint));
});

$app->get('/status', function ($request,$response, $args) {
    $endpoint = $request->getUri()->getPath();
    $response->withHeader('Content-Type', 'application/json');
    return $response->write(getCall($endpoint));
});

$app->run();


function getCall($endpoint){
    $url = "https://oslobysykkel.no/api/v1/".$endpoint;

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($curl, CURLOPT_HTTPHEADER, array("Client-Identifier: ".KEY));
    $response = curl_exec($curl);

    if($errno = curl_errno($curl)) {
        $error_message = curl_error($curl);
        die("cURL error ({$errno}):\n {$error_message}");
    }

    return $response;
    //echo json_decode($response,true);
}

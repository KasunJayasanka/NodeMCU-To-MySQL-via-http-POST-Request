<?php

// Change port accordingly
$servername = "eu-cdbr-west-03.cleardb.net";

// REPLACE with your Database name
$dbname = "heroku_cc37febd15469e6";
// REPLACE with Database user
$username = "bc198622e1365c";
// REPLACE with Database user password
$password = "f0e73a72";

// Keep this API Key value to be compatible with the ESP32 code provided in the project page.
// If you change this value, the ESP32 sketch needs to match
$api_key_value = 'tPmAT5Ab3j7F9';

// keep the respnse payload
$response = ['success' => false, 'massage' => 'Internal server error' ];
// set the http response code
$responseCode = 500; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {    
    // get request header in order to get api key
    $header = apache_request_headers();

    // get api key
    $apiKey = $header['X-API-KEY'] ?? null; // shorthand operator IF X-API-KEY exist in header assing X-API-KEY value ELSE assign null


    if($apiKey == $api_key_value) {
        
        // get input json payload
        $json = file_get_contents('php://input');
        $json = json_decode($json, true);

        // var_dump($json); return;

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        
        // Check connection
        if ($conn->connect_error) {
            $response['massage'] = 'Connection failed'.$conn->connect_error;
            $responseCode = 500; // internal server error
        } else {
            // prepare sql connection
            // ref -> https://www.w3schools.com/php/php_mysql_prepared_statements.asp
            $stmt = $conn->prepare("INSERT INTO nodemcu_table (sensorValue1,sensorValue2,sensorValue3,sensorValue4) VALUES (?,?,?,?);");

            // get values form pay load
            $sensorValue1 = (float)($json['sensorValue1'] ?? 0); 
            $sensorValue2 = (float)($json['sensorValue2'] ?? 0); 
            $sensorValue3 = (float)($json['sensorValue3'] ?? 0); 
            $sensorValue4 = (float)($json['sensorValue4'] ?? 0);

            // bind paramiters to sql statement
            $stmt->bind_param(
                'dddd',
                $sensorValue1, 
                $sensorValue2, 
                $sensorValue3, 
                $sensorValue4,
            );

            if ($stmt->execute() === true) {
                $response['success'] = true;
                $response['massage'] = 'Data inserted successfully';
                $responseCode = 200; // response success
            } else {
                $response['massage'] = 'Error: ' . $sql .' '. $conn->error;
                $responseCode = 500; // internal server error
            }

            $stmt->close();
        }

        // Close the connection
        $conn->close();

    } else {
        $response['massage'] = 'Wrong API Key provided!';
        $responseCode = 401; // unauthorized request
    } 


} else {
    $response['massage'] = 'Method Not Allowed';
    $responseCode = 405; // Method Not Allowed
}

// send response to client
http_response_code($responseCode);
header('Content-Type: application/json; charset=utf-8');
echo json_encode($response);
?>

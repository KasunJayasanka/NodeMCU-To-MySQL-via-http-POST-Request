<?php
session_start();
?>

<?php
$api_key_value = "tPmAT5Ab3j7F9";

$apiKey= $sensor = $location = $sensorValue = $value2 = $value3 = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $api_key = test_input($_POST["apiKey"]);
    if($apiKey==$api_key_value) {
        $sensorValue = test_input($_POST["sensorValue"]);
       
        $_SESSION['data'] = $sensorValue;
        
        // Create connection
        include 'inc/connection.php';
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 
        
        $sql = "INSERT INTO nodemcu_table (sensorValue)
        VALUES ('" . $sensorValue . "')";
        
        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
              
        } 
        else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        
        //------------------------------------------------------------------------------------------------------------------------------------
     
        $conn->close();
    }
    else {
        echo "Wrong API Key provided.";
    }

}
else {
    echo "No data posted with HTTP POST.";
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

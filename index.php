<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="1"> <!-- Refreshes the browser every 1 second -->
    <!-- All the CSS styling for our Web Page, is inside the style tag below -->
    <title>NodeMCU MySQL Datalog</title>
   
    <style type="text/css">
        @import url('https://fonts.googleapis.com/css2?family=Roboto+Condensed&display=swap');
       * {
            margin: 0;
            padding: 0;
        }
        body {
            background: url('/img/bg.jpg') no-repeat center center;
            background-attachment: fixed;
            background-size: cover;
            display: grid;
            align-items: center;
            justify-content: center;
            height: 100vh;
            font-family:Haettenschweiler, 'Arial Narrow Bold', sans-serif;
        }
        .container {
            box-shadow: 0 0 1rem 0 rgba(0, 0, 0, .2);
            border-radius: 1rem;
            position: relative;
            z-index: 1;
            background: inherit;
            overflow: hidden;
                text-align:center;
                padding: 5rem;
            font-size:40px;
                color: black;
        }
        .container:before {
            content: "";
            position: absolute;
            background: inherit;
            z-index: -1;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            box-shadow: inset 0 0 2000px rgba(255, 255, 255, .5);
            filter: blur(10px);
            margin: -20px;
        }         
            h1{
               font-size: 40px;
            }
        p{
            margin: 60px 0 0 0;
        }
  </style>
</head>
<body>
    <?php
        $host = "eu-cdbr-west-03.cleardb.net";  // host = localhost because database hosted on the same server where PHP files are hosted
        $dbname = "heroku_cc37febd15469e6";  // Database name
        $username = "bc198622e1365c";  // Database username
        $password = "f0e73a72"; // Database password
        // Establish connection to MySQL database
        $conn = new mysqli($host, $username, $password, $dbname);
        // Check if connection established successfully
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        // Query the single latest entry from the database. -> SELECT * FROM table_name ORDER BY col_name DESC LIMIT 1
        $sql = "SELECT * FROM nodemcu_table ORDER BY id DESC LIMIT 1";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            //Will come handy if we later want to fetch multiple rows from the table
            while($row = $result->fetch_assoc()) { //fetch_assoc fetches a row from the result of our query iteratively for every row in our result.
                //Returning HTML from the server to show on the webpage.
                echo '<div class="container">';
                echo '<h1>NodeMCU Data Logging</h1>';
                                                  
                echo '<p>';
                echo '   <span class="dht-labels">sensorValue1 = </span>';
                echo '   <span id="temperature">'.$row["sensorValue1"].' &#8451</span>';
                echo ' </p>';
                                                  
                echo '<p>';                               
                echo '   <span class="dht-labels">sensorValue2 = </span>';
                echo '   <span id="temperature">'.$row["sensorValue2"].' &#8451</span>';
                echo ' </p>';

                echo '<p>';                               
                echo '   <span class="dht-labels">sensorValue3 = </span>';
                echo '   <span id="temperature">'.$row["sensorValue3"].' &#8451</span>';
                echo ' </p>';

                echo '<p>';                               
                echo '   <span class="dht-labels">sensorValue4 = </span>';
                echo '   <span id="temperature">'.$row["sensorValue4"].' &#8451</span>';
                echo ' </p>';
                                                  
                echo '</div>';
            }
        } else {
            echo "0 results";
        }
    ?>
</body>
</html>

<html>
<head>
    
</head>
<body>
    
</body>
</html>

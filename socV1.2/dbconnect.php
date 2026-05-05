<?php
$server="localhost";
$username="u419907007_kauntey";
$password="SOC@account1";
$dbname = "u419907007_user_info";

    // Create connection
    $conn = mysqli_connect($server, $username, $password, $dbname);
    
        // Check connection
      if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
      }

?>


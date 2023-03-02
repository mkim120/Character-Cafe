<?php
    // MySQL database credentials
    // create connection
    $host = "localhost";
    $user = "kuk10";
    $password = "Student_4109484";
    $database = "kuk10";
    $conn = new mysqli($host, $user, $password, $database);
    
    // check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    //echo "Connected successfully";
?> 
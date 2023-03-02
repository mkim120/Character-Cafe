<?php
    session_start();
    require 'config.php';
    // unset session variable and destroy session
    /*unset($_SESSION['loggedin']);*/
    session_unset();
    session_destroy();
    $conn->close();
    // redirect to home page
    header("Location: index.php");
?>
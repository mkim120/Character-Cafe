<?php
    session_start();
    
    // redirect to manager login page if NOT logged in   
    if(!isset($_SESSION['manager'])) {
        header("Location: managerlogin.php");
        exit();
    }

    require 'config.php';
    $check = implode("','", $_POST['checkbox']);
    $query = "UPDATE food SET available = 'no' WHERE foodID in ('$check')";
    $result = $conn->query($query) or die($conn->error);

    header('Location: removefood.php');
    $conn->close();
?>
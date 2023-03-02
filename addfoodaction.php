<?php
    session_start();
    
    // redirect to manager login page if NOT logged in   
    if(!isset($_SESSION['manager'])) {
        header("Location: managerlogin.php");
        exit();
    }

    require 'config.php';
    
    // sanitize
    $name = $conn->real_escape_string($_POST['name']);
    $description = $conn->real_escape_string($_POST['description']);
    $price = $conn->real_escape_string($_POST['price']);
    $imagePath = $conn->real_escape_string($_POST['imagePath']);
    $available = $conn->real_escape_string($_POST['available']);

    $query = "INSERT INTO food (name, description, price, imagePath, available) VALUES ('$name', '$description', '$price', '$imagePath', '$available')";
    $success = $conn->query($query);
    if(!$success) {
        echo "Something went wrong.";
    } else {
        header('Location: menu.php');
    }
    $conn->close();
?>
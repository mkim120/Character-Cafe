<?php 
        // redirect to home page if customer is logged in   
        /*if(isset($_SESSION['customer'])) {
            header("location: index.php"); 
        }*/
        if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
            header("Location: index.php");
            exit();
        }
        
/*
        include 'header.php';
*/

        // define and initialize variables
        $username = $password = "";
        $usernameError = $passwordError = $error = "";
        
        // process form when submitted
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // check username
            if(empty(trim($_POST['username']))) {
                $usernameError = "*Username is required.";
            } else { 
                $username = $conn -> real_escape_string(trim($_POST['username']));
            }
            
            // check password
            if(empty(trim($_POST['password']))) {
                $passwordError = "*Password is required.";
            } else {
                $password = trim($_POST['password']);
            }
            
            // connect to database
            require 'config.php';
            
            // validate credentials if no errors
            if(empty($usernameError) && empty($passwordError)) {
                // prepare select statement
                $query = "SELECT customerID, username, password FROM customer WHERE username = ? LIMIT 1";
                    if($stmt = $conn->prepare($query)) {
                    // bind variables to prepared statement as parameters
                    $stmt->bind_param("s", $paramUsername);
                    // set parameters
                    $paramUsername = $username;
                    // execute prepared statement
                    if($stmt->execute()) {
                        // store result
                        $stmt->store_result();
                        // check if username exists, if yes then verify password
                        if($stmt->num_rows == 1) {                    
                            // bind result variables
                            $stmt->bind_result($id, $username, $hashedPassword);
                            if($stmt->fetch()) {
                                if(password_verify($password, $hashedPassword)) {
                                    // start new session
                                    session_start();
                                    // store data in session variables
                                    $_SESSION['loggedin'] = 1;
                                    $_SESSION['id'] = $id;
                                    $_SESSION['customer'] = $username;                            
                                    // redirect to home page
                                    header("Location: index.php");
                                } else {
                                    $error = "Incorrect username or password.<br><br>";
                                }
                            }
                        } else {
                            $error = "Incorrect username or password.<br><br>";
                        }
                    } else {
                        echo "Something went wrong. Please try again later.";
                    }
                    $stmt->close();
                }
            }
                    $conn->close();

        }
    ?>
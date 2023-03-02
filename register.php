<?php 
    session_start(); 
    
    // redirect to home page if customer is logged in   
    if(isset($_SESSION['customer'])) {
        header("Location: index.php");
        exit();
    }
?> 
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Register | Genshin Cafe</title>
</head>
<body>
    <?php
        include 'header.php';
    
        // connect to database
        require 'config.php';

        // define and initialize variables
        $fullname = $username = $password = $confirm = $email = "";
        $fullnameError = $usernameError = $passwordError = $confirmError = $emailError = "";
        
        // process form when submitted
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // check username
            if(empty(trim($_POST['username']))) {
                $usernameError = "Username is required.<br>";
            } elseif(!preg_match("/^[a-zA-Z0-9-_]+$/", $_POST['username'])) { 
                $usernameError = "Username must only contain alphanuermic characters, hyphens, and underscores.<br>"; 
            } else { 
                // verify username
                $query = "SELECT username FROM customer WHERE username = ?";
                if($stmt = $conn->prepare($query)) {
                    // bind variables to prepared statement as parameters
                    $stmt->bind_param("s", $paramUsername);
                    // set parameters and execute
                    $paramUsername = trim($_POST['username']);
                    if($stmt->execute()) {
                        $stmt->store_result();
                        if($stmt->num_rows == 1) {
                            $usernameError = "This username is already taken.<br>";
                        } else {
                            $username = trim($_POST['username']);
                        }
                    } else {
                        echo "<br>Something went wrong. Please try again later.";
                    }
                    $stmt->close();
                }
            }
            
            // check password
            if(empty(trim($_POST['password']))) {
                $passwordError = "Password is required.<br>";
            } else {
                $password = trim($_POST['password']);
            }
            // confirm password
            if(empty($_POST['confirm']) && !empty($_POST['password'])) {
                $confirmError = "Please confirm password.<br>";     
            } else {
                $confirm = $_POST['confirm'];
                if(empty($passwordError) && $password != $confirm) {
                    $confirmError = "Password did not match.<br>";
                }
            }
            
            // insert into database if no errors
            if(empty($usernameError) && empty($passwordError) && empty($confirmError)) {
                $query = "INSERT INTO customer (username, password, creationDate) VALUES (?, ?, now())";
                if($stmt = $conn->prepare($query)) {
                    $stmt->bind_param("ss", $paramUsername, $paramPassword);
                    $paramUsername = $username;
                    $paramPassword = password_hash($password, PASSWORD_DEFAULT);
                    if($stmt->execute()) {
                        // redirect to login page with success message
                        header("Location: login.php?register=true");
                        exit();
                    } else {
                        echo "<br>Something went wrong. Please try again later.";
                    }
                    $stmt->close();
                }
            }
        }
        $conn->close();
    ?>   
    
    <div class="container-fluid login-form">
        <div class="row">
            <div class="col-md-5 login-sec">                
                <h2 class="text-center">Register</h2>

                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" class="login-form">
                    <!-- username -->
                    <div class="wrap-input validate-input">
                        <span class="label-input">Username</span>
                        <input class="input" type="text" name="username" <?php if(isset($username)) echo "value='$username'"; ?> autofocus>
                        <span class="focus-input"></span>
                    </div>
                    <span class="error"><?php echo $usernameError; ?></span>
                    <span class="error"><?php if($usernameError == "" && $passwordError == "") echo $error; ?></span>
                    <br>
                    <!-- password -->
                    <div class="wrap-input validate-input">
                        <span class="label-input">Password</span>
                        <input class="input" type="password" name="password">
                        <span class="focus-input"></span>
                    </div>
                    <span class="error"><?php echo $passwordError; ?></span>
                    <span class="error"><?php echo $confirmError; ?></span>
                    <br>
                    <!-- confirm -->
                    <div class="wrap-input validate-input">
                        <span class="label-input">Confirm Password</span>
                        <input class="input" type="password" name="confirm">
                        <span class="focus-input"></span>
                    </div>
                    <br>    
                    <!-- submit -->
                    <div class="container-login-btn">
                        <input type="submit" id="login" class="btn btn-dark btn-block" value="Register">
                    </div>
                    <!-- login -->
                    <div class="text-right p-t-8 p-b-31">
                        <p class="link">Already have an account? <a href="login.php">Log In <i class="fa fa-chevron-right"></i></a></p>
                    </div>
                    <!-- social media -->
                    <div class="txt1 text-center p-t-54 p-b-20">
                        <span>Or log in using social media</span>
                    </div>
                    <div class="flex-c-m link">
                        <a href="#" class="login-social-item fb-bg">
                            <i class="fa fa-facebook"></i>
                        </a>
                        <a href="#" class="login-social-item tw-bg">
                            <i class="fa fa-twitter"></i>
                        </a>
                    </div>
                </form>
            </div>

            <!-- carousel -->
            <div class="col-md-7 banner-sec">   
                <div id="carousel" class="carousel slide carousel-fade" data-ride="carousel">
                    <!--<ol class="carousel-indicators">
                        <li data-target="#carousel" data-slide-to="0" class="active"></li>
                        <li data-target="#carousel" data-slide-to="1"></li>
                    </ol>-->

                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <!-- image source: https://www.pixiv.net/en/artworks/83935073 -->
                            <img class="img-responsive fit-image" style="height: 560px" src="images/genshin-food.jpg" alt="">
                        </div>
                        <div class="carousel-item">
                            <!-- image source: https://www.instagram.com/p/CB21qd0pD0u/ -->
                            <img class="img-responsive fit-image" style="height: 560px;" src="images/genshin-food2.jpg" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php 
        include 'footer.php';
    ?>
</body>
</html>
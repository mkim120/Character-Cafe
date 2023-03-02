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
    <title>Login | Genshin Cafe</title>
</head>
<body>
    <?php
        include 'header.php';
    
        // connect to database
        require 'config.php';

        // define and initialize variables
        $username = $password = "";
        $usernameError = $passwordError = $error = "";
        
        // process form when submitted
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // check username
            if(empty(trim($_POST['username']))) {
                $usernameError = "Username is required.<br>";
            } else { 
                $username = $conn -> real_escape_string(trim($_POST['username']));
            }
            
            // check password
            if(empty(trim($_POST['password']))) {
                $passwordError = "Password is required.<br>";
            } else {
                $password = trim($_POST['password']);
            }
            
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
                                    $error = "<br>Incorrect username or password.<br>";
                                }
                            }
                        } else {
                            $error = "<br>Incorrect username or password.<br>";
                        }
                    } else {
                        echo "<br>Something went wrong. Please try again later.";
                    }
                    $stmt->close();
                }
            }
        }
        $conn->close();
    ?>
    
    <!-- https://bootsnipp.com/snippets/X2GOr -->
    <div class="container-fluid login-form">
        <div class="row">
            <div class="col-md-5 login-sec">
                <!-- registration message -->
                <h3 class="text-center"><?php if(@$_GET['register'] == 'true') echo "You have registered successfully.<br><br>" ?></h3>
                
                <h2 class="text-center">Log In</h2>

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
                    <br>
                    <!-- submit -->
                    <div class="container-login-btn">
                        <input type="submit" id="login" class="btn btn-dark btn-block" value="Log In">
                    </div>
                    <!-- register -->
                    <div class="text-right p-t-8 p-b-31">
                        <p class="link">New Customer? <a href="register.php">Register Now <i class="fa fa-chevron-right"></i></a></p>
                    </div>
                    <!-- managers -->
                    <div class="text-right p-t-8 p-b-31">
                        <p class="link">Managers log in <a href="managerlogin.php">HERE <i class="fa fa-chevron-right"></i></a></p>
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
                            <img class="img-responsive fit-image" src="images/genshin-food.jpg" alt="">
                        </div>
                        <div class="carousel-item">
                            <!-- image source: https://www.instagram.com/p/CB21qd0pD0u/ -->
                            <img class="img-responsive fit-image" src="images/genshin-food2.jpg" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal Login Form -->
    <!--<div id="loginModal" class="modal fade">
        <div class="modal-dialog modal-login">
            <div class="modal-content">-->
                <!--<div class="modal-header">
                    <div class="modal-title"><img src="images/logo.png" alt="logo"></div>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <form action="" method="post">
                        <div class="form-group">
                            <input type="text" name="username" id="username" <?php if(isset($username)) echo "value='$username'"; ?> class="form-control" placeholder="Username">
                            <span class="error"><?php echo $usernameError; ?></span>
                        </div>
                        <br>
                        <span class="error"><?php if($usernameError == "" && $passwordError == "") echo $error; ?></span>
                        <div class="form-group">
                            <input type="password" id="password" class="form-control" placeholder="Password">
                            <span class="error"><?php echo $passwordError; ?></span>
                        </div>
                        <div class="form-group">
                            <input type="submit" id="login" class="btn btn-primary btn-block btn-lg" value="Log In">
                        </div>
                    </form>				
                    <p class="register">New Customer? <a href="register.php">Register Now</a></p>
                </div>-->
            <!--</div>
        </div>
    </div>-->

    <?php 
        include 'footer.php';
    ?>
</body>
</html>
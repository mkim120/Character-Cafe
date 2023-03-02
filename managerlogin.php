<?php 
    session_start();

    // redirect to dashboard if manager is logged in   
    if(isset($_SESSION['manager'])) {
        header("Location: dashboard.php");
        exit();
    }
?> 
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manager Login | Genshin Cafe</title>
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
                // verify username and password
                $sql = "SELECT * FROM manager WHERE username = '$username' AND password = '$password'";
                // perform query
                $request = $conn->query($sql);
                if($request->num_rows > 0) {
                    // put results in assoc array
                    $row = $request->fetch_assoc();
                    $id = $row['managerID'];
                    $username = $row['username'];
                    // session variables
                    $_SESSION['loggedin'] = 1;
                    $_SESSION['id'] = $id;
                    $_SESSION['manager'] = $username;
                    // redirect to main page
                    header("Location: dashboard.php");
                } else {
                    $error = "<br>Incorrect username or password.<br>";
                }
            }
        }
        $conn->close();
    ?>
    
    <div class="container-fluid login-form">
        <div class="row">
            <div class="col-md-5 login-sec">                
                <h2 class="text-center">Manager Log In</h2>

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

    <?php 
        include 'footer.php';
    ?>
</body>
</html>
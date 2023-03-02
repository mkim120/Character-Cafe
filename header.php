<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">   
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Genshin Cafe</title>  
    <meta name="keywords" content="genshin impact, mihoyo, cafe, merchandise">
    <meta name="description" content="Genshin Cafe is a character cafe that offers merchandise and a menu based on Genshin Impact, a free-to-play action role-playing game by mihoYo.">
    <meta name="author" content="Michael Kim">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <!-- Only this Bootstrap version along with the jQuery and Bootstrap JS below worked for the modal login form -->
    <!--<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" />-->
    
    <link rel="stylesheet" href="css/styles.css">
    
    <!-- Font Awesome personal kit code -->
    <script src="https://kit.fontawesome.com/85633b29ad.js" crossorigin="anonymous"></script>
</head>
<body>
    <!-- Navbar with left and right aligned items -->
    <!-- https://www.codeply.com/go/qhaBrcWp3v -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <a class="navbar-brand" href="index.php"><img src="images/genshin.png" alt="logo"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsingNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="navbar-collapse collapse" id="collapsingNavbar">
            <ul class="navbar-nav">
                <li class="nav-item mx-2">
                    <a class="nav-link" href="index.php">HOME</a>
                </li>
                <li class="nav-item mx-2">
                    <a class="nav-link" href="index.php#about">ABOUT</a>
                </li>
                <li class="nav-item mx-2">
                    <a class="nav-link" href="menu.php">MENU</a>
                </li>
                <li class="nav-item mx-2">
                    <a class="nav-link" href="merch.php">MERCH</a>
                </li>
            </ul>
    <?php
        // customer login
        if(isset($_SESSION['customer'])) {
    ?>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item mx-2">
                    <a class="nav-link" href="cart.php"><i class="fa fa-shopping-cart"></i> CART (<?php
                            if(isset($_SESSION['cart'])) {
                                $count = count($_SESSION['cart']); 
                                echo $count; 
                            } else {
                                echo "0";
                            }
                        ?>)
                    </a>
                </li>
                <!--<li class="nav-item mx-2">
                    <a class="nav-link" href="account.php"><?php echo $_SESSION['customer']; ?></a>
                </li>-->
                <li class="nav-item mx-2">
                    <a class="nav-link li-modal" id="logout" href="logout.php">LOG OUT</a>
                </li>
            </ul>
        <?php
            // manager login
            } elseif(isset($_SESSION['manager'])) {
        ?>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item mx-2">
                    <a class="nav-link li-modal" href="dashboard.php">DASHBOARD</a>
                </li>
                <li class="nav-item mx-2">
                    <a class="nav-link li-modal" href="logout.php">LOG OUT</a>
                </li>
            </ul>
        <?php    
            // no login
            } else {
        ?>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item mx-2">
                    <!-- li-modal custom CSS -->
                    <a class="nav-link li-modal" href="login.php">LOG IN</a>
                </li>
            <?php
                }
            ?>
            </ul>
        </div>    
    </nav>
    
    <!--<div id="loginModal" class="modal fade">
        <div class="modal-dialog modal-login">
            <div class="modal-content"></div>
        </div>
    </div>-->
</body>
</html>
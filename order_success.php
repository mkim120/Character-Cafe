<?php 
    session_start();
    
    // redirect to home page if customer is NOT logged in   
    if(!isset($_SESSION['customer'])) {
        header("Location: index.php");
        exit();
    }
?> 
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Order Success | Genshin Cafe</title>
    </head>
<body>
    <?php
        include 'header.php';
    
        $orderID = $_GET['orderID'];
        
        // reset cart
        foreach($_SESSION["cart"] as $keys => $values) {
            unset($_SESSION["cart"]);
            echo '<script>window.location="order_success.php?orderID='.$orderID.'"</script>';
        }
    ?>
    
    <div class="menu-section-box">
    <div class="container-fluid">
    
        <div class="container">
            <div class="jumbotron">
                <h1 class="text-center">Order Placed Successfully.</h1>
            </div>
        </div>

        <h2 class="text-center text-light"> Thank you for ordering at Genshin Cafe!</h2>

    <?php
        // connect to database
        require 'config.php';
    
        $orderID = $_GET['orderID'];
    ?>
    
        <h3 class="text-center text-light"><strong>Your Order Number: </strong><span><?php echo "$orderID"; ?></span> </h3>
        
        <br><br>
        
    <!-- container-fluid -->
    </div>
    <!-- section-box -->
    </div>
    
    <?php
        include 'footer.php';
            
        // close connection
        $conn->close();
    ?>
</body>
</html>
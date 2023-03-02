<?php 
    session_start();
    
    // redirect to manager login page if NOT logged in   
    if(!isset($_SESSION['manager'])) {
        header("Location: managerlogin.php");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Manager Dashboard | Genshin Cafe</title>
    </head>
<body>
    <?php
        include 'header.php';
    ?>
    
    <div class="menu-section-box">    
    <div class="container">
        <div class="jumbotron">
            <h1>Welcome, Manager!</h1>
        </div>
    	
        <div class="col-xs-3 text-center">
            <div class="list-group" style="padding-bottom: 30px;">
                <a href="viewfood.php" class="list-group-item">View Food Items</a>
                <a href="addfood.php" class="list-group-item">Add Food Items</a>
                <a href="editfood.php" class="list-group-item">Edit Food Items</a>
                <a href="removefood.php" class="list-group-item">Remove Food Items</a>
                <a href="vieworders.php" class="list-group-item">View Order Details</a>
            </div>
        </div>         
    <!-- container -->
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
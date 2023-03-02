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
        <title>Add Food Items | Genshin Cafe</title>
    </head>
<body>
    <?php
        include 'header.php';
    
        require 'config.php';
    ?>
    
    <div class="menu-section-box">    
    <div class="container">
    
    <div class="jumbotron text-center">
        <h1>Add Food Items</h1>
    </div>

    <div class="container">
        <div class="col-xs-9">
            <div class="form-area" style="padding-bottom: 20px;">
                <form action="addfoodaction.php" method="POST">
                    <!-- name -->
                    <div class="form-group">
                        <input type="text" class="form-control" id="name" name="name" placeholder="Name" required>
                    </div>
                    <!-- description -->
                    <div class="form-group">
                        <input type="text" class="form-control" id="description" name="description" placeholder="Description" required>
                    </div>
                    <!-- price -->
                    <div class="form-group">
                        <input type="text" class="form-control" id="price" name="price" placeholder="Price: 0.00" required>
                    </div>
                    <!-- image path -->
                    <div class="form-group">
                        <input type="text" class="form-control" id="imagePath" name="imagePath" placeholder="Image Path: images/food/<filename>.<extention>" required>
                    </div>
                    <!-- availability -->
                    <div class="form-group">
                        <input type="text" class="form-control" id="available" name="available" placeholder="Available: yes / no" required>
                    </div>
                    <!-- submit -->
                    <div class="form-group">
                        <button type="submit" id="submit" name="submit" class="btn btn-primary float-right">Add Food</button>    
                    </div>
                </form>
            </div>
        </div>
    </div>
        
    <br><br>

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
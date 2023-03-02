<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Menu | Genshin Cafe</title>
    </head>
<body>
    <?php
        include 'header.php';
    ?>
    
    <div class="menu-banner">
        <div class="jumbotron">
            <div class="container">
                <h1 class="welcome-text"><span>Menu</span></h1>
            </div>
        </div>
    </div>

    <!-- menu with backgroud -->
    <div class="menu-section-box">
    
    <?php 
        // show message if not logged in
        if(!isset($_SESSION['customer'])) {
    ?>
            <div class="container-fluid" style="padding-bottom: 20px;">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <div class="container inner-column" style="text-align: center;">
                            <h2 class="link"><a href="login.php">Log In</a> to Order!</h2>
                            <br>
                            <h3 class="link">New Customer? <a href="register.php">Register Now <i class="fa fa-chevron-right"></i></a></h3>
                        </div>
                    </div>
                </div>
            </div>
    <?php
        }
    ?>

        <!-- food items -->
        <div class="container-fluid">
        
<?php
    // connect to database
    require 'config.php';

    $query = "SELECT * FROM food WHERE available = 'yes' ORDER BY foodID";
    $result = $conn->query($query);

    if($result->num_rows > 0) {
        $count = 0;

        while($row = $result->fetch_assoc()) {
            if($count == 0) {
                echo "<div class='row'>";
            }
?>       
            <div class="col-md-4">
                <form method="post" action="cart.php?action=add&id=<?php echo $row["foodID"]; ?>">
                    <div class="food-panel <?php if(isset($_SESSION['customer'])) echo 'loggedin-panel' ?>" align="center">
                        <!-- image -->
                        <img src="<?php echo $row["imagePath"]; ?>" class="img-responsive img-thumbnail">
                        <!-- name -->
                        <h4><?php echo $row["name"]; ?></h4>
                        <!-- description -->
                        <p class="text-dark" style="text-align: left; padding: 0 10px;"><?php echo $row["description"]; ?></p>
                        <!-- price -->
                        <h5 class="text-dark" style="text-align: right; margin-right: 40px;">$<?php echo $row["price"]; ?></h5>

                <?php 
                    // only show quantity and add to cart option if logged in
                    if(isset($_SESSION['customer'])) { 
                ?>
                        <!-- quantity -->
                        <h5 class="text-dark" style="padding-bottom: 50px;">Quantity: <input type="number" min="1" max="25" name="quantity" class="form-control" value="1" style="width: 60px;"></h5>
                        <!-- values to send to cart -->
                        <input type="hidden" name="name" value="<?php echo $row["name"]; ?>">
                        <input type="hidden" name="price" value="<?php echo $row["price"]; ?>">
                        <!-- cart -->
                        <h5><input type="submit" name="add" style="margin-top: 5px;" class="btn btn-dark" value="Add to Cart"></h5>
                <?php
                    }
                ?>
                    </div>
                </form>
            </div>
    <?php
            $count++;
            // create new row once there are 3 columns
            if($count == 3) {
                echo "</div>";
                $count = 0;
            }
        }
    ?>
        <!-- container-fluid -->
        </div>
    <!-- menu-section-box -->
    </div>
<?php
    } else {
?>
        <div class="container-fluid" style="padding-bottom: 20px;">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="container inner-column" style="text-align: center;">
                        <h2>No food items are available.</h2>
                    </div>
                </div>
            </div>
        </div>
<?php
    }
        
        include 'footer.php';
           
        // logout confirmation alert if cart is not empty
        if(!empty($_SESSION['cart'])) {
?>
            <script>
            $(document).ready(function(){
                $('#logout').on('click', function(e){
                    if(confirm("Are you sure you want to logout? Your cart will not be saved."))
                        window.location.href = "logout.php";
                    return false;
                });
            });
            </script>
    <?php
        }
    
        // close connection
        $conn->close();
    ?>

    <!-- food item sources -->
    <!-- https://twitter.com/hanyams -->
    <!-- https://www.instagram.com/issagrill/ -->
    <!-- https://vinoshipper.com/shop/enlightenment_wines_farm_and_meadery/memento_mori-_dandelion_wine_16,079 -->
</body>
</html>
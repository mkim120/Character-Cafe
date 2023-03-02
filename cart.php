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
        <title>Cart | Genshin Cafe</title>
    </head>
<body>
    <?php
        include 'header.php';
    ?>
    
    <div class="menu-banner">
        <div class="jumbotron">
            <div class="container text-center">
                <h1 class="welcome-text"><span>Cart</span></h1>
            </div>
        </div>
    </div>

    <div class="menu-section-box">
    <div class="container-fluid">
            
<?php
    // connect to database
    require 'config.php';    
        
    if(!empty($_SESSION['cart'])) {
?>
        <div class="table-responsive container-fluid">
            
        <table class="table">
            <!-- table head -->
            <thead class="thead-light" style="text-align: center">
                <tr>
                    <th width="30%" style="text-align: left;">Food Name</th>
                    <th width="15%">Quantity</th>
                    <th width="15%">Price</th>
                    <th width="15%">Total</th>
                    <th width="15%">Action</th>
                </tr>
            </thead>
            
    <?php  
        $total = 0;
        foreach($_SESSION['cart'] as $keys => $values) {
    ?>
            <tr>
                <td><?php echo $values['food_name']; ?></td>
                <td style="text-align: center;"><?php echo $values['food_quantity'] ?></td>
                <td style="text-align: center;">$<?php echo $values['food_price']; ?></td>
                <td style="text-align: center;">$<?php echo number_format($values['food_quantity'] * $values['food_price'], 2); ?></td>
                <td class="link" style="text-align: center;"><a href="cart.php?action=delete&id=<?php echo $values['food_id']; ?>"><span class="text-danger">Remove</span></a></td>
            </tr>
    <?php 
            $total = $total + ($values['food_quantity'] * $values['food_price']);
        }
    ?>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td align="right">Order Total:</td>
                <td align="right">$<?php echo number_format($total, 2); ?></td>
            </tr>
        </table>
            
        <a href="cart.php?action=empty"><button class="btn btn-danger"><i class="fa fa-trash"></i> Empty Cart</button></a>

        <a href="checkout.php"><button class="btn btn-success float-right"><i class="fa fa-credit-card"></i> Checkout</button></a>

        <a href="menu.php"><button class="btn btn-light float-right" style="margin-right: 20px;">Continue Shopping</button></a>';
        
        <!-- end table-responsive -->
        </div>
        
        <br><br>
<?php
    // end if cart NOT empty
    }
        
    if(empty($_SESSION['cart'])) {
?>
        <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 text-center" >
                        <div class="container inner-column" style="text-align: center;">
                            <br>
                            <h3 class="link">Your cart is empty. Go to the <a href="menu.php">MENU</a> to order.</h3>
                           <br>
                        </div>
                    </div>
                </div>
            </div>
        
        <br><br><br><br>
<?php
    }
?>

<?php
    if(isset($_POST['add'])) {
        /* add to cart */
        if(isset($_SESSION['cart'])) {
            $item_array_id = array_column($_SESSION['cart'], "food_id");
            if(!in_array($_GET['id'], $item_array_id)) {
                $count = count($_SESSION['cart']);
                $item_array = array(
                    'food_id' => $_GET['id'],
                    'food_name' => $_POST['name'],
                    'food_price' => $_POST['price'],
                    'food_quantity' => $_POST['quantity']
                );
                $_SESSION['cart'][$count] = $item_array;
                echo '<script>window.location="cart.php"</script>';
            } else {
                echo '<script>alert("Food item already added to cart.")</script>';
                echo '<script>window.location="cart.php"</script>';
            }
        } else {
            $item_array = array(
                'food_id' => $_GET['id'],
                'food_name' => $_POST['name'],
                'food_price' => $_POST['price'],
                'food_quantity' => $_POST['quantity']
            );
            $_SESSION['cart'][0] = $item_array;
            echo '<script>window.location="cart.php"</script>';
        }
    }

    if(isset($_GET['action'])) {
        /* remove food item */
        if($_GET['action'] == "delete") {
            foreach($_SESSION['cart'] as $keys => $values) {
                if($values['food_id'] == $_GET['id']) {
                    unset($_SESSION['cart'][$keys]);
                    //echo '<script>alert("Food item removed.")</script>';
                    echo '<script>window.location="cart.php"</script>';
                }
            }
        /* empty cart */
        } elseif($_GET['action'] == "empty") {
            foreach($_SESSION['cart'] as $keys => $values) {
                unset($_SESSION['cart']);
                //echo '<script>alert("Cart is now empty.")</script>';
                echo '<script>window.location="cart.php"</script>';
            }
        }
    }
?>
    <!-- container-fluid -->
    </div>
    <!-- section-box -->
    </div>
    
    <?php
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
</body>
</html>
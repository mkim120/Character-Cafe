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
        <title>View Order Details | Genshin Cafe</title>
    </head>
<body>
    <?php
        include 'header.php';
    
        require 'config.php';
    ?>
    
    <div class="menu-section-box">    
    <div class="container">
    
    <div class="jumbotron text-center">
        <h1>View Order Details</h1>
    </div>

    <div class="col-xs-9">
        <div class="form-area" style="padding: 20px;">
            <form action="" method="POST">

<?php
    $query = "SELECT orderItems.*, orders.*, food.name FROM orderItems 
    INNER JOIN orders ON orderItems.orderID = orders.orderID 
    INNER JOIN food ON food.foodID = orderItems.foodID 
    ORDER BY orderDate DESC";
    $result = mysqli_query($conn, $query);
    if($result->num_rows > 0) {    
?>
        <table class="table table-striped">
            <thead class="thead-light text-center">
                <tr>
                    <th>Order ID</th>
                    <th>Order Date</th>
                    <th>Food Name</th>
                    <th>Quantity</th>-->
                    <th>Customer ID</th>
                </tr>
            </thead>

    <?php
        while($row = $result->fetch_assoc()) {
    ?>
            <tbody>
                <tr class="text-light text-center">
                    <td><?php echo $row["orderID"]; ?></td>
                    <td><?php echo $row["orderDate"]; ?></td>
                    <td><?php echo $row["name"]; ?></td>
                    <td><?php echo $row["quantity"]; ?></td>
                    <td><?php echo $row["customerID"]; ?></td>
                </tr>
            </tbody>

        <?php } ?>
        </table>

<?php 
    } else { 
?>
        <h1 class="text-center">0 Results</h1>
<?php 
    } 
?>

            </form>
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
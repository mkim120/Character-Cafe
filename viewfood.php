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
        <title>View Food Items | Genshin Cafe</title>
    </head>
<body>
    <?php
        include 'header.php';
    
        require 'config.php';
    ?>
    
    <div class="menu-section-box">    
    <div class="container">
        
    <div class="jumbotron text-center">
        <h1>View Food Items</h1>
    </div>

    <div class="col-xs-9">
        <div class="form-area" style="padding: 20px;">
            <form action="" method="POST">
                
<?php
    // get food list from database
    $query = "SELECT * FROM food ORDER BY foodID";
    $result = $conn->query($query);
    if($result->num_rows > 0) {    
?>
                
        <table class="table table-striped">
        <thead class="thead-light text-center">
            <tr>
                <th>Food ID</th>
                <th>Food Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Available</th>
            </tr>
        </thead>

    <?php
        // loop through each row and add to table
        while($row = $result->fetch_assoc()) {
    ?>
            <tbody>
                <tr class="text-light text-center">
                    <td><?php echo $row['foodID']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td class="text-left"><?php echo $row['description']; ?></td>
                    <td><?php echo $row['price']; ?></td>
                    <td><?php echo $row['available']; ?></td>
                </tr>
            </tbody>
    <?php 
        } 
    ?>
        </table>
        
<?php 
    } else { 
?>     
        <div class="container-fluid">
            <div class="jumbotron">
                <h1 class="text-center">0 Results</h1>
            </div>
        </div>
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
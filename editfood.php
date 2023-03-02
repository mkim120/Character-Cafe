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
        <title>Edit Food Items | Genshin Cafe</title>
    </head>
<body>
    <?php
        include 'header.php';
    
        require 'config.php';
    ?>
    
    <div class="menu-section-box">    
    <div class="container">
    
    <div class="jumbotron text-center">
        <h1>Edit Food Items</h1>
    </div>
    	
    <div class="row">
    
    <div class="col-md-6" style="padding-top: 20px;">
        <div class="form-area">
            <div class="container-fluid">
            <div class="jumbotron" style="padding: 20px;">
                <h2>Select food item to edit.</h2>
  
<?php
    if (isset($_GET['submit'])) {
        $foodID = $_GET['newid'];
        $name = $_GET['newname'];
        $price = $_GET['newprice'];
        $description = $_GET['newdescription'];

        $query = $conn->query("UPDATE food SET name='$name', description='$description', price='$price' WHERE foodID='$foodID'");
    }
    
    $query = $conn->query("SELECT * FROM food ORDER BY foodID");
    while($row = $query->fetch_array()) {
?>  
        <div class="list-group text-left">
            <?php
                echo "<a href='editfood.php?update={$row['foodID']}'>{$row['name']}</a>";  
            ?>
        </div>
<?php
    }
?>
            <!-- container-fluid -->
            </div>
            <!-- jumbotron -->
            </div>
                
<?php
    if (isset($_GET['update'])) {
        $update = $_GET['update'];
        $query2 = mysqli_query($conn, "SELECT * FROM food WHERE foodID=$update");
        while ($row2 = mysqli_fetch_array($query2)) {
?>
        <!-- form-area -->    
        </div>
    <!-- col -->
    </div>

        <div class="col-md-6">
            <div class="form-area" style="padding: 20px;">
                <form action="editfood.php" method="GET">
                    <!-- food ID -->
                    <div class="form-group">
                        <input class='input' type='hidden' name="newid" value=<?php echo $row2['foodID']; ?>>
                    </div>
                    <!-- name -->
                    <div class="form-group">
                        <label for="username">Name: </label>
                        <input type="text" class="form-control" id="newname" name="newname" value="<?php echo $row2['name']; ?>" placeholder="Name" required>
                    </div>     
                    <!-- description -->
                    <div class="form-group">
                        <label for="username">Description: </label>
                        <!-- textarea does not use value attribute -->
                        <textarea type="text" class="form-control" rows="3" id="newdescription" name="newdescription" value="<?php echo $row2['description']; ?>" placeholder="Description" required><?php echo $row2['description']; ?></textarea>
                    </div>
                    <!-- price -->
                    <div class="form-group">
                        <label for="username">Price: </label>
                        <input type="text" class="form-control" id="newprice" name="newprice" value=<?php echo $row2['price']; ?> placeholder="Price" required>
                    </div>
                    <!-- submit -->
                    <div class="form-group">
                        <button type="submit" id="submit" name="submit" class="btn btn-primary float-right" value="update">Update</button>    
                    </div>
                </form>
<?php
        }
    }
?>
            <!-- form-area -->
            </div>
        <!-- col -->
        </div>
        
    <!--row-->
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
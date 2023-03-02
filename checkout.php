<?php 
    session_start();
    
    // redirect to home page if customer is NOT logged in or if cart is not set
    if(!isset($_SESSION['customer']) || !isset($_SESSION['cart'])) {
        header("Location: index.php");
        exit();
    }
?> 
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Checkout | Genshin Cafe</title>
    </head>
<body>
    <?php
        include 'header.php';
    ?>
     
    <div class="menu-banner">
        <div class="jumbotron">
            <div class="container text-center">
                <h1 class="welcome-text"><span>Checkout</span></h1>
            </div>
        </div>
    </div>
    
<?php
    // connect to database
    require 'config.php';
    
    // input validations
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $firstName = trim($_POST['firstName']);
        $lastName = trim($_POST['lastName']);
        $email = trim($_POST['email']);
        $address = trim($_POST['address']);
        $city = trim($_POST['city']);
        $state = $_POST['state'];            
        $zip = trim($_POST['zip']);
        $ccname = trim($_POST['cc-name']);
        $ccnumber = trim($_POST['cc-number']);
        $exp = trim($_POST['cc-expiration']);
        $cvv = trim($_POST['cc-cvv']);

        // error messages
        $fnameError = "";
        $lnameError = "";
        $emailError = "";
        $addressError = "";
        $cityError = "";
        $stateError = "";
        $zipError = "";
        $ccnameError = "";
        $ccnumberError = "";
        $expError = "";
        $cvvError = "";

        // error checker
        $error = 0;   

        // name validation
        if(empty($firstName)) {
            $fnameError = "First name is required.";
            $error = 1;
        } elseif(!preg_match("/^[a-zA-Z' ]*$/", $firstName)) { 
            $nameError = "Enter a name with only letters, spaces, and apostrophes.";
            $error = 1;
        }
        if(empty($lastName)) {
            $lnameError = "Last name is required.";
            $error = 1;
        } elseif(!preg_match("/^[a-zA-Z' ]*$/", $lastName)) { 
            $nameError = "Enter a name with only letters, spaces, and apostrophes.";
            $error = 1;
        }
        
        // email validation
        if(empty($_POST['email'])) {
            $emailError = "Email is required.";
            $error = 1;
        } elseif(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $emailError = "Invalid email format.";
            $error = 1;
        }

        // street address validation
        if(empty($address)) {
            $addressError = "Address is required.";
            $error = 1;
        } elseif(!preg_match("/^[a-zA-Z0-9 .-]*$/", $address)) { 
            $addressError = "Enter an address with only letters, numbers, spaces, hyphens, and periods.";
            $error = 1;
        }

        // city validation
        if(empty($city)) {
            $cityError = "City is required";
            $error = 1;
        } elseif(!preg_match("/^[a-zA-Z -]*$/", $city)) { 
            $cityError = "Enter a city with only letters, spaces, and hyphens.";
            $error = 1; 
        }

        // state validation
        if(empty($state)) {
            $stateError = "State is required.";
            $error = 1;
        }

        // zip code validation
        if(empty($zip)) {
            $zipError = "ZIP Code is required.";
            $error = 1;
        }
        elseif(!preg_match("/^[0-9]{5}$/", $zip)) { 
            $zipError = "Enter a five-digit ZIP Code.";
            $error = 1;
        }
        
        // cc-name validation
        if(empty($ccname)) {
            $ccnameError = "<br>Full name is required.";
            $error = 1;
        } elseif(!preg_match("/^[a-zA-Z' ]*$/", $ccname)) { 
            $ccnameError = "<br>Enter a name with only letters, spaces, and apostrophes.";
            $error = 1;
        }
        
        // cc-number validation
        if(empty($ccnumber)) {
            $ccnumberError = "Credit card number is required.";
            $error = 1;
        } elseif(!preg_match("/^\d{16}$/", $ccnumber)) { 
            $ccnumberError = "Enter a 16-digit credit card number.";
            $error = 1;
        }
        
        // cc-expiration validation
        if(empty($exp)) {
            $expError = "Credit card expiration date is required.";
            $error = 1;
        } elseif(!preg_match("/^(0[1-9]|1[0-2])\/[0-9]{2}$/", $exp)) { 
            $expError = "Enter the expiration date in the form MM/YY.";
            $error = 1;
        }
        
        // cc-cvv validation
        if(empty($cvv)) {
            $cvvError = "Credit card security code is required.";
            $error = 1;
        } elseif(!preg_match("/^[0-9]{3,4}$/", $cvv)) { 
            $cvvError = "Enter a 3 or 4-digit security code.";
            $error = 1;
        }
        
        // error message
        if($error) {
            echo "<h2 class='error text-center'>Error: There are fields below that require your attention.</h2>";
        }
    
        // insert into database if no errors
        if(!$error) {    
            $total = 0;    
            foreach($_SESSION['cart'] as $keys => $values) {
                /*$name = $values['food_name'];*/
                $quantity = $values['food_quantity'];
                $price =  $values['food_price'];
                $food_total = ($values['food_quantity'] * $values['food_price']);
                $orderDate = date("Y-m-d H:i:s");
                $customerID = $_SESSION['id'];
                $total = $total + $food_total;
            }
            
            // generate order number
            $num1 = rand(100,999); 
            $num2 = rand(100,999); 
            $num3 = rand(100,999);
            $orderID = $num1.$num2.$num3;
                        
            // insert new order into database
            $query = "INSERT INTO orders (orderID, total, orderDate, customerID) VALUES ('$orderID', '$total', '$orderDate', '$customerID')";
            $result = $conn->query($query);   
            if(!$result) {
?>
                <div class="menu-section-box" style="padding-bottom: 10px;">    
                    <div class="container-fluid">
                        <div class="jumbotron">
                            <h1>Something went wrong!</h1>
                            <p>Please try again later.</p>
                        </div>
                    </div>
                </div>
        <?php
            }

            foreach($_SESSION['cart'] as $keys => $values) {
                $foodID = $values['food_id'];
                $quantity = $values['food_quantity'];
                
                // insert order items into database with matching orderID
                $query = "INSERT INTO orderItems (orderID, foodID, quantity) VALUES ('$orderID', '$foodID', '$quantity')";
                $result = $conn->query($query);
                if(!$result) {
            ?>
                    <div class="menu-section-box" style="padding-bottom: 10px;"> 
                        <div class="container-fluid">
                            <div class="jumbotron">
                                <h1>Something went wrong!</h1>
                                <p>Please try again later.</p>
                            </div>
                        </div>
                    </div>
        <?php
                }
            }
            
            // sanitize
            $firstName = $conn -> real_escape_string($firstName);
            $lastName = $conn -> real_escape_string($lastName);
            $email = $conn -> real_escape_string($email);
            $address = $conn -> real_escape_string($address);
            $city = $conn -> real_escape_string($city);
            $state = $conn -> real_escape_string($state);
            $zip = $conn -> real_escape_string($zip);
            
            // insert customer delivery details into database
            $query = "INSERT INTO customerDetails (orderID, customerID, firstName, lastName, email, address, city, state, zip) VALUES ('$orderID', '$customerID', '$firstName', '$lastName', '$email', '$address', '$city', '$state', '$zip')";
            $result = $conn->query($query);
            if(!$result) {
        ?>
                <div class="menu-section-box" style="padding-bottom: 10px;">
                    <div class="container-fluid">
                        <div class="jumbotron">
                            <h1>Something went wrong!</h1>
                            <p>Please try again later.</p>
                        </div>
                    </div>
                </div>
    <?php
            } else {
                // redirect to order success page
                header("Location: order_success.php?orderID='<?php echo $orderID ?>'");
            }
        // end if(!error)
        }
    // end if(post)
    }
?>    
        
    <div class="menu-section-box">
    
    <!-- checkout form -->
    <!-- https://getbootstrap.com/docs/4.5/examples/checkout/ -->
    <div class="container" style="padding: 20px;">
        <div class="row">
            <!-- cart summary -->
            <div class="col-md-4 order-md-2 mb-4">
                <h4 class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-light">Your Cart</span>
                    <span class="badge badge-light badge-pill">
                        <?php
                            if(isset($_SESSION['cart'])) {
                                $count = count($_SESSION['cart']); 
                                echo $count; 
                            } else {
                                echo "0";
                            }
                        ?>
                    </span>
                </h4>
                
                <ul class="list-group mb-3">
            <?php
                $total = 0;
                foreach($_SESSION['cart'] as $keys => $values) {
                    $food_total = number_format($values['food_quantity'] * $values['food_price'], 2);
                    $total = number_format($total + $food_total, 2);
            ?>          
                    <li class="list-group-item d-flex justify-content-between lh-condensed">
                        <div>
                            <h6 class="my-0"><?php echo $values['food_name']; ?></h6>
                            <small class="text-muted">Quantity: <?php echo $values['food_quantity']; ?></small>
                        </div>
                        <span class="text-muted">$<?php echo $food_total; ?></span>
                    </li>
            <?php
                }
            ?>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Total</span>
                        <strong>$<?php echo $total; ?></strong>
                    </li>
                </ul>
            </div>
            
            <!-- delivery address -->
            <div class="col-md-8 order-md-1">
                <h4 class="mb-3 text-light">Delivery Address</h4>
                
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="firstName">First name</label>
                            <input type="text" class="form-control" id="firstName" name="firstName" placeholder="" value="<?php if(isset($firstName)) echo $firstName; ?>" autofocus>
                            <span class="error"><?php echo $fnameError; ?></span>
                            <span class="error"><?php echo $nameError; ?></span>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="lastName">Last name</label>
                            <input type="text" class="form-control" id="lastName" name="lastName" placeholder="" value="<?php if(isset($lastName)) echo $lastName; ?>">
                            <span class="error"><?php echo $lnameError; ?></span>
                            <span class="error"><?php echo $nameError; ?></span>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="example@email.com" value="<?php if(isset($email)) echo $email; ?>">
                        <span class="error"><?php echo $emailError; ?></span>
                    </div>

                    <div class="mb-3">
                        <label for="address">Address</label>
                        <input type="text" class="form-control" id="address" name="address" placeholder="1234 Main St" value="<?php if(isset($address)) echo $address; ?>">
                        <span class="error"><?php echo $addressError; ?></span>
                    </div>

                <div class="row">
                  <div class="col-md-5 mb-3">
                    <label for="city">City</label>
                    <input type="text" class="form-control" id="city" name="city" placeholder="" value="<?php if(isset($city)) echo $city; ?>">
                    <span class="error"><?php echo $cityError; ?></span>
                  </div>
                  <div class="col-md-4 mb-3">
                    <label for="state">State</label>
                    <select class="custom-select d-block w-100" id="state" name="state" value="<?php if(isset($state)) echo $state; ?>">
                        <option value="">Choose...</option>
                        <option value="AL" <?php if($state == "AL") echo "selected"; ?>>Alabama</option>
                        <option value="AK" <?php if($state == "AK") echo "selected"; ?>>Alaska</option>
                        <option value="AZ" <?php if($state == "AZ") echo "selected"; ?>>Arizona</option>
                        <option value="AR" <?php if($state == "AR") echo "selected"; ?>>Arkansas</option>
                        <option value="CA" <?php if($state == "CA") echo "selected"; ?>>California</option>
                        <option value="CO" <?php if($state == "CO") echo "selected"; ?>>Colorado</option>
                        <option value="CT" <?php if($state == "CT") echo "selected"; ?>>Connecticut</option>
                        <option value="DE" <?php if($state == "DE") echo "selected"; ?>>Delaware</option>
                        <option value="FL" <?php if($state == "FL") echo "selected"; ?>>Florida</option>
                        <option value="GA" <?php if($state == "GA") echo "selected"; ?>>Georgia</option>
                        <option value="HI" <?php if($state == "HI") echo "selected"; ?>>Hawaii</option>
                        <option value="ID" <?php if($state == "ID") echo "selected"; ?>>Idaho</option>
                        <option value="IL" <?php if($state == "IL") echo "selected"; ?>>Illinois</option>
                        <option value="IN" <?php if($state == "IN") echo "selected"; ?>>Indiana</option>
                        <option value="IA" <?php if($state == "IA") echo "selected"; ?>>Iowa</option>
                        <option value="KS" <?php if($state == "KS") echo "selected"; ?>>Kansas</option>
                        <option value="KY" <?php if($state == "KY") echo "selected"; ?>>Kentucky</option>
                        <option value="LA" <?php if($state == "LA") echo "selected"; ?>>Louisiana</option>
                        <option value="ME" <?php if($state == "ME") echo "selected"; ?>>Maine</option>
                        <option value="MD" <?php if($state == "MD") echo "selected"; ?>>Maryland</option>
                        <option value="MA" <?php if($state == "MA") echo "selected"; ?>>Massachusetts</option>
                        <option value="MI" <?php if($state == "MI") echo "selected"; ?>>Michigan</option>
                        <option value="MN" <?php if($state == "MN") echo "selected"; ?>>Minnesota</option>
                        <option value="MS" <?php if($state == "MS") echo "selected"; ?>>Mississippi</option>
                        <option value="MO" <?php if($state == "MO") echo "selected"; ?>>Missouri</option>
                        <option value="MT" <?php if($state == "MT") echo "selected"; ?>>Montana</option>
                        <option value="NE" <?php if($state == "NE") echo "selected"; ?>>Nebraska</option>
                        <option value="NV" <?php if($state == "NV") echo "selected"; ?>>Nevada</option>
                        <option value="NH" <?php if($state == "NH") echo "selected"; ?>>New Hampshire</option>
                        <option value="NJ" <?php if($state == "NJ") echo "selected"; ?>>New Jersey</option>
                        <option value="NM" <?php if($state == "NM") echo "selected"; ?>>New Mexico</option>
                        <option value="NY" <?php if($state == "NY") echo "selected"; ?>>New York</option>
                        <option value="NC" <?php if($state == "NC") echo "selected"; ?>>North Carolina</option>
                        <option value="ND" <?php if($state == "ND") echo "selected"; ?>>North Dakota</option>
                        <option value="OH" <?php if($state == "OH") echo "selected"; ?>>Ohio</option>
                        <option value="OK" <?php if($state == "OK") echo "selected"; ?>>Oklahoma</option>
                        <option value="OR" <?php if($state == "OR") echo "selected"; ?>>Oregon</option>
                        <option value="PA" <?php if($state == "PA") echo "selected"; ?>>Pennsylvania</option>
                        <option value="RI" <?php if($state == "RI") echo "selected"; ?>>Rhode Island</option>
                        <option value="SC" <?php if($state == "SC") echo "selected"; ?>>South Carolina</option>
                        <option value="SD" <?php if($state == "SD") echo "selected"; ?>>South Dakota</option>
                        <option value="TN" <?php if($state == "TN") echo "selected"; ?>>Tennessee</option>
                        <option value="TX" <?php if($state == "TX") echo "selected"; ?>>Texas</option>
                        <option value="UT" <?php if($state == "UT") echo "selected"; ?>>Utah</option>
                        <option value="VT" <?php if($state == "VT") echo "selected"; ?>>Vermont</option>
                        <option value="VA" <?php if($state == "VA") echo "selected"; ?>>Virginia</option>
                        <option value="WA" <?php if($state == "WA") echo "selected"; ?>>Washington</option>
                        <option value="WV" <?php if($state == "WV") echo "selected"; ?>>West Virginia</option>
                        <option value="WI" <?php if($state == "WI") echo "selected"; ?>>Wisconsin</option>
                        <option value="WY" <?php if($state == "WY") echo "selected"; ?>>Wyoming</option>
                    </select>
                    <span class="error"><?php echo $stateError; ?></span>
                  </div>
                  <div class="col-md-3 mb-3">
                    <label for="zip">Zip</label>
                    <input type="text" class="form-control" id="zip" name="zip"  placeholder="12345" value="<?php if(isset($zip)) echo $zip; ?>">
                    <span class="error"><?php echo $zipError; ?></span>
                  </div>
                </div>
                
                <!-- payment options -->    
                <h4 class="mb-3 text-light">Payment</h4>
                    <div class="row">
                  <div class="col-md-6 mb-3">
                    <label for="cc-name">Name on card</label>
                    <input type="text" class="form-control" id="cc-name" name="cc-name" placeholder="Full Name" value="<?php if(isset($ccname)) echo $ccname; ?>">
                    <small class="text-muted">Full name as displayed on card</small>
                    <span class="error"><?php echo $ccnameError; ?></span>
                  </div>
                  <div class="col-md-6 mb-3">
                    <label for="cc-number">Credit card number</label>
                    <!-- only display last 4 digits of credit card number -->
                    <!-- https://stackoverflow.com/questions/45588890/displaying-last-4-digit-credit-card -->
                    <!-- the card is successfully masked, but if you refresh, you need to re-enter the cc number -->
                    <input type="text" class="form-control" id="cc-number" name="cc-number" placeholder="1234567812345678" value="<?php if(isset($ccnumber)) { $masked = str_pad(substr($ccnumber, -4), strlen($ccnumber), '*', STR_PAD_LEFT); echo $masked; } ?>">
                    <span class="error"><?php echo $ccnumberError; ?></span>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-3 mb-3">
                    <label for="cc-expiration">Expiration</label>
                    <input type="text" class="form-control" id="cc-expiration" name="cc-expiration" placeholder="MM/YY" value="<?php if(isset($exp)) echo $exp; ?>">
                    <span class="error"><?php echo $expError; ?></span>
                  </div>
                  <div class="col-md-3 mb-3">
                    <label for="cc-cvv">CVV</label>
                    <input type="text" class="form-control" id="cc-cvv" name="cc-cvv" placeholder="123" value="<?php if(isset($cvv)) echo $cvv; ?>">
                    <span class="error"><?php echo $cvvError; ?></span>
                  </div>
                </div>
                <br>
                <button class="btn btn-primary btn-lg btn-block" type="submit">Confirm Order</button>
              </form>
        </div>
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
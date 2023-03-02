<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Merch | Genshin Cafe</title>
    </head>
<body>  
     <?php 
        include('header.php');
    ?>
    
    <main>
        <div class="merch-section-box">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 text-center">
                        <div class="container inner-column">
                            <h1>We are currently working on the <span>Merchandise Section</span> of our online store!</h1>
                            <h4>Please stop by later!</h4>
                            <br>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <!-- image source: https://twitter.com/soreko -->
                        <img src="images/paimon-maintenance.png" alt="" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
            
        <?php
            include('footer.php');

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
        ?>
    </main>
</body>
</html>
<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en" style="height: 100%;">
<head>
    <title>Genshin Cafe</title>
    <script>
    
    </script>
</head>
<body style="height: 100%;">   
    <?php 
        include('header.php');
    ?>
    
    <!-- video background -->
    <!-- https://css-tricks.com/full-page-background-video-styles/ -->
    <video src="images/genshin-cover.mp4" autoplay loop playsinline muted></video>

    <header class="viewport-header welcome-text">
        <h1>
            Welcome to<br>
            <span>Genshin Cafe</span>
            
            <i class="fa fa-chevron-down"></i>
        </h1>
    </header>    
    <main id="about">
        <div class="about-section-box">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 text-center">
                        <div class="container inner-column link">
                            <h1>Welcome To <span>Genshin Cafe</span></h1>
                            <p> Genshin Cafe was inspired by character cafes, which are cafes/restaurants that collaborate with popular characters, anime, games, movies, etc, and serve exclusive themed food and drinks as well as limited merchandise. I wanted to take this concept of making a character cafe for a video game, but with <a href="https://genshin.mihoyo.com/en/home" target="_blank">Genshin Impact</a>. Developed and published by miHoYo, this game is available for mobile (iOS/Android), PS4, and Windows PC.</p>
                            <p>Genshin Impact features a system for "crafting" food that can buff your characters to deal more damage, heal or revive you, or restore your stamina. Due to its popularity, there are already amazing real-life dishes that have been made by fans of the game, so I wanted to take the chance to highlight these creations.</p>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <img src="images/genshin-food2.jpg" alt="" class="img-fluid">
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
    
    <!-- outside of the main tag, the footer is transparent and shows the video background -->
    <?php
        //include('footer.php');
    ?>
</body>
</html>
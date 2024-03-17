<?php 
session_start();

function title() {
    global $title;
    if(isset($title))
        echo $title;
    else
        echo 'Home';
}

function css() {
    global $css;
    if(isset($css))
        echo '<link href="/public/css/'. $css .'" rel="stylesheet">';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image" href="./image/logo2.png">
    <link rel="stylesheet" href="/public/css/profile.css">
    <link rel="stylesheet" href="/public/css/style.css">
    <link rel="stylesheet" href="/public/css/icons.min.css">
    <script src="/public/js/pro.min.js"></script>
    <!-- bootstrap links -->
    <link href="/public/css/bootstrap.min.css" rel="stylesheet">
    <!-- bootstrap links -->
    <!-- fonts links -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="/public/css/css3.css" rel="stylesheet">
    <!-- fonts links -->
</head>
<body>
    <!-- top navbar -->
    <div class="top-navbar">
        <div class="top-icons">
            <i class="fa-brands fa-twitter"></i>
            <i class="fa-brands fa-facebook-f"></i>
            <i class="fa-brands fa-instagram"></i>
        </div>
        <div class="other-links">
            <?php 
                if(isset($_SESSION['user'])){
                    echo '<button id="btn-login"><a href="profile.php">Profile</a></button>';
                } else {
                    echo '<button id="btn-login"><a href="signin.php">Sign in</a></button>';
                    echo '<button id="btn-signup"><a href="signup.php">Sign up</a></button>';
                }
            ?>
            <i class="fa-solid fa-user" href="profile.php"></i>
            <i class="fa-solid fa-cart-shopping"></i>
        </div>
    </div>
    <!-- top navbar -->

    <div class="home-section">
        <nav class="navbar navbar-expand-lg" id="navbar">
            <div class="container-fluid">
                <a class="navbar-brand" href="#"><img src="./image/logo.png" alt="" width="180px"></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span><i class="fa-solid fa-bars" style="color: white;"></i></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="clothe.php">Clothe</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="about.php">About Us</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="contact.php">Contact Us</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="cart.php">Cart</a>
                        </li>
                    </ul>   
                    <form class="d-flex" method="get" action="/clothe.php">
                        <input class="form-control me-2" name="search" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-success" type="submit" id="search-btn">Search</button>
                    </form>
                </div>
            </div>
        </nav>
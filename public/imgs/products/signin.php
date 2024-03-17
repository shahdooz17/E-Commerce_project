<?php
    $title = "Sign in";
    include_once('components/header.php');
    include_once('connect.php');
    include_once('services/auth.php');


    $error = '';
    if(isset($_SESSION["user"])) {
        header("Location: index.php");
    }

    if(isset($_POST["signin"])) {
        $email = $_POST["email"];
        $password = $_POST["password"];
        $result = signin($conn, $email, $password);
        if($result == 0) {
            $error = "User is not found";
        } else if($result == 1) {
            $error = "Password is incorrect";
        } else if($result == 2) {
            $error = "You are logged in";
        } else {
            $error = "Something went wrong";
        }
    }
    
?>

<!-- signin -->
<div class="container login">
    <div class="row">
        <div class="col-md-4" id="side1">
            <h3>Hello Friend!</h3>
            <p>Create New Account</p>
            <div id="btn"><a href="signup.php">Sign up</a></div>
        </div>
        <div class="col-md-8" id="side2">
            <h3>Login Account</h3>
            <form action="signin.php" method="POST">
                <div class="inp">
                    <input type="email" name="email" placeholder="Email" required>
                    <input type="password" name="password" placeholder="Password" required>
                </div>
            <p>Forgot Your Password</p>
            <div class="icons">
                <i class="fa-brands fa-twitter"></i>
                <i class="fa-brands fa-facebook-f"></i>
                <i class="fa-brands fa-instagram"></i>
            </div>
            <div id="login"><button type="submit" name="signin">SGIN IN</button></div>
            
        </form>
        </div>
    </div>
</div>
<!-- signin -->

<?php include 'components/footer.php'; ?>
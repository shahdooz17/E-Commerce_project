<?php
    $title = "Sign up";
    include 'components/header.php';
    include 'connect.php';
    include 'services/auth.php';

    $error = '';
    if(isset($_SESSION["user"])) {
        header("Location: index.php");
    }

    if(isset($_POST["signup"])) {
        $name = $_POST["name"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $result = signup($conn, $name, $email, $password);
        if($result == 2) {
            $error = "Account created successfully";
        } else if($result == 0) {
            $error = "There is user with that email";
        } else {
            $error = "Something went wrong";
        }
    }
?>

<!-- login -->
<div class="container login">
    <div class="row">
        <div class="col-md-4" id="side1">
            <h3>Welcome Back!!</h3>
            <div id="btn"><a href="signin.php">Sign in</a></div>
        </div>
        <div class="col-md-8" id="side2">
            <form method="post" action="signup.php">
            <h3>Create Account</h3>
            <div class="inp">
                <input type="text" name="name" placeholder="Name" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <div class="icons">
                <i class="fa-brands fa-twitter"></i>
                <i class="fa-brands fa-facebook-f"></i>
                <i class="fa-brands fa-instagram"></i>
            </div>
            <div id="login"><button type="submit" name="signup">SIGN UP</button></div>
                <?php echo $error; ?>
            </form>
        </div>
    </div>
</div>
<!-- login -->

<?php include 'components/footer.php'; ?>
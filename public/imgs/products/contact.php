<?php
    $title = "Contact us";
    include 'components/header.php';
    include 'connect.php';

    $messages = [];

    if(isset($_POST['message'])) {
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);
        $number = filter_input(INPUT_POST, 'number', FILTER_SANITIZE_NUMBER_INT);
        $date = date("Y-m-d");
        $sqlMessage = "INSERT INTO messages (name, email,number, messages, date) VALUES ('$name', '$email', '$number', '$message', '$date')";
        if(!$conn->query($sqlMessage)) {
            $messages[0] = 'Could not add the message';
        } else {
            $messages[0] = 'Message added successfully';
        }
    }
?>

<!-- contact -->
<div class="container" id="contact">
    <h1 class="text-center">CONTACT US</h1>
    <div class="row" style="margin-top: 50px;">
        <div class="col-md-4 py-3 py-md-0">
            <div class="card">
                <i class="fas fa-phone"> Phone</i>
                <h6>+00000000000000000</h6>
            </div>
        </div>
        <div class="col-md-4 py-3 py-md-0">
            <div class="card">
                <i class="fa-solid fa-envelope"> Email</i>
                <h6>FASHION2023@gmail.com</h6>
            </div>
        </div>
        <div class="col-md-4 py-3 py-md-0">
            <div class="card">
                <i class="fa-solid fa-location-dot"> Address</i>
                <h6>Nasr city </h6>
            </div>
        </div>
    </div>
    <form action="<?php $_SERVER['PHP_SELF']?>" method="post">
    <div class="row" style="margin-top: 30px;">
        <div class="col-md-4 py-3 py-md-0">
            <input type="text" name="name" class="form-control form-control" placeholder="Name">
        </div>
        <div class="col-md-4 py-3 py-md-0">
            <input type="text" name="email" class="form-control form-control" placeholder="Email">
        </div>
        <div class="col-md-4 py-3 py-md-0">
            <input type="number" name="number" class="form-control form-control" placeholder="Phone">
        </div>
        <div class="form-group" style="margin-top: 30px;">
        <textarea class="form-control" name="message" id=""rows="5" placeholder="Message"></textarea>
    </div>
    <div id="messagebtn" class="text-center"><button type="submit">Message</button></div>
        <?php 
        
        if(!empty($messages)) {
            foreach($messages as $message) {
                echo "<div class='alert alert-danger'>$message</div>";
            }
        }
        
        ?>
</form>
    </div>
</div>
<!-- contact -->

<?php include 'components/footer.php'; ?>
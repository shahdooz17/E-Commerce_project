<?php
    $title = "profile";
    include 'connect.php';
    include 'components/header.php';
    $sessionuser='';
    if(!isset($_SESSION['user'])) {
        header('Location: /');
    }
    if(isset($_POST['update']) && isset($_SESSION['user'])){
        $sessionuser=$_SESSION['user'];
        $name= filter_input(INPUT_POST,'name',FILTER_SANITIZE_STRING);
        $email= filter_input(INPUT_POST,'email',FILTER_SANITIZE_EMAIL);
        $password= filter_input(INPUT_POST,'password',FILTER_SANITIZE_STRING);
        $hashedpassword=sha1($password);
        if(empty($password)){
            $hashedpassword=$sessionuser['password'];
        }
        if(empty($name)){
            $name=$sessionuser['name'];
        }
        if(empty($email)){
            $email=$sessionuser['email'];
        }
        $sql="UPDATE users SET name='$name',email='$email',password='$hashedpassword' WHERE id='$sessionuser[id]'";
        $stmt=$conn->prepare($sql);
        $stmt->execute();
        if($stmt->rowCount()>0){
            $_SESSION['user']['name']=$name;
            $_SESSION['user']['email']=$email;
            $_SESSION['user']['password']=$hashedpassword;
            header('Location:profile.php');
        }
    }
    if(isset($_SESSION['user'])){
        $sessionuser=$_SESSION['user'];
    $myOrdersSql = "SELECT * from orders where user_id = {$sessionuser['id']}";
    $result = $conn->query($myOrdersSql);
    $orders = $result->fetchAll(PDO::FETCH_ASSOC);
?>


<div class="container rounded bg-white mt-5 mb-5">
    <div class="row">
        <div class="col-md-3 border-right">
            <div class="d-flex flex-column align-items-center text-center p-3 py-5"><img class="rounded-circle mt-5" width="150px" src="/public/imgs/profile.jpg"><span class="font-weight-bold"><?= $sessionuser['name'] ?></span><span class="text-black-50"></span><span> </span></div>
        </div>
        <div class="col-md-5 border-right">
            <div class="p-3 py-5">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="text-right">Profile</h4>
                </div>
                <form action="<?php $_SERVER['PHP_SELF']?>" method="post">
                <div class="row mt-2">
                    <div class="col-md-12"><label class="labels">Name</label><input name="name" type="text" class="form-control" placeholder="first name" value="<?= $sessionuser['name'] ?>"></div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12"><label class="labels">Email</label><input type="email" name="email" class="form-control" placeholder="enter email" value="<?= $sessionuser['email'] ?>"></div>
                    <div class="col-md-12"><label class="labels">Password</label><input type="password" name="password" class="form-control" placeholder="enter password"></div>
                </div>
                <div class="mt-5 text-center"><button class="form-submit-button" name="update" type="submit">Save Profile</button> <a href="/logout.php">Logout</a></div>
                </form>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <h2>Your Orders:</h2>
            <?php if($orders): ?>
                <?php foreach($orders as $order): ?>
                    <div class="mb-3 text-center">
                        <h3>Total price: <?= $order['price'] ?> </h3>
                        <h3>Date: <?= $order['date'] ?> </h3>
                        <h3>Product: <?= $order['productId'] ?> </h3>
                        <h3>Status: <?php print ($order['status'] ? 'Approved' : 'Pending') ?> </h3>
                        <h3>Quantity: <?= $order['quantity'] ?> </h3>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <h3 class="text-center">There is no orders</h3>
            <?php endif; ?>
        </div>
    </div>
</div>
</div>
</div>


<?php
} else{
    header('location:signin.php');
    exit();
}



include 'components/footer.php'; ?>
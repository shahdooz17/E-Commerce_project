<?php
include 'functions.php';
$title = "my store";
$id = $_GET['edit'];

function uploadImg() {
    $myImagesDir = $_SERVER["DOCUMENT_ROOT"] .'/public/imgs/products/';
    $myImageFile = $myImagesDir . htmlspecialchars(basename($_FILES["product_image"]["name"]));
    $image_File_Type = strtolower(pathinfo($myImageFile,PATHINFO_EXTENSION));
    if($_FILES["product_image"]["tmp_name"] == "" || $_FILES["product_image"]["tmp_name"] == null || !isset($_FILES["product_image"]["tmp_name"])) {
        return false;
    }
    if(file_exists($myImageFile)) {
        return htmlspecialchars( basename( $_FILES["product_image"]["name"]));
    }
    if($_FILES["product_image"]["size"] >= 600000) {
        return false;
    }
    if($image_File_Type != "jpg" && $image_File_Type != "png" && $image_File_Type != "jpeg" && $image_File_Type != "gif" ) {
        return false;
    }
    if(!move_uploaded_file($_FILES["product_image"]["tmp_name"], $myImageFile)) {
        return false;
    }
    return htmlspecialchars( basename( $_FILES["product_image"]["name"]));
}

if (isset($_POST['update_product'])) {
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
	$product_rating = $_POST['product_rating'];
    uploadImg() ? $product_image = uploadImg() : (isset($_POST['product_image_old']) ?  $product_image = $_POST['product_image_old'] : $product_image = 'default.png');
	echo $product_image;
    if (empty($product_name) || empty($product_price) || empty($product_image) || empty($product_rating)) {
        $message[] = 'please fill all the required info';
    } else {
        // Use prepared statement to prevent SQL injection
        $update = "UPDATE products SET name='$product_name', price='$product_price', rating='$product_rating', image='$product_image' 
        WHERE id= $id ";
        $stmt = $conn->query($update);
        if ($stmt->rowCount() > 0) {
            $message[] = 'product updated successfully';
        } else {
            $message[] = 'could not update the product';
        }
    }
};?>



<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Boxicons -->
	<link href='/public/css/boxicons.min.css' rel='stylesheet'>
	<!-- My CSS -->
	<link rel="stylesheet" href="../public/css/admin.css">
    <link rel="stylesheet" href="../public/css/mystore.css">
	<style>
		@import url('/public/css/css2.css');
	</style>
	<title>AdminHub</title>
</head>
<body>


	<!-- SIDEBAR -->
	<section id="sidebar">
		<a href="#" class="brand">
			<i class='bx bxs-smile'></i>
			<span class="text">AdminHub</span>
		</a>
		<ul class="side-menu top">
			<li class="active">
				<a href="index.php">
					<i class='bx bxs-dashboard' ></i>
					<span class="text">Dashboard</span>
				</a>
			</li>
			<li>
				<a href="mystore.php">
					<i class='bx bxs-shopping-bag-alt' ></i>
					<span class="text">My Store</span>
				</a>
			</li>
			<li>
				<a href="messages.php">
					<i class='bx bxs-message-dots' ></i>
					<span class="text">Messages</span>
				</a>
			</li>
			<li>
				<a href="orders.php">
					<i class='bx bxs-group' ></i>
					<span class="text">Orders</span>
				</a>
			</li>
		</ul>
		<ul class="side-menu">
			
			<li>
				<a href="/logout.php" class="logout">
					<i class='bx bxs-log-out-circle' ></i>
					<span class="text">Logout</span>
				</a>
			</li>
		</ul>
	</section>
	<!-- SIDEBAR -->



	<!-- CONTENT -->
	<section id="content">
		<!-- NAVBAR -->
		<nav>
			<i class='bx bx-menu' ></i>
			<a href="#" class="nav-link">Categories</a>
			<form action="#">
				<div class="form-input">
					<input type="search" placeholder="Search...">
					<button type="submit" class="search-btn"><i class='bx bx-search' ></i></button>
				</div>
			</form>
			<input type="checkbox" id="switch-mode" hidden>
			<label for="switch-mode" class="switch-mode"></label>
			<a href="#" class="notification">
				<i class='bx bxs-bell' ></i>
				<span class="num">8</span>
			</a>
			<a href="#" class="profile">
				<img src="../public/imgs/people.png">
			</a>
		</nav>
		<!-- NAVBAR -->

		<!-- MAIN -->
		<?php
			if(isset($message)){
				foreach($message as $message){
					echo '<span class="message">'.$message.'</span>';
				}
			}
		
		
		?>
		<div class="container">
            <div class="add-product-form centered">
			<section>
                <?php
                $stmt =$conn->query("SELECT * FROM products WHERE id= {$id} LIMIT 1")->fetchAll();

				foreach($stmt as $result){
                ?>
					<form action="<?php $_SERVER['PHP_SELF']?>" method="post" enctype ="multipart/form-data">
						<h3>Update the product</h3>
						<input type="text" name="product_name" value="<?= $result['name'];?>" placeholder="enter the product name" class="box" required>
						<input type="number" name="product_price" min="0" value="<?= $result['price'];?>" placeholder="enter the product price" class="box" required>
						<input type="number" name="product_rating" min="0" value="<?= $result['rating'];?>" placeholder="enter the product rating out of 5" class="box" required>
						<input type="hidden" name="product_image_old" value="<?= $result['image'];?>" class="box">
						<input type="file" name="product_image" accept="image/png, image/jpg, image/jpeg" class="box">
						<input type="submit" value="Update the product" name="update_product" class="btn">
						<a href ="mystore.php" class="btn">Go back</a>
					</form>
				<?php } ?>
			</section>
            </div>
		</div>
		<!-- MAIN -->
	</section>
	<!-- CONTENT -->
	

	<script src="../public/js/script.js"></script>
</body>
</html>
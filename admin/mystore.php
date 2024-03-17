<?php
include 'functions.php';
$title = "my store";
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
if (isset($_POST['add_product'])) {
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
	$product_rating = $_POST['product_rating'];
    $product_image = $_FILES['product_image'];
	uploadImg() ? $product_image = uploadImg() : $product_image = 'default.png';

    if (empty($product_name) || empty($product_price) || empty($product_image) || empty($product_rating)) {
        $message[] = 'please fill all the required info';
    } else {
        // Use prepared statement to prevent SQL injection
        $insert = "INSERT INTO products(name, price, rating, image) VALUES(:name, :price, :rating, :image)";
        $stmt = $conn->prepare($insert);
        $stmt->execute(['name' => $product_name, 'price' => $product_price,'rating' =>$product_rating,'image' => $product_image]);
		header("Location: mystore.php");
        if ($stmt->rowCount() > 0) {
            $message[] = 'new product added successfully';
        } else {
            $message[] = 'could not add the product';
        }
    }
};
	if(isset($_GET['delete'])){
		$id = $_GET['delete'];
		$stmt = $conn->prepare("DELETE FROM products WHERE id = :id");
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		$stmt->execute();
		header('location:mystore.php');
}
?>
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
			<section>
				<form action="" method="post" class="add-product-form" enctype ="multipart/form-data">
					<h3>Add a new product</h3>
					<input type="text" name="product_name" placeholder="enter the product name" class="box" required>
					<input type="number" name="product_price" min="0" placeholder="enter the product price" class="box" required>
					<input type="number" name="product_rating" min="0" placeholder="enter the product rating out of 5" class="box" required>
					<input type="file" name="product_image" accept="image/png, image/jpg, image/jpeg" class="box" required>
					<input type="submit" value="Add the product" name="add_product" class="btn">
				</form>
			</section>
		</div>
		<?php
		$query = "SELECT * FROM PRODUCTS";
		$select = $conn->query($query);
		?>
		<div class="product-display">
			<table class="product-display-table">
				<thead>
					<tr>
						<th>Product image</th>
						<th>Product name</th>
						<th>Product price</th>
						<th>Product rating</th>
						<th colspan="2">action</th>
					</tr>
					<?php
					while($row = $select->fetch(PDO::FETCH_ASSOC)){
					?>
					<tr>
						<td><img src="/public/imgs/products/<?= $row['image'];?>" height="100" alt=""></td>
						<td><?php echo $row['name'];?></td>
						<td><?php echo $row['price'];?></td>
						<td><?php echo $row['rating'];?></td>
						<td>
							<a href="admin_update.php?edit=<?php echo $row['id'];?>" class="btn"><i class="fas fa-edit"></i>edit</a>
							<a href="mystore.php?delete=<?php echo $row['id'];?>" class="btn"><i class="fas fa-trash"></i>delete</a>
						</td>

					</tr>
					<?php };?>
				</thead>


			</table>

		</div>
		<!-- MAIN -->
	</section>
	<!-- CONTENT -->
	

	<script src="../public/js/script.js"></script>
</body>
</html>
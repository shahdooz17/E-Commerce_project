<?php
include 'functions.php';
$title = "my store";
$message= [];
if(isset($_GET['edit'])) {
	$id = $_GET['edit'];
	$sqlAdmins = "SELECT * FROM users WHERE admin = '1'";
	$adminsStmt = $conn->query($sqlAdmins);
	$admins = $adminsStmt->fetchAll(PDO::FETCH_ASSOC);

	$sqlProducts = "SELECT * FROM products";
	$productsStmt = $conn->query($sqlProducts);
	$products = $productsStmt->fetchAll(PDO::FETCH_ASSOC);
	if (isset($_POST['update_order'])) {
		$admin = filter_input(INPUT_POST, 'admin', FILTER_SANITIZE_NUMBER_INT);
		$product = filter_input(INPUT_POST, 'product', FILTER_SANITIZE_NUMBER_INT);
		$price = filter_input(INPUT_POST, 'price', FILTER_SANITIZE_NUMBER_INT);
		$quantity = filter_input(INPUT_POST, 'quantity', FILTER_SANITIZE_NUMBER_INT);
		$date = filter_input(INPUT_POST, 'date', FILTER_SANITIZE_STRING) ?? date("Y-m-d");
		$status = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_NUMBER_INT);
		$sqlOrder = "UPDATE orders SET user_id='$admin', productId='$product', price='$price', date='$date', status='$status' WHERE id='$id'";
		if (!$conn->query($sqlOrder)) {
			$message[] = 'Could not update the order';
		} else {
			$message[] = 'Order updated successfully';
		}
	}
} else if(isset($_GET['delete'])) {
	$id = $_GET['delete'];
	$sqlOrder = "DELETE FROM orders WHERE id='$id'";
	if (!$conn->query($sqlOrder)) {
		$message[] = 'Could not delete the order';
	} else {
		$message[] = 'Order deleted successfully';
	}
} else {
	header('Location: orders.php');
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
            <div class="add-product-form centered">
			<section>
                <?php
                $stmt =$conn->query("SELECT * FROM orders WHERE id= {$id} LIMIT 1")->fetchAll();

				foreach($stmt as $result) { ?>
					<form action="<?php $_SERVER['PHP_SELF']?>" method="post" enctype ="multipart/form-data">
						<h3>Update the order</h3>
						<input type="number" name="price" value="<?= $result['price'] ?>" placeholder="enter the order price" class="box" required>
						<input type="number" name="quantity" placeholder="enter the order quantity" class="box" required value="<?= $result['quantity'] ?>">
						<input type="text" name="date" value="<?= $result['date'] ?>" placeholder="enter the order date" class="box" required>
						<select class="box" name="admin" aria-label="Admins" required>
							<?php
								if($admins) {
									foreach($admins as $admin) {
										if($admin['id'] == $result['id']) {
											echo "<option value='{$admin['id']}' selected>{$admin['name']} - {$admin['id']}</option>";
										}else{
											echo "<option value='{$admin['id']}'>{$admin['name']} - {$admin['id']}</option>";
										}
									}
								}
							?>
						</select>
						<select class="box" name="product" aria-label="Products" required>
							<?php
								if($products) {
									foreach($products as $product) {
										if($admin['id'] == $result['id']) {
											echo "<option value='{$product['id']}' selected>{$product['name']} - {$product['id']}</option>";
										}else{
											echo "<option value='{$product['id']}'>{$product['name']} - {$product['id']}</option>";
										}
								}
							}
							?>
						</select>
						<select class="box" name="status" aria-label="status" required>
							<option value="0" selected>pending</option>
							<option value="1">approved</option>
						</select>
						<input type="submit" value="Update the order" name="update_order" class="btn">
						<a href ="orders.php" class="btn">Go back</a>
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
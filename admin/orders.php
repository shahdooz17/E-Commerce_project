<?php 
	include 'functions.php';
	
	$message = [];


	$sqlAdmins = "SELECT * FROM users WHERE admin = '1'";
    $adminsStmt = $conn->query($sqlAdmins);
	$admins = $adminsStmt->fetchAll(PDO::FETCH_ASSOC);

	$sqlProducts = "SELECT * FROM products";
    $productsStmt = $conn->query($sqlProducts);
	$products = $productsStmt->fetchAll(PDO::FETCH_ASSOC);


	if(isset($_POST['add_order'])) {
		$user = filter_input(INPUT_POST, 'admin', FILTER_SANITIZE_NUMBER_INT);
		$product = filter_input(INPUT_POST, 'product', FILTER_SANITIZE_NUMBER_INT);
		$price = filter_input(INPUT_POST, 'price', FILTER_SANITIZE_NUMBER_INT);
		$quantity = filter_input(INPUT_POST, 'quantity', FILTER_SANITIZE_NUMBER_INT);
		$date = date("Y-m-d");
		$status = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_NUMBER_INT);
		$sqlOrder = "INSERT INTO orders (user_id, productId, price, date, quantity, status) VALUES ('$user', '$product', '$price', '$date', '$quantity', '$status')";
		
		if(!$conn->query($sqlOrder)) {
			$message[0] = 'Could not add the order';
		} else {
			$message[0] = 'Order added successfully';
		}
		
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
				<form action="<?php $_SERVER['PHP_SELF']?>" method="post" class="add-product-form" enctype ="multipart/form-data">
					<h3>Add a new order</h3>
					<input type="number" name="price" placeholder="enter the order price" class="box" required>
					<input type="number" name="quantity" placeholder="enter the order quantity" class="box" required>
					<select class="box" name="admin" aria-label="Admins" required>
                        <?php
                            if($admins) {
                                foreach($admins as $admin) {
                                    if($admin['id'] == $_SESSION['id']) {
                                        echo "<option value='{$_SESSION['id']}' selected>{$_SESSION['name']} - {$_SESSION['id']}</option>";
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
                                    echo "<option value='{$product['id']}'>{$product['name']} - {$product['id']}</option>";
                                }
                            }
                        ?>
                    </select>
					<select class="box" name="status" aria-label="status" required>
                        <option value="0" selected>pending</option>
						<option value="1">approved</option>
                    </select>
					<input type="submit" value="Add the order" name="add_order" class="btn">
				</form>
			</section>
		</div>
		<?php
		$query = "SELECT * FROM orders";
		$select = $conn->query($query);
		?>
		<div class="product-display">
			<table class="product-display-table">
				<thead>
					<tr>
						<th>Id</th>
						<th>Admin id</th>
						<th>Product id</th>
						<th>Price</th>
						<th>Date</th>
						<th>Status</th>
						<th colspan="2">action</th>
					</tr>
					<?php
					while($row = $select->fetch(PDO::FETCH_ASSOC)){
					?>
					<tr style="text-align: center;">
						<td><?= $row['id']?></td>
						<td><?php echo $row['user_id'];?></td>
						<td><?php echo $row['productId'];?></td>
						<td><?php echo $row['price'];?></td>
						<td><?php echo $row['date'];?></td>
						<td><?php ($row['status'] == 1) ? print "Approved" : print "Pending"?></td>
						<td>
							<a href="order_update.php?edit=<?php echo $row['id'];?>" class="btn"><i class="fas fa-edit"></i>edit</a>
							<a href="order_update.php?delete=<?php echo $row['id'];?>" class="btn"><i class="fas fa-trash"></i>delete</a>
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
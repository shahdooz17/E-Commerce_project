<?php
	include 'functions.php';
    $title="messages";
	$messages = [];

	if(isset($_POST['add_message'])) {

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
	<!-- CONTENT -->
	<?php
			if(isset($messages)){
				foreach($messages as $message){
					echo '<span class="message">'.$message.'</span>';
				}
			}
		
		
		?>
	<div class="container">
		<section>
			<form action="<?php $_SERVER['PHP_SELF']?>" method="post" class="add-product-form" enctype ="multipart/form-data">
				<h3>Add a new message</h3>
				<input type="text" name="name" placeholder="enter the name" class="box" required>
				<input type="email" name="email" placeholder="enter the email" class="box" required>
				<input type="number" name="number" placeholder="enter the phone number" class="box" required>
				<textarea class="box" name="message" row="3" required placeholder="enter the message"></textarea>
				<input type="submit" value="Add the message" name="add_message" class="btn">
			</form>
		</section>
	</div>
		<?php
		$query = "SELECT * FROM messages";
		$select = $conn->query($query);
		?>
	<div class="product-display">
		<table class="product-display-table">
			<thead>
				<tr>
					<th>Id</th>
					<th>Name</th>
					<th>Email</th>
					<th>Date</th>
					<th colspan="2">action</th>
				</tr>
				<?php
					while($row = $select->fetch(PDO::FETCH_ASSOC)){
				?>
				<tr style="text-align: center;">
					<td><?= $row['id']?></td>
					<td><?php echo $row['name'];?></td>
					<td><?php echo $row['email'];?></td>
					<td><?php echo $row['date'];?></td>
					<td>
						<a href="message_update.php?edit=<?php echo $row['id'];?>" class="btn"><i class="fas fa-edit"></i>edit</a>
						<a href="message_update.php?delete=<?php echo $row['id'];?>" class="btn"><i class="fas fa-trash"></i>delete</a>
					</td>
				</tr>
				<?php };?>
			</thead>
		</table>
	</div>
					</section>
	<script src="../public/js/script.js"></script>
</body>
</html>
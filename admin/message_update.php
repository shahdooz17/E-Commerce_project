<?php
include 'functions.php';
$title = "my store";
$messages= [];
if(isset($_GET['edit'])) {
	$id = $_GET['edit'];

	if (isset($_POST['update_message'])) {
		$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
        $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);
        $date = filter_input(INPUT_POST, 'date', FILTER_SANITIZE_STRING) ?? date("Y-m-d");
        $sqlOrder = "UPDATE messages SET name='$name', email='$email', messages='$message', date='$date' WHERE id='$id'";
		if (!$conn->query($sqlOrder)) {
			$messages[0] = 'Could not update the message';
		} else {
			$messages[0] = 'Message updated successfully';
		}
	}
} else if(isset($_GET['delete'])) {
	$id = $_GET['delete'];
	$sqlOrder = "DELETE FROM messages WHERE id='$id'";
	if (!$conn->query($sqlOrder)) {
		$messages[0] = 'Could not delete the message';
	} else {
		$messages[0] = 'Message deleted successfully';
	}
} else {
	header('Location: messages.php');
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
			if(isset($messages)){
				foreach($messages as $message){
					echo '<span class="message">'.$message.'</span>';
				}
			}
		
		
		?>
		<div class="container">
            <div class="add-product-form centered">
			<section>
                <?php
                $stmt =$conn->query("SELECT * FROM messages WHERE id= {$id} LIMIT 1")->fetchAll();

				foreach($stmt as $result) { ?>
					<form action="<?php $_SERVER['PHP_SELF']?>" method="post" enctype ="multipart/form-data">
						<h3>Update the message</h3>
                        <input type="text" name="name" placeholder="enter the name" value="<?= $result['name'] ?>" class="box" required>
					    <input type="email" name="email" placeholder="enter the email" class="box" value="<?= $result['email'] ?>" required>
					    <input type="number" name="number" placeholder="enter the phone number" class="box" value="<?= $result['number'] ?>" required>
					    <textarea class="box" name="message" row="3" required placeholder="enter the message"><?= $result['messages'] ?></textarea>
						<input type="submit" value="Update the message" name="update_message" class="btn">
						<a href ="messages.php" class="btn">Go back</a>
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
<?php
    $title ="cart";
    include 'components/header.php';
    include 'connect.php';
	include 'services/products.php';
	include 'services/cart.php';
	if(isset($_GET['id'])) {
		$id = $_GET['id'];
		$product = findProductById($conn, $id);
		addProduct($product['id'], $product['name'], $product['price']);
		header('Location: /cart.php');
	}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Cart</title>
	<link rel="stylesheet" href="/public/css/bootstrap4.min.css">
	<style>
		.form-submit-button {
	background: white;
	color: black;
	border-style: outset;
	border-color:white;
	height: 50px;
	width: 100px;
	font: bold15px arial,sans-serif;
	text-shadow: none;}
	</style>
</head>
<body>




	<div class="container">
		<div class="col-md-12">
			<table class="table table-bordered my-5">
				<tr>
					<th>ITEM ID</th>
					<th>ITEM NAME</th>
					<th>ITEM PRICE</th>
					<th>ITEM QUANTITY</th>
					<th>ACTION</th>
				</tr>

				<?php 

				$total_price = 0;

				if (!empty($_SESSION['cart'])) {
					
					foreach ($_SESSION['cart'] as $key => $value) { ?>
						<tr>
							<td><?php echo $value['id']; ?></td>
							<td><?php echo $value['name']; ?></td>
							<td><?php echo $value['price']; ?></td>
							<td><?php echo $value['quantity']; ?></td>
                                <td>
									<button class="btn btn-danger remove" id="<?php echo $value['id']; ?>" >Remove</button>
                                </td>
						</tr>

						  <?php $total_price = $total_price + $value['quantity'] * $value['price']; ?>

						
						
					<?php }
				}else{ ?>
                        <tr>
							<td class="text-center" colspan="5">NO ITEM SELECTED</td>
                        </tr>
				<?php }




				?>

						<tr>
							<td colspan="2"></td>
							<td>Total Price</td>
							<td><?php echo number_format($total_price,2); ?></td>
							<td>
								<button class="form-submit-button clearall">Clear All</button>
                            </td>
							<td>
								<button class="form-submit-button"><a href="checkout.php">checkout</a></button>
                            </td>
						</tr>
			</table>
		</div>
	</div>
<script src="/public/js/jquery-3.6.0.js"></script>



<script type="text/javascript">
	$(document).ready(function(){


		$(".remove").click(function(){
            var id = $(this).attr("id");
			$.post({
				url: "/action.php",
				data: {action: "remove", id: id},
			}, function(){
				location.reload();
			}());
		});
        

        $(".clearall").click(function(){
			$.post({
				url: "/action.php",
				data: {action: "clear"},
			}, function(){
				location.reload();
			}());
        });
	});
</script>
</body>
</html>

<?php include 'components/footer.php'; ?>
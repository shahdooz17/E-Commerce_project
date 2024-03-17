<?php include './components/header.php'; 
include './connect.php';

?>

<?php 

if(!isset($_SESSION['user']) || !isset($_SESSION['cart'])) {
    header('Location: signin.php');
}
$cart = $_SESSION['cart'];
$user = $_SESSION['user']['id'];
$status = 0;
$date = date("Y-m-d");
foreach($cart as $product_array => $product) {
    $id = $product['id'];
    $quantity = $product['quantity'];
    $price = $product['price'] * $quantity;
    $date = date("Y-m-d");
    $sql = "INSERT INTO orders (user_id, productId, quantity, price, status, date) VALUES ('$user', '$id', '$quantity', '$price', '0', '$date')";
    $result = $conn->query($sql);
    if($result) {
        unset($cart[$product_array]);
    }
}

$_SESSION['cart'] = $cart;
header('Location: cart.php')

?>



<?php include './components/footer.php'; ?>
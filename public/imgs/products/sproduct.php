<?php
    $title ="product";
    include 'components/header.php';
    include 'connect.php';

    $id = $_GET['id'];
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);    
    $sql = "SELECT * FROM products WHERE id =? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]); 
    $product = $stmt->fetch();
    $name = $product['name'];
    $price = $product['price'];
    $image = $product['image'];
    $rating = $product['rating'];

?>
<div class="d-flex justify-content-center container mt-5">
    <div class="card p-3 bg-white">
        <div class="about-product text-center mt-2"><img src="/public/imgs/products/<?= $image ?>" width="300">
            <div>
                <h4><?= $name ?></h4>
            </div>
        </div>
        <div class="d-flex justify-content-center total font-weight-bold mt-4"><p>$<?= $price ?></p></div>
        <h5><a class="text-muted" href="/cart.php?id=<?= $product['id'] ?>"><span><i class="fa-solid fa-cart-shopping"></i></span></a></h5>
    </div>
</div>

















































<?php include 'components/footer.php'; ?>
<?php
    $title = "Clothe";
    include 'connect.php';
    include 'components/header.php';
    include $_SERVER['DOCUMENT_ROOT'] .'/services/products.php';
    if(isset($_GET['search'])) {
        $products = findProduct($conn, $_GET['search']);
    } else {
        $products = getAllProducts($conn);
    }
?>

<!-- banner -->
<div class="banner2">
        <div class="content2">
            <h1>Get More Product</h1>
            <div id="bannerbtn2"><button>SHOP NOW</button></div>
        </div>
    </div>
    <!-- banner -->

    <!-- product cards -->
    <div class="container" id="product-cards">
        <div class="row" style="margin-top: 30px;">
            <?php if($products):?>
                <?php foreach ($products as $product): ?>
                    <div class="col-md-3 py-3 py-md-0">
                            <div class="card">
                                <a class="text-decoration-none text-dark" href="/sproduct.php?id=<?= $product['id'] ?>">
                                <img class="img-fluid" src="/public/imgs/products/<?= $product['image'] ?>"alt="">
                                <div class="card-body">
                                    <h3><?= $product['name'] ?></h3>
                                    <div class="star">
                                        <?php 
                                        
                                        for($i = 0; $i < $product['rating']; $i++) {
                                            echo '<i class="fas fa-star checked"></i>';
                                        }

                                        for($i = 0; $i < 5 - $product['rating']; $i++) {
                                            echo '<i class="fas fa-star"></i>';
                                        }
                                        ?>
                                    </div>
                                    <h5>$<?= $product['price'] ?> <a href="/cart.php?id=<?= $product['id'] ?>"><span><i class="fa-solid fa-cart-shopping"></i></span></a></h5>
                                </div>
                                </a>
                            </div>
                        
                    </div>
                <?php endforeach;?>
            <?php else: ?>
                <h1>No products found</h1>
            <?php endif; ?>
        </div>
    </div>
    <!-- product cards -->


    <!-- product -->
    <div class="container" style="margin-top: 100px;">
    <hr>
</div>
<div class="container">
    <h3 style="font-weight: bold;">PRODUCT.</h3>
    <hr>
</div>
    <!-- product -->


<!-- offer -->
    <div class="container" id="offer">
        <div class="row">
            <div class="col-md-4 py-3 py-md-0">
                <i class="fa-solid fa-cart-shopping"></i>
                <h5>Free Shipping</h5>
                <p>On order over $100</p>
            </div>
            <div class="col-md-4 py-3 py-md-0">
                <i class="fa-solid fa-truck"></i>
                <h5>Fast Delivery</h5>
                <p>World wide</p>
            </div>
            <div class="col-md-4 py-3 py-md-0">
                <i class="fa-solid fa-thumbs-up"></i>
                <h5>Big Choice</h5>
                <p>Of product</p>
            </div>
        </div>
    </div>
<!-- offer -->



<?php include 'components/footer.php'; ?>
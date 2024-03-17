<?php 
function addProduct($product,$name, $price,  $quantity = 1) {
    if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
        if (array_key_exists($product, $_SESSION['cart'])) {
            $_SESSION['cart'][$product]["quantity"] += 1;
        } else {
            $product_array = array(
                "id" => $product,
                "name" => $name,
                "price" => $price,
                "quantity" => $quantity
            );
            $_SESSION['cart'][$product] = $product_array;
        }
    } else {
        $product_array = array(
            "id" => $product,
            "name" => $name,
            "price" => $price,
            "quantity" => $quantity
        );
        $_SESSION['cart'] = array($product => $product_array);
    }
}

function removeItemsFromCart($product) {
    if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
        if (array_key_exists($product, $_SESSION['cart'])) {
            unset($_SESSION['cart'][$product]);
        }
    }
}

function updateQuantity($product, $quantity) {
    if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
        if (array_key_exists($product, $_SESSION['cart'])) {
            $_SESSION['cart'][$product]["quantity"] = $quantity;
        }
    }
}

?>
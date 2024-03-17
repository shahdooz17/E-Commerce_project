<?php 

function inputFilter($value) {
    if($value != ''){
        $value = trim($value); # " shahi elsayed " = "shahi elsayed"
        $value = stripslashes($value); # "shahi\'" = "shahi'"
        $value = htmlspecialchars($value); # "<script>" = "&lt;script&gt;"
        return $value;
    } else {
        return false;
    }
}

function getAllProducts($conn) {
    $sql = "SELECT * FROM products";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $products;
}

function findProductById($conn, $id) {
    if(inputFilter($id)) {
        $id = inputFilter($id);
        $sql = "SELECT * FROM products WHERE id = ". $id;
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
        return $product;
    } else {
        header('Location: /clothe.php');
    }
}

function findProduct($conn, $product) {
    if(inputFilter($product)) {
        $product = inputFilter($product);
        $sql = "SELECT * FROM products WHERE name LIKE '%". $product ."%'";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $products;
    } else {
        header('Location: /clothe.php');
    }
}

?>
<?php
include("../../config/db.php");
include("../../objects/Product.php");

if (isset($_GET['name']) && isset($_GET['price']) && isset($_GET['id'])){
    $name = $_GET['name'];
    $price = $_GET['price'];
    $id = $_GET['id'];

    $product = new Product($db);

    $product->update($name, $price, $id);
} else {
    echo "Error: product name, price and id required";
}
?>
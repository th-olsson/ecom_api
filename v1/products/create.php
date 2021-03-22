<?php
include("../../config/db.php");
include("../../objects/Product.php");

if (isset($_GET['name']) && isset($_GET['price'])){
    $name = $_GET['name'];
    $price = $_GET['price'];

    $product = new Product($db);

    $product->create($name, $price);

    echo "Product created where name: $name and price: $price";
} else {
    echo "Error: product name and price required";
}
?>
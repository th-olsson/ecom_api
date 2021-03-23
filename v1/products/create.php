<?php
header('Content-Type: application/json');

include("../../config/db.php");
include("../../objects/Product.php");

if (isset($_GET['name']) && isset($_GET['price'])){
    $name = $_GET['name'];
    $price = $_GET['price'];

    $product = new Product($db);

    $product->create($name, $price);

    echo json_encode("Product created where name: $name and price: $price");
} else {
    echo json_encode("Error: product name and price required");
}
?>
<?php
header('Content-Type: application/json');

include("../../config/db.php");
include("../../objects/Product.php");

if (isset($_GET['name']) && isset($_GET['price']) && isset($_GET['id'])){
    $name = $_GET['name'];
    $price = $_GET['price'];
    $id = $_GET['id'];

    $product = new Product($db);

    $product->update($name, $price, $id);
} else {
    $response = new stdClass();
    $response->message = "Product name, price and id needs to be specified";
    print_r(json_encode($response));
}
?>
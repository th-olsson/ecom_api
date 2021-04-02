<?php
header('Content-Type: application/json');

include("../../config/db.php");
include("../../objects/Product.php");

if (isset($_GET['name']) && isset($_GET['price'])){
    $name = $_GET['name'];
    $price = $_GET['price'];

    $product = new Product($db);

    $product->create($name, $price);

    $response = new stdClass();
    $response->message = "Product created";
    print_r(json_encode($response));
} else {

    $response = new stdClass();
    $response->message = "Product name and price needs to be specified";
    print_r(json_encode($response));
}
?>
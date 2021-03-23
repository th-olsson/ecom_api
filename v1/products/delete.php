<?php
header('Content-Type: application/json');

include("../../config/db.php");
include("../../objects/Product.php");

if (isset($_GET['id'])){
    $id = $_GET['id'];

    $product = new Product($db);

    $product->delete($id);
} else {
    echo "Specify which product should be deleted";
}

?>
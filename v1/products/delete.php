<?php
header('Content-Type: application/json');

include("../../config/db.php");
include("../../objects/Product.php");

if (isset($_GET['id'])){
    $id = $_GET['id'];

    $product = new Product($db);

    $product->delete($id);
} else {
    echo json_encode("Specify which product should be deleted with product id");
}

?>
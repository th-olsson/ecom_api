<?php
header('Content-Type: application/json');

include("../../config/db.php");
include("../../objects/Product.php");

$product = new Product($db);

$product->read();
?>
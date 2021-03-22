<?php
include("../../config/db.php");
include("../../objects/Product.php");

$product = new Product($db);

$product->read();
?>
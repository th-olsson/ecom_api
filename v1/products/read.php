<?php
header('Content-Type: application/json');

include("../../config/db.php");
include("../../objects/Product.php");
include("../../objects/User.php");
$user = new User($db);

$token="";
if (isset($_GET['token'])){
    $token = $_GET['token'];
} else {
    echo json_encode("No token specified");
    die();
}


$product = new Product($db);

if ($user->isTokenValid($token)){
    $product->read();
} else {
    echo json_encode("You need a valid token to view this page");
}

?>
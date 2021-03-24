<?php
header('Content-Type: application/json');

include("../../config/db.php");
include("../../objects/User.php");

if (isset($_GET['username']) && isset($_GET['password'])){
    $username = $_GET['username'];
    $password = $_GET['password'];

    $user = new User($db);

    $user->login($username, $password);

} else {
    echo json_encode("Error: username and password needs to be specified");
}
?>
<?php
header('Content-Type: application/json');

include("../../config/db.php");
include("../../objects/User.php");

if (isset($_GET['email']) && isset($_GET['username']) && isset($_GET['password'])){
    $email = $_GET['email'];
    $username = $_GET['username'];
    $password = $_GET['password'];

    $user = new User($db);

    $user->register($email, $username, $password);

    echo json_encode("User has been created where email: $email and username: $username");
} else {
    echo json_encode("Error: email, username and password needs to be specified");
}
?>
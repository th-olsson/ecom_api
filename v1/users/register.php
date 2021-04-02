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

    $response = new stdClass();
    $response->message = "User created";
    print_r(json_encode($response));
} else {
    
    $response = new stdClass();
    $response->message = "Email, username and password needs to be specified";
    print_r(json_encode($response));
}
?>
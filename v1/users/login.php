<?php
header('Content-Type: application/json');

include("../../config/db.php");
include("../../objects/User.php");

if (isset($_GET['username']) && isset($_GET['password'])){

    //Verify hashed password: returns true if correct password
    function pwdVerify($db){
        $sql = "SELECT password FROM users WHERE username = :username_IN";
        $stm = $db->prepare($sql);
        $stm->bindParam(":username_IN", $_GET['username']);
        $stm->execute();
        $hashed_pwd = $stm->fetch()['password'];
        $pwd_verify = password_verify($_GET['password'], $hashed_pwd);
        return $pwd_verify;
    }

    $user = new User($db);
    $user->login($_GET['username'], pwdVerify($db));
} else {
    
    $response = new stdClass();
    $response->message = "Username and password needs to be specified";
    print_r(json_encode($response));
}
?>
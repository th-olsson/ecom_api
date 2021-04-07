<?php
header('Content-Type: application/json');

include("../../config/db.php");
include("../../objects/User.php");

if (isset($_GET['username']) && isset($_GET['password'])){

    //Verify hashed password
    function pwdVerify($db){

        $sql = "SELECT password FROM users WHERE username = :username_IN";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(":username_IN", $_GET['username']);
        $stmt->execute();

        if ( $stmt->rowCount() == 1 ){  //If record with specified username exists in database
            $hashed_pwd = $stmt->fetch()['password'];
            $pwd_verify = password_verify($_GET['password'], $hashed_pwd); //pwd_verify is assigned true or false
            return $pwd_verify;
        } else {
            $response = new stdClass();
            $response->message = "User not found";
            print_r(json_encode($response));
            die();
        }
    }

    //Try login using User login method
    $user = new User($db);
    $user->login($_GET['username'], pwdVerify($db));
} else {
    
    $response = new stdClass();
    $response->message = "Username and password needs to be specified";
    print_r(json_encode($response));
}
?>
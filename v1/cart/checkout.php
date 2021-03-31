<?php #On this endpoint, user will checkout cart and needs to be logged in to do so, thus endpoint will require token 
header('Content-Type: application/json');

include("../../config/db.php");
include("../../objects/User.php");
include("../../objects/Cart.php");

    //Get token from URL
    if( isset($_GET['token']) ){
        $token = $_GET['token'];
        $user = new User($db);

        if ( $user->isTokenValid($token) == true ){
            $cart = new Cart($db);

            $cart->checkout($token);

        } else {
            echo json_encode("Token is invalid");
        }

    } else {
        echo json_encode("Token needs to be specified");
    }

?>
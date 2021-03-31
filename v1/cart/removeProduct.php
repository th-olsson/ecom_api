<?php #On this endpoint, user will remove products from cart and needs to be logged in to do so, thus endpoint will require token 
header('Content-Type: application/json');

include("../../config/db.php");
include("../../objects/User.php");
include("../../objects/Cart.php");

    //Get product ID and token from URL
    if( isset($_GET['product_id']) && isset($_GET['token']) ){
        $product_id = $_GET['product_id'];
        $token = $_GET['token'];
        $user = new User($db);

        if ( $user->isTokenValid($token) == true ){
            $cart = new Cart($db);

            $cart->removeProduct($product_id, $token);

        } else {
            echo json_encode("Token is invalid");
        }

    } else {
        echo json_encode("Product and token needs to be specified");
    }

?>
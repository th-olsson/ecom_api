<?php #On this endpoint, user will add products into cart and needs to be logged in to do so, thus endpoint will require token 
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

            $cart->addProduct($product_id, $token);

        } else {
            $response = new stdClass();
            $response->message = "Invalid token";
            print_r(json_encode($response));
        }

    } else {
        $response = new stdClass();
        $response->message = "Product and token needs to be specified";
        print_r(json_encode($response));
    }

?>
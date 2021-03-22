<?php
class Cart{
    //Cart properties
    private $user_id;
    private $product_id;
    private $quantity;

    //Database connection
    private $dbConnect;
    public function __construct($db){
        $this->dbConnect = $db;
    }

    //Methods for endpoints
    public function addProduct(){
    }

    public function removeProduct(){
    }
}
?>
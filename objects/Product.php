<?php
class Product{
    //Product properties
    private $product_id;
    private $name;
    private $price;
    private $quantity;

    //Database connection
    private $dbConnect;
    public function __construct($db){
        $this->dbConnect = $db;
    }

    //Methods for endpoints
    public function create(){
    }

    public function delete(){
    }

    public function update(){
    }

    public function read(){
    }
}
?>
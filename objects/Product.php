<?php
class Product{
    //Product properties
    private $product_id;
    private $name;
    private $price;

    //Database connection
    private $dbConnect;
    public function __construct($db){
        $this->dbConnect = $db;
    }

    //Methods for endpoints
    public function create($name_IN, $price_IN){
        $sql = "INSERT INTO products (name, price) VALUES (:name_IN, :price_IN)";
        $stmt = $this->dbConnect->prepare($sql);
        $stmt->bindparam(":name_IN", $name_IN);
        $stmt->bindparam(":price_IN", $price_IN);

        return $stmt->execute();
    }

    public function delete(){
    }

    public function update(){
    }

    public function read(){
        $sql = "SELECT name, price FROM products";
        $stmt = $this->dbConnect->query($sql);
        $stmt->execute();
        
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    }
}
?>
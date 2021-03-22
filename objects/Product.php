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

    public function delete($id_IN){
        $sql = "DELETE FROM products WHERE id = :id_IN";
        $stmt = $this->dbConnect->prepare($sql);
        $stmt->bindparam(":id_IN", $id_IN);

        $stmt->execute();

        if ($stmt->rowCount() < 1){
            echo "No product with id of $id_IN was found";
        } else {
            echo "Product with id of $id_IN was successfully deleted";
        }

    }

    public function update($name_IN, $price_IN, $id_IN){
            $sql = "UPDATE products SET name = :name_IN, price = :price_IN WHERE id = :id_IN";
            $stmt = $this->dbConnect->prepare($sql);
            $stmt->bindparam(":name_IN", $name_IN);
            $stmt->bindparam(":price_IN", $price_IN);
            $stmt->bindparam(":id_IN", $id_IN);
    
            $stmt->execute();
            
            if ($stmt->rowCount() < 1){
                echo "Product with id of $id_IN either doesn't exist or already has currently specified values";
            } else {
                echo "Product with id of $id_IN was successfully updated to name: $name_IN, price: $price_IN";
            }
    }

    public function read(){
        $sql = "SELECT id, name, price FROM products";
        $stmt = $this->dbConnect->query($sql);
        $stmt->execute();
        
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    }
}
?>
<?php   #Interacts with products-table in database
class Product{ 

    //Fields of product-table for reference:
    # id
    # name
    # price

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
            $response = new stdClass();
            $response->message = "Product not found";
            print_r(json_encode($response));
        } else {
            $response = new stdClass();
            $response->message = "Product deleted";
            print_r(json_encode($response));
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
            $response = new stdClass();
            $response->message = "Product not found or already has currently specified values";
            print_r(json_encode($response));
        } else {
            $response = new stdClass();
            $response->message = "Product updated";
            print_r(json_encode($response));
        }
    }

    public function read(){
        $sql = "SELECT id, name, price FROM products";
        $stmt = $this->dbConnect->query($sql);
        
        //Stop script if execute fails
        if ( !$stmt->execute() ){
            $response = new stdClass();
            $response->message = "Can't get products";
            print_r(json_encode($response));
            die();
        }
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $response = new stdClass();
        $response->data = $data;
        print_r(json_encode($response));
    }
}
?>
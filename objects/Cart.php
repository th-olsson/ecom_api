<?php   #Interacts with cart-table in database
class Cart{

    //Fields of cart-table for reference:
    # user_id
    # product_id
    # quantity

    //Database connection
    private $dbConnect;
    public function __construct($db){
        $this->dbConnect = $db;
    }

    //Methods for endpoints
    public function addProduct($product_id_IN, $token_IN){
        $user_id_IN = $this->getUserIdFromToken($token_IN);

        //See if product with specified id exists
        $sql = "SELECT name FROM products WHERE id = :product_id_IN";
        $stmt = $this->dbConnect->prepare($sql);
        $stmt->bindParam(":product_id_IN", $product_id_IN);
        $stmt->execute();
        if ( $stmt->rowCount() == 0 ){
            echo json_encode("Product of specified id doesn't exist");
            die();
        }
                
        //See first if product already exists in cart and declare quantity
        $sql = "SELECT quantity FROM cart WHERE user_id = :user_id_IN AND product_id = :product_id_IN";
        $stmt = $this->dbConnect->prepare($sql);
        $stmt->bindParam(":user_id_IN", $user_id_IN);
        $stmt->bindParam(":product_id_IN", $product_id_IN);
        $stmt->execute();

        if ( $stmt->rowCount() == 0 ){ //If product doesn't exist in cart
            $quantity_IN = 1;
            //Add product to cart
            $sql = "INSERT INTO cart (user_id, product_id, quantity) VALUES (:user_id_IN, :product_id_IN, :quantity_IN)";
            $stmt = $this->dbConnect->prepare($sql);
            $stmt->bindParam(":user_id_IN", $user_id_IN);
            $stmt->bindParam(":product_id_IN", $product_id_IN);
            $stmt->bindParam(":quantity_IN", $quantity_IN);
            $stmt->execute();

            echo json_encode("Product with id $product_id_IN was added to cart");
        } else { //If product exists already

            //Get quantity
            $quantity_IN = $stmt->fetch()['quantity'];
            $quantity_IN++;

            //Update quantity
            $sql = "UPDATE cart SET quantity = :quantity_IN WHERE user_id = :user_id_IN AND product_id = :product_id_IN";
            $stmt = $this->dbConnect->prepare($sql);
            $stmt->bindParam(":quantity_IN", $quantity_IN);
            $stmt->bindParam(":user_id_IN", $user_id_IN);
            $stmt->bindParam(":product_id_IN", $product_id_IN);
            $stmt->execute();

            echo json_encode("Another product with id $product_id_IN was added to cart");
        }
        
    }

    public function removeProduct($product_id_IN, $token_IN){
        $user_id_IN = $this->getUserIdFromToken($token_IN);

        //See if product with specified id exists
        $sql = "SELECT name FROM products WHERE id = :product_id_IN";
        $stmt = $this->dbConnect->prepare($sql);
        $stmt->bindParam(":product_id_IN", $product_id_IN);
        $stmt->execute();
        if ( $stmt->rowCount() == 0 ){
            echo json_encode("Product of specified id doesn't exist");
            die();
        }
                
        //See first if product already exists in cart and declare quantity
        $sql = "SELECT quantity FROM cart WHERE user_id = :user_id_IN AND product_id = :product_id_IN";
        $stmt = $this->dbConnect->prepare($sql);
        $stmt->bindParam(":user_id_IN", $user_id_IN);
        $stmt->bindParam(":product_id_IN", $product_id_IN);
        $stmt->execute();

        if ( $stmt->rowCount() == 0 ){ //If product doesn't exist in cart
            echo json_encode("Item with specified id doesn't exist in cart");
            die();
        }

        //Get quantity
        $quantity_IN = $stmt->fetch()['quantity'];

        if ( $quantity_IN > 1 ){
            $quantity_IN--;

            //Update quantity
            $sql = "UPDATE cart SET quantity = :quantity_IN WHERE user_id = :user_id_IN AND product_id = :product_id_IN";
            $stmt = $this->dbConnect->prepare($sql);
            $stmt->bindParam(":quantity_IN", $quantity_IN);
            $stmt->bindParam(":user_id_IN", $user_id_IN);
            $stmt->bindParam(":product_id_IN", $product_id_IN);
            $stmt->execute();

            echo json_encode("You have removed one product with id $product_id_IN from cart");

        } else if ($quantity_IN == 1) { //If there's only one product in cart, delete record
            $sql = "DELETE FROM cart WHERE user_id = :user_id_IN AND product_id = :product_id_IN";
            $stmt = $this->dbConnect->prepare($sql);
            $stmt->bindParam(":user_id_IN", $user_id_IN);
            $stmt->bindParam(":product_id_IN", $product_id_IN);
            $stmt->execute();

            echo json_encode("You have removed all products with id $product_id_IN from cart");
        }
        
    }

    public function checkout($token_IN){
        $user_id_IN = $this->getUserIdFromToken($token_IN);

        //Get cart records (product_id and quantity) with specified user id
        $sql = "SELECT product_id, quantity FROM cart WHERE user_id = :user_id_IN";
        $stmt = $this->dbConnect->prepare($sql);
        $stmt->bindParam(":user_id_IN", $user_id_IN);
        $stmt->execute();
        
        $data = json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        echo $data;
    }

    public function getUserIdFromToken($token_IN){
        $sql = "SELECT user_id FROM sessions WHERE token = :token_IN";
        $stmt = $this->dbConnect->prepare($sql);
        $stmt->bindParam(":token_IN", $token_IN);
        $stmt->execute();

        $row = $stmt->fetch();

        $user_id = $row['user_id'];

        return $user_id;
    }
}
?>
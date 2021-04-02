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
            $response = new stdClass();
            $response->message = "Product not found";
            print_r(json_encode($response));
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

            $response = new stdClass();
            $response->message = "Product added to cart";
            print_r(json_encode($response));

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

            $response = new stdClass();
            $response->message = "Product added to cart";
            print_r(json_encode($response));
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
            $response = new stdClass();
            $response->message = "Product not found";
            print_r(json_encode($response));
            die();
        }
                
        //See first if product already exists in cart and declare quantity
        $sql = "SELECT quantity FROM cart WHERE user_id = :user_id_IN AND product_id = :product_id_IN";
        $stmt = $this->dbConnect->prepare($sql);
        $stmt->bindParam(":user_id_IN", $user_id_IN);
        $stmt->bindParam(":product_id_IN", $product_id_IN);
        $stmt->execute();

        if ( $stmt->rowCount() == 0 ){ //If product doesn't exist in cart
            $response = new stdClass();
            $response->message = "Product not found in cart";
            print_r(json_encode($response));
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

            $response = new stdClass();
            $response->message = "Product removed from cart";
            print_r(json_encode($response));

        } else if ($quantity_IN == 1) { //If there's only one product in cart, delete record
            $sql = "DELETE FROM cart WHERE user_id = :user_id_IN AND product_id = :product_id_IN";
            $stmt = $this->dbConnect->prepare($sql);
            $stmt->bindParam(":user_id_IN", $user_id_IN);
            $stmt->bindParam(":product_id_IN", $product_id_IN);
            $stmt->execute();

            $response = new stdClass();
            $response->message = "Product removed from cart";
            print_r(json_encode($response));
        }
        
    }

    public function checkout($token_IN){
        $user_id_IN = $this->getUserIdFromToken($token_IN);

        //Get products data from cart of specified user id
        $sql = "SELECT c.product_id, p.name, c.quantity, c.quantity*p.price AS total_cost FROM cart AS c
                JOIN products AS p ON p.id = c.product_id
                WHERE c.user_id = :user_id_IN";
        $stmt = $this->dbConnect->prepare($sql);
        $stmt->bindParam(":user_id_IN", $user_id_IN);
        $stmt->execute();

        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $response = new stdClass();
        $response->data = $data;
        print_r(json_encode($response));

        
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
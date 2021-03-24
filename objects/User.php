<?php   #Interacts with users-table in database
class User{

    //Fields of users-table for reference:
    # id
    # email
    # username
    # password

    private $id;
    private $email;
    private $username;
    private $password;

    //Database connection
    private $dbConnect;
    public function __construct($db){
        $this->dbConnect = $db;
    }

    //Methods for endpoints
    public function register($email_IN, $username_IN, $password_IN){   
        $sql = "INSERT INTO users (email, username, password) VALUES (:email_IN, :username_IN, :password_IN)";

        $stmt = $this->dbConnect->prepare($sql);
        $stmt->bindParam(":email_IN", $email_IN);
        $stmt->bindParam(":username_IN", $username_IN);
        $stmt->bindParam(":password_IN", $password_IN);

        return $stmt->execute();
    }

    public function login($username_IN, $password_IN){
        $sql = "SELECT * FROM users WHERE username = :username_IN AND password = :password_IN";

        $stmt = $this->dbConnect->prepare($sql);
        $stmt->bindParam(":username_IN", $username_IN);
        $stmt->bindParam(":password_IN", $password_IN);
        
        $stmt->execute();

        if ($stmt->rowCount() == 1){
            echo json_encode("User has successfully been logged in");
        } else {
            echo json_encode("Invalid login credentials");
        }
    }
}
?>
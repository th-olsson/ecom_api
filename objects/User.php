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

        $hashed_pwd = password_hash($password_IN, PASSWORD_DEFAULT);

        $stmt = $this->dbConnect->prepare($sql);
        $stmt->bindParam(":email_IN", $email_IN);
        $stmt->bindParam(":username_IN", $username_IN);
        $stmt->bindParam(":password_IN", $hashed_pwd);

        return $stmt->execute();
    }

    public function login($username_IN, $pwd_verify_IN){
        $sql = "SELECT * FROM users WHERE username = :username_IN";

        $stmt = $this->dbConnect->prepare($sql);
        $stmt->bindParam(":username_IN", $username_IN);
        $stmt->execute();

        //Checks if input matches a record in database & verifies hashed password
        if ($stmt->rowCount() == 1 && $pwd_verify_IN == true){ //Correct login credentials
            echo json_encode("User has successfully been logged in");
        } else {    //Incorrect login credentials
            echo json_encode("Invalid login credentials");
        }
    }
}
?>
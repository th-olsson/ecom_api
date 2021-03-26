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
        $sql = "SELECT id, username FROM users WHERE username = :username_IN";

        $stmt = $this->dbConnect->prepare($sql);
        $stmt->bindParam(":username_IN", $username_IN);
        $stmt->execute();

        //Checks if input matches a record in database & verifies hashed password
        if ($stmt->rowCount() == 1 && $pwd_verify_IN == true){
            $row = $stmt->fetch();
            return $this->createToken($row['id'], $row['username']);

            echo json_encode("User has successfully been logged in");
        } else {
            echo json_encode("Invalid login credentials");
        }
    }

    public function createToken($id, $username){
        $checked_token = $this->checkToken($id);

        if ($checked_token != false){
            return $checked_token;
        }
        
        $time = time();
        $token = md5($time . $id . $username);

        $sql = "INSERT INTO sessions(user_id, token, last_used) VALUES(:user_id_IN, :token_IN, :last_used_IN)";
        $stmt = $this->dbConnect->prepare($sql);
        $stmt->bindParam(":user_id_IN", $id);
        $stmt->bindParam(":token_IN", $token);
        $stmt->bindParam(":last_used_IN", $time);
        $stmt->execute();

        return $token;
    }

    public function checkToken($id){
        $active_time = time() - (60*60);

        $sql = "SELECT token, last_used FROM sessions WHERE user_id = :user_id_IN AND last_used > :active_time_IN";
        $stmt = $this->dbConnect->prepare($sql);
        $stmt->bindParam(":user_id_IN", $id);
        $stmt->bindParam(":active_time_IN", $active_time);
        $stmt->execute();

        $row = $stmt->fetch();

        if(isset($row['token'])){
            return $row['token'];
        } else {
            return false;
        }
    }

    public function isTokenValid($token){
        $active_time = time() - (60*60);

        $sql = "SELECT token, last_used FROM sessions WHERE token = :token_IN AND last_used > :active_time_IN";
        $stmt = $this->dbConnect->prepare($sql);
        $stmt->bindParam(":token_IN", $token);
        $stmt->bindParam(":active_time_IN", $active_time);
        $stmt->execute();

        $row = $stmt->fetch();

        if(isset($row['token'])){
            return true;
        } else {
            return false;
        }
    }
}
?>
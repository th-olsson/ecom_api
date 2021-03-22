<?php
class User{
    //User properties
    private $user_id;
    private $email;
    private $username;
    private $password;

    //Database connection
    private $dbConnect;
    public function __construct($db){
        $this->dbConnect = $db;
    }

    //Methods for endpoints
    public function register(){
    }

    public function login(){
    }
}
?>
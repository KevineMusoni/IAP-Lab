<?php
    include "crud.php";
    include "authenticator.php";
    include_once 'DBConnector.php';

    class User implements Crud{
        private $user_id;
        private $first_name;
        private $last_name;
        private $city_name;

        private $username;
        private $password;

        // We can use the class constructor to initialize our values. Member variables can not be instantiated from elsewhere; They are private.

        function __construct($first_name, $last_name, $city_name, $username, $password){
            // "this->" works as a reference to the current object

            $this->first_name = $first_name;
            $this->last_name = $last_name;
            $this->city_name = $city_name;
            $this->username = $username;
            $this->password = $password;
        }
        // Introduce a static constructor so that we access it with the class rather than an object (PHP does not allow multiple constructors )
        
        public static function create(){
            $instance = new self("", "", "", "", "");
            return $instance;
        }

        // username setter
        public function setUsername($username){
            $this->username = $username;
        }
        
        // username getter
        public function getUsername(){
            return $this->username;
        }

        // password setter
        public function setPassword($password){
            $this->password = $password;
        }
        // password getter
        public function getPassword(){
            return $this->password;
        }

        // user_id setter
        public function setUserId($user_id){
            $this->user_id = $user_id;
        }
        // user_id getter
        public function getUserId(){
            return $this->$user_id;
        }

        // crud interface
        public function save($con){
            $fn = $this-> first_name;
            $ln = $this-> last_name;
            $city = $this-> city_name;
            $uname = $this-> username;
            $this-> hashPassword;
            $pass = $this->password;

            $res = mysqli_query($con->conn,"INSERT INTO user(first_name,last_name,user_city) VALUES('$fn','$ln','$city')") or die("Error" .mysqli_error($con->conn));
            return $res;
        }

        public function readAll($con){
            $res = $con->query("SELECT * FROM user");
            return $res;
        }
        public function readUnique(){
            return null;
        }
        public function search(){
            return null;
        }
        public function update(){
            return null;
        }
        public function removeOne(){
            return null;
        }
        public function removeAll(){
            return null;
        }
        public function validateForm(){
            // Return true if values are not empty
            $fn = $this->first_name;
            $ln = $this->last_name;
            $city = $this->city_name;

            if($fn == "" || $ln == "" || $city == ""){
                return false;
            }
            return true;
        }
        public function createFormErrorSessions(){
            session_start();
            $_SESSION['form_errors']= "All fields are required";
        }

        public function hashPassword(){
        // inbuilt function
            $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        }

        public function isPasswordCorrect($username,$password){
            $con =new DBConnector;
            $found = False;
            $res = mysqli_query($con->conn, "SELECT * FROM user") or die ("Error" .mysqli_error());

            while($row = mysqli_fetch_array($res)){
                if(password_verify($this->getPassword(), $row['password']) && $this ->getUsername() == $row['username']){
                    $found = true;
                }
            }
            // close database connection
            $con->closeDatabase();
            return $found;
            // return true;
        }

        public function login(){
            if($this->isPasswordCorrect()){
                // if password is correct, we load the protected page
                header("Location:private_page.php");
            }
        }

        public function createUserSession(){
            session_start();
            $_SESSION['username'] = $this->getUsername();
        }

        public function logout(){
            session_start();
            unset($_SESSION['username']);
            session_destroy();
            header("Location:lab1.php");

        }

    }
?>

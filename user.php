<?php
    include "crud.php";
    class User implements Crud{
        private $user_id;
        private $first_name;
        private $last_name;
        private $city_name;

        function __construct($first_name, $last_name, $city_name){
            $this->first_name = $first_name;
            $this->last_name = $last_name;
            $this->city_name = $city_name;
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

    }
?>

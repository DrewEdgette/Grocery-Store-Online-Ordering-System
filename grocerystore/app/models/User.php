<?php
    class User {
        private $db;

        public function __construct() {
            $this->db = new Database;
        }

        // creates new user in database and then returns true or false
        public function register($data) {
            $this->db->query("INSERT INTO customers (full_name, email, customer_password) VALUES (:full_name,:email,:password);");
            $this->db->bind(":full_name", $data["full_name"]);
            $this->db->bind(":email", $data["email"]);
            $this->db->bind(":password", $data["pwd"]);

            return ($this->db->execute()) ? true : false;
        }

        // logs the user in and returns the row if successful
        public function login($email,$pwd) {
            $this->db->query("SELECT * FROM customers WHERE email=:email;");
            $this->db->bind(":email", $email);

            // check if that email is even in the database
            if (!$this->userExists($email)) {
                return false;
            }

            $user = $this->db->single();
            $pwdHashed = $user->customer_password;

            return password_verify($pwd,$pwdHashed) ? $user : false;
        }

        // checks if a user exists based on the email
        public function userExists($email) {
            $this->db->query("SELECT * FROM customers WHERE email=:email;");
            $this->db->bind(":email", $email);

            return ($this->db->rowCount() > 0);
        }


        // updates user address info
        public function updateInfo($id, $value, $column) {
            $this->db->query("UPDATE customers SET " . $column . " = :value WHERE customer_id=:userid;");
            $this->db->bind(":value", $value);
            $this->db->bind(":userid", $id);
            $this->db->execute();
        }


        // gets user by id
        public function getUser($id) {
            $this->db->query("SELECT * FROM customers WHERE customer_id = :id");
            $this->db->bind(":id", $id);

            $user = $this->db->single();

            return ($this->db->rowCount() > 0) ? $user : false;
        }


        // updates user password
        public function updatePassword($user, $pwd, $new_pwd) {

            $pwdHashed = $user->customer_password;

            if (password_verify($pwd,$pwdHashed)) {
                $this->db->query("UPDATE customers SET customer_password = :new_pwd WHERE customer_id=:userid;");
                $this->db->bind(":new_pwd", $new_pwd);
                $this->db->bind(":userid", $user->customer_id);
                $this->db->execute();

                return true;
            }

            return false;
        }
}

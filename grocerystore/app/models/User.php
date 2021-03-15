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
}

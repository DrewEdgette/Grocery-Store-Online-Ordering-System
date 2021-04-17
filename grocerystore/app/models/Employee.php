<?php

class Employee {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }


    // creates new user in database and then returns true or false
    public function register($data) {
        $this->db->query("INSERT INTO employees (full_name, email, employee_password) VALUES (:full_name,:email,:password);");
        $this->db->bind(":full_name", $data["full_name"]);
        $this->db->bind(":email", $data["email"]);
        $this->db->bind(":password", $data["pwd"]);

        return ($this->db->execute()) ? true : false;
    }  

    // adds a grocery item to the database
    public function additem($data) {
    $this->db->query("INSERT INTO items (item_name, item_price, item_weight, image_url) VALUES (:item_name,:item_price,:item_weight,:image_url); DELETE FROM items WHERE item_price = 0.00;");
    $this->db->bind(":item_name", $data["item_name"]);
    $this->db->bind(":item_price", $data["item_price"]);
    $this->db->bind(":item_weight", $data["item_weight"]);
    $this->db->bind(":image_url", $data["image_url"]);

    return ($this->db->execute());
    }

    // logs the user in and returns the row if successful
    public function login($email,$pwd) {
        $this->db->query("SELECT * FROM employees WHERE email=:email;");
        $this->db->bind(":email", $email);

        // check if that email is even in the database
        if (!$this->userExists($email)) {
            return false;
        }

        $user = $this->db->single();
        $pwdHashed = $user->employee_password;

        return password_verify($pwd,$pwdHashed) ? $user : false;
    }


    // checks if a user exists based on the email
    public function userExists($email) {
        $this->db->query("SELECT * FROM employees WHERE email=:email;");
        $this->db->bind(":email", $email);

        return ($this->db->rowCount() > 0);
    }

    // gets employee by id
    public function getUser($id) {
        $this->db->query("SELECT * FROM employees WHERE employee_id = :id");
        $this->db->bind(":id", $id);

        $user = $this->db->single();

        return ($this->db->rowCount() > 0) ? $user : false;
    }


    // updates user info
    public function updateInfo($id, $column, $value) {
        $this->db->query("UPDATE employees SET " . $column . " = :value WHERE employee_id=:id;");
        $this->db->bind(":value", $value);
        $this->db->bind(":id", $id);
        $this->db->execute();
    }


    // updates user password
    public function updatePassword($user, $pwd, $new_pwd) {

        $pwdHashed = $user->employee_password;

        if (password_verify($pwd,$pwdHashed)) {
            $this->db->query("UPDATE employees SET employee_password = :new_pwd WHERE employee_id=:userid;");
            $this->db->bind(":new_pwd", $new_pwd);
            $this->db->bind(":userid", $user->employee_id);
            $this->db->execute();

            return true;
        }

        return false;
    }

    // gets the latest orders from all customers
    public function getOrders() {
        $this->db->query("SELECT * FROM orders WHERE order_status = 'Pending' ORDER BY order_id ASC;");
        return $this->db->resultSet();
    }


    // gets specific order by its id
    public function getOrder($orderID) {
        $this->db->query("SELECT * FROM orders WHERE order_id = :order_id;");
        $this->db->bind(":order_id", $orderID);

        return $this->db->single();
    }

}
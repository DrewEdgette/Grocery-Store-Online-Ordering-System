<?php

class Customer {
    private $db;
    private $cart;

    public function __construct() {
        $this->db = new Database;
        $this->cart = new Cart;
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



    // updates address
    public function updateAddress($id, $column, $value) {
        $this->db->query("UPDATE addresses SET " . $column . " = :value WHERE address_id=:id;");
        $this->db->bind(":value", $value);
        $this->db->bind(":id", $id);
        $this->db->execute();
    }


    // gets all user addresses by id
    public function getAddresses($id) {
        $this->db->query("SELECT * FROM addresses WHERE customer_id = :id;");
        $this->db->bind(":id", $id);

        return $this->db->resultSet();
    }


    // gets address by id
    public function getAddress($customerID, $addressID) {
        $this->db->query("SELECT * FROM addresses WHERE address_id = :addressID;");
        $this->db->bind(":addressID", $addressID);

        $result = $this->db->single();

        return ($customerID === $result->customer_id) ? $result : header("location: /grocerystore/customers/addresses");
    }


    // deletes an address by id
    public function deleteAddress($id) {
        $this->db->query("DELETE FROM addresses WHERE address_id = :id;");
        $this->db->bind(":id", $id);
        $this->db->execute();
    }

    // adds an address to the database
    public function addAddress($data) {
        $this->db->query("INSERT INTO addresses (street_address,city,state,zip,phone,customer_id) 
                            VALUES (:new_address, :new_city, :new_state, :new_zip, :new_phone, :userid);");
        $this->db->bind(":new_address", $data["new_address"]);
        $this->db->bind(":new_city", $data["new_city"]);
        $this->db->bind(":new_state", $data["new_state"]);
        $this->db->bind(":new_zip", $data["new_zip"]);
        $this->db->bind(":new_phone", $data["new_phone"]);
        $this->db->bind(":userid", $data["userid"]);
        $this->db->execute();
    }




    // updates user info
    public function updateInfo($id, $column, $value) {
        $this->db->query("UPDATE customers SET " . $column . " = :value WHERE customer_id=:id;");
        $this->db->bind(":value", $value);
        $this->db->bind(":id", $id);
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


    // finds out if user is employee based on email
    public function isEmployee($email) {
        $this->db->query("SELECT * FROM employees WHERE email=:email;");
        $this->db->bind(":email", $email);
        return $this->db->rowCount() > 0;
    }


    // gets all of a user's orders by id
    public function getOrders($id) {
        $this->db->query("SELECT * FROM orders WHERE customer_id = :customer_id ORDER BY order_id DESC;");
        $this->db->bind(":customer_id", $id);

        return $this->db->resultSet();
    }

    // gets specific order by its id
    public function getOrder($customerID, $orderID) {
        $this->db->query("SELECT * FROM orders WHERE order_id = :order_id;");
        $this->db->bind(":order_id", $orderID);

        $order = $this->db->single();
        $resultCustomerID = $order->customer_id;

        return ($customerID == $resultCustomerID) ? $order : header("location: /grocerystore/customers/orders");
    }

}

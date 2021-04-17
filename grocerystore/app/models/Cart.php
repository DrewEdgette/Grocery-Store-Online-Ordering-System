<?php

class Cart {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }


    public function getSubTotal($cart) {
        $subTotal = 0.00;

        foreach ($cart as $item) {
            $subTotal += $item[0]->item_price * $item[1];
        }

        return $subTotal;
    }


    public function getTax($subTotal, $TAX_RATE) {
        return round($subTotal * $TAX_RATE, 2);
    }


    public function getTotal($subTotal, $tax) {
        return $subTotal + $tax;
    }


    public function placeOrder($data) {

        // create a new empty order
        $this->db->query("INSERT INTO orders (order_date, order_total, order_status, customer_id) VALUES (:order_date,:order_total,:order_status,:customer_id);");
        $this->db->bind(":order_date", $data["date"]);
        $this->db->bind(":order_total", $data["total"]);
        $this->db->bind(":order_status", "Pending");
        $this->db->bind(":customer_id", $data["user"]->customer_id);
        $this->db->execute();

        // get the id of the order we just made
        $this->db->query("SELECT * FROM orders WHERE customer_id = :customer_id ORDER BY order_id DESC LIMIT 1;");
        $this->db->bind(":customer_id", $data["user"]->customer_id);
        $orderID = $this->db->single()->order_id;

        // populate order_details with all of the items that were in the cart
        foreach ($data["cart"] as $item) {
            $this->db->query("INSERT INTO order_details (item_id, item_quantity, item_price, order_id) VALUES (:item_id, :item_quantity, :item_price, :order_id);");
            $this->db->bind(":item_id", $item[0]->item_id);
            $this->db->bind(":item_quantity", $item[1]);
            $this->db->bind(":item_price", $item[0]->item_price);
            $this->db->bind(":order_id", $orderID);

            $this->db->execute();
        }
        
    }


    public function setItemQuantity($item, $quantity) {

    }
    
}
<?php

class Carts extends Controller {


    private $data = [];

    public function __construct() {
        $this->cartModel = $this->model('Cart');
        $this->userModel = $this->model('Customer');
    }

    public function myCart() {
        if (!isset($_SESSION["userid"])) {
            header("location: /grocerystore/customers/login");
        }

        $data = [
            "cart" => $_SESSION["cart"],
        ];


        // sends data to the view
        $this->view('carts/mycart', $data);
    }

    public function checkout() {
        if (!isset($_SESSION["userid"])) {
            header("location: /grocerystore/customers/login");
        }
        
        
        $data = [
            "cart" => $_SESSION["cart"],

            "date" => date("Y-m-d"),

            "taxrate" => 0.04,
            "tax" => 0.00,
            "subtotal" => 0.00,
            "total" => 0.00,
        ];

        $data["user"] = $this->userModel->getUser($_SESSION["userid"]);

        $data["subtotal"] = $this->cartModel->getSubTotal($data["cart"]);
        $data["tax"] = $this->cartModel->getTax($data["subtotal"], $data["taxrate"]);
        $data["total"] = $this->cartModel->getTotal($data["subtotal"], $data["tax"]);


        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $this->cartModel->placeOrder($data);
            
            header("location: /grocerystore/customers/orders");
        }

        // sends data to the view
        $this->view('carts/checkout', $data);
    }

}
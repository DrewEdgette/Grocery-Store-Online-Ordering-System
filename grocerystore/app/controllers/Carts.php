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


        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (!isset($_SESSION["userid"])) {
                header("location: /grocerystore/customers/login");
            }

            $data = [
                "cart" => $_SESSION["cart"],
            ];

            $newQuantity = $_POST["quantity"];
            $itemID = array_key_last($_POST);

            $_SESSION["cart"][$itemID][1] = $newQuantity;

            //echo $data["cart"][$itemID][1];

            header("location: /grocerystore/carts/mycart");
        }


        // sends data to the view
        $this->view('carts/mycart', $data);
    }

    public function checkout() {
        if (!isset($_SESSION["userid"])) {
            header("location: /grocerystore/customers/login");
        }

        $user = $this->userModel->getUser($_SESSION["userid"]);
        
        
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
            
            $this->updateSessionInfo($user);
            header("location: /grocerystore/customers/orders");
        }

        // sends data to the view
        $this->view('carts/checkout', $data);
    }


    public function changeQuantity() {
        if (!isset($_SESSION["userid"])) {
            header("location: /grocerystore/customers/login");
        }

        $data = [
            "cart" => $_SESSION["cart"],
        ];


        // sends data to the view
        $this->view('carts/changequantity', $data);
    }


    // updates the current session variables
    public function updateSessionInfo($user) {
        $_SESSION["userid"] = $user->customer_id;
        $_SESSION["username"] = $user->full_name;
        $_SESSION["email"] = $user->email;
        $_SESSION["pwd"] = $user->customer_password;

        $_SESSION["address"] = $user->address;
        $_SESSION["city"] = $user->city;
        $_SESSION["state"] = $user->state;
        $_SESSION["zip"] = $user->zip;

        $_SESSION["phone"] = $user->phone;
        $_SESSION["payment"] = $user->payment;

        $_SESSION["cart"] = [];
        $_SESSION["isEmployee"] = false;
    }

}
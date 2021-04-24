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

            if (!$newQuantity) {
                unset($_SESSION["cart"][$itemID]);
            }

            else {
                $_SESSION["cart"][$itemID][1] = $newQuantity;
            }


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

            "orderAddressID" => $_SESSION["orderAddressID"],
            "payment" => $_SESSION["payment"],
        ];

        if (isset($_SESSION["orderType"])) {
            $data["orderType"] = $_SESSION["orderType"];
        }

        $data["user"] = $this->userModel->getUser($_SESSION["userid"]);

        if (!empty($data["orderAddressID"])) {
            $data["address"] = $this->userModel->getAddress($_SESSION["userid"], $data["orderAddressID"]);
        }

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



    public function orderType() {
        if (!isset($_SESSION["userid"])) {
            header("location: /grocerystore/customers/login");
        }

        else if (empty($_SESSION["cart"])) {
            header("location: /grocerystore");
        }

        unset($_SESSION["orderType"]);

        $user = $this->userModel->getUser($_SESSION["userid"]);
        
        
        $data = [
            "cart" => $_SESSION["cart"],

        ];

        $data["user"] = $this->userModel->getUser($_SESSION["userid"]);



        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            if ($_POST["ordertype"] == "Pickup") {
                header("location: /grocerystore/carts/confirmpayment");
            }

            else if ($_POST["ordertype"] == "Delivery") {
                header("location: /grocerystore/carts/confirmaddress");
            }
            
        }

        // sends data to the view
        $this->view('carts/ordertype', $data);
    }



    public function confirmAddress() {
        if (!isset($_SESSION["userid"])) {
            header("location: /grocerystore/customers/login");
        }

        else if (empty($_SESSION["cart"])) {
            header("location: /grocerystore");
        }

        $user = $this->userModel->getUser($_SESSION["userid"]);

        $data = [
            "addresses" => [],
            "noaddress" => ""
        ];

        $addressList = $this->userModel->getAddresses($user->customer_id);

        if (empty($addressList[0]->address_id)) {
            $_POST["error"] = "noaddress";
            $data["noaddress"] = "You don't have any addresses yet.";
        }
        

        foreach ($addressList as $address) {
            array_push($data["addresses"], array(
                $address->address_id,
                $address->street_address, 
                $address->city,
                $address->state,
                $address->zip,
                $address->phone,
                $address->address_name
            ));
        }
        
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $_SESSION["orderAddressID"] = array_key_first($_POST);
            $_SESSION["orderType"] = "Delivery";

            header("location: /grocerystore/carts/confirmpayment");
        }


        // sends data to the view
        $this->view('carts/confirmaddress', $data);
    }



    public function confirmPayment() {
        if (!isset($_SESSION["userid"])) {
            header("location: /grocerystore/customers/login");
        }

        else if (empty($_SESSION["cart"])) {
            header("location: /grocerystore");
        }

        $user = $this->userModel->getUser($_SESSION["userid"]);

        $data = [
            "payment" => "",
        ];

        $data["payment"] = "Card ending in " . substr($user->payment, -4);
        $_SESSION["payment"] = $data["payment"];

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            header("location: /grocerystore/carts/checkout");
        }


        // sends data to the view
        $this->view('carts/confirmpayment', $data);
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
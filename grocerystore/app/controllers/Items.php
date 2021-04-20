<?php

class Items extends Controller {

    private $data = "";

    public function __construct() {
        $this->itemModel = $this->model('Item');
    }

    public function search() {
        $data = $this->data;

        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            $_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);

            $data = [
                "query" => $_GET["query"],
                "results" => ""
            ];

            $results = $this->itemModel->getSearchResults($data);


            if (!$results) {
                $data["results"] = "<div class='my-account'><h1>No results found.</h1></div>";
            }

            else {
                foreach($results as $result) {
                    // if user is not logged in or logged in as a customer, show search results that link them to the item's page
                    if (!isset($_SESSION["isEmployee"]) || !$_SESSION["isEmployee"]) {
                        $data["results"] .= "<div class='clickable-section-box' onclick=location.href='/grocerystore/items/info?id=" . $result->item_id . "'>" . $result->item_name . " <img src='" . $result->image_url . "'> $$result->item_price</div>";
                    }

                    // otherwise link them to the employee update item page
                    else {
                        $data["results"] .= "<div class='clickable-section-box' onclick=location.href='/grocerystore/employees/changeitem?id=" . $result->item_id . "'>" . $result->item_name . " <img src='" . $result->image_url . "'> $$result->item_price</div>";
                    }
                    
                }
            }
        }

        $this->view('items/search', $data);
    }


    public function info() {
        $data = $this->data;

        if (!isset($_SESSION["cart"])) {
            $_SESSION["cart"] = [];
        }


        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            $_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);

            $data = [
                "itemID" => $_GET["id"],
                "item" => null,
                "quantity" => 0
            ];

            $data["item"] = $this->itemModel->getItem($data["itemID"]);
            $data["quantity"] = ($data["item"]->item_quantity > 5) ? "In stock" : "Only " . $data["item"]->item_quantity . " left in stock";

            if (!$data["item"]->item_quantity) {
                $data["quantity"] = "Out of stock";
            }
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            if (!isset($_SESSION["userid"])) {
                header("location: /grocerystore/customers/login");
              }

            $data = [
                "itemID" => $_GET["id"],
                "success" => "",
                "quantity" => 0
            ];

            

            $data["item"] = $this->itemModel->getItem($data["itemID"]);
            $data["quantity"] = ($data["item"]->item_quantity > 5) ? "In stock" : "Only " . $data["item"]->item_quantity . " left in stock";

            if (!isset($_SESSION["cart"][$_GET["id"]])) {
                $_SESSION["cart"][$_GET["id"]][0] = $data["item"];
                $_SESSION["cart"][$_GET["id"]][1] = 1;
            }

            else {
                $_SESSION["cart"][$_GET["id"]][1]++;
            }

            $_POST["error"] = "success";
            $data["success"] = "Item added to cart.";

        }

        $this->view('items/info', $data);
    }

}
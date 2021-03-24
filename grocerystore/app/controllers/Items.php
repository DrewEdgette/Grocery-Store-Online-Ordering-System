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
                    $data["results"] .= "<div class='clickable-section-box' onclick=location.href='/grocerystore/items/info?id=" . $result->item_id . "'>" . $result->item_name . " <img src='" . $result->image_url . "'> </div>";
                }
            }
        }

        $this->view('items/search', $data);
    }


    public function info() {
        $data = $this->data;

        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            $_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);

            $data = [
                "itemID" => $_GET["id"],
                "item" => null
            ];

            $data["item"] = $this->itemModel->getItem($data["itemID"]);
        }

        $this->view('items/info', $data);
    }
}
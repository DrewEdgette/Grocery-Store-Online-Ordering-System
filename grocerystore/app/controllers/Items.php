<?php

class Items extends Controller {

    private $data = "";

    public function __construct() {
        $this->userModel = $this->model('Item');
    }

    public function search() {
        $data = $this->data;

        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            $_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);

            $data = [
                "query" => $_GET["query"],
                "results" => ""
            ];

            $results = $this->userModel->getSearchResults($data);


            if (!$results) {
                $data["results"] = "<div class='my-account'><h1>No results found.</h1></div>";
            }

            else {
                foreach($results as $result) {
                    $data["results"] .= "<div class='clickable-section-box'>" . $result->item_name . " <img src='" . $result->image_url . "'> </div>";
                }
            }
        }

        $this->view('items/search', $data);
    }
}
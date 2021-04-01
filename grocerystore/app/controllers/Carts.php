<?php

class Carts extends Controller {


    private $data = [];

    public function __construct() {
        $this->userModel = $this->model('Cart');
    }

    public function myCart() {
        $data = $this->data;

        // sends data to the view
        $this->view('carts/mycart', $data);
    }

}
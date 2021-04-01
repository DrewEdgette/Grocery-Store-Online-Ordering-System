<?php

class About extends Controller {

    private $data = [];

    public function index() {
        $data = $this->data;

        // sends data to the view
        $this->view('about', $data);
    }

}
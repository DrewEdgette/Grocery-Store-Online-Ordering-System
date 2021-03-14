<?php
class Pages extends Controller {

    // loads the homepage view
    public function index() {
        $data = [
            'title' => 'Home page'
        ];

        $this->view('index', $data);
    }
}

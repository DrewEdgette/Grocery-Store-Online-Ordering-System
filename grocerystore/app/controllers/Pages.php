<?php
class Pages extends Controller {

    // loads the homepage view
    public function index() {
        $data = [
            'title' => 'Home page'
        ];

        $this->view('index', $data);
    }


    // loads the homepage view
    public function us() {
        $data = [
            'title' => 'Home page'
        ];

        $this->view('us', $data);
    }
}

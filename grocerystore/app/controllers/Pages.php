<?php
class Pages extends Controller {
    public function __construct() {
        $this->itemModel = $this->model('Item');
    }

    // loads the homepage view
    public function index() {
        $data = [
            'title' => 'Home page'
        ];

        $data["featured_items"] = $this->itemModel->getFeaturedItems();

        $this->view('index', $data);
    }

}

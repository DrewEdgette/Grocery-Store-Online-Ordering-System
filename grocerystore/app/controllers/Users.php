<?php

class Users extends Controller {


    private $data = [];

    public function __construct() {
        $this->userModel = $this->model('User');
    }

   
    public function account() {
        $data = $this->data;

        if (!isset($_SESSION["userid"])) {
            header("location: /grocerystore/customers/login");
          }

        if ($_SESSION["isEmployee"]) {
            $this->view('employees/account', $data);
        }

        else {
            $this->view('customers/account', $data);
        }
    
    }


    // logs the user out
    public function logout() {
        $data = [];
        session_unset();

        $this->view('users/logout', $data);
    }
}
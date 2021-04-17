<?php

class Employees extends Controller {


    private $data = [];

    public function __construct() {
        $this->userModel = $this->model('Employee');
        $this->itemModel = $this->model('Item');
    }

    // displays the employee account creation page
    public function register() {

        if (!$_SESSION["isEmployee"]) {
            header("location: /grocerystore/employees/login");
        }

        $data = $this->data;

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'full_name' => $_POST["full_name"],
                'email' => $_POST["email"],
                'pwd' => $_POST["pwd"],
                'pwdRepeat' => $_POST["pwdRepeat"],
                'emptyinput' => '',
                'invalidemail' => '',
                'pwdmatch' => '',
                'emailtaken' => '',
                'stmtfailed' => ''
            ];

            $userInfo = array($data["full_name"],$data["email"],$data["pwd"],$data["pwdRepeat"]);

            // check if there are any input errors
            if (!$this->emailIsValid($data["email"])) {
                $_POST["error"] = "invalidemail";
                $data["invalidemail"] = "Not a valid email address.";
            }

            if (!$this->passwordsMatch($data["pwd"],$data["pwdRepeat"])) {
                $_POST["error"] = "pwdmatch";
                $data["pwdmatch"] = "The passwords do not match.";
            }

            if ($this->inputIsEmpty($userInfo)) {
                $_POST["error"] = "emptyinput";
                $data["emptyinput"] = "Please fill out all fields.";
            }

            if ($this->userModel->userExists($data["email"])) {
                $_POST["error"] = "emailtaken";
                $data["emailtaken"] = "Email already in use.";
            }

            $data["pwd"] = password_hash($data["pwd"], PASSWORD_DEFAULT);

            // if there are no errors, try to register the user
            if (empty($data["emptyinput"]) && empty($data["pwdmatch"]) && empty($data["invalidemail"]) && empty($data["emailtaken"])) {
                if ($this->userModel->register($data)) {
                    header("location: /grocerystore/employees/login");
                }

                else {
                    die("Something went wrong.");
                }
    
            }

        }

        // sends data to the view
        $this->view('employees/register', $data);
    }




    // displays the employee login page
    public function login() {
        $data = $this->data;

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'email' => $_POST["email"],
                'pwd' => $_POST["pwd"],

                'emptyinput' => '',
                'wrongpwd' => '',
                'stmtfailed' => ''
            ];

            $userInfo = array($data["email"],$data["pwd"]);

            // check for input errors
            if ($this->inputIsEmpty($userInfo)) {
                $_POST["error"] = "emptyinput";
                $data["emptyinput"] = "Please fill out both fields.";
            }
            
            // if there are no input errors, try to log the user in
            if (empty($data["emptyinput"]) && empty($data["wrongpwd"])) {
                $user = $this->userModel->login($data["email"], $data["pwd"]);

                if ($user) {
                    session_start();
                    $this->updateSessionInfo($user);
                    header("location: /grocerystore");
                }

                else {
                    $_POST["error"] = "wrongpwd";
                    $data["wrongpwd"] = "Incorrect email or password.";
                }
            }
            

        }

        // sends data to the view
        $this->view('employees/login', $data);
    }




    public function orders() {
        $data = $this->data;

        if (!$_SESSION["isEmployee"]) {
            header("location: /grocerystore/employees/login");
        }

        $data = [
            "orders" => [],
        ];

        $data["orders"] = $this->userModel->getOrders();
      
        // sends data to the view
        $this->view('employees/orders/orders', $data);
    }


    public function viewOrder() {
        $data = $this->data;

        if (!$_SESSION["isEmployee"]) {
            header("location: /grocerystore/employees/login");
        }

        $order = $this->userModel->getOrder($_GET["id"]);

        $itemList = $this->itemModel->getItemList($_GET["id"]);

        $data = [
            "order" => [],
            "itemList" => []
        ];

        $data["order"] = $order;
        $data["itemList"] = $itemList;

      
        // sends data to the view
        $this->view('employees/orders/vieworder', $data);
    }


    public function inventory() {
        $data = $this->data;
    
        if (!$_SESSION["isEmployee"]) {
            header("location: /grocerystore/employees/login");
        }
    
        $data = [
            "results" => ""
        ];
    
        $results = $this->itemModel->getLowStockItems($data);
    
    
        if (!$results) {
            $data["results"] = "<div class='my-account'><h1>No results found.</h1></div>";
        }
    
        else {
            foreach($results as $result) {
    
                // if the item quantity is zero, just say it's out of stock
                $quantity = (!$result->item_quantity) ? "Out of stock" : "Quantity: " . $result->item_quantity;
                $data["results"] .= "<div class='clickable-section-box' onclick=location.href='/grocerystore/employees/changeitem?id=" . $result->item_id . "'>" . $result->item_name . " <img src='" . $result->image_url . "'> $quantity</div>";
            }
        }
      
        // sends data to the view
        $this->view('employees/inventory/inventory', $data);
    }


    public function changeitem() {
        $data = $this->data;

        if (!$_SESSION["isEmployee"]) {
            header("location: /grocerystore/employees/login");
        }

        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            $_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);

            $data = [
                "itemID" => $_GET["id"],
                "item" => null
            ];

            $data["item"] = $this->itemModel->getItem($data["itemID"]);
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $data = [
                "itemID" => $_GET["id"],
                "success" => "",

                "new_name" => $_POST["new_name"],
                "new_price" => $_POST["new_price"],
                "new_quantity" => $_POST["new_quantity"]
            ];

            $data["item"] = $this->itemModel->getItem($data["itemID"]);


             // check if input has been entered and update info for each field
             if (!empty($_POST["new_name"])) {
                $this->itemModel->updateItem($_GET["id"], "item_name", $data["new_name"]);
            }

            if (!empty($_POST["new_price"])) {
                $this->itemModel->updateItem($_GET["id"], "item_price", $data["new_price"]);
            }

            if (!empty($_POST["new_quantity"])) {
                $this->itemModel->updateItem($_GET["id"], "item_quantity", $data["new_quantity"]);
            }

            header("location: /grocerystore/employees/changeitem?id=" . $_GET["id"]);


        }

        $this->view('employees/inventory/changeitem', $data);
    }




    // displays the security page
    public function security() {
        if (!$_SESSION["isEmployee"]) {
            header("location: /grocerystore/employees/login");
        }

        $user = $this->userModel->getUser($_SESSION["userid"]);

        $data = [
            'name' => $user->full_name,
            'email' => $user->email,

            'emailtaken' => ''
        ];
        
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);


            $data = [
                'name' => $user->full_name,
                'email' => $user->email,


                'new_name' => $_POST["new_name"],
                'new_email' => $_POST["new_email"],

                'emailtaken' => ''
            ];
            
            // check if input has been entered and update info for each field
            if (!empty($_POST["new_name"])) {
                $this->userModel->updateInfo($user->employee_id, "full_name", $data["new_name"]);
            }

            if (!empty($_POST["new_email"])) {

                // if that email is in the database, dont let the user choose it
                if ($this->userModel->userExists($data["new_email"])) {
                    $_POST["error"] = "emailtaken";
                    $data["emailtaken"] = "The email is already registered.";
                }
                else {
                    $this->userModel->updateInfo($user->customer_id, "email", $data["new_email"]);
                }
            }

            // if there wasnt an error, reload the page to display changes
            if (empty($data["emailtaken"])) {
                header("location: /grocerystore/employees/security/security");
            }


        }

        $this->updateSessionInfo($user);

        // sends data to the view
        $this->view('employees/security/security', $data);
    }






    // displays the change password page
    public function changePassword() {
        if (!isLoggedIn()) {
            header("location: /grocerystore/employees/login");
          }

        $user = $this->userModel->getUser($_SESSION["userid"]);

        $data = [
            'pwdmatch' => '',
            'wrongpwd' => '',
            'success' => ''
        ];
        
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);


            $data = [
                'pwd' => $_POST["pwd"],
                'new_pwd' => $_POST["new_pwd"],
                'new_pwd_repeat' => $_POST["new_pwd_repeat"],

                'emptyinput' => '',
                'pwdmatch' => '',
                'wrongpwd' => '',
                'success' => ''
            ];

            // check for input errors
            if ($this->inputIsEmpty($data)) {
                $_POST["error"] = "emptyinput";
                $data["emptyinput"] = "Please fill out all fields.";
            }

            if (!$this->passwordsMatch($data["new_pwd"],$data["new_pwd_repeat"])) {
                $_POST["error"] = "pwdmatch";
                $data["pwdmatch"] = "The passwords do not match.";
            }
            
            else {
                $data["new_pwd"] = password_hash($data["new_pwd"], PASSWORD_DEFAULT);

                // check if current password is correct and update it if so
                if (!$this->userModel->updatePassword($user, $data["pwd"], $data["new_pwd"])) {
                    $_POST["error"] = "wrongpwd";
                    $data["wrongpwd"] = "The current password is incorrect.";
                }

                else {
                    $_POST["error"] = "success";
                    $data["success"] = "Password successfully updated.";
                }
            }
        }   
        
        // sends data to the view
        $this->view('employees/security/changepassword', $data);
    }




     // displays the change name page
     public function changeName() {
        if (!isset($_SESSION["userid"])) {
            header("location: /grocerystore/employees/login");
          }

        $user = $this->userModel->getUser($_SESSION["userid"]);

        $data = [
            'name' => $user->full_name,
            'new_name' => '',
            'emptyinput' => ''
        ];
        
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);


            $data = [
                'name' => $user->full_name,
                'new_name' => $_POST["new_name"],
                'emptyinput' => ''
            ];

            $fields = array($data["new_name"]);


            // check for input errors
            if ($this->inputIsEmpty($fields)) {
                $_POST["error"] = "emptyinput";
                $data["emptyinput"] = "Please fill out all fields.";
            }

            else {
                $this->userModel->updateInfo($user->employee_id, "full_name", $data["new_name"]);
                header("location: /grocerystore/employees/security");
            }
        }
        
        // sends data to the view
        $this->view('employees/security/changename', $data);
    }


    // displays the change email page
    public function changeEmail() {
        if (!isset($_SESSION["userid"])) {
            header("location: /grocerystore/employees/login");
          }

        $user = $this->userModel->getUser($_SESSION["userid"]);

        $data = [
            'email' => $user->email,
            'new_email' => '',
            'emptyinput' => '',
            'emailtaken' => ''
        ];
        
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);


            $data = [
                'email' => $user->email,
                'new_email' => $_POST["new_email"],
                'emptyinput' => '',
                'emailtaken' => ''
            ];

            $fields = array($data["new_email"]);

            if (empty($_POST["new_email"])) {
                $_POST["error"] = "emptyinput";
                $data["emptyinput"] = "Please fill out all fields.";
            }

            else {

                // if that email is in the database, dont let the user choose it
                if ($this->userModel->userExists($data["new_email"])) {
                    $_POST["error"] = "emailtaken";
                    $data["emailtaken"] = "The email is already registered.";
                }
           
                else {
                    $this->userModel->updateInfo($user->employee_id, "email", $data["new_email"]);
                    header("location: /grocerystore/employees/security");
                }
            }

        }
        
        // sends data to the view
        $this->view('employees/security/changeemail', $data);
    }


    // displays the add item page
public function additem() {

        if (!$_SESSION["isEmployee"]) {
            header("location: /grocerystore");
        }

        $data = $this->data;

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'item_name' => $_POST["item_name"],

            'item_price' => $_POST["item_price"],

            'item_weight' => $_POST["item_weight"],

            'image_url' => $_POST["image_url"]

            ];

            $userInfo = array($data["item_name"],$data["item_price"],$data["item_weight"],$data["image_url"]);

            if ($this->inputIsEmpty($userInfo)) {
                $_POST["error"] = "emptyinput";
                $data["emptyinput"] = "Please fill out all fields.";
            }

            if (empty($data["emptyinput"])) {
                if ($this->userModel->additem($data)) {
                    header("location: /grocerystore/employees/additem");
                }

                else {
                    die("Something went wrong.");
                }
    
            }

        }

        // sends data to the view
        $this->view('employees/additem', $data);
    }






    // determines whether any input field is empty
    public function inputIsEmpty($userInfo) {
        foreach($userInfo as $item) {
            if (empty($item)) {
                return true;
            }
        }
        return false;
    }


    // determines whether email is valid or not
    public function emailIsValid($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL) ? true : false;
    }



    // determines if password fields match
    public function passwordsMatch($pwd,$pwdRepeat) {
        return ($pwd === $pwdRepeat);
    } 

    // logs the user out
    public function logout() {
        $data = [];
        unset($_SESSION["userid"]);
        unset($_SESSION["username"]);
        unset($_SESSION["email"]);
        unset($_SESSION["isEmployee"]);

        $this->view('users/logout', $data);
    }


    // updates the current session variables
    public function updateSessionInfo($user) {
        $_SESSION["userid"] = $user->employee_id;
        $_SESSION["username"] = $user->full_name;
        $_SESSION["email"] = $user->email;
        $_SESSION["pwd"] = $user->employee_password;
        $_SESSION["isEmployee"] = true;
    }


}
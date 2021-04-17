<?php

class Customers extends Controller {


    private $data = [];

    public function __construct() {
        $this->userModel = $this->model('Customer');
        $this->itemModel = $this->model('Item');
    }



    // displays the account creation page
    public function register() {

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
                    header("location: /grocerystore/customers/login");
                }

                else {
                    die("Something went wrong.");
                }
    
            }

        }

        // sends data to the view
        $this->view('customers/register', $data);
    }


    // displays the login page
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
        $this->view('customers/login', $data);
    }



    public function account() {
        $data = $this->data;

        if (!isset($_SESSION["userid"])) {
            header("location: /grocerystore/customers/login");
          }

        $this->view('customers/account', $data);
    }

 
    public function orders() {
        $data = $this->data;

        if (!isset($_SESSION["userid"])) {
            header("location: /grocerystore/customers/login");
        }

        $user = $this->userModel->getUser($_SESSION["userid"]);

        $data = [
            "orders" => [],
        ];

        $data["orders"] = $this->userModel->getOrders($_SESSION["userid"]);

      
        // sends data to the view
        $this->view('customers/orders/orders', $data);
    }


    public function vieworder() {
        $data = $this->data;

        if (!isset($_SESSION["userid"])) {
            header("location: /grocerystore/customers/login");
        }

        $user = $this->userModel->getUser($_SESSION["userid"]);
        $order = $this->userModel->getOrder($user->customer_id, $_GET["id"]);

        $itemList = $this->itemModel->getItemList($_GET["id"]);

        $data = [
            "order" => [],
            "itemList" => []
        ];

        $data["order"] = $order;
        $data["itemList"] = $itemList;

      
        // sends data to the view
        $this->view('customers/orders/vieworder', $data);
    }




    // displays the addresses page
    public function addresses() {
        if (!isset($_SESSION["userid"])) {
            header("location: /grocerystore/customers/login");
          }

        $user = $this->userModel->getUser($_SESSION["userid"]);

        $data = [
            "addresses" => [],
            "noaddress" => ""
        ];

        $addressList = $this->userModel->getAddresses($user->customer_id);

        if (empty($addressList[0]->address_id)) {
            $_POST["error"] = "noaddress";
            $data["noaddress"] = "You don't have any addresses yet.";
        }
        

        foreach ($addressList as $address) {
            array_push($data["addresses"], array(
                $address->address_id,
                $address->street_address, 
                $address->city,
                $address->state,
                $address->zip,
                $address->phone
            ));
        }   

        // sends data to the view
        $this->view('customers/addresses/addresses', $data);
    }



     // displays the change address page
     public function changeAddress() {
        if (!isset($_SESSION["userid"])) {
            header("location: /grocerystore/customers/login");
        }

        $user = $this->userModel->getUser($_SESSION["userid"]);
        $address = $this->userModel->getAddress($_SESSION["userid"], $_GET["id"]);


        $data = [
            'userid' => $user->customer_id,
            'current_address' => $address->street_address,
            'current_city' => $address->city,
            'current_state' => $address->state,
            'current_zip' => $address->zip,
            'current_phone' => $address->phone,
        ];

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $data = [
                'userid' => $user->customer_id,
                'current_address' => $address->street_address,
                'current_city' => $address->city,
                'current_state' => $address->state,
                'current_zip' => $address->zip,
                'current_phone' => $address->phone,

                'new_address' => $_POST["new_address"],
                'new_city' => $_POST["new_city"],
                'new_state' => $_POST["new_state"],
                'new_zip' => $_POST["new_zip"],
                'new_phone' => $_POST["new_phone"]
            ];

            
            // check if input has been entered and update info for each field
            if (!empty($_POST["new_address"])) {
                $this->userModel->updateAddress($_GET["id"], "street_address", $data["new_address"]);
            }

            if (!empty($_POST["new_city"])) {
                $this->userModel->updateAddress($_GET["id"], "city", $data["new_city"]);
            }

            if (!empty($_POST["new_state"])) {
                $this->userModel->updateAddress($_GET["id"], "state", $data["new_state"]);
            }

            if (!empty($_POST["new_zip"])) {
                $this->userModel->updateAddress($_GET["id"], "zip", $data["new_zip"]);
            }

            if (!empty($_POST["new_phone"])) {
                $this->userModel->updateAddress($_GET["id"], "phone", $data["new_phone"]);
            }

            header("location: /grocerystore/customers/addresses");
        }
  
        // sends data to the view
        $this->view('customers/addresses/changeaddress', $data);
    }


    // displays the delete address page
    public function deleteAddress() {
        if (!isset($_SESSION["userid"])) {
            header("location: /grocerystore/customers/login");
        }

        $user = $this->userModel->getUser($_SESSION["userid"]);
        $address = $this->userModel->getAddress($_SESSION["userid"], $_GET["id"]);


        $data = [
            'userid' => $user->customer_id,
            'current_address' => $address->street_address,
            'current_city' => $address->city,
            'current_state' => $address->state,
            'current_zip' => $address->zip,
            'current_phone' => $address->phone,
        ];

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $data = [
                'userid' => $user->customer_id,
                'address_id' => $address->address_id,
            ];


            $this->userModel->deleteAddress($data["address_id"]);

            header("location: /grocerystore/customers/addresses");
        }
  
        // sends data to the view
        $this->view('customers/addresses/deleteaddress', $data);
    }



    // displays the delete address page
    public function addAddress() {
        if (!isset($_SESSION["userid"])) {
            header("location: /grocerystore/customers/login");
        }

        $user = $this->userModel->getUser($_SESSION["userid"]);

        $data = [
            'userid' => $user->customer_id,
        ];

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $data = [
                'userid' => $user->customer_id,

                'new_address' => $_POST["new_address"],
                'new_city' => $_POST["new_city"],
                'new_state' => $_POST["new_state"],
                'new_zip' => $_POST["new_zip"],
                'new_phone' => $_POST["new_phone"]
            ];


            $this->userModel->addAddress($data);

            header("location: /grocerystore/customers/addresses");
        }
  
        // sends data to the view
        $this->view('customers/addresses/addaddress', $data);
    }



    // displays the security page
    public function security() {
        if (!isset($_SESSION["userid"])) {
            header("location: /grocerystore/customers/login");
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
                $this->userModel->updateInfo($user->customer_id, "full_name", $data["new_name"]);
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
                header("location: /grocerystore/customers/security");
            }


        }


        $this->updateUserSessionInfo($user);

        // sends data to the view
        $this->view('customers/security/security', $data);
    }


    // displays the change password page
    public function changePassword() {
        if (!isLoggedIn()) {
            header("location: /grocerystore/customers/login");
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
        $this->view('customers/security/changepassword', $data);
    }


    // displays the change payment page
    public function changePayment() {
        if (!isset($_SESSION["userid"])) {
            header("location: /grocerystore/customers/login");
          }

        $user = $this->userModel->getUser($_SESSION["userid"]);

        $data = [
            'payment' => '',
            'emptyinput' => ''
        ];
        
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);


            $data = [
                'payment' => $_POST["payment"],
                'emptyinput' => ''
            ];

            $fields = array($data["payment"]);


            // check for input errors
            if ($this->inputIsEmpty($fields)) {
                $_POST["error"] = "emptyinput";
                $data["emptyinput"] = "Please fill out all fields.";
            }

            else {
                if ($this->userModel->updateInfo($user->customer_id, "payment", $data["payment"])) {
                    $_POST["error"] = "success";
                    $data["success"] = "Payment successfully updated.";
                }
            }
        }
        
        // sends data to the view
        $this->view('customers/security/changepayment', $data);
    }



     // displays the change name page
     public function changeName() {
        if (!isset($_SESSION["userid"])) {
            header("location: /grocerystore/customers/login");
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
                $this->userModel->updateInfo($user->customer_id, "full_name", $data["new_name"]);
                header("location: /grocerystore/customers/security");
            }
        }
        
        // sends data to the view
        $this->view('customers/security/changename', $data);
    }


    // displays the change email page
    public function changeEmail() {
        if (!isset($_SESSION["userid"])) {
            header("location: /grocerystore/customers/login");
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
                    $this->userModel->updateInfo($user->customer_id, "email", $data["new_email"]);
                    header("location: /grocerystore/customers/security");
                }
            }

        }
        
        // sends data to the view
        $this->view('customers/security/changeemail', $data);
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

        $this->view('customers/logout', $data);
    }


    // updates the current session variables
    public function updateSessionInfo($user) {
        $_SESSION["userid"] = $user->customer_id;
        $_SESSION["username"] = $user->full_name;
        $_SESSION["email"] = $user->email;
        $_SESSION["pwd"] = $user->customer_password;

        $_SESSION["address"] = $user->address;
        $_SESSION["city"] = $user->city;
        $_SESSION["state"] = $user->state;
        $_SESSION["zip"] = $user->zip;

        $_SESSION["phone"] = $user->phone;
        $_SESSION["payment"] = $user->payment;

        $_SESSION["cart"] = [];
        $_SESSION["isEmployee"] = false;
    }


    // updates the current session variables
    public function updateUserSessionInfo($user) {
        $_SESSION["userid"] = $user->customer_id;
        $_SESSION["username"] = $user->full_name;
        $_SESSION["email"] = $user->email;
        $_SESSION["pwd"] = $user->customer_password;

        $_SESSION["address"] = $user->address;
        $_SESSION["city"] = $user->city;
        $_SESSION["state"] = $user->state;
        $_SESSION["zip"] = $user->zip;

        $_SESSION["phone"] = $user->phone;
        $_SESSION["payment"] = $user->payment;
        $_SESSION["isEmployee"] = false;
    }
}
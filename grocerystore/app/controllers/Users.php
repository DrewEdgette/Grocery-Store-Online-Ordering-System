<?php

class users extends Controller {


    private $data = [];

    public function __construct() {
        $this->userModel = $this->model('User');
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
                    header("location: /grocerystore/users/login");
                }

                else {
                    die("Something went wrong.");
                }
    
            }



        }

        // sends data to the view
        $this->view('users/register', $data);
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
        $this->view('users/login', $data);
    }


    public function account() {
        $data = $this->data;

        if (!isset($_SESSION["userid"])) {
            header("location: /grocerystore/users/login");
          }
    

        $this->view('users/account', $data);
    }



 
    public function orders() {
        $data = $this->data;

        if (!isset($_SESSION["userid"])) {
            header("location: /grocerystore/users/login");
          }
      
        // sends data to the view
        $this->view('users/orders', $data);
    }




    // displays the addresses page
    public function addresses() {
        if (!isset($_SESSION["userid"])) {
            header("location: /grocerystore/users/login");
          }

        $data = $this->data;
        $user = $this->userModel->getUser($_SESSION["userid"]);


          $data = [
            'current_address' => $user->address,
            'current_city' => $user->city,
            'current_state' => $user->state,
            'current_zip' => $user->zip,
            'current_phone' => $user->phone,
        ];
        
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);


            $data = [
                'userid' => $user->customer_id,
                'current_address' => $user->address,
                'current_city' => $user->city,
                'current_state' => $user->state,
                'current_zip' => $user->zip,
                'current_phone' => $user->phone,

                'new_address' => $_POST["new_address"],
                'new_city' => $_POST["new_city"],
                'new_state' => $_POST["new_state"],
                'new_zip' => $_POST["new_zip"],
                'new_phone' => $_POST["new_phone"]
            ];
            
            // check if input has been entered and update info for each field
            if (!empty($_POST["new_address"])) {
                $this->userModel->updateInfo($data["userid"], $data["new_address"], "address");
            }

            if (!empty($_POST["new_city"])) {
                $this->userModel->updateInfo($data["userid"], $data["new_city"], "city");
            }

            if (!empty($_POST["new_state"])) {
                $this->userModel->updateInfo($data["userid"], $data["new_state"], "state");
            }

            if (!empty($_POST["new_zip"])) {
                $this->userModel->updateInfo($data["userid"], $data["new_zip"], "zip");
            }

            if (!empty($_POST["new_phone"])) {
                $this->userModel->updateInfo($data["userid"], $data["new_phone"], "phone");
            }

            
            header("location: /grocerystore/users/addresses");
        }
  
        // sends data to the view
        $this->view('users/addresses', $data);
    }



    // displays the security page
    public function security() {
        if (!isset($_SESSION["userid"])) {
            header("location: /grocerystore/users/login");
          }


        $data = $this->data;
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
                $this->userModel->updateInfo($user->customer_id, $data["new_name"], "full_name");
            }

            if (!empty($_POST["new_email"])) {

                // if that email is in the database, dont let the user choose it
                if ($this->userModel->userExists($data["new_email"])) {
                    $_POST["error"] = "emailtaken";
                    $data["emailtaken"] = "The email is already registered.";
                }
                else {
                    $this->userModel->updateInfo($user->customer_id, $data["new_email"], "email");
                }
            }

            // if there wasnt an error, reload the page to display changes
            if (empty($data["emailtaken"])) {
                header("location: /grocerystore/users/security");
            }


        }

        $this->updateSessionInfo($user);

        // sends data to the view
        $this->view('users/security', $data);
    }


    // displays the change password page
    public function changePassword() {
        if (!isLoggedIn()) {
            header("location: /grocerystore/users/login");
          }


        $data = $this->data;
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
        $this->view('users/changepassword', $data);
    }


    // displays the change payment page
    public function changePayment() {
        if (!isset($_SESSION["userid"])) {
            header("location: /grocerystore/users/login");
          }


        $data = $this->data;
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
                if ($this->userModel->updateInfo($user->customer_id, $data["payment"], "payment")) {
                    $_POST["error"] = "success";
                    $data["success"] = "Payment successfully updated.";
                }
            }
        }
        
        // sends data to the view
        $this->view('users/changepayment', $data);
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

        $this->view('users/logout', $data);
    }


    // updates the current session variables
    public  function updateSessionInfo($user) {
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
    }
}
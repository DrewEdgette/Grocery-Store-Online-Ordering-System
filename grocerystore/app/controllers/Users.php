<?php

class users extends Controller {


    private $data = [];

    public function __construct() {
        $this->userModel = $this->model('User');
    }


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

            if (empty($data["emptyinput"]) && empty($data["pwdmatch"]) && empty($data["invalidemail"]) && empty($data["emailtaken"])) {
                if ($this->userModel->register($data)) {
                    header("location: /grocerystore/users/login");
                }

                else {
                    die("Something went wrong.");
                }
    
            }



        }

        $this->view('users/register', $data);
    }



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

            if ($this->inputIsEmpty($userInfo)) {
                $_POST["error"] = "emptyinput";
                $data["emptyinput"] = "Please fill out both fields.";
            }
            
            if (empty($data["emptyinput"]) && empty($data["wrongpwd"])) {
                $user = $this->userModel->login($data["email"], $data["pwd"]);

                if ($user) {
                    session_start();
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

                    header("location: /grocerystore");
                }

                else {
                    $_POST["error"] = "wrongpwd";
                    $data["wrongpwd"] = "Incorrect email or password.";
                }
            }
            

        }

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
      

        $this->view('users/orders', $data);
    }





    public function addresses() {
        $data = $this->data;
        $user = $this->userModel->getUser($_SESSION["userid"]);

        if (!isset($_SESSION["userid"])) {
            header("location: /grocerystore/users/login");
          }


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
            
            if (!empty($_POST["new_address"])) {
                $this->userModel->updateAddress($data["userid"], $data["new_address"], "address");
            }

            if (!empty($_POST["new_city"])) {
                $this->userModel->updateAddress($data["userid"], $data["new_city"], "city");
            }

            if (!empty($_POST["new_state"])) {
                $this->userModel->updateAddress($data["userid"], $data["new_state"], "state");
            }

            if (!empty($_POST["new_zip"])) {
                $this->userModel->updateAddress($data["userid"], $data["new_zip"], "zip");
            }

            if (!empty($_POST["new_phone"])) {
                $this->userModel->updateAddress($data["userid"], $data["new_phone"], "phone");
            }

            header("location: /grocerystore/users/addresses");
        }
  

        $this->view('users/addresses', $data);
    }




    public function security() {
        if (!isset($_SESSION["userid"])) {
            header("location: /grocerystore/users/login");
          }


        $data = [
            'name' => $_SESSION["username"],
            'email' => $_SESSION["email"],
        ];

        $this->view('users/security', $data);
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



    public function changeInfo() {
        $data = $this->data;

        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                "type" => $_GET["type"]
            ];
        }

        $this->view('users/changeinfo', $data);
    }
}
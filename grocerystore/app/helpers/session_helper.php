<?php

session_start();

function isLoggedIn() {
    return isset($_SESSION["userid"]);
}


// updates the current session variables
function updateSessionInfo($user) {
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
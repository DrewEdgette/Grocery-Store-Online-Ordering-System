<?php

// determines whether any input field is empty
function inputIsEmpty($userInfo) {

    foreach($userInfo as $item) {
        if (empty($item)) {
            return true;
        }
    }
    return false;
}


// determines whether email is valid or not
function emailIsValid($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) ? true : false;
}



// determines if password fields match
function passwordsMatch($pwd,$pwdRepeat) {
    return ($pwd === $pwdRepeat);
}



// determines whether user is in the db or not based on provided email
function getUser($connect,$email) {
    $sql = "SELECT * FROM customers WHERE email = ?;";
    $stmt = mysqli_stmt_init($connect);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: /grocerystore/signup.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    }

    else {
        return false
    }

    mysqli_stmt_close($stmt);
}



// sends user info into database and creates a user
function createUser($connect,$full_name,$email,$pwd) {
    
    $sql = "INSERT INTO customers (full_name,email,customer_password) VALUES (?,?,?)";
    $stmt = mysqli_stmt_init($connect);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: /grocerystore/signup.php?error=stmtfailed");
        exit();
    }

    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);

    mysqli_stmt_bind_param($stmt, "sss", $full_name, $email, $hashedPwd);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}



function loginUser($connect,$email,$pwd) {

    $user = getUser($connect, $email);

	if (!$user) {
        header("location: /grocerystore/signin.php?error=wrongemail");
        exit();
    }

    $pwdHashed = $user["customer_password"];

    $pwdVerify = password_verify($pwd,$pwdHashed);

    if (!$pwdVerify) {
        header("location: /grocerystore/signin.php?error=wrongpwd");
        exit();
    }

    session_start();
    $_SESSION["userid"] = $user["customer_id"];
    $_SESSION["username"] = $user["full_name"];
    $_SESSION["email"] = $user["email"];

    header("location: /grocerystore");
    exit();
}

<?php

// if the user gets to this page without clicking submit, send them back to the homepage
if (!isset($_POST["submit"])) {

	header("location: /grocerystore");
	exit();
}

$email=$_POST["email"];
$pwd=$_POST["pwd"];

require_once "dbh.inc.php";
require_once "functions.inc.php";

$userInfo = array($email,$pwd);

if (inputIsEmpty($userInfo)) {
	header("location: /grocerystore/signin.php?error=emptyinput");
	exit();
}

loginUser($connect,$email,$pwd);
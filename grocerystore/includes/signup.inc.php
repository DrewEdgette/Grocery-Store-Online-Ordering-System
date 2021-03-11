<?php 

// if the user gets to this page without clicking submit, send them back to the homepage
if (!isset($_POST["submit"])) {
	
	header("location: /grocerystore");
	exit();
}

$full_name=$_POST["full_name"];
$email=$_POST["email"];
$pwd=$_POST["pwd"];
$pwdRepeat=$_POST["pwdRepeat"];

require_once "dbh.inc.php";
require_once "functions.inc.php";

$userInfo = array($full_name,$email,$pwd,$pwdRepeat);


if (inputIsEmpty($userInfo)) {
	header("location: /grocerystore/signup.php?error=emptyinput");
	exit();
}

if (!emailIsValid($email)) {
	header("location: /grocerystore/signup.php?error=invalidemail");
	exit();
}

if (!passwordsMatch($pwd,$pwdRepeat)) {
	header("location: /grocerystore/signup.php?error=pwdmatch");
	exit();
}

if (getUser($connect,$email)) {
	header("location: /grocerystore/signup.php?error=emailtaken");
	exit();
}

createUser($connect,$full_name,$email,$pwd);
loginUser($connect,$email,$pwd);

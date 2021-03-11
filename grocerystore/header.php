<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="css/style.css">
    <title>5 Brothers Grocery</title>
</head>

<div class="header">

        <a class="active" href="/grocerystore">Home</a>

        <?php 
            if (isset($_SESSION["userid"])) {
                $fullName = $_SESSION["username"];
                $nameArray = explode(' ',trim($fullName));
                $firstName =  $nameArray[0];

                echo "<a class='active' href='account.php'>Welcome, " . $firstName . "</a>";
                echo "<a class='active' href='includes/logout.inc.php'>Logout</a>";
            }

            else {
                echo "<a href='signin.php'>Sign in</a>";
            }
        ?>

        <input type="text" placeholder="Search..." id="search" onkeypress="">
</div>


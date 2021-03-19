
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="favicon" href="/grocerystore/images/grocery-favicon.png" type="image/ico"/>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="/grocerystore/public/css/style.css">
    <title>5 Brothers Grocery</title>
</head>

<div class="header">

        <a class="active" href="/grocerystore">Home</a>

        <?php 
            if (isset($_SESSION["userid"])) {
                $fullName = $_SESSION["username"];
                $nameArray = explode(' ',trim($fullName));
                $firstName =  $nameArray[0];

                echo "<a class='active' href='/grocerystore/users/account'>Welcome, " . $firstName . "</a>";
                echo "<a class='active' href='/grocerystore/users/logout'>Logout</a>";
            }

            else {
                echo "<a href='/grocerystore/users/login'>Sign in</a>";
            }
        ?>

        <form action="/grocerystore/items/search" method="GET">
        <input type="text" name="query" type="submit" placeholder="Search here and press ENTER..."/>
        </form>
</div>


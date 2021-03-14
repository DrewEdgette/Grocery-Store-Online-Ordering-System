<?php
    require APPROOT . "/views/includes/header.php";
?>

<body>

<div class="signin-signup"> 
    <h1>My Account</h1>
    <?php
        echo $_SESSION["username"] . "<br>";
        echo $_SESSION["email"] . "<br>";
    ?>
</div>

</html>
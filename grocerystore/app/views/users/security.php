<?php
    require APPROOT . "/views/includes/header.php";
?>


<body>

<div class="main-area">

<div class="my-account"><h1>Login & security</h1></div>

<div class="section-box">

<?php

echo "<h2>Name</h2>";
echo $_SESSION["username"];


echo "<h2>Email</h2>";
echo $_SESSION["email"];

?>

</div>
    
</div>


<?php
    require APPROOT . "/views/includes/footer.php";
?>

</body>

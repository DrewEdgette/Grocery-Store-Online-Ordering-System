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
echo "<input type='text' name='name' placeholder='Change Name'>";


echo "<h2>Email</h2>";
echo $_SESSION["email"];
echo "<input type='text' name='email' placeholder='Change Email'>";

echo "<h2>Password</h2>";
echo "......";
echo "<input type='password' name='pwd' placeholder='Change Password'>";

?>

<input type="submit" name="submit" value="Update information">

</div>
    
</div>


<?php
    require APPROOT . "/views/includes/footer.php";
?>

</body>

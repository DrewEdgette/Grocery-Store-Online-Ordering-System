<?php
    require APPROOT . "/views/includes/header.php";
?>
<html>

<body>

<div class="main-area">

<div class="my-account"><h1>Delete Address</h1></div>

<div class="section-box">

  <p><strong>Address: </strong><br> <?php echo $data["current_address"] ?></p>

<br>

<p><strong>City: </strong><br> <?php echo $data["current_city"] ?></p> 

<br>

<p><strong>State: </strong><br> <?php echo $data["current_state"] ?></p>


<br>

<p><strong>Zip: </strong><br> <?php echo $data["current_zip"] ?></p>


<br>

<p<strong>Phone: </strong><br> <?php echo $data["current_phone"] ?></p>

<?php echo "<form method='post' action='/grocerystore/users/deleteaddress?id=" . $_GET["id"] . "'>";?>
    <input type='submit' value='Delete address?'>
</form>


</div>

</div>

<?php
    require APPROOT . "/views/includes/footer.php";
?>

</body>

</html>

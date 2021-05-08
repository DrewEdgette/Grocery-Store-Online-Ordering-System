<?php
    require APPROOT . "/views/includes/header.php";
?>
<html>

<div class="main-area">

<body>

<div class="my-account"><h1>Change Address</h1>

<div class="section-box">

<?php echo "<form method='post' action='/grocerystore/customers/changeaddress?id=" . $_GET["id"] . "'>";?>

Address name: <br> <?php echo $data["current_name"] ?>
<input type='text' name="new_name" placeholder="Change address name">

<br>

  Address: <br> <?php echo $data["current_address"] ?>
  <input type='text' name="new_address" placeholder="Change address">

<br>

  City: <br> <?php echo $data["current_city"] ?> 
  <input type='text' name="new_city" placeholder='Change city'>

<br>

  State: <br> <?php echo $data["current_state"] ?>
  <input type='text' name="new_state" placeholder='Change state'>

<br>

  Zip: <br> <?php echo $data["current_zip"] ?>
  <input type='text' name="new_zip" placeholder='Change zip'>

<br>

  Phone: <br> <?php echo $data["current_phone"] ?>
  <input type='text' name="new_phone" placeholder='Change phone'>

  <input type='submit' value='Update address information'>


</form>

</div>


<div class="goto-signup">
        <?php echo "<a href='/grocerystore/customers/deleteaddress?id=" . $_GET["id"] . "'><button>Delete address</button></a>"; ?>
</div>

</div>

</body>

<?php
    require APPROOT . "/views/includes/footer.php";
?>

</div>

</html>

<?php
    require APPROOT . "/views/includes/header.php";
?>
<html>

<body>

<div class="main-area">

<div class="my-account"><h1>Your Addresses</h1></div>

<div class="section-box">

<div class="my-account"><h1>Address</h1></div>

<form method="post" action="/grocerystore/users/addresses">

  Address: <br> <?php echo $data["current_address"] ?>

  <input type='text' name="new_address" placeholder="change address">

<br>

  City: <br> <?php echo $data["current_city"] ?> 
  <input type='text' name="new_city" placeholder='change city'>

<br>

  State: <br> <?php echo $data["current_state"] ?>
  <input type='text' name="new_state" placeholder='change state'>

<br>

Zip: <br> <?php echo $data["current_zip"] ?>
<input type='text' name="new_zip" placeholder='change zip'>

<br>

  Phone: <br> <?php echo $data["current_phone"] ?>
  <input type='text' name="new_phone" placeholder='change phone'>

  <input type='submit' value='Update Address Info'>



</form>

</div>

</div>

<?php
    require APPROOT . "/views/includes/footer.php";
?>

</body>

</html>

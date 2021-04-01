<?php
    require APPROOT . "/views/includes/header.php";
?>
<html>

<body>

<div class="main-area">

<div class="my-account"><h1>Add Address</h1></div>

<div class="section-box">

<form method="post" action="?">

  Address: <br>
  <input type='text' name="new_address" placeholder="Street Address">

<br>

  City: <br>
  <input type='text' name="new_city" placeholder='City'>

<br>

  State: <br> 
  <input type='text' name="new_state" placeholder='State'>

<br>

  Zip: <br> 
  <input type='text' name="new_zip" placeholder='Zip'>

<br>

  Phone: <br> 
  <input type='text' name="new_phone" placeholder='Phone'>

  <input type='submit' value='Add address'>


</form>

</div>


</div>

<?php
    require APPROOT . "/views/includes/footer.php";
?>

</body>

</html>

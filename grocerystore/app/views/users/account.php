<?php
    require APPROOT . "/views/includes/header.php";
?>


<body>

<div class="my-account"><h1>Your Account</h1></div>

  <div class="clickable-section-box" onclick="location.href='/grocerystore/users/orders'">
    <h2>Your orders</h2>
    <p>Track orders or buy things again</p>
  </div>

  <div class="clickable-section-box" onclick="location.href='/grocerystore/users/security'">
    <h2>Your login info</h2>
    <p>view and update email and password</p>
  </div>

  <div class="clickable-section-box" onclick="location.href='/grocerystore/users/addresses'">
    <h2>Your Addresses</h2>
    <p>Add or update shipping addresses</p>
  </div>

  <?php
    require APPROOT . "/views/includes/footer.php";
  ?>

</body>

</div>
</html>


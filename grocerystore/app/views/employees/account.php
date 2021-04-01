<?php
    require APPROOT . "/views/includes/header.php";
?>


<body>

<div class="my-account"><h1>Your Account</h1></div>

<div class="main-area">

  <div class="clickable-section-box" onclick="location.href='../employees/orders'">
    <h2>Fulfill an order</h2>
    <p>Track orders or buy things again</p>
  </div>

  <div class="clickable-section-box" onclick="location.href='../employees/inventory'">
    <h2>Update low-stock items</h2>
    <p>View and update email and password</p>
  </div>

  <div class="clickable-section-box" onclick="location.href='../employees/additem'">
    <h2>Add item</h2>
    <p>Add item to catalog</p>
  </div>

  <div class="clickable-section-box" onclick="location.href='../employees/security'">
    <h2>Your login info</h2>
    <p>View and update email and password</p>
  </div>

</div>

  <?php
    require APPROOT . "/views/includes/footer.php";
  ?>

</body>

</div>
</html>


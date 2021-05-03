<?php
    require APPROOT . "/views/includes/header.php";
?>

<div class="main-area">

<body>

<div class="my-account"><h1>Your Account</h1>


  <div class="clickable-section-box" onclick="location.href='../employees/orders'">
    <h2>Fulfill an order</h2>
    <p>View and fulfill customer orders</p>
  </div>

  <div class="clickable-section-box" onclick="location.href='../employees/orderstats'">
    <h2>Order statistics</h2>
    <p>View stats on how much is getting ordered</p>
  </div>

  <div class="clickable-section-box" onclick="location.href='../employees/inventory'">
    <h2>Update inventory</h2>
    <p>View and update low-stock items</p>
  </div>

  <div class="clickable-section-box" onclick="location.href='../employees/additem'">
    <h2>Add item</h2>
    <p>Add an item to the catalog</p>
  </div>

  <div class="clickable-section-box" onclick="location.href='../employees/security'">
    <h2>Your login info</h2>
    <p>Update name and password</p>
  </div>

  <div class="clickable-section-box" onclick="location.href='../employees/register'">
    <h2>Register employee</h2>
    <p>Create new employee account</p>
  </div>

</div>

</body>

  <?php
    require APPROOT . "/views/includes/footer.php";
  ?>

</div>


</div>
</html>


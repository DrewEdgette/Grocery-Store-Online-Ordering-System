<?php
    require APPROOT . "/views/includes/header.php";
?>

<div class="main-area">

<body>

<div class="my-account"><h1>Order details</h1>



<div class='section-box'>
<form method="post" action="">

<?php
  echo "<h3><strong>Order number: " . $data["order"]->order_id . "</strong></h3>";
  echo "<h3><strong>Placed on " . $data["order"]->order_date . "</strong></h3>";
  echo "<h3><strong>Status: " . $data["order"]->order_status . "</strong></h3>";
  echo "<h3><strong>Customer ID: " . $data["order"]->customer_id . "</strong></h3>";
?>

<input type='text' name="new_status" placeholder="New status">
<input type='submit' value='Update order status'>
</form>
</div>

<?php
  foreach ($data["itemList"] as $item) {
    echo "<div class='section-box'>";
    echo $item->item_name . "<br>";
    echo "</div>";
  } 
?>

</div>

</body>

<?php
    require APPROOT . "/views/includes/footer.php";
?>

</div>


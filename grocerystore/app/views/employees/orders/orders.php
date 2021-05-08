<?php
    require APPROOT . "/views/includes/header.php";
?>
<?php
error_reporting(0);
?>
<div class="main-area">

<body>

<div class="my-account"><h1>Customer Orders</h1>


<?php
  foreach ($data["orders"] as $order) {
  echo "<div class='section-box'>";
  echo "<h3><strong>Order number: " . $order->order_id . "</strong></h3>";
  echo "<h3><strong>Placed on " . $order->order_date . "</strong></h3>";
  echo "<h3><strong>Status: " . $order->order_status . "</strong></h3>";
  echo "<h3><strong>Customer ID: " . $order->customer_id . "</strong></h3>";
  echo "<a href='/grocerystore/employees/vieworder?id=" . $order->order_id . "'><button>View order</button></a>";
  echo "</div>";
  } 
?>

</div>
</body>

<?php
    require APPROOT . "/views/includes/footer.php";
?>

</div>
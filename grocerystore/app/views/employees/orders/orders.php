<?php
    require APPROOT . "/views/includes/header.php";
?>


<body>

<div class="my-account"><h1>Customer Orders</h1></div>

<div class="main-area">

<?php
   foreach ($data["orders"] as $order) {
    echo "<div class='clickable-section-box'>";
    echo "<h3><strong>Order placed on " . $order->order_date . "</strong></h3>";
    echo "<h3><strong>Status: " . $order->order_status . "</strong></h3>";
    echo "</div>";
  } 
?>

</div>


<?php
    require APPROOT . "/views/includes/footer.php";
?>

</body>

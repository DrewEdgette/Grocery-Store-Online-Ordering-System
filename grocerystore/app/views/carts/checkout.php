<?php
    require APPROOT . "/views/includes/header.php";
?>

<div class="main-area">

<body>

<div class="my-account"><h1>Checkout</h1>

<div class='section-box'>
<h2>Order type</h2>

<?php 
if (isset($data["orderType"])) {
    echo "<p>Delivery</p>";
    echo "</div>";
    echo "<div class='section-box'>";
    echo "<h2>Shipping address</h2>";
    echo "<p><strong>Name</strong><br>" . $data["address"]->address_name . "</p>";
    echo "<p><strong>Address</strong><br>" . $data["address"]->street_address . "</p>";
    echo "<p><strong>City</strong><br>" . $data["address"]->city . "</p>";
    echo "<p><strong>State</strong><br>" . $data["address"]->state . "</p>";
    echo "<p><strong>Zip</strong><br>" . $data["address"]->zip . "</p>";
    echo "<p><strong>Phone</strong><br>" . $data["address"]->phone . "</p>";
}

else {
    echo "<p>Pickup</p>";
}
?>
</div>



<div class='section-box'>
<h2>Payment</h2>
<?php echo "<p>" . $data["payment"] . "</p>"; ?>
</div>



<div class="section-box">

<h2>Receipt</h2>

<form method="post" action="/grocerystore/carts/checkout">

<?php

    foreach ($_SESSION["cart"] as $item) {
        echo "<p>" . $item[0]->item_name . "</p>";
        echo "<p>Quantity: " . $item[1] . "</p>";
        echo "<p>$" . $item[0]->item_price * $item[1] . "</p>";
    }
    


    echo "Sub-total: $" . $data["subtotal"] . "<br>";
    echo "Tax: $" . $data["tax"] . "<br>";
    echo "<h2>Total: $" . $data["total"] . "</h2><br>";
?>

<input type="submit" name="submit" value="Place order">

</form>

</div>



<div class="goto-signup">
      <button onclick="document.location='/grocerystore/carts/mycart'">Return to cart</button>
</div>

</div>

</body>

<?php
    require APPROOT . "/views/includes/footer.php";
?>

</div>

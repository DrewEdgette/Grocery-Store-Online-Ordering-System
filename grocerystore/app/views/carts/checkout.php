<?php
    require APPROOT . "/views/includes/header.php";
?>


<body>

<div class="my-account"><h1>Checkout</h1></div>

<div class="main-area">

<div class="section-box">

<form method="post" action="/grocerystore/carts/checkout">

<?php

    foreach ($_SESSION["cart"] as $item) {
        echo "<p>" . $item[0]->item_name . "</p>";
        echo "<img src='" . $item[0]->image_url . "'></img>";
        echo "<p>$" . $item[0]->item_price * $item[1] . "</p>";
        echo "<p>Quantity: " . $item[1] . "</p>";
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



<?php
    require APPROOT . "/views/includes/footer.php";
?>

</body>

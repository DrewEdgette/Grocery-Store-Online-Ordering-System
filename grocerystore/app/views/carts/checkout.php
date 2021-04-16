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
        echo "<p>" . $item->item_name . "</p>";
        echo "<img src='" . $item->image_url . "'></img>";
        echo "<p>$" . $item->item_price . "</p>";
    }
    


    echo "Sub-total: $" . $data["subtotal"] . "<br>";
    echo "Tax: $" . $data["tax"] . "<br>";
    echo "Total: $" . $data["total"] . "<br>";
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

<?php
    require APPROOT . "/views/includes/header.php";
?>

<div class="main-area">

<body>

<div class="my-account"><h1>Choose order type</h1>

<div class="clickable-section-box" onclick="location.href='/grocerystore/carts/confirmpayment'">
<h2>Pickup</h2>
</div>

<div class="clickable-section-box" onclick="location.href='/grocerystore/carts/confirmaddress'">
<h2>Delivery</h2>
</div>

</div>


</body>

<?php
    require APPROOT . "/views/includes/footer.php";
?>

</div>


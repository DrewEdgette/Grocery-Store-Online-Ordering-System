<?php
    require APPROOT . "/views/includes/header.php";
?>

<body>

<div class="main-area">

<div class="section-box">
<?php
echo "<h1>" . $data["item"]->item_name . "</h1>";
echo "<img src='" . $data["item"]->image_url . "'></img>";
echo "<h2>$" . $data["item"]->item_price . "</h2>";
?>
</div>
</div>
</body>
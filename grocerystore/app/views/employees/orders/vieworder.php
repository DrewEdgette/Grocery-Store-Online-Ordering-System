<?php
    require APPROOT . "/views/includes/header.php";
?>


<body>

<div class="my-account"><h1>Order details</h1></div>

<div class="main-area">

<?php
   foreach ($data["itemList"] as $item) {
    echo "<div class='section-box'>";
    echo $item->item_name . "<br>";
    echo "<img src='" . $item->image_url . "'></img>";
    echo "</div>";
  } 
?>

</div>


<?php
    require APPROOT . "/views/includes/footer.php";
?>

</body>

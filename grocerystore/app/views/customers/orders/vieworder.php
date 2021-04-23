<?php
    require APPROOT . "/views/includes/header.php";
?>

<div class="main-area">


<body>

<div class="my-account"><h1>Order details</h1>


<?php
   foreach ($data["itemList"] as $item) {
    echo "<div class='section-box'>";
    echo $item->item_name . "<br>";
    echo "<img src='" . $item->image_url . "'></img>";
    echo "</div>";
  } 
?>


</div>

</body>

<?php
    require APPROOT . "/views/includes/footer.php";
?>

</div>





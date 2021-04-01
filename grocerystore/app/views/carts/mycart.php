<?php
    require APPROOT . "/views/includes/header.php";
?>


<body>

<div class="my-account"><h1>Your Cart</h1></div>

<div class="main-area">
<?php
      foreach ($_SESSION["cart"] as $item) {
        echo "<div class='section-box'>";
        echo "<p>" . $item->item_name . "</p>";
        echo "<img src='" . $item->image_url . "'></img>";
        echo "</div>";
      }
    ?>
</div>


<?php
    require APPROOT . "/views/includes/footer.php";
?>

</body>

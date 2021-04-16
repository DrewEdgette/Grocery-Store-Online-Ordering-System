<?php
    require APPROOT . "/views/includes/header.php";
?>


<body>

<div class="my-account"><h1>Your Cart</h1></div>

<div class="main-area">
<?php

      if (empty($data["cart"])) {
        echo "<div class=my-account> Your cart is empty.</div>";
      }

      else {

        foreach ($_SESSION["cart"] as $item) {
          echo "<div class='section-box'>";
          echo "<p>" . $item->item_name . "</p>";
          echo "<img src='" . $item->image_url . "'></img>";
          echo "<p>$" . $item->item_price . "</p>";
          echo "</div>";
        }

      echo "<div class='goto-signup'>";
      echo "<button onclick=document.location='/grocerystore/carts/checkout'>Go to checkout</button>";
      echo "</div>";
      echo "</div>";
      }

?>


<?php
    require APPROOT . "/views/includes/footer.php";
?>

</body>

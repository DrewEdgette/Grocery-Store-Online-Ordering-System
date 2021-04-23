<?php
    require APPROOT . "/views/includes/header.php";
?>

<div class="main-area">

<body>

<div class="my-account"><h1>Your Cart</h1>

<?php

      if (empty($data["cart"])) {
        echo "<div class=my-account> Your cart is empty.</div>";
      }

      else {

        foreach ($_SESSION["cart"] as $item) {
          echo "<form action='/grocerystore/carts/mycart' method='post'>";
          echo "<div class='section-box'>";
          echo "<p>" . $item[0]->item_name . "</p>";
          echo "<img src='" . $item[0]->image_url . "'></img>";
          echo "<p>$" . $item[0]->item_price *  $item[1]. "</p>";
          echo "<p> Quantity: " . $item[1] . "</p>";
          echo "<select name='quantity'>";
          echo "<option value='none' selected disabled hidden>" . $item[1] ."</option>";

          for ($i=0; $i<11; $i++) {
            echo "<option>" . $i . "</option>";
          }

          echo "</select>";
          echo "<input type='submit' name='" . $item[0]->item_id . "' value='Change quantity'>";
          echo "</form>";
          echo "</div>";
        }

      echo "<div class='goto-signup'>";
      echo "<button onclick=document.location='/grocerystore/carts/checkout'>Go to checkout</button>";
      echo "</div>";
      echo "</div>";
      }

?>

</body>

<?php
    require APPROOT . "/views/includes/footer.php";
?>

</div>


<?php
    require APPROOT . "/views/includes/header.php";
?>



<div class="main-area">

<body>

<div class="my-account"><h1>Choose address</h1> <?php echo $data["noaddress"]; ?>

<form action='confirmaddress' method='post'>

<?php

      foreach ($data["addresses"] as $address) {
        echo "<div class='section-box'>";
        echo "<h2>" . $address[6] . "</h2>";
        echo "<p><strong>Address</strong><br>" . $address[1] . "</p>";
        echo "<p><strong>City</strong><br>" . $address[2] . "</p>";
        echo "<p><strong>State</strong><br>" . $address[3] . "</p>";
        echo "<p><strong>Zip</strong><br>" . $address[4] . "</p>";
        echo "<p><strong>Phone</strong><br>" . $address[5] . "</p>";
        echo "<input type='submit' name='" . $address[0] . "' value='Choose this address'>";
        echo "</div>";
      }
    ?>

</form> 



<div class="goto-signup">
      <button onclick="document.location='/grocerystore/carts/ordertype'">Go back</button>
</div>


</div>


</body>


<?php
    require APPROOT . "/views/includes/footer.php";
?>

</div>

</html>
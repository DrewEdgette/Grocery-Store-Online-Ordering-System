<?php
    require APPROOT . "/views/includes/header.php";
?>

<body>

<div class="main-area">
<div class="my-account"><h1>Your Addresses</h1> <?php echo $data["noaddress"]; ?> </div>
    <?php


      foreach ($data["addresses"] as $address) {
        echo "<div class='section-box'>";
        echo "<p><strong>Address</strong><br>" . $address[1] . "</p>";
        echo "<p><strong>City</strong><br>" . $address[2] . "</p>";
        echo "<p><strong>State</strong><br>" . $address[3] . "</p>";
        echo "<p><strong>Zip</strong><br>" . $address[4] . "</p>";
        echo "<p><strong>Phone</strong><br>" . $address[5] . "</p>";
        echo "<a href='/grocerystore/users/changeaddress?id=" . $address[0] . "'><button>Change this address</button></a>";
        echo "</div>";
      }
    ?>

<div class="goto-signup">
  <button onclick="document.location='addaddress'">Add address</button>
</div>

</div>



<?php
    require APPROOT . "/views/includes/footer.php";
?>
</body>
</html>
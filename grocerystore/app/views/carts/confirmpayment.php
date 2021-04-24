<?php
    require APPROOT . "/views/includes/header.php";
?>



<div class="main-area">

<body>

<div class="my-account"><h1>Confirm payment</h1>

<form action='confirmpayment' method='post'>

<?php

    echo "<div class='section-box'>";
    if (empty($data["payment"])) {
        echo "You do not have any payment information yet.";
    }

    else {
        echo "<p><strong>Payment</strong><br>" . $data["payment"] . "</p>";
        echo "<input type='submit' value='Continue'>";
    }
    
    echo "</div>";

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
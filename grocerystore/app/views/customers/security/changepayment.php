<?php
    require APPROOT . "/views/includes/header.php";
?>


<div class="main-area">

<body>

<div class="my-account"><h1>Change Payment</h1>

<div class="section-box">

<form method="post" action="/grocerystore/customers/changepayment">

  Card Number: <br>
  <input type='text' name="payment" placeholder="New card number">

<br>

<input type='submit' value='Update card info'>
</form>




<div class="error-field">

    <?php
    if (isset($_POST["error"])) {
        switch ($_POST["error"]) {
            case "emptyinput":
                echo $data["emptyinput"];
                break;

            case "success":
                echo $data["success"] . "<br>";
                echo "<a href='/grocerystore/users/account'>Return to account</a>";
                break;

            default:
                break;
        }
    }
    ?>
    </div>

</div>  
</div>

</body>

<?php
    require APPROOT . "/views/includes/footer.php";
?>

</div>


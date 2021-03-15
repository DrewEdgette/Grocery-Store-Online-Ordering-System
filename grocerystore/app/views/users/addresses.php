<?php
    require APPROOT . "/views/includes/header.php";
?>
<html>

<body>

<div class="signin-signup">

<h1>My Addresses</h1>

<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">

  Address: <input type="text" name="address">

<br>

  Street: <input type="text" name="street">

<br>

  City: <input type="text" name="city">

<br>

  State: <input type="text" name="state">

<br>

  Zip Code: <input type="text" name="zip">

<br>

  Phone Number: <input type="text" name="phone">

<br>

  Payment Method (e.g: Visa): <input type="text" size="45" maxlength="45" name="pay">

<br>

  <input type="submit">

</form>

</div>

<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  // collect value of input field

  $address = $_POST['address'];

  $street = $_POST['street'];

  $city = $_POST['city'];

  $state = $_POST['state'];

  $zip = $_POST['zip'];

  $phone = $_POST['phone'];

  $pay = $_POST['pay'];

  if (empty($address)) {

    echo "Address field is blank";echo "<br>";

  } else {

    echo $address;echo "<br>";

  }

  if (empty($street)) {

    echo "Street field is blank.";echo "<br>";

  } else {

    echo $street;echo "<br>";

  }

  if (empty($city)) {

    echo "City field is blank.";echo "<br>";

  } else {

    echo $city;echo "<br>";

  }

  if (empty($state)) {

    echo "State field is blank.";echo "<br>";

  } else {

    echo $state;echo "<br>";

  }

  if (empty($zip)) {

    echo "Zip Code field is blank.";echo "<br>";

  } else {

    echo $zip;echo "<br>";

  }

  if (empty($phone)) {

    echo "Phone number field is blank.";echo "<br>";

  } else {

    echo $phone;echo "<br>";

  }

  if (empty($pay)) {

    echo "Payment method field is blank.";echo "<br>";

  } else {

    echo $pay;echo "<br>";

  }

}

?>

<?php
    require APPROOT . "/views/includes/footer.php";
?>

</body>

</html>

<body>

    <?php

        echo $_SESSION["username"];

        echo "<br>";

        echo $_SESSION["email"];

                echo "<br>";

                $address = 'Enter Address';

                $street = 'Enter Street';

                $city = 'Enter City';

                $state = 'Enter State';

                $zip = 'Enter Zip Code';

                $phone = 'Enter Phone Number';

                $pay = 'Enter Payment Method (e.g: Visa #0123 4567 8901 2345)';

    ?>
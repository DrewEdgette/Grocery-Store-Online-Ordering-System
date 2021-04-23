<?php
    require APPROOT . "/views/includes/header.php";
?>


<div class="main-area">

<body>

<div class="my-account"><h1>Change Name</h1>

<div class="section-box">

<form method="post" action="/grocerystore/employees/changename">

<?php echo "Name: <br>" . $data["name"];?>
  <input type='text' name="new_name" placeholder="New name">

<input type='submit' value='Update name'>
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


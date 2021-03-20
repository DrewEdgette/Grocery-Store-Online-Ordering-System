<?php
    require APPROOT . "/views/includes/header.php";
?>


<body>

<div class="main-area">

<div class="my-account"><h1>Login & security</h1></div>

<div class="section-box">

<form method="post" action="/grocerystore/users/security">

  Name: <br> <?php echo $data["name"] ?>

  <input type='text' name="new_name" placeholder="Change name">

<br>

  Email: <br> <?php echo $data["email"] ?> 
  <input type='text' name="new_email" placeholder='Change email'>

<br>

<input type='submit' value='Update information'>
</form>

<div class="error-field">

    <?php
    if (isset($_POST["error"])) {
        switch ($_POST["error"]) {
            case "emailtaken":
                echo $data["emailtaken"];
                break;
                
            default:
                break;
        }
    }
    ?>
    </div>

</div>

<div class="section-box">
  <h2><a href="/grocerystore/users/changepassword">Change password</a></h2>
</div>

<div class="section-box">
  <h2><a href="/grocerystore/users/changepayment">Change payment info</a></h2>
</div>

</div>  


<?php
    require APPROOT . "/views/includes/footer.php";
?>

</body>

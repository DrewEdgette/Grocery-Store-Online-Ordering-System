<?php
    require APPROOT . "/views/includes/header.php";
?>


<div class="main-area">

<body>


<div class="my-account"><h1>Change Password</h1>

<div class="section-box">

<form method="post" action="/grocerystore/employees/changepassword">

  Current password: <br>
  <input type='password' name="pwd" placeholder="Current password">

<br>

  New password: <br>
  <input type='password' name="new_pwd" placeholder='New password'>

<br>

Re-enter new password: <br>
  <input type='password' name="new_pwd_repeat" placeholder='New password'>

<br>

<input type='submit' value='Update password'>
</form>




<div class="error-field">

    <?php
    if (isset($_POST["error"])) {
        switch ($_POST["error"]) {
            case "pwdmatch":
                echo $data["pwdmatch"];
                break;
    
            case "wrongpwd":
                echo $data["wrongpwd"];
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


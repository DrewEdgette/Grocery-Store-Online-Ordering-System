<?php
    require APPROOT . "/views/includes/header.php";
?>


<body>

<div class="main-area">

<div class="my-account"><h1>Change Email</h1></div>

<div class="section-box">

<form method="post" action="/grocerystore/customers/changeemail">

<?php echo "Email: <br>" . $data["email"];?>
  <input type='text' name="new_email" placeholder="New email">

<input type='submit' value='Update email'>
</form>


<div class="error-field">

    <?php
    if (isset($_POST["error"])) {
        switch ($_POST["error"]) {
            case "emptyinput":
                echo $data["emptyinput"];
                break;
                
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
</div>


<?php
    require APPROOT . "/views/includes/footer.php";
?>

</body>

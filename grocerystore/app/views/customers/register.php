<?php
    require APPROOT . "/views/includes/header.php";
?>

<body>

    <div class="main-area">
    <div class="section-box">

        <h1>Create Account</h1>

        <form method="post" action="/grocerystore/customers/register">
            <label>Your Name</label>
            <input type="text" name="full_name" placeholder="Full Name"/>


            <label>Email</label>
            <input type="text" name="email" placeholder="Email"/>


            <label>Password</label>
            <input type="password" name="pwd" placeholder="Password"/>


            <label>Re-enter Password</label>
            <input type="password" name="pwdRepeat" placeholder="Password"/>


            <input type="submit" name="submit" value="Create your account">
        </form>

    <div class="error-field">

    <?php
    if (isset($_POST["error"])) {
        switch ($_POST["error"]) {
            case "emptyinput":
                echo $data["emptyinput"];
                break;

            case "invalidemail":
                echo $data["invalidemail"];
                break;

            case "pwdmatch":
                echo $data["pwdmatch"];
                break;
    
            case "emailtaken":
                echo $data["emailtaken"];
                break;

            case "stmtfailed":
                echo $data["stmtfailed"];
                break;

            default:
                break;
        }
    }
    ?>
    </div>

    </div>

    <div class="goto-signup">
        <p>Already have an account?</p>
        <button onclick="document.location='login'">Sign-In</button>
    </div>


</body>

<?php
    require APPROOT . "/views/includes/footer.php";
?>

</div>

</html>
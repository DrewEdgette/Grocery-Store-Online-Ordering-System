<?php
    include "header.php";
?>

<body>
    <div class="signin-signup">

        <h1>Create Account</h1>

        <form method="post" action="includes/signup.inc.php">
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
    if (isset($_GET["error"])) {
        switch ($_GET["error"]) {
            case "emptyinput":
                echo "<p>Please enter all fields!</p>";
                break;

            case "invalidemail":
                echo "<p>That's not a proper email address.</p>";
                break;

            case "pwdmatch":
                echo "<p>The passwords do not match.</p>";
                break;
    
            case "emailtaken":
                echo "<p>The email is already in use.</p>";
                break;

            case "stmtfailed":
                echo "<p>Something went wrong.</p>";
                break;

            default:
                break;
        }
    }
    ?>
    </div>

    </div>

</body>

</html>
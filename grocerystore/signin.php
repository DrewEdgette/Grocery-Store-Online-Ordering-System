<?php
    include "header.php";
?>

<body>

    <div class="signin-signup">

        <h1>Sign-In</h1>

        <form method="post" action="includes/signin.inc.php">
            <label>Email</label>
            <input type="text" name="email" placeholder="Email"/>

            <label>Password</label>
            <input type="password" name="pwd" placeholder="Password"/>

            <input type="submit" name="submit" value="Continue">
        </form>

        <div class="error-field">

        <?php
            if (isset($_GET["error"])) {
                switch ($_GET["error"]) {
                    case "emptyinput":
                        echo "<p>Please enter all fields!</p>";
                        break;

                    case "wrongemail":
                        echo "<p>Wrong email address.</p>";
                        break;

                    case "wrongpwd":
                        echo "<p>Password is incorrect.</p>";
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

    <div class="goto-signup">
        <p>Don't have an account yet?</p>
        <button onclick="document.location='signup.php'">Create an account</button>
    </div>

</body>

</html>
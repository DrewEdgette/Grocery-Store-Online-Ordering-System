<?php
    require APPROOT . "/views/includes/header.php";
?>

<body>
    
    <div class="main-area">


    <div class="section-box">

        <h1>Sign-In</h1>

        <form method="post" action="/grocerystore/customers/login">
            <label>Email</label>
            <input type="text" name="email" placeholder="Email"/>

            <label>Password</label>
            <input type="password" name="pwd" placeholder="Password"/>

            <input type="submit" name="submit" value="Continue">
        </form>

        <div class="error-field">

        <?php
            if (isset($_POST["error"])) {
                switch ($_POST["error"]) {
                    case "emptyinput":
                        echo $data["emptyinput"];
                        break;

                    case "wrongpwd":
                        echo $data["wrongpwd"];
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
        <p>Don't have an account yet?</p>
        <button onclick="document.location='register'">Create an account</button>
    </div>

    
    <div class="goto-signup">
        <p>Employees</p>
        <button onclick="document.location='/grocerystore/employees/login'">Employee Login</button>
    </div>

    </div>


    <?php
    require APPROOT . "/views/includes/footer.php";
    ?>

</body>

</html>
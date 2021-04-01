<?php
    require APPROOT . "/views/includes/header.php";
?>

<body>
    
    <div class="main-area">


    <div class="section-box">

        <h1>Employee Sign-In</h1>

        <form method="post" action="/grocerystore/employees/login">
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


    </div>


    <?php
    require APPROOT . "/views/includes/footer.php";
    ?>

</body>

</html>
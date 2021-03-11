<?php
    include "header.php";
    include "includes/functions.inc.php";
?>

<body>
    <?php
        echo $_SESSION["username"];
        echo "<br>";
        echo $_SESSION["email"];
    ?>
</body>
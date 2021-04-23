<?php
    require APPROOT . "/views/includes/header.php";
?>

<div class="main-area">

<body>

<div class="my-account"><h1>Here's what we found:</h1>

    <?php
        echo $data["results"];
    ?>


</body>

</div>

</body>

<?php
    require APPROOT . "/views/includes/footer.php";
?>


</div>
</html>
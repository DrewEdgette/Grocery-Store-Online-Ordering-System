<?php
    require APPROOT . "/views/includes/header.php";
?>

<body>

<div class="main-area">

<div class="section-box">
<?php
echo "<h1>" . $data["item"]->item_name . "</h1>";
echo "<img src='" . $data["item"]->image_url . "'></img>";
echo "<h2>$" . $data["item"]->item_price . "</h2>";
echo "<h2>" . $data["quantity"] . "</h2>";

if ($data["item"]->item_quantity) {
    echo "<form method='post' action=''><input type='submit' name='submit' value='Add to cart'></form>";
}
?>




<div class="error-field">

        <?php
            if (isset($_POST["error"])) {
                switch ($_POST["error"]) {
                    case "success":
                        echo $data["success"];
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
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
echo "<h2> Quantity: " . $data["item"]->item_quantity
?>


<form method="post" action="">

<input type='text' name="new_quantity" placeholder="New quantity">

<input type='submit' value='Update quantity'>
</form>

<div class="error-field">

        <?php
            if (isset($_POST["error"])) {
                switch ($_POST["error"]) {
                    case "success":
                        echo $data["success"];
                        break;

                    case "failure":
                        echo $data["failure"];
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
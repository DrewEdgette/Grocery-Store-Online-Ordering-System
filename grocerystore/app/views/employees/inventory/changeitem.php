<?php
    require APPROOT . "/views/includes/header.php";
?>

<div class="main-area">

<body>


<div class="section-box">
<?php
echo "<h1>" . $data["item"]->item_name . "</h1>";
echo "<img src='" . $data["item"]->image_url . "'></img>";
echo "<h2>$" . $data["item"]->item_price . "</h2>";
echo "<h2> Quantity: " . $data["item"]->item_quantity
?>


<form method="post" action="">

<input type='text' name="new_name" placeholder="New name">
<input type='text' name="new_price" placeholder="New price">
<input type='text' name="new_quantity" placeholder="New quantity">

<input type='submit' value='Update item information'>
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



</body>

<?php
    require APPROOT . "/views/includes/footer.php";
?>

</div>
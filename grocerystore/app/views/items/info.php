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
echo "<h2>" . $data["quantity"] . "</h2>";

if ($data["item"]->item_quantity) {
    echo "<form method='post' action=''><input type='submit' name='submit' value='Add to cart'></form>";
}
else
{
    echo "We are all out of this item. However, try to search for the name of the product again because we may have a different brand of the item you are looking for available. If not, we will make sure to update the inventory as soon as possible. We apologize any inconvenience.";
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


</body>

<?php
    require APPROOT . "/views/includes/footer.php";
?>

</div>
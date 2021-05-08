<?php
    require APPROOT . "/views/includes/header.php";
?>

<div class="main-area">

<body>
    <div class="greeting">
        <h1>5 Brothers' Grocery Closet Online Website</h1>
    </div>

<section class = "featured-items">
<h1>Featured Items</h1>
<div class="grid-container">
<?php
    foreach($data["featured_items"] as $item) {

        if (!isset($_SESSION["isEmployee"]) || !$_SESSION["isEmployee"]) {
            echo "<div class='clickable-section-box' onclick=location.href='/grocerystore/items/info?id=" . $item->item_id . "'>";
        }
        else {
            echo "<div class='clickable-section-box' onclick=location.href='/grocerystore/employees/changeitem?id=" . $item->item_id . "'>";
        }
        echo "<img src='" . $item->image_url . "'></img>";
        echo $item->item_name . "<br> <br>";
        echo "$" . $item->item_price;
        echo "</div>";
    
    }
?>
</div>
</section>

 </body>

 <?php
    require APPROOT . "/views/includes/footer.php";
?>

 </div>
 
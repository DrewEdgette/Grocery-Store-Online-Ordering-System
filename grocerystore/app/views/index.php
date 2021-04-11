<?php
    require APPROOT . "/views/includes/header.php";
?>

<body>
    <div class="greeting">
        <h1>Welcome to the 5 Brothers' Grocery Closet Online Website!</h1>
    </div>

    
<section class = "image">
<img src="/grocerystore/public/images/home_image.jpg" alt="Trulli">   
</section>


<article class = "FeaturedItems">
    <h1>Featured Items: </h1>
<?php
    echo "<table>";
    foreach($data["featured_items"] as $item) {

        echo "<tr>";
		echo "<th>Item Name</th>";
        echo "<th><img src='" . $item->image_url . "'></img></th>";
        echo "<th>Item Price</th>";
		echo "<th>Item Weight</th>";
        echo "</tr>";
        
        echo "<tr>";
		echo "<td>" . $item->item_name . "</td>";
        echo "<td>" . $item->item_price . "</td>";
		echo "<td>" . $item->item_weight . "</td>";
        echo "</tr>";
    }

    echo "</table>";
?>

</article>

<?php
    require APPROOT . "/views/includes/footer.php";
?>

 </body>
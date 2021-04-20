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


<article>
    

</article>

<section class = "FeaturedItems">
<h1>Featured Items: </h1>
<?php
    echo "<table>";
    foreach($data["featured_items"] as $item) {
        
        echo "<td>";

        echo "<tr>";
        echo "<th><img src='" . $item->image_url . "'></img></th>";
        echo "</tr>";
        
        echo "<tr>";
		echo "<td>" . $item->item_name . "</td>";
        echo "</tr>";

        echo "<tr>";
        echo "<td>" . "$" . $item->item_price . "</td>";
        echo "</tr>";
        
        echo "</td>";
        
		
    }
    echo "</table>";
?>
</section>

<?php
    require APPROOT . "/views/includes/footer.php";
?>

 </body>
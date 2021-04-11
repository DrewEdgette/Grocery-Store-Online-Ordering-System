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
</article>
<?php
$link = mysqli_connect("", "", "", "");
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
 
// Attempt select query execution
$sql = "SELECT * FROM items WHERE item_quantity > 0 ORDER BY RAND() LIMIT 5";
if($result = mysqli_query($link, $sql)){
    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_array($result)){
	echo "<table>";
            echo "<tr>";
		echo "<th>Item Name</th>";
        echo "<img src='" . $row['image_url'] . "'>Image</img>";
        echo "<th>Item Price</th>";
		echo "<th>Item Weight</th>";
        echo "</tr>";
        echo "<tr>";
		echo "<td>" . $row['item_name'] . "</td>";
        echo "<td>" . $row['item_price'] . "</td>";
		echo "<td>" . $row['item_weight'] . "</td>";
        echo "</tr>";
        }
        echo "</table>";
        // Free result set
        mysqli_free_result($result);
    } else{
        echo "No records matching your query were found.";
    }
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}
 
// Close connection
mysqli_close($link);
?>

    <?php
    require APPROOT . "/views/includes/footer.php";
    ?>

 </body>
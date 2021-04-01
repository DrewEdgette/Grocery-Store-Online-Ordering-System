<?php
    require APPROOT . "/views/includes/header.php";
?>

<body>
    
    <div class="main-area">


    <div class="section-box">

        <h1>Add Product</h1>
        
	<form method="post" action="/grocerystore/employees/additem">

            <label for="item_name">Item Name</label>
            <input type="text" name="item_name" placeholder="Item Name"/>

	    <label for="item_price">Item Price</label>
            <input type="text" name="item_price" placeholder="Item Price"/>

	    <label for="item_weight">Item Weight</label>
            <input type="text" name="item_weight" placeholder="Item Weight"/>

	    <label for="image_url">Image URL</label>
            <input type="text" name="image_url" placeholder="Image URL"/>

            <input type="submit" name="submit" value="Add Item">

        </form>
</div>

<?php
    require APPROOT . "/views/includes/footer.php";
?>
</body>
</html>
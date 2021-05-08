<?php
    require APPROOT . "/views/includes/header.php";
?>
<?php
error_reporting(0);
?>
<div class="main-area">

<body>

<div class="my-account"><h1>Order Statistics</h1>

<form method="post" action="/grocerystore/employees/orderstats">

        <label for='customer_id'>Customer ID</label>
        <input type='text' name='customer_id' placeholder='Customer ID'/>
        <input type='submit' name='submit' value='Check Frequency'/>
	    <input type='submit' name='submit2' value='Check Order Dates'/>
	    <input type='submit' name='submit3' value='Check Total Money Spent'/>
        <input type='submit' name='submit4' value='Check Amount of Pending Orders'/>
	    <input type='submit' name='submit5' value='Check Amount of Ready Orders'/>
</form> 

<?php
if (isset($data["submit"])) {
    echo $data["submit"];
}
?>

</div>
</body>

<?php
    require APPROOT . "/views/includes/footer.php";
?>

</div>
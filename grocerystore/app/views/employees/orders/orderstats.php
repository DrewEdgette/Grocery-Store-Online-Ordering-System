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
</form> 

<?php

if (isset($data["orderTotal"])) {
    echo $data["orderTotal"];
}

?>

</div>
</body>

</div>
<?php include 'database.php';


$sql = "SELECT * FROM customers;";

//Execute the query

$result = mysqli_query($connect,$sql);

if (mysqli_affected_rows($connect) > 0) {
	while($row = MYSQLI_fetch_assoc($result)) {
        echo $row['full_name'] . " " . $row['email'] . "<br>";
    }
	echo "<a href='index.php'>Go Back</a>";
} 
else {
	echo "Couldnt connect <br/>";
	echo mysqli_error ($connect);
}

?>
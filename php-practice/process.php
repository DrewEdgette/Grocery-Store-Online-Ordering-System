<?php include 'database.php';


// create a variable
$full_name=$_POST['full_name'];
$email=$_POST['email'];
$password=$_POST['password'];

$sql = "INSERT INTO customers (full_name,email,customer_password) VALUES ('$full_name','$email', '$password')";

//Execute the query

mysqli_query($connect,$sql);
				
if(mysqli_affected_rows($connect) > 0) {
	echo "<p>Employee Added</p>";
	echo "<a href='index.php'>Go Back</a>";
} 
else {
	echo "Employee NOT Added<br />";
	echo mysqli_error ($connect);
}

?>
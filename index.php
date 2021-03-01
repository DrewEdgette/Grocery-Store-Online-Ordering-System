<!DOCTYPE html>
<html>

<head>
    <style>
        label {
            display: inline-block;
            width: 100px;
            margin-bottom: 10px;
        }
    </style>

    <title>Add Employee</title>
</head>

<body>

    <form method="post" action="process.php">
        <label>Your Name</label>
        <input type="text" name="full_name" placeholder="Full Name"/>
        <br>

        <label>Email</label>
        <input type="text" name="email" placeholder="Email"/>
        <br>

        <label>Password</label>
        <input type="password" name="password" placeholder="Password"/>
        <br>
        <input type="submit" value="Add Employee">
    </form>

</body>

</html>
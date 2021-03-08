<!DOCTYPE html>
<html>

<head>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">

    <title>Sign Up</title>
</head>

<body>

    <div class="topnav">
        <a class="active" href="../">Home</a>
    </div>

    <div class="signin-signup">

        <h1>Create Account</h1>

        <form method="post" action="process.php">
            <label>Your Name</label>
            <input type="text" name="full_name" placeholder="Full Name"/>


            <label>Email</label>
            <input type="text" name="email" placeholder="Email"/>



            <label>Password</label>
            <input type="password" name="password" placeholder="Password"/>

            <input type="submit" value="Create your account">
        </form>

    </div>


  <a href='viewdb.php'>View Database</a>

</body>

</html>
<!DOCTYPE html>
<html>

<head>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">

    <title>Sign-In</title>
</head>

<body>

    <div class="topnav">
        <a class="active" href="../">Home</a>
    </div>

    <div class="signin-signup">

        <h1>Sign-In</h1>

        <form method="post" action="">
            <label>Email</label>
            <input type="text" name="email" placeholder="Email"/>

            <label>Password</label>
            <input type="password" name="password" placeholder="Password"/>

            <input type="submit" value="Continue">
        </form>

    </div>

    <div class="goto-signup">
        <p>Don't have an account yet?</p>
        <button onclick="document.location='signup.php'">Create an account</button>
    </div>


  <a href='viewdb.php'>View Database</a>

</body>

</html>
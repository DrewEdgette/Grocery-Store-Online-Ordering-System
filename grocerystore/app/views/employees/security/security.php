<?php
    require APPROOT . "/views/includes/header.php";
?>

<div class="main-area">

<body>


<div class="my-account"><h1>Login & security</h1>

<div class="section-box">
  <?php echo "Name: <br>" . $data["name"];?>
  <h2><a href="changename">Change name</a></h2>
</div>

<div class="section-box">
<?php echo "Email: <br>" . $data["email"];?>
  <h2></h2>
</div>

<div class="section-box">
  <h2><a href="changepassword">Change password</a></h2>
</div>

</div>  

</body>

<?php
    require APPROOT . "/views/includes/footer.php";
?>

</div>



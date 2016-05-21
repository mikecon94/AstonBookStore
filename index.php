
<html>
<head>
  <title> Aston Book Store</title>
  <link rel="stylesheet" type="text/css" href="css/tacit.min.css">
  <link rel="icon" type="image/png" href="favicon.ico">
  <link rel="stylesheet" type="text/css" href="css/my.css?v=<?=time();?>">
</head>
<body>
  <?php
    session_start();
    //Check if a user is logged in otherwise redirect to login page.
    if(!isset($_SESSION['username'])){
      header('location: login.php');
    }

   ?>
  <div class="center">
    <div>
      <h1 >Aston Book Store</h1>
      <h2 class="center">Welcome <?php echo $_SESSION['fullname'];?> </h2>
    </div>
  </div>
</body>
</html>

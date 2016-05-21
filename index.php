
<html>
<head>
  <title> Aston Book Store</title>
  <link rel="stylesheet" type="text/css" href="css/tacit.min.css">
  <link rel="icon" type="image/png" href="favicon.ico">
  <link rel="stylesheet" type="text/css" href="css/my.css?v=<?=time();?>">
</head>
<body>
  <?php
    //Check if user is logged in or just clicked login.
    if($_SESSION['loggedin'] == true){
      header('location: login.php');
    }

   ?>
  <div class="center">
    <div>
      <h1 >Aston Book Store</h1>
      <h2 >Welcome</h2>
    </div>
  </div>
</body>
</html>

<html>
<head>
  <title> Aston Book Store</title>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="css/bootstrap.css?v=<?= time();?>">
  <script src="js/jquery.js"></script>
  <script src="js/bootstrap.js"></script>

  <link rel="stylesheet" type="text/css" href="css/tacit.min.css">
  <link rel="icon" type="image/png" href="favicon.ico">
  <link rel="stylesheet" type="text/css" href="css/my.css">
</head>
<body>
  <?php include 'php/CheckLoggedIn.php'; ?>

  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <ul class="nav navbar-nav">
        <li <?php if(strpos($_SERVER['REQUEST_URI'], "index.php") !== false){echo 'class="active"';} ?>><a href="index.php">Aston Book Store</a></li>
        <li <?php if(strpos($_SERVER['REQUEST_URI'], "books.php") !== false){echo 'class="active"';} ?>><a href="books.php">Books</a></li>
        <li <?php if(strpos($_SERVER['REQUEST_URI'], "basket.php") !== false){echo 'class="active"';} ?>><a href="basket.php">Basket</a></li>
        <?php
          //Only show the following if the user is staff.
          if($_SESSION['type'] == 'Staff'){?>
            <li <?php if(strpos($_SERVER['REQUEST_URI'], "addbook.php") !== false){echo 'class="active"';} ?>><a href="addbook.php">Add Book</a></li>
            <li <?php if(strpos($_SERVER['REQUEST_URI'], "topup.php") !== false){echo 'class="active"';} ?>><a href="topup.php">Top Up Users</a></li>
            <li <?php if(strpos($_SERVER['REQUEST_URI'], "purchase.php") !== false){echo 'class="active"';} ?>><a href="purchase.php">Complete Purchase</a></li>
        <?php }
         ?>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="#"><span class="glyphicon glyphicon-user"></span><?php echo $_SESSION['username'];?></a></li>
        <li><a href="php/Logout.php"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
      </ul>
    </div>
  </nav>

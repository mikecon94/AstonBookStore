<html>
<head>
  <title> Aston Book Store</title>
  <link rel="stylesheet" type="text/css" href="css/tacit.min.css">
  <link rel="icon" type="image/png" href="favicon.ico">
  <link rel="stylesheet" type="text/css" href="css/my.css?v=<?=time();?>">
</head>
<body>

  <div class="center">
    <div>
      <h1 class="center">Aston Book Store</h1>
      <h2 class="center">Login</h2>
      <form method="post" action="login.php">
        <input type="text" name="username" placeholder="Username" autofocus>
        <input type="password" name="password" placeholder="Password">
        <div class="center">
          <input type="submit" value="Login">
          <button type="button" onclick='location.href="register.php"'>Register</button>
        </div>
      </form>
    </div>
  </div>
</body>
</html>

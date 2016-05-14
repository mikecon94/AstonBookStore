<html>
<head>
  <title> Aston Book Store</title>
  <link rel="stylesheet" type="text/css" href="css/tacit.min.css">
  <link rel="icon" type="image/png" href="favicon.ico">
  <link rel="stylesheet" type="text/css" href="css/my.css?v=<?=time();?>">
</head>
<body>

  <div class="center">
    <h1>Aston Book Store</h1>
    <h2>Login</h2>
    <form method="post" action="login.php">
      <input type="text" name="username" placeholder="Username" autofocus>
      <input type="password" name="password" placeholder="Password">
      <input type="submit" value="Login">
      <button type="button" onclick='location.href="register.php"'>Register</button>
    </form>
  </div>
</body>
</html>

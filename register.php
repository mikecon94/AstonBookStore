<!DOCTYPE html>
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
      <h2 class="center">Register</h2>
      <form method="post" action="login.php">
        <input type="text" name="username" placeholder="Username" autofocus>
        <input type="text" name="name" placeholder="Full Name" autofocus>
        <input type="text" name="email" placeholder="Email Address" autofocus>
        <input type="password" name="password" placeholder="Password">
        <input type="password" name="validate_password" placeholder="Password">
        <div class="center">
          <input type="submit" value="Register">
        </div>
      </form>
    </div>
  </div>
</body>
</html>

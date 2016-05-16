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
        <div class="center">
          <div>
            <input type="text" name="username" placeholder="Username" autofocus class="center">
            <input type="text" name="name" placeholder="Full Name" class="center">
            <input type="text" name="email" placeholder="Email Address" class="center">
            <input type="password" name="password" placeholder="Password" class="center">
            <input type="password" name="validate_password" placeholder="Password" class="center">
            <div class="center">
              <input type="submit" value="Register" >
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</body>
</html>

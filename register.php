<!DOCTYPE html>
<html>
<head>
  <title> Aston Book Store</title>
  <link rel="stylesheet" type="text/css" href="css/tacit.min.css">
  <link rel="icon" type="image/png" href="favicon.ico">
  <link rel="stylesheet" type="text/css" href="css/my.css?v=">
</head>
<body>
  <div class="center">
    <div>
      <h1 class="center">Aston Book Store</h1>
      <h2 class="center">Register</h2>
        <div class="center">
          <div>
            <?php require_once 'php/ValidateRegister.php' ?>
            <form method="post" action="register.php">
            <input type="text" name="username" value="<?php echo $username;?>" placeholder="Username" autofocus class="center">
            <input type="text" name="name" value="<?php echo $name;?>" placeholder="Full Name" class="center">
            <input type="text" name="email" value="<?php echo $email;?>" placeholder="Email Address" class="center">
            <input type="password" name="password" placeholder="Password" class="center">
            <input type="password" name="password2" placeholder="Password" class="center">
            <input type="hidden" name="operation" value="register">
            <div class="center">
              <input type="submit" value="Register" >
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</body>
</html>

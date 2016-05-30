<?php
/*This script cleanses the data of illegal chars and validates
  the required fields have been passed and in a valid format.
  The data is then sent to the database to create a new user.
  */

$username = htmlspecialchars($_POST['username']);
$name = htmlspecialchars($_POST['name']);
$email = htmlspecialchars($_POST['email']);
$password = htmlspecialchars($_POST['password']);
$password2 = htmlspecialchars($_POST['password2']);

/*Check if there has been a post to the register page.
  We don't want to show errors when the user first clicks
  register.*/
if($_POST['operation'] == 'register'){

  //If this is true at the end then we don't attempt to insert the users data.
  $errors = false;
  //Basic validation eg. empty etc.
  //Check username is unique.
  if(empty($username)){
    echo '<div class="center">Username can not be blank.</div>';
    $errors=true;
  }

  if(empty($name)){
    echo '<div class="center">Name can not be blank.</div>';
    $errors=true;
  }

  if(empty($email)){
    echo '<div class="center">Email can not be blank.</div>';
    $errors=true;
  } else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    echo '<div class="center">Invalid email entered.</div>';
    $errors=true;
  }

  if(empty($password) || empty($password2)){
    echo '<div class="center">Please enter your password twice.</div>';
    $errors=true;
  } else if ($password != $password2){
    echo '<div class="center">Passwords must be equal</div>';
    $errors=true;
  }

  if(!$errors){
    require_once 'InitDb.php';
    //Create new variables that are safe for inserting into the db
    //Old variables aren't reused as they could get output
    //In the sticky form.
    $dbusername = $db->quote($username);
    $dbname = $db->quote($name);
    $dbemail = $db->quote($email);
    $dbhash = password_hash($password, PASSWORD_DEFAULT);
    $dbhash = $db->quote($dbhash);

    try{
      //Check username is unique.
      $rows = $db->query("SELECT user_id FROM user WHERE username = $dbusername");
      if($rows->rowCount() > 0){
        echo '<div class="center">Username is already taken.</div>';
      } else {
        $db->exec("INSERT INTO user (username, password, balance, email, name)
                  VALUES ($dbusername, $dbhash, 0, $dbemail, $dbname)");
        //Redirect to the login page on successful registration.
        header('location:login.php');
      }
    } catch (PDOException $e){
      echo '<div class="center">Database error, please try again.</div>';
      error_log('Database Error: ' . $e);
    }
  }
}
?>

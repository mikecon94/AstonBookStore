<?php
/*This script cleanses the data of illegal chars and validates
  the username & password have been passed and in a valid format.
  The script then connects to the database and attempts to login.
  */

include 'InitDb.php';

$username = htmlspecialchars($_POST['username']);
$password = $_POST['password'];

//Check whether the login form has been submitted.
//This prevents us showing validation errors when a user
//first visits the login page.
if($_POST['operation'] == 'login'){

  //Track if there are validation errors. If so don't attempt to login.
  $errors = false;

  if(empty($username)){
    echo '<div class="center">Username can not be blank.</div>';
    $errors=true;
  }

  if(empty($password)){
    echo '<div class="center">Password can not be blank.</div>';
    $errors=true;
  }

  if(!$errors){
    $dbusername = $db->quote($username);

    try{
      //Retrieve all the users details now as they will be stored
      //in the session variable if the login is successful.
      $rows = $db->query("SELECT username, password, type, balance, email, name FROM user WHERE username = $dbusername");
      if($rows->rowCount() == 0){
        echo '<div class="center">Username not found.</div>';
      } else {
        //Username exists, check the password.
        $user = $rows->fetch();
        if(password_verify($password, $user['password'])){
          //Successfully logged in.
          //Write the session variables and then redirect to index.
          session_start();
          $_SESSION['username'] = $user['username'];
          $_SESSION['type'] = $user['type'];
          $_SESSION['balance'] = $user['balance'];
          $_SESSION['email'] = $user['email'];
          $_SESSION['fullname'] = $user['name'];

          header('Location: index.php');
        } else {
          echo '<div class="center">Incorrect password.</div>';
        }
      }
    } catch(PDOException $e){
      echo '<div class="center">Database error, please try again.</div>';
      error_log('Database Error: ' . $e);
    }
  }
}
?>

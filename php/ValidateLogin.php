<?php
/*This script cleanses the data of illegal chars and validates
  the username & password have been passed and in a valid format.
  The script then connects to the database and attempts to login.
  */

//These are used as sticky form values. They are set during the validation checks.
$username = '';
$password = '';

//Check whether the login form has been submitted.
//This prevents us showing validation errors when a user first visits the login page.
if(isset($_POST['operation']) && $_POST['operation'] == 'login'){

  //Track if there are validation errors. If so don't attempt to login.
  $errors = false;

  if(empty($_POST['username'])){
    echo '<div class="center">Username can not be blank.</div>';
    $errors=true;
  } else {
    $username = htmlspecialchars($_POST['username']);
  }

  if(empty($_POST['password'])){
    echo '<div class="center">Password can not be blank.</div>';
    $errors=true;
  } else {
    //We don't need htmlspecialchars as this isn't a sticky value.
    $password = $_POST['password'];
  }

  if(!$errors){
    require_once 'InitDb.php';

    //Sanitise the user input for the db query to protect against SQL injection.
    $dbusername = $db->quote($username);

    try{
      //Retrieve all the users details now as they will be stored
      //in the session variable if the login is successful.
      $rows = $db->query("SELECT user_id, username, password, type, balance, email, name FROM user WHERE username = $dbusername");
      if($rows->rowCount() == 0){
        echo '<div class="center">Username not found.</div>';
      } else {
        //Username exists, check the password.
        $user = $rows->fetch();
        if(password_verify($password, $user['password'])){
          //Successfully logged in.
          //Write the session variables and then redirect to index.
          session_start();
          $_SESSION['id'] = $user['user_id'];
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

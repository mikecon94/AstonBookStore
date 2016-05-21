<?php
/* This script will be used to validate the data posted to the register form.
  It will "cleanse" the data of illegal chars and validate the required fields
  have been passed.*/

include 'initDb.php';

$username = htmlspecialchars($_POST['username']);
$name = htmlspecialchars($_POST['name']);
$email = htmlspecialchars($_POST['email']);
$password = htmlspecialchars($_POST['password']);
$password2 = htmlspecialchars($_POST['password2']);

/*Check if there has been a post to the register page.
  We don't want to show errors when the user first clicks
  register.*/
if($_POST['operation'] == 'register'){

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


  //If all validation passes, register the user (send to database)
  //$db->quote
  //Catch errors eg. duplicate username
  //throw them back to user.
  if(!$errors){
    echo "No validation errors. Attempting to insert to database.";

  }
}
?>

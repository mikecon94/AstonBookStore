<?php
  session_start();
  //Check if a user is logged in otherwise redirect to login page.
  if(!isset($_SESSION['username'])){
    header('location: login.php');
  }
 ?>

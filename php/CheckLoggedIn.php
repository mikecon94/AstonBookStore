<?php
  session_start();
  //If the user isn't logged in then redirect to login page.
  if(!isset($_SESSION['username'])){
    header('location: /DC2410/coursework/login.php');
  }
 ?>

<?php
/*This script is used to check if a user is logged in. If the user is not
  logged in then they are redirected to the login page. This script should be
  required on every page apart from login and register. */

  session_start();
  //Session variable would have been set on login so if it isn't then
  //return to login page.
  if(!isset($_SESSION['username'])){
    header('location: /DC2410/coursework/login.php');
  }
 ?>

<?php
  //Destroys all session variables and redirects the user to the login page.
  session_start();
  session_unset();
  session_destroy();
  header('Location: ../login.php');
?>

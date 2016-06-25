<?php
  /* As the name suggests, this script is used to log a user out. It destroys
     all session variables and then redirects the user to the login page. */
  session_start();
  session_unset();
  session_destroy();
  header('Location: ../login.php');
?>

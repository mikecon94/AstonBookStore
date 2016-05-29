<?php
  /*This script is included on pages which only staff should be able to access.
    It checks the type of the user and if they are not staff then they are
    redirected to the index/welcome page.*/
  if($_SESSION['type'] !== 'Staff'){
    header('Location: /DC2410/coursework/index.php');
  }
?>

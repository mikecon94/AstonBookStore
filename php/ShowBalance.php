<?php
  /*This script simply grabs the users balance and echos it.
    The balance isn't stored in a session variable as it is likely to change
    more often than other values and we don't want to show the user
    an incorrect value.*/

  require_once 'CheckLoggedIn.php';
  require_once 'InitDb.php';

  try{
    $rows = $db->query("SELECT balance FROM user WHERE user_id = {$_SESSION['id']}");
    $row = $rows->fetch();
    echo '£' . $row['balance'];
  } catch(PDOException $e){
    echo 'Error retrieving balance';
    error_log('Database Error: ' . $e);
  }
?>

<?php
  /*This script grabs the users balance and echos it. It is used in the header.php
    script to display the balance on every page.
    We don't use a session variable for the balance as it is more likely to change
    than the other variables (eg. username) and we don't want to display an
    incorrect balance to the user. */

  require_once 'CheckLoggedIn.php';
  require_once 'InitDb.php';

  try{
    $rows = $db->query("SELECT balance FROM user WHERE user_id = {$_SESSION['id']}");
    $row = $rows->fetch();
    //The balance in the db is decimal(10,2) so it is returned in the format
    //0.00. We prefix this with a £ symbol.
    echo '£' . $row['balance'];
  } catch(PDOException $e){
    echo 'Error retrieving balance';
    error_log('Database Error: ' . $e);
  }
?>

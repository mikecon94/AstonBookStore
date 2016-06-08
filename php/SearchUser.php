<?php
  require_once 'StaffAccess.php';

  //This is used later in the page so we know whether to display the basket or not.
  $success = false;
  if($_GET['operation'] == 'searchuser' || $_GET['operation'] == 'purchase'){
    $username = htmlspecialchars($_GET['username']);

    if(empty($username)){
      echo '<div class="center">Username can not be blank.</div>';
    } else {
      require_once 'InitDb.php';

      $dbuser = $db->quote($username);
      try{
        $rows = $db->query("SELECT user_id, balance FROM user WHERE username = $dbuser");
        if($rows->rowCount() == 1){
          $row = $rows->fetch();
          $userid = $row['user_id'];
          $balance = $row['balance'];
          $success = true;
        } else {
          echo '<div class="center">User not found.</div>';
        }

      } catch(PDOException $e){
        echo '<div class="center">Database error, please try again.</div>';
        error_log('Database Error: ' . $e);
      }

    }
  }
?>

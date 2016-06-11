<?php
  require_once 'StaffAccess.php';

  //This is used later in the page so we know whether to display the basket or not.
  $userfound = false;
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
          $userfound = true;
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
<form method="get" action="<?php echo $_SERVER['PHP_SELF'] ?>">
  <div class="center">
    <input type="text" name="username" placeholder="Username" style="width: 200px;" value="<?php echo $username;?>" autofocus class="center">
    <input type="hidden" name="operation" value="searchuser">
    <input type="submit" value="Find User" style="height: 40px; margin-left: 10px;">
  </div>
</form>

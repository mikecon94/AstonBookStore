<?php
  /*This script is used to search for users on the complete purchase page.
    It displays the form on the page and when it's submitted the script will
    populate variables with user information for later use, or display an error
    if the user cannot be found.*/

  require_once 'StaffAccess.php';

  //This is used later in the page so we know whether to display the basket or not.
  $userfound = false;

  //If the operation isn't set to one of these then we don't attempt to search
  //for a user as the user hasn't submitted the form yet.
  if($_GET['operation'] == 'searchuser' || $_GET['operation'] == 'purchase'){

    //It is a sticky form so we prepare the variable to be shown in the forma again.
    $username = htmlspecialchars($_GET['username']);

    //Display an error as the form has been submitted with a blank username.
    if(empty($username)){
      echo '<div class="center">Username can not be blank.</div>';
    } else {
      require_once 'InitDb.php';

      $dbuser = $db->quote($username);
      try{
        $rows = $db->query("SELECT user_id, balance FROM user WHERE username = $dbuser");
        if($rows->rowCount() == 1){
          //Set the variables that will be used later in the page and set the
          //boolean userfound to true so later in the page it knows a user
          //was found.
          $row = $rows->fetch();
          $userid = $row['user_id'];
          $balance = $row['balance'];
          $userfound = true;
        } else {
          //If the db didn't return any rows then the username doesn't exist.
          //So we display an error.
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

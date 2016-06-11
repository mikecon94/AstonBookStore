<?php
/*This script is used to validate and sanitise the inputs of the top up
  form. If everything is valid it will connect to the db and update the
  selected users balance. */


//This prevents users directly POSTing to this script and will redirect
//them if they aren't logged in or aren't staff.
require_once 'StaffAccess.php';

$username = htmlspecialchars($_POST['username']);
//It does not matter if the user includes the pound symbol or not.
//We remove it if it is included though.
$amount = trim(htmlspecialchars($_POST['amount']), '£');

if($_POST['operation'] == 'topup'){

  $errors = false;

  if(empty($username)){
    echo '<div class="center">Username can not be blank.</div>';
    $errors=true;
  }

  if(empty($amount) || $amount == 0){
    echo '<div class="center">Amount can not be blank or 0.</div>';
    $errors=true;
  } else if(!is_numeric($amount)){
    echo '<div class="center">Amount must be a number.</div>';
    $errors=true;
  } else {
    /*Check the submitted amount is at most 2 decimal places.
      To do this we multiply by 100, and cast to int to truncate the extract
      decimals that would be in a position higher than 2.
      We then divide by 100 and check if the new amount equals the original
      amount if not then there are too many decimals. */
    $testamount = (int) ($amount * 100);
    $testamount = $testamount / 100;
    if($amount != $testamount){
      echo '<div class="center">Amount can\'t be more than 2 decimal places.</div>';
      $errors=true;
    }
  }

  if(!$errors){
    require_once 'InitDb.php';
    $dbusername = $db->quote($username);

    try{
      //Retrieve all the users details now as they will be stored
      //in the session variable if the login is successful.
      $rows = $db->query("SELECT user_id, balance FROM user WHERE username = $dbusername");
      if($rows->rowCount() == 0){
        echo '<div class="center">Username not found.</div>';
      } else {
        $user = $rows->fetch();
        $userid = $user['user_id'];
        $newbalance = $user['balance'] + $amount;

        $db->exec("UPDATE user SET balance = $newbalance WHERE user_id = $userid");

        echo "<div class=\"center\">User topped up successfully.</div>";
        //Reset the sticky values as presumably they won't need to top
        //the same user up again.
        $username = '';
        $amount = '';
      }
    } catch(PDOException $e){
      echo '<div class="center">Database error, please try again.</div>';
      error_log('Database Error: ' . $e);
    }
  }
}
?>

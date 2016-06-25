<?php
/*This script is used to validate and sanitise the inputs of the top up
  form. If everything is valid it will connect to the db and update the
  selected users balance. */

//This prevents users directly POSTing to this script and will redirect
//them if they aren't logged in or aren't staff.
require_once 'StaffAccess.php';

$username = htmlspecialchars($_POST['username']);
//Remove the £ symbol if one is included, we store the value in the db as a
//decimal.
$amount = trim(htmlspecialchars($_POST['amount']), '£');

//If the operation is not set to topup then the form hasn't been submitted Yaf_Exception
//so we don't try to validate and update the db.
if($_POST['operation'] == 'topup'){

  $errors = false;

  if(empty($username)){
    echo '<div class="center">Username can not be blank.</div>';
    $errors=true;
  }

  if(empty($amount) || $amount == 0){
    echo '<div class="center">Amount can not be blank or 0.</div>';
    $errors = true;
  } else if(!is_numeric($amount)){
    echo '<div class="center">Amount must be a number.</div>';
    $errors = true;
  } else {
    /*Check the submitted amount is at most 2 decimal places.
      To do this we multiply by 100, and cast to int which truncates the extra
      decimals that would be more than 2 decimal places.
      We then divide by 100 and check if the new amount equals the original
      amount if not then there are too many decimals. */
    $testamount = (int) ($amount * 100);
    $testamount = $testamount / 100;
    if($amount != $testamount){
      echo '<div class="center">Amount can\'t be more than 2 decimal places.</div>';
      $errors = true;
    }

    //Limit the amount a user can be topped up by at a time.
    //This helps prevent a user submitting a number to high (ie. above 2^32)
    if($amount > 100){
      echo '<div class="center">Amount can\'t be more than £100.</div>';
      $errors = true;
    } else if($amount <=0){
      echo '<div class="center">Amount can\'t be negative or 0.</div>';
      $errors = true;
    }
  }

  if(!$errors){
    require_once 'InitDb.php';
    $dbusername = $db->quote($username);

    try{
      $rows = $db->query("SELECT user_id, balance FROM user WHERE username = $dbusername");
      if($rows->rowCount() == 0){
        echo '<div class="center">Username not found.</div>';
      } else {
        $user = $rows->fetch();
        $userid = $user['user_id'];

        //Update the balance.
        $db->exec("UPDATE user SET balance = balance + $amount WHERE user_id = $userid");

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

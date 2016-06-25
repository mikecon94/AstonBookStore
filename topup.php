<?php
  require_once 'php/Header.php';
  require_once 'php/StaffAccess.php';
?>

<h2 class="center">Top Up a User</h2>
<div class="center">
  <div>
    <form method="post" action="topup.php">
        <?php require_once 'php/ValidateTopUp.php' ?>
        <input type="text" name="username" placeholder="Username" value="<?php echo $username;?>" style="width: 200px;" autofocus class="center">
        <input type="text" name="amount" placeholder="Amount to top up" value="<?php echo $amount;?>" style="width: 200px;" class="center">
        <input type="hidden" name="operation" value="topup">
        <div class="center">
          <input type="submit" value="Top Up User" style="height: 40px; margin-left: 10px;">
        </div>
    </form>
  </div>
</div>
</body>
</html>

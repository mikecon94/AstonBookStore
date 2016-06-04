<?php require_once 'php/Header.php'; ?>
<?php require_once 'php/StaffAccess.php' ?>

<div class="center">
  <div>
    <h2 class="center">Complete a Purchase</h2>
    <div class="center">
      <div>
        <?php require_once 'php/SearchUser.php' ?>
        <form method="get" action="purchase.php">
          <div class="center">
            <input type="text" name="username" placeholder="Username" style="width: 200px;" value="<?php echo $username;?>" autofocus class="center">
            <input type="hidden" name="operation" value="searchuser">
            <input type="submit" value="Find User" style="height: 40px; margin-left: 10px;">
          </div>
        </form>

        <?php require_once 'php/ViewUsersBasket.php' ?>

      </div>
    </div>
  </div>
</div>

</body>
</html>

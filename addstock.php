<?php require_once 'php/Header.php'; ?>
<?php require_once 'php/StaffAccess.php' ?>
<h2 class="center">Increase Stock</h2>
<div class="center">
  <div>
    <?php
      $errors = false;
      if(empty($_GET['isbn'])){
        echo "<div>ISBN can not be empty.</div>";
        echo '<div class="center"><button type="button" onclick=\'location.href="books.php"\' class="btn btn-primary">Return to Books</button></div>';
        $errors = true;
      } else {
        require_once 'php/InitDb.php';
        try{
          $isbn = $db->quote($_GET['isbn']);
          $rows = $db->query("SELECT title, authors, quantity FROM book
                              WHERE book_id = $isbn");
          if($rows->rowCount() == 0){
            echo "<div>ISBN not found.</div>";
            echo '<div class="center"><button type="button" onclick=\'location.href="books.php"\' class="btn btn-primary">Return to Books</button></div>';
            $errors = true;
          } else {
            $book = $rows->fetch();
            echo "<div class=\"center\">Title: {$book['title']}</div>";
            echo "<div class=\"center\">Authors: {$book['authors']}</div>";
            echo "<div class=\"center\">Current Quantity: {$book['quantity']}</div>";
          }
        } catch(PDOException $e){
          echo '<div class="center">Database error, please try again.</div>';
          error_log('Database Error: ' . $e);
        }
      }

      if(!$errors){
        ?>
        <form method="post" action="addbook.php">
          <div class="center">
            <input type="text" name="new_quantity" placeholder="Amount to add to stock" autofocus class="center" size="30">
          </div>
          <div class="center">
            <input type="submit" value="Increase Stock" >
          </div>
        </form>
      <?php
      }
     ?>
  </div>
</div>

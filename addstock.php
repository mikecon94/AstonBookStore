<?php
  /*This page is given an isbn in a GET parameter and if it is a valid isbn
    that exists in the db then the user will be able to increase the amount in
    stock for that book. */
  require_once 'php/Header.php';
  require_once 'php/StaffAccess.php';
?>
<h2 class="center">Increase Stock</h2>
<div class="center">
  <div>
    <?php
      $errors = false;
      //Validate an isbn has been passed.
      if(empty($_GET['isbn'])){
        echo "<div>ISBN can not be empty.</div>";
        echo '<div class="center"><button type="button" onclick=\'location.href="books.php"\' class="btn btn-primary">Return to Books</button></div>';
        $errors = true;
      } else {
        require_once 'php/InitDb.php';
        try{
          $isbn = $db->quote($_GET['isbn']);
          $rows = $db->query("SELECT book_id, title, authors, quantity FROM book
                              WHERE book_id = $isbn");
          //Check the book/isbn exists in the database.
          if($rows->rowCount() == 0){
            echo "<div>ISBN not found.</div>";
            echo '<div class="center"><button type="button" onclick=\'location.href="books.php"\' class="btn btn-primary">Return to Books</button></div>';
            $errors = true;
          } else {
            $book = $rows->fetch();
            //Display the books information so the user can validate they selected
            //the correct book.
            echo "<div class=\"center\">Title: {$book['title']}</div>";
            echo "<div class=\"center\">Authors: {$book['authors']}</div>";

            //If the operation is increase_stock then the user has submitted
            //the form to increase the amount of stock.
            if(!empty($_POST['operation']) && $_POST['operation'] == 'increase_stock'){
              //Check quantity submitted is a whole number.
              if(ctype_digit($_POST['quantity'])){
                if($_POST['quantity'] < 100){
                  //Increase the amount in stock and display a message saying so.
                  $db->exec("UPDATE book SET quantity = quantity + {$_POST['quantity']} WHERE book_id = $isbn");
                  $message = "<div class=\"center\">Quantity Increased.</div>";
                  $rows = $db->query("SELECT book_id, quantity FROM book
                                      WHERE book_id = $isbn");
                  $book = $rows->fetch();
                } else {
                  $message = "<div class=\"center\">Amount must be less than 100.</div>";
                }
              } else {
                $message = "<div class=\"center\">Amount must be a whole number.</div>";
              }
            }
            echo "<div class=\"center\">Current Quantity: {$book['quantity']}</div>";
            echo $message;
          }
        } catch(PDOException $e){
          echo '<div class="center">Database error, please try again.</div>';
          error_log('Database Error: ' . $e);
          $errors = true;
        }
      }

      //If there are no errors validating the isbn then we can display the Books
      //information and the form to allow the staff member to increase the
      //amount in stock.
      if(!$errors){
        ?>
        <form method="post" action="addstock.php?isbn=<?php echo $book['book_id']?>">
          <div class="center">
            <input type="text" name="quantity" placeholder="Amount to add to stock" autofocus class="center" size="30">
            <input type="hidden" name="operation" value="increase_stock">
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

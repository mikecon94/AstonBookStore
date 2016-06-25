<?php
  /*This script is used by the purchase.php page. The variable $userid is set
    earlier in the page and used in this script to grab the users basket contents
    and displays them in a table. */

  require_once 'StaffAccess.php';
  require_once 'InitDb.php';

  //This variable is set in the search user funcion, if this is true then the user
  //has been found and we can display the basket.
  if($userfound){

    try{
      $userid = $db->quote($userid);
      //Grab all the books from the chosen users basket.
      $rows=$db->query("SELECT SUM(book.price) AS total FROM book
                INNER JOIN basket ON book.book_id = basket.book_id
                WHERE user_id = $userid");
      $row=$rows->fetch();

      $total = $row['total'];
      if($total == ''){
        $total = 0;
      }

      echo '<div class="center">';
      $new_balance = $balance;
      $purchase_success = false;
      //If the operation is purchase then we need to complete the purchase.
      if($_GET['operation'] == 'purchase'){
        //Check the user has enough balance
        if($balance >= $total){
          if($total > 0){
            //Subtract the total from the users balance
            $new_balance = $balance - $total;
            $db->exec("UPDATE user SET balance = $new_balance WHERE user_id = $userid");

            //Remove the books from the users basket
            $rows = $db->query("SELECT basket_id FROM basket WHERE user_id = $userid");
            foreach($rows as $row){
              $id = $row['basket_id'];
              $db->exec("DELETE FROM basket WHERE basket_id = $id");
            }
            $purchase_success = true;
          }
        }
      }
      echo '</div>';
      if($purchase_success){
        //The basket total will be 0 as the purchase was completed.
        $total = '0.00';
        echo '<div class="center">Basket Total: £' . $total . '</div>';
        echo '<div class="center">Users Balance: £' . $new_balance . '</div>';
        echo '<div class="center">';
        echo 'Purchase was successful.';
      } else if($balance < $total){
        //The balance isn't enough to cover the transaction so we display
        //a disabled button informing the user.
        echo '<div class="center">Basket Total: £' . $total . '</div>';
        echo '<div class="center">Users Balance: £' . $new_balance . '</div>';
        echo '<div class="center">';
        echo '<button type="button" style="margin-bottom: 10px;" class="btn btn-primary disabled">Balance Not Enough</button>';
      } else if($total == 0){
        //The basket is empty.
        echo '<div class="center">Basket Total: £0.00</div>';
        echo '<div class="center">Users Balance: £' . $new_balance . '</div>';
        echo '<div class="center">';
        echo '<button type="button" style="margin-bottom: 10px;" class="btn btn-primary disabled">Basket Is Empty</button>';
      } else{
        //Give the user the option to complete the purchase.
        echo '<div class="center">Basket Total: £' . $total . '</div>';
        echo '<div class="center">Users Balance: £' . $new_balance . '</div>';
        echo '<div class="center">';
        echo '<button type="button" style="margin-bottom: 10px;" onclick=\'location.href="?username=' . $username . '&operation=purchase"\' class="btn btn-primary">Complete Purchase</button>';
      }
      echo '</div>';

      //If the total is 0 then it suggests the basket is empty.
      //This assume no books are free. If it isn't 0 then we display the books
      //in a table.
      if($total != 0){
        ?>
        <div class="center">
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th>Image</th>
                  <th>Name</th>
                  <th>Authors</th>
                  <th>Categories</th>
                  <th>Price</th>
                </tr>
              </thead>
              <tbody>
        <?php

        $rows = $db->query("SELECT book.book_id, title, authors, price, image
          FROM book INNER JOIN basket on basket.book_id = book.book_id
          WHERE basket.user_id = $userid
          ORDER BY title");
        $total = 0;
        foreach($rows as $row){
          echo '
          <tr>
            <td><img src="data:image/jpeg;base64, ' . base64_encode($row['image']) . '" style="width: 100px;"></td>
            <td>' . $row['title'] . '</td>
            <td>' . $row['authors'] . '</td>
            <td>';

            //Query to get the books categories
            $categories = $db->query("SELECT category.name FROM category
              INNER JOIN book_category on category.category_id = book_category.category_id
              INNER JOIN book on book.book_id = book_category.book_id
              WHERE book.book_id = {$row['book_id']}
              ORDER BY category.name");
            foreach($categories as $category){
              echo $category['name'] . '<br>';
            }
            $total += $row['price'];
            echo '</td> <td>£' . $row['price'] . '</td>';
            echo '</tr>';
        }
      }
    } catch (PDOException $e){
      echo '<div class="center">Database error, please try again.</div>';
      error_log('Database Error: ' . $e);
    }
  }
?>
</tbody>
</table>
</div>

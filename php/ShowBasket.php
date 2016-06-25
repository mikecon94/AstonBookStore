<?php
/*This script is used on the basket.php script. It displays a table of information
  about the books in the users basket. */

require_once 'CheckLoggedIn.php';
require_once  'InitDb.php';

try{

  //We don't sanitise the session ID variable as it is set on login and grabbed
  //from the database so it is fair to assume it is safe.
  $rows = $db->query("SELECT book.book_id, title, authors, price, image
    FROM book INNER JOIN basket on basket.book_id = book.book_id
    WHERE basket.user_id = {$_SESSION['id']}
    ORDER BY title");

  //If there are books in the basket then we will display the table of them.
  if($rows->rowCount() > 0){?>
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
    //Used to get a running total of the basket value.
    $total = 0;
    foreach($rows as $row){
      //Add a new row to the table for each book in the basket.
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
        //Books can have multiple categories so we loop round and add each one
        //into the table of information
        foreach($categories as $category){
          echo $category['name'] . '<br>';
        }
        $total += $row['price'];
        echo '</td> <td>£' . $row['price'] . '</td>';
        echo '<td><button type="button" onclick=\'location.href="php/RemoveFromBasket.php?isbn=' . $row['book_id'] . '"\' class="btn btn-primary">Remove</button></td>';
        echo '</tr>';
    }
    //By having this within the table it is displayed at the top of the page.
    echo '<div class="center">Total: £' . $total . '</div></tbody></table></div>';
  } else {
    echo "Basket is empty.";
  }
} catch (PDOException $e){
  echo '<div class="center">Database error, please try again.</div>';
  error_log('Database Error: ' . $e);
}

?>

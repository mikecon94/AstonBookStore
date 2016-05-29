<?php
include_once 'CheckLoggedIn.php';

//Query the database for books.
include_once  'InitDb.php';

try{
  //Check ISBN is unique
  $rows = $db->query("SELECT book_id, title, authors, quantity, price, description, image
    FROM book ORDER BY book.title");
  foreach($rows as $row){
    echo '
    <tr>
      <td><img src="data:image/jpeg;base64, ' . base64_encode($row['image']) . '" style="width: 100px;"></td>
      <td>' . $row['title'] . '</td>
      <td>' . $row['authors'] . '</td>
      <td>' . $row['description'] . '</td>
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

      echo '</td>
      <td>' . $row['book_id'] . '</td>
      <td>£' . $row['price'] . '</td>
      <td>' . $row['quantity'] . '</td>';

    if($row['quantity'] > 0){
      echo '<td><button type="button" onclick=\'location.href="#"\' class="btn btn-primary">Add to basket</button></td>';
    } else {
      echo '<td><button type="button" class="btn btn-primary disabled">Out of stock</button></td>';
    }
    echo '</tr>';
  }
} catch (PDOException $e){
  echo '<div class="center">Database error, please try again.</div>';
  error_log('Database Error: ' . $e);
}

?>

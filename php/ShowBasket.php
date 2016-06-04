<?php
require_once 'CheckLoggedIn.php';
require_once  'InitDb.php';

try{

  $rows = $db->query("SELECT book.book_id, title, authors, price, image
    FROM book INNER JOIN basket on basket.book_id = book.book_id
    WHERE basket.user_id = {$_SESSION['id']}
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
      echo '<td><button type="button" onclick=\'location.href="php/RemoveFromBasket.php?isbn=' . $row['book_id'] . '"\' class="btn btn-primary">Remove</button></td>';
      echo '</tr>';
  }
  echo '<div class="center">Total: £' . $total . '</div>';
} catch (PDOException $e){
  echo '<div class="center">Database error, please try again.</div>';
  error_log('Database Error: ' . $e);
}

?>

<?php
require_once 'CheckLoggedIn.php';

//Query the database for books.
require_once  'InitDb.php';

try{

  $sortby = "book.title";
  if(isset($_POST['sort'])){
    if( $_POST['sort'] == "authors"){
      $sortby = "book.authors";
    } else if($_POST['sort'] == "price"){
      $sortby = "book.price";
    } else if ($_POST['sort'] == "isbn"){
      $sortby = "book.book_id";
    }
  }

  $rows = $db->query("SELECT book_id, title, authors, quantity, price, description, image
    FROM book ORDER BY $sortby");
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

    //Add check to see whether it is already in the users basket.
    if($row['quantity'] > 0){
      echo '<td><button type="button" onclick=\'location.href="php/ValidateAddBasket.php?isbn=' . $row['book_id'] . '"\' class="btn btn-primary">Add to basket</button></td>';
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

<?php
/*This script is used on the books.php page. It grabs all the books in the
  database and generates a table on the page to display them and the information.
*/

require_once 'CheckLoggedIn.php';
require_once  'InitDb.php';

try{

  //Default to order the books is by title. There is a form on the page that
  //allows a user to select a different attribute to sort by. We set this odbc_setoption
  //here and then use it in the query.
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

  //Get all the books from the db.
  //No need to sanitise the $sortby variable as it is hardcoded above.
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

    //Check the book is in stock.
    if($row['quantity'] > 0){
      //Display a button to add to basket passing the isbn as a get parameter.
      echo '<td><button type="button" onclick=\'location.href="php/ValidateAddBasket.php?isbn=' . $row['book_id'] . '"\' class="btn btn-primary">Add to basket</button></td>';
    } else {
      //Display a disabled button with the message "Out of stock"
      echo '<td><button type="button" class="btn btn-primary disabled">Out of stock</button></td>';
    }
    //If the user is staff then they have the ability to increase the amount in stock.
    if($_SESSION['type'] == 'Staff'){
      echo '<td><button type="button" onclick=\'location.href="addstock.php?isbn=' . $row['book_id'] . '"\' class="btn btn-primary">Increase Stock</button></td>';
    }

    echo '</tr>';
  }
} catch (PDOException $e){
  echo '<div class="center">Database error, please try again.</div>';
  error_log('Database Error: ' . $e);
}

?>

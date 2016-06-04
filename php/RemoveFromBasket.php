<?php
  require_once 'CheckLoggedIn.php';
  require_once 'InitDb.php';

  $isbn = $db->quote($_GET['isbn']);
  try{
    $rows = $db->query("SELECT basket_id, book.quantity FROM basket
      INNER JOIN book on basket.book_id = book.book_id
      WHERE book.book_id = $isbn");

    //Check the book is in already in the basket, if not redirect.
    if($rows->rowCount() == 0){
      redirect("Book not in basket. Redirecting...");
      exit();
    }
    $row = $rows->fetch();

    //Remove from basket
    $db->exec("DELETE FROM basket WHERE basket_id = {$row['basket_id']}");

    //Add one back to the books stock from the books stock.
    $quantity = $row['quantity'] + 1;
    $db->exec("UPDATE book SET quantity = $quantity WHERE book_id = $isbn");

    header('location: ../basket.php');

  } catch (PDOException $e){
    error_log('Database Error: ' . $e);
    redirect("Database Error. Redirecting...");
  }

  function redirect($message){
    echo $message;
    echo "<script>setTimeout(\"location.href = '../basket.php';\",1500);</script>";
  }

?>

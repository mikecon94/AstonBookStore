<?php
  require_once 'CheckLoggedIn.php';
  require_once 'InitDb.php';

  $isbn = $db->quote($_GET['isbn']);
  try{
    $rows = $db->query("SELECT book_id, quantity FROM book WHERE book_id = $isbn");

    //Check the book exists
    if($rows->rowCount() == 0){
      redirect("Book not found. Redirecting...");
      exit();
    }
    $book = $rows->fetch();

    //Check the book is in stock
    if($book['quantity'] == 0){
      redirect("Book not in stock. Redirecting...");
      exit();
    }

    //We only check the users balance when the staff member tries to complete
    //the transaction
    //Check the user doesn't already have this book in their basket
    $userid = $db->quote($_SESSION['id']);
    $bookid = $db->quote($book['book_id']);
    $rows = $db->query("SELECT basket_id FROM basket
        WHERE user_id = $userid AND book_id = $bookid");

    if($rows->rowCount() > 0){
      //The book is already in the users basket.
      redirect("This book is already in your basket. Redirecting...");
      exit();
    }

    //Insert a row into the basket table
    $db->exec("INSERT INTO basket(user_id, book_id)
              VALUES ($userid, $bookid)");

    //Reduce one from the books stock.
    $quantity = $book['quantity'] - 1;
    $bookid = $book['book_id'];
    $db->exec("UPDATE book SET quantity = $quantity WHERE book_id = $bookid");

    header('location:../basket.php');

  } catch (PDOException $e){
    error_log('Database Error: ' . $e);
    redirect("Database Error. Redirecting...");
  }

  function redirect($message){
    echo $message;
    echo "<script>setTimeout(\"location.href = '../books.php';\",1500);</script>";
  }

?>

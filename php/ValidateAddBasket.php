<?php
  /*This script is used to add a book to basket. It checks the book exists and
    is in stock and adds it to the users basket and reduces the stock by one.
    As per the requirements, the users balance is not checked until a staff
    member tries to complete the purchase. */

  require_once 'CheckLoggedIn.php';
  require_once 'InitDb.php';

  //A malicious user could hit the script directly with the isbn GET parameter
  //So we sanitise it for use in the query.
  $isbn = $db->quote($_GET['isbn']);
  try{
    $rows = $db->query("SELECT book_id, quantity FROM book WHERE book_id = $isbn");

    //Check the book exists
    if($rows->rowCount() == 0){
      redirect("Book not found. Redirecting...");
      exit();
    }

    //We assume the first result is the correct book. book_id is unique in the db
    //so it should be the only book in the results.
    $book = $rows->fetch();

    //Check the book is in stock
    if($book['quantity'] == 0){
      redirect("Book not in stock. Redirecting...");
      exit();
    }

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

  //Helper function that displays a passed string (errors) and then redirects
  //to the books.php page after 1.5 seconds.
  function redirect($message){
    echo $message;
    echo "<script>setTimeout(\"location.href = '../books.php';\",1500);</script>";
  }

?>

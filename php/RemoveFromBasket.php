<?php
  /*This page is linked to from the basket page. It is given an isbn as a
    a GET parameter and then removes it from the users basket if it exists. */
  require_once 'CheckLoggedIn.php';
  require_once 'InitDb.php';

  //Make sure the passed variables are safe to use in a db query.
  $isbn = $db->quote($_GET['isbn']);
  $userid = $db->quote($_SESSION['id']);
  try{

    //Query the db to check the book is in the users basket.
    $rows = $db->query("SELECT basket_id, book.quantity FROM basket
      INNER JOIN book on basket.book_id = book.book_id
      WHERE book.book_id = $isbn
      AND user_id = $userid");

    //If row count is 0 then the book wasn't in the users basket so we display
    //a message and redirect them.
    if($rows->rowCount() == 0){
      redirect("Book not in basket. Redirecting...");
      exit();
    }
    $row = $rows->fetch();

    //Remove from basket
    $db->exec("DELETE FROM basket WHERE basket_id = {$row['basket_id']}");

    //Add one back to the books stock quantity as we removed one when the user
    //added it to their basket.
    $db->exec("UPDATE book SET quantity = quantity + 1 WHERE book_id = $isbn");

    header('location: ../basket.php');

  } catch (PDOException $e){
    error_log('Database Error: ' . $e);
    redirect("Database Error. Redirecting...");
  }

  //Helper function that displays a passed string (error messages) to the user
  //and then redirects to the basket page.
  function redirect($message){
    echo $message;
    echo "<script>setTimeout(\"location.href = '../basket.php';\",1500);</script>";
  }

?>

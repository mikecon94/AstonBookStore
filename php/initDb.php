<?php
  //By using this file and including it in many other files we can change
  //these settings just once.
  $db = new PDO("mysql:dbname=aston_book_store;host=localhost","phpuser","JuFMU28C2CVjy7z6");
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // $results = $db->query("SELECT * FROM user");
  //
  // foreach($results as $row){
  //   echo $row['username'];
  // }
?>

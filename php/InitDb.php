<?php
  /*This script is used by any page that needs to access the database.
    It can simply be included/required and then the page will have access to
    the $db variable already connected. This allows us to quickly make changes
    to any connection settings in one place.
  */
  $db = new PDO("mysql:dbname=aston_book_store;host=localhost","phpuser","JuFMU28C2CVjy7z6");
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>

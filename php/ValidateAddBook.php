<?php
/*This script validates the data that has been posted in the addbook form.
  It removes any illegal chars and inserts the data into the database.*/

//This prevents users directly POSTing to this script and will redirect
//them if they aren't logged in or aren't staff.
require_once 'StaffAccess.php';

//A future improvement could be to have php dynamically insert the categories
//into the html based on categories in the database.

//Used so the multiselect will remain a sticky form.
function checkSelected($checkCategory){
  if(isset($_POST['categories'])){
    foreach ($_POST['categories'] as $category){
      if($checkCategory == $category){
        echo 'selected';
        return;
      }
    }
  }
}

//Remove whitespace and dashes from the isbn.
$isbn = preg_replace('/\s+/','', htmlspecialchars($_POST['isbn']));
$isbn = preg_replace('/-/' , '', $isbn);
$title = htmlspecialchars($_POST['title']);
$authors = htmlspecialchars($_POST['authors']);
//Remove the pound symbol
$price = trim(htmlspecialchars($_POST['price']), '£');
$quantity = htmlspecialchars($_POST['quantity']);
$description = htmlspecialchars($_POST['description']);

if($_POST['operation'] == 'addbook'){

  //Track if there are validation errors and if so don't send to db.
  $errors = false;

  //An additional check is checking the isbns checksum digit.
  //This will be added if there is enough time.
  if(empty($isbn)){
    echo '<div class="center">IBSN can not be blank.</div>';
    $errors=true;
  } else if(!ctype_digit($isbn)){
    echo '<div class="center">IBSN must only contain digits.</div>';
    $errors=true;
  }
  if(empty($title)){
    echo '<div class="center">Title can not be blank.</div>';
    $errors=true;
  }
  if(empty($authors)){
    echo '<div class="center">Authors can not be blank.</div>';
    $errors=true;
  }
  if(empty($price)){
    echo '<div class="center">Price can not be blank.</div>';
    $errors=true;
  } else if(!preg_match('/^[0-9]+(.[0-9]+)?$/', $price)){
    echo '<div class="center">Price must be in the format 9.99</div>';
    $errors=true;
  }
  if(!ctype_digit($quantity)){
    echo '<div class="center">Quantity must be a whole number.</div>';
    $errors=true;
  }

  if(empty($description)){
    echo '<div class="center">Description can not be blank.</div>';
    $errors=true;
  }
  if(!isset($_POST['categories'])){
    echo '<div class="center">Please choose a category.</div>';
    $errors=true;
  }

  /*Check the file type is that of an image (jpeg or png)
    Also check the file extension is that of an image.
    This prevents malicious users uploading malicious files.*/
  $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
  if(!is_uploaded_file($_FILES['image']['tmp_name'])){
    echo '<div class="center">Please upload an image.</div>';
    $errors=true;
  } else if(!(($_FILES['image']['type'] == 'image/jpeg'
    || $_FILES['image']['type'] == 'image/png')
    && ($ext == 'png' || $ext == 'jpg' || $ext == 'jpeg'))){
      echo '<div class="center">Image must be png or jpeg.</div>';
      $errors=true;
  }

  if(!$errors){
    require_once 'InitDb.php';

    //Sanitise the inputs before using them on db queries.
    $dbisbn = $db->quote($isbn);
    $dbtitle = $db->quote($title);
    $dbauthors = $db->quote($authors);
    $dbprice = $db->quote($price);
    $dbquantity = $db->quote($quantity);
    $dbdescription = $db->quote($description);
    $dbimagename = $db->quote($_FILES['image']['name']);
    $dbimagecontents = $db->quote(file_get_contents($_FILES['image']['tmp_name']));

    try{
      //Check ISBN is unique
      $rows = $db->query("SELECT book_id FROM book WHERE book_id = $dbisbn");
      if($rows->rowCount() > 0){
        echo '<div class="center">ISBN already exists in catalog.</div>';
      } else {

        $category_ids = array();
        $invalid_category = false;
        //Check the POSTed categories are valid.
        foreach($_POST['categories'] as $category){
          $category = $db->quote($category);
          $rows = $db->query("SELECT category_id FROM category WHERE name = $category");
          if($rows->rowCount() == 0){
            echo '<div class="center">' . $category . ' is an invalid category.</div>';
            $invalid_category = true;
          } else {
            //Grab the categorys id and store it... it will be needed when
            //we insert into the db.
            $row = $rows->fetch();
            $category_ids[] = $row['category_id'];
          }
        }

        if(!$invalid_category){
          //Insert into db.
          $db->exec("INSERT INTO book (book_id, title, authors, quantity, price, description, image, image_name)
                    VALUES ($dbisbn, $dbtitle, $dbauthors, $dbquantity, $dbprice, $dbdescription, $dbimagecontents, $dbimagename)");
          //Insert the books categories.
          foreach($category_ids as $category_id){
            $db->exec("INSERT INTO book_category (book_id, category_id) VALUES ($dbisbn, '$category_id')");
          }
          //Output success message to user and reset the sticky values.
          echo '<div class="center">Book added to catalog.</div>';
          $isbn = '';
          $title = '';
          $authors = '';
          $price = '';
          $quantity = '';
          $description = '';
          unset($_POST['categories']);
        }

      }
    } catch(PDOException $e){
      echo '<div class="center">Database error, please try again.</div>';
      error_log('Database Error: ' . $e);
    }
  }
}
?>

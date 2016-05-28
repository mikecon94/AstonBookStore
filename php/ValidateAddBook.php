<?php
/*This script validates the data that has been posted in the addbook form.
  It removes any illegal chars and inserts the data into the database.*/

//A future improvement could be to have php dynamically insert the categories
//into the html based on categories in the database.

//Used so the multiselect will "remember" what categories were chosen.
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

}
?>

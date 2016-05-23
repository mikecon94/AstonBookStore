<?php
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
?>

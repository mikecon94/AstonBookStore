<?php require_once 'php/Header.php'; ?>
<?php require_once 'php/StaffAccess.php' ?>
<h2 class="center">Add A New Book To The Store</h2>
  <div class="center">
    <div>
      <?php require_once 'php/ValidateAddBook.php'?>
      <form method="post" action="addbook.php" enctype="multipart/form-data">
        <input type="text" name="isbn" value="<?php echo $isbn;?>" placeholder="ISBN" autofocus class="center" size="30">
        <input type="text" name="title" value="<?php echo $title;?>" placeholder="Title" class="center" size="30">
        <input type="text" name="authors" value="<?php echo $authors;?>" placeholder="Authors" class="center" size="30">
        <input type="text" name="price" value="<?php echo $price;?>" placeholder="Price" class="center" size="30">
        <input type="text" name="quantity" value="<?php echo $quantity;?>" placeholder="Quantity" class="center" size="30">
        <textarea rows="3" name="description" placeholder="Book Description" class="center" cols="31"><?php echo $description;?></textarea>
        <div class="center">
          Categories:
          <select name="categories[]" multiple size="3" style="width: 230px;">
            <?php
              //Generate the category options from the db. This makes it easier
              //to add/remove categories in future.
              require_once 'php/InitDb.php';
              $rows = $db->query("SELECT name FROM category ORDER BY name ASC");
              foreach($rows as $category){
                echo '<option value="' . $category['name'] . '" class="center" ' . checkSelected($category['name']) . '>' . $category['name'] . '</option>';
              }
             ?>
          </select>
        </div>
        <label>Book Image
          <input type="file" name="image"/>
        </label>
        <input type="hidden" name="operation" value="addbook">
        <div class="center">
          <input type="submit" value="Add Book" >
        </div>
      </form>
    </div>
  </div>
</body>
</html>

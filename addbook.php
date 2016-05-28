<?php include 'php/Header.php'; ?>
<?php include 'php/StaffAccess.php' ?>
<h2 class="center">Add A New Book To The Store</h2>
  <div class="center">
    <div>
      <?php include 'php/ValidateAddBook.php'?>
      <form method="post" action="addbook.php" enctype="multipart/form-data">
        <input type="text" name="isbn" value="<?php echo $isbn;?>" placeholder="ISBN" autofocus class="center" size="30">
        <input type="text" name="title" value="<?php echo $title;?>" placeholder="Title" class="center" size="30">
        <input type="text" name="authors" value="<?php echo $authors;?>" placeholder="Authors" class="center" size="30">
        <input type="text" name="price" value="<?php echo $price;?>" placeholder="Price" class="center" size="30">
        <textarea rows="3" name="description" placeholder="Book Description" class="center" cols="31"><?php echo $description;?></textarea>
        <div class="center">
          Categories:
          <select name="categories[]" multiple size="3" style="width: 230px;">
            <option value="Business" class="center" <?php checkSelected('Business'); ?>> Business</option>
            <option value="Computing" class="center" <?php checkSelected('Computing'); ?>>Computing</option>
            <option value="Java" class="center" <?php checkSelected('Java'); ?>>Java</option>
            <option value="Mathematics" class="center" <?php  checkSelected('Mathematics'); ?>>Mathematics</option>
            <option value="PHP" class="center" <?php checkSelected('PHP'); ?>>PHP</option>
            <option value="Programming" class="center" <?php checkSelected('Programming'); ?>>Programming</option>
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

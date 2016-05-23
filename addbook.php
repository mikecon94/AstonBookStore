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
      <input type="text" name="category" value="<?php echo $categories;?>" placeholder="Categories (comma separated)" class="center" size="30">
      <input type="text" name="price" value="<?php echo $price;?>" placeholder="Price" class="center" size="30">
      <textarea rows="3" name="description" placeholder="Enter a description of the book." class="center" cols="31"></textarea>
      <input type="file" name="image"/>
      <input type="hidden" name="operation" value="addbook">
      <div class="center">
        <input type="submit" value="Add Book" >
      </div>
    </form>
  </div>
</div>
</div>
</div>
</body>
</html>

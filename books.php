<?php require_once 'php/Header.php'; ?>

<h2 class="center">Books</h2>
<form  method="post" action="books.php" class="center">
  <h3 style="margin-bottom: 40px; margin-right: 10px;">Sort by:</h3>
  <select name="sort" style="height: 40px;">
    <option value="name" <?php if($_POST['sort'] == "name"){ echo "selected"; }?>>Name</option>
    <option value="authors" <?php if($_POST['sort'] == "authors"){ echo "selected"; }?>>Authors</option>
    <option value="price" <?php if($_POST['sort'] == "price"){ echo "selected"; }?>>Price</option>
    <option value="isbn" <?php if($_POST['sort'] == "isbn"){ echo "selected"; }?>>ISBN</option>
  </select>
  <input type="submit" style="height: 40px; margin-left: 10px;" value="Go">
</form>

<div class="center">
<div class="table-responsive">
  <table class="table">
    <thead>
      <tr>
        <th>Image</th>
        <th>Name</th>
        <th>Authors</th>
        <th>Description</th>
        <th>Categories</th>
        <th>ISBN</th>
        <th>Price</th>
        <th>Stock</th>
      </tr>
    </thead>
    <tbody>
      <?php require_once 'php/ShowBooks.php'; ?>
    </tbody>
  </table>

</div>

</div>
</body>
</html>

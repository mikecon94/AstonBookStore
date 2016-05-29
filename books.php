<?php include 'php/Header.php'; ?>

<h2 class="center">Books</h2>

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
        <th>Add to basket</th>
      </tr>
    </thead>
    <tbody>
      <?php include 'php/ShowBooks.php'; ?>
    </tbody>
  </table>
</div>

</div>
</body>
</html>

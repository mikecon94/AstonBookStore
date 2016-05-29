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
        <th>ISBN</th>
        <th>Price</th>
        <th>Stock</th>
        <th>Add to basket</th>
      </tr>
    </thead>
    <tbody>
      <?php include 'php/ShowBooks.php'; ?>
      <tr>
        <td><img src="http://www.planwallpaper.com/static/images/ZhGEqAP.jpg" style="width: 100px;"></td>
        <td>Killer Game Programming</td>
        <td>Andrew Patrick Smith</td>
        <td>Description lalalalallalalalallalalallalala asdasd asdas dasdbadsdadasdasdlka lk wdnsalskndlaksn lkansdlkans lkn alskdnalksndlaksnd</td>
        <td>1001122334455</td>
        <td>£9.99</td>
        <td>10</td>
        <td><button type="button" onclick='location.href="#"' class="btn btn-primary">Add to basket</button></td>
      </tr>
    </tbody>
  </table>
</div>

</div>
</body>
</html>

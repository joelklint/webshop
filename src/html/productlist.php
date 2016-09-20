<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <link rel="stylesheet" type="text/css" href="bootstrapPaper.css">
  </head>
  <body>
    <nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header">
        <a class="navbar-brand" href="#">NäbbShop</a>
      </div>
      <ul class="nav navbar-nav">
        <li ><a href="index.html">Home</a></li>
        <li class="active"><a href="productlist.php">Birds</a></li>
        <li><a href="contact.html">Contact</a></li>
        <li><a href="#">Shoppingcart</a></li>
      </ul>
    </div>
  </nav>

  <div class="col-md-1">
  </div>
  <div class="col-md-10">
<h2> Köp fåglar! Kom igen det blir kul! </h2>

<table class="table table-striped table-hover ">
  <thead>
    <tr>
      <th>#</th>
      <th>Fågelsort</th>
      <th>Beskrivning</th>
      <th>Pris</th>
    </tr>
  </thead>
  <tbody>

<?php
require_once __DIR__ . "/../inc/DatabaseHelper.php";
$db = new DatabaseHelper();

$products = $db->get_all_products();

foreach($products as $thisproduct){
  $id = $thisproduct->id();
  $name = $thisproduct->name();
  $desc = $thisproduct->description();
  $price = "3 miljoner tusen";    //detta ska roppa på price-metoden sen

  echo "<tr onclick=rowclick('". $id ."')>";
  echo "<td>" . $id . "</td>";
  echo "<td>" . $name . "</td>";
  echo "<td>" . $desc . "</td>";
  echo "<td>" . $price . "</td>";
  echo "</tr>";
}

 ?>

  </tbody>
</table>

<div class="col-md-9">
</div>
<div class="col-md-3">
  <a href="#" class="btn btn-default" onclick=goshopping()>Go to Shoppingcart</a>
</div>
<div class="col-md-1">
</div>
  </body>
<script src="productlist.js"></script>
</html>

<?php
session_start();
$method = $_SERVER['REQUEST_METHOD'];
// Handle if product was picked
if($method == 'POST') {
  // Retrieve which product was clicked
  $product_id = $_POST['product_id'];
  // Retrieve cart from session
  if(array_key_exists('shopping_cart', $_SESSION)) {
    $cart = $_SESSION['shopping_cart'];
  }
  else {
    $cart = array();
  }
  // Decide whether to add or remove product
  $action = $_REQUEST['action'];
  if($action == 'add') {
    $cart[$product_id]++;
  }
  elseif($action == 'remove' && $cart[$product_id] > 1 ) {
    $cart[$product_id]--;
  }
  elseif($action == 'remove' && $cart[$product_id] == 1 ) {
    unset($cart[$product_id]);
  }
  $_SESSION['shopping_cart'] = $cart;
}

 ?>

<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <link rel="stylesheet" type="text/css" href="bootstrapPaper.css">
  </head>
  <body>

    <?php
    include __DIR__ . '/navbar.php'
     ?>

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

if(array_key_exists('shopping_cart', $_SESSION)) {
  $cart = $_SESSION['shopping_cart'];
}
else {
  $cart = array();
}

foreach($products as $thisproduct){
  $id = $thisproduct->id();
  $name = $thisproduct->name();
  $desc = $thisproduct->description();
  $price = $thisproduct->price();

  if(array_key_exists($id, $cart)) {
    $amount_in_cart = $cart[$id];
  }
  else {
    $amount_in_cart = 0;
  }

  $button_label = !in_array($id, $cart) ? "Add to cart" : "Remove from cart";
  echo "<tr type='submit'>";
    echo "<td>" . $id . "</td>";
    echo "<td>" . $name . "</td>";
    echo "<td>" . $desc . "</td>";
    echo "<td>" . $price . "</td>";
    echo "<td>";
      echo "<form action='productlist.php' method='POST'>";
        echo "<input name='action' value='remove' style='display:none'>";
        echo "<button name='product_id' value='$id'>-</button>";
      echo "</form>";
    echo "</td>";
    echo "<td>";
      echo $amount_in_cart;
    echo "</td>";
    echo "<td>";
      echo "<form action='productlist.php' method='POST'>";
        echo "<input name='action' value='add' style='display:none'>";
        echo "<button name='product_id' value='$id'>+</button>";
      echo "</form>";
    echo "</td>";
  echo "</tr>";
}

 ?>

  </tbody>
</table>

<div class="col-md-9">
</div>
<div class="col-md-3">

  <a href="shoppingcart.php" class="btn btn-default">Go to Shoppingcart</a>
</div>
<div class="col-md-1">
</div>
  </body>
<script src="productlist.js"></script>
</html>

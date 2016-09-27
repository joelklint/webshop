<?php session_start();
  if(!$_SESSION['username']) {
	header("Location: index.php");
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
  <h2> Shoppingcart </h2>
</br>
<div class="col-md-1">
</div>
<div class="col-md-8">
<ul class="list-group">

  <?php
  require_once __DIR__ . "/../inc/DatabaseHelper.php";
  $db = new DatabaseHelper();
  
  if(array_key_exists('shopping_cart', $_SESSION)) {
    $cart = $_SESSION['shopping_cart'];
  }
  else {
    $cart = array();
  }

  $products = $db->get_products_with_id_numbers(array_keys($cart));

  $sum = 0;

  foreach($products as $thisproduct){
    $id = $thisproduct->id();
    $name = $thisproduct->name();
    $desc = $thisproduct->description();
    $price = $thisproduct->price();

    $units = $cart[$id];

    $sum += $price*$units;

    echo "<li class='list-group-item'><span class='pull-right'>$units x $price</span>$name</li>";

  }
   echo "<div class='col-md-4'></div><div class='col-md-3'><h3> Summa: </h3></div><div class='col-md-5'><h3>". $sum . " kr</h3></div>";

   ?>

</ul>
</div>
</div>
<div class="col-md-7">
</div>
<div class="col-md-3">
  <a href="checkout.php" class="btn btn-default" >Checkout</a>
</div>
<div class="col-md-1">
</div>
</body>
</html>

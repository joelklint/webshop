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
<h2> Checkout </h2>

<?php
  require_once __DIR__ . "/../inc/DatabaseHelper.php";
  $db = new DatabaseHelper();

  if(array_key_exists('shopping_cart', $_SESSION)) {
    $cart = $_SESSION['shopping_cart'];
  } 
  if (count($cart) == 0){
    $cart = array();
	echo '<script type="text/javascript">alert("Cannot checkout with 0 products in the cart!")</script>';
	header("Location: productlist.php");
    die;
  }

  $products = $db->get_products_with_id_numbers($cart);
  $sum = 0;

  foreach($products as $thisproduct){
    $price = $thisproduct->price();
    $sum += $price;
  }
  
	$username = $_SESSION["username"];
	$address = $_SESSION["address"];

	echo "<div class='col-md-2'></div><div class='col-md-1'><h5>Sum: </h5></div><div class='col-md-2'><h5>". $sum . " kr</h5></div>";
	echo "<div class='col-md-2'></div><div class='col-md-1'><h5>Username: </h5></div><div class='col-md-2'><h5>". $username . "</h5></div>";
	echo "<div class='col-md-2'></div><div class='col-md-1'><h5>Address: </h5></div><div class='col-md-2'><h5>". $address . "</h5></div>";
 ?>

<div class="col-md-6">
		<form action="receipt.php" method="POST" class="form-horizontal">
  <fieldset>
    <legend>Enter Valid Payment information</legend>
    <div class="form-group" >
      <label for="inputCardNumber" class="col-lg-2 control-label">Card Number</label>
      <div class="col-lg-10">
        <input type="text" class="form-control" name="inputCardNumber" placeholder="0000 0000 0000 0000">
      </div>
    </div>
    <div class="form-group" >
      <label for="inputCVC" class="col-lg-2 control-label">CVC code</label>
      <div class="col-lg-10">
        <input type="text" class="form-control" name="inputCVC" placeholder="XXX">
      </div>
    </div>
    <div class="form-group">
      <label for="inputName" class="col-lg-2 control-label">Full name</label>
      <div class="col-lg-10">
        <input type="password" class="form-control" name="inputName" placeholder="Full name">
      </div>
    </div>
    <div class="form-group">
      <div class="col-lg-10 col-lg-offset-2">
        <button type="reset" class="btn btn-default">Reset fields</button>
        <button type="submit" class="btn btn-primary">Pay</button>
      </div>
    </div>
  </fieldset>
</form>
</div>
<!--<div class="col-md-8">
</div>
<div class="col-md-3">
  <a href="payment.php" class="btn btn-default" onclick=goshopping()>Pay</a>
</div>
<div class="col-md-1">
</div>-->
  </body>
<script src="productlist.js"></script>
</html>

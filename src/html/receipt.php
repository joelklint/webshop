<?php 
  session_start();
  if(!$_SESSION['username']) {
	header("Location: index.php");
	die();
  }
  $ref = $_SERVER['HTTP_REFERER'];
  if($ref !== 'https://localhost:1337/checkout.php') {
	die("No permission");
  }
?>

<!DOCTYPE HTML>
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
<h2> Your order has been accepted </h2>

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
  $cart = $_SESSION['shopping_cart'];
  $products = $db->get_products_with_id_numbers(array_keys($cart));

  $sum = 0;

foreach($products as $thisproduct){
  $id = $thisproduct->id();
  $name = $thisproduct->name();
  $desc = $thisproduct->description();
  $price = $thisproduct->price();
  $units = $cart[$id];
  $sum += $units*$price;
  echo "<tr type='submit'>";
    echo "<td>" . $id . "</td>";
    echo "<td>" . $name . "</td>";
    echo "<td>" . $desc . "</td>";
    echo "<td>" . $units . "x" . $price . "</td>";
  echo "</tr>";
  }
	unset($_SESSION['shopping_cart']);
	$username = $_SESSION["username"];
	$orderID = $_SESSION['orderid'];

  echo "<div class='col-md-2'></div><div class='col-md-2'><h5>Username: </h5></div><div class='col-md-2'><h5>". $username . "</h5></div><div class='col-md-6'></div>";
  echo "<div class='col-md-12'></div>";
  echo "<div class='col-md-2'></div><div class='col-md-2'><h5>Sum: </h5></div><div class='col-md-2'><h5>". $sum . " kr</h5></div><div class='col-md-6'></div>";
  echo "<div class='col-md-12'></div>";
  echo "<div class='col-md-2'></div><div class='col-md-2'><h5>Order ID: </h5></div><div class='col-md-2'><h5>". $orderID . "</h5></div>";
 ?>

  </tbody>
  </table>
  </body>
</html>

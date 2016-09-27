<?php
	session_start();
	
	$method = $_SERVER['REQUEST_METHOD'];
	if($method == 'POST') {
	$_SESSION['inputCardNumber'] = $_POST['inputCardNumber'];
	$_SESSION['inputCVC'] = $_POST['inputCVC'];
	$_SESSION['inputName'] = $_POST['inputName'];
	}
	
   #"Fake" check for payment information
  if(!isset($_SESSION['inputCardNumber']) || !isset($_SESSION['inputCVC']) || !isset($_SESSION['inputName'])){
		header("Location: checkout.php");
	} else {
		header("Location: receipt.php");
	}
	die();
 ?>
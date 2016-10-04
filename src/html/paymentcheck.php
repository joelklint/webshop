<?php
	session_start();
	
	$ref = $_SERVER['HTTP_REFERER'];
	if($ref !== 'https://localhost:1337/checkout.php') {
		die("No permission");
	}
	
	$method = $_SERVER['REQUEST_METHOD'];
	if($_SERVER['REQUEST_METHOD'] == 'POST') {
		
		#CSRF token protection
		if (!empty($_POST['ctoken'])) {
			if (strcmp($_POST['ctoken'], $_SESSION['ctoken']) !== 0) {
				die("No permission");
			}
		} else {
			die("No permission");
		}
		
		require_once __DIR__ . "/../inc/DatabaseHelper.php";
		$db = new DatabaseHelper();
  
		$PASSWORD = $_POST['pwd'];

		if(empty($PASSWORD)){
			header("Location: https://localhost:1337/shoppingcart.php");
			die();
		}
		
		$user = $db->authenticate_with_username_and_psw($_SESSION['username'], $PASSWORD);
		#Authentication successful
		if(!$user){
			header("Location: https://localhost:1337/shoppingcart.php");
			die();
		}
	}
	
	#Adds values to session, and neutalization of CRLF attack.
	if($method == 'POST') {
		$_SESSION['inputCardNumber'] = preg_replace("/[^\\S ]/", '', $_POST['inputCardNumber']);
		$_SESSION['inputCVC'] = preg_replace("/[^\\S ]/", '', $_POST['inputCVC']);
		$_SESSION['inputName'] = preg_replace("/[^\\S ]/", '', $_POST['inputName']);
	}
	
   #"Fake" check for payment information
  if(!isset($_SESSION['inputCardNumber']) || !isset($_SESSION['inputCVC']) || !isset($_SESSION['inputName'])){
		header("Location: checkout.php");
	} else {
		$_SESSION['orderid'] = uniqid();
		header("Location: receipt.php");
	}
	die();
 ?>
<?php
	session_start();
	
	$ref = $_SERVER['HTTP_REFERER'];
	if($ref !== 'https://localhost:1337/checkout.php') {
		die("No permission");
	}
	
	if($_SERVER['REQUEST_METHOD'] == 'POST') {
		
		#CSRF token protection
		if (!empty($_POST['ctoken'])) {
			if (strcmp($_POST['ctoken'], $_SESSION['ctoken']) !== 0) {
				die("No permission");
			}
		} else {
			die("No permission");
		}
  
		$PASSWORD = $_POST['pwd'];

		if(empty($PASSWORD)){
			header("Location: https://localhost:1337/shoppingcart.php");
			die();
		}
		
		require_once __DIR__ . "/../inc/DatabaseHelper.php";
		$db = new DatabaseHelper();
		
		$user = $db->authenticate_with_username_and_psw($_SESSION['username'], $PASSWORD);
		#Authentication successful
		if(!$user){
			header("Location: https://localhost:1337/shoppingcart.php");
			die();
		}
	} else {
		header("Location: https://localhost:1337/shoppingcart.php");
		die();
	}
	
	if(!isset($_POST['inputCardNumber']) && !isset($_POST['inputCardNumber']) && !isset($_POST['inputCardNumber'])) {
		header("Location: https://localhost:1337/shoppingcart.php");
		die();
	}
	
	#Adds values to session, and neutralization of CRLF attack.
	$_SESSION['inputCardNumber'] = preg_replace("/[^\\S ]/", '', $_POST['inputCardNumber']);
	$_SESSION['inputCVC'] = preg_replace("/[^\\S ]/", '', $_POST['inputCVC']);
	$_SESSION['inputName'] = preg_replace("/[^\\S ]/", '', $_POST['inputName']);
	$_SESSION['inputCardNumber'] = htmlspecialchars($_SESSION['inputCardNumber'], ENT_QUOTES, 'UTF-8');
	$_SESSION['inputCVC'] = htmlspecialchars($_SESSION['inputCVC'], ENT_QUOTES, 'UTF-8');
	$_SESSION['inputName'] = htmlspecialchars($_SESSION['inputName'], ENT_QUOTES, 'UTF-8');
	
	if(strlen($_SESSION['inputCardNumber']) == 16 && strlen($_SESSION['inputCVC']) == 3 && isset($_SESSION['inputName'])) {
		$_SESSION['orderid'] = uniqid();
		header("Location: receipt.php");
	} else {
		header("Location: checkout.php");
	}
	die();
 ?>
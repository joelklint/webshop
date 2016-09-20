<?php

require_once __DIR__ . "/../inc/DatabaseHelper.php";
$db = new DatabaseHelper();

$USERNAME = $_POST['uid'];
$PASSWORD = $_POST['pwd'];


if(!empty($USERNAME && !empty($PASSWORD))){

$authenticate = $db->authenticate_with_username_and_psw($USERNAME, $PASSWORD);

  if($authenticate){
    echo "You are logged in";
    header("Location: productlist.php");
    die;
  }
  else{
    echo "Username or password is incorrect";
    header("Location: login.html");
    die;
  }
}
header("Location: login.html");

?>

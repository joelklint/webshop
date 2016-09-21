<?php
session_start();
require_once __DIR__ . "/../inc/DatabaseHelper.php";
$db = new DatabaseHelper();

$USERNAME = $_POST['uid'];
$PASSWORD = $_POST['pwd'];


if(!empty($USERNAME && !empty($PASSWORD))){

$user = $db->authenticate_with_username_and_psw($USERNAME, $PASSWORD);

  // Login succesful
  if($user){
    $_SESSION["username"] = $user->username();
    var_dump($_SESSION);
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

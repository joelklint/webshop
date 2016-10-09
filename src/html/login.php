<?php
session_start();
$method = $_SERVER['REQUEST_METHOD'];
if($method == 'POST') {
  require_once __DIR__ . "/../inc/DatabaseHelper.php";
  $db = new DatabaseHelper();

  $USERNAME = $_POST['uid'];
  $PASSWORD = $_POST['pwd'];

  if(!empty($USERNAME && !empty($PASSWORD))){

	#Neutralization of CRLF attack and removes html chars
	$USERNAME = preg_replace("/[^\\S ]/", '', $USERNAME);
	$PASSWORD = preg_replace("/[^\\S ]/", '', $PASSWORD);
	$USERNAME = htmlspecialchars($USERNAME, ENT_QUOTES, 'UTF-8');
	$PASSWORD = htmlspecialchars($PASSWORD, ENT_QUOTES, 'UTF-8');
	
  $user = $db->authenticate_with_username_and_psw($USERNAME, $PASSWORD);

    // Login succesful
    if($user){
      $_SESSION["username"] = $user->username();
      header("Location: productlist.php");
      die;
    }
  }
}
 ?>
<!DOCTYPE HTML>
<html>
	<head>
  <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
		<title>Sign-Up</title>
		<link rel="stylesheet" type="text/css" href="bootstrapPaper.css">
	</head>
	<body>

    <?php include __DIR__ . "/navbar.php" ?>

	<div class="col-md-3">
	</div>
	<div class="col-md-6">
		<form action="login.php" method="POST" class="form-horizontal">
  <fieldset>
    <legend>Log in</legend>
    <div class="form-group" >
      <label for="inputUsername" class="col-lg-2 control-label">Username</label>
      <div class="col-lg-10">
        <?php
        $username = $_POST['uid'];
        echo "<input type='text' class='form-control' name='uid' placeholder='Username' value=$username>";
         ?>
      </div>
    </div>
    <div class="form-group">
      <label for="inputPassword" class="col-lg-2 control-label">Password</label>
      <div class="col-lg-10">
        <input type="password" class="form-control" name="pwd" placeholder="Password">
      </div>
    </div>
    <div class="form-group">
      <div class="col-lg-10 col-lg-offset-2">
        <button type="reset" class="btn btn-default">Reset Fields</button>
        <button type="submit" class="btn btn-primary">Log in</button>
      </div>
    </div>
  </fieldset>
</form>
</div>
		</body>
		</html>

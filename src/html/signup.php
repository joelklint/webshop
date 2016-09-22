<?php

session_start();
$method = $_SERVER['REQUEST_METHOD'];
if($method == 'POST') {

  require_once __DIR__ . "/../inc/DatabaseHelper.php";
  $db = new DatabaseHelper();

  $USERNAME = $_POST['inputUsername'];
  $PASSWORD = $_POST['inputPassword'];
  $CONFIRMPASSWORD = $_POST['inputConfirmPassword'];
  $ADDRESS = $_POST['inputAddress'];

  if(!empty($USERNAME && !empty($PASSWORD)) && !empty($CONFIRMPASSWORD) && !empty($ADDRESS)){

  	if($PASSWORD == $CONFIRMPASSWORD){
  		$success = $db->save_new_user_with_username_address_pswd($USERNAME, $ADDRESS, $PASSWORD);
      if($success) {
        $user = $db->find_user_by_username($USERNAME);
        $_SESSION["username"] = $user->username();
        header("Location: productlist.php");
        die;
      }

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
		<form action="signup.php" method="POST" class="form-horizontal">
  <fieldset>
    <legend>Sign up</legend>
    <div class="form-group" >
      <label for="inputUsername" class="col-lg-2 control-label">Username</label>
      <div class="col-lg-10">
        <?php
        $USERNAME = $_POST['inputUsername'];
        echo "<input type='text' class='form-control' name='inputUsername' value='$USERNAME' placeholder='Username'>"
         ?>
      </div>
    </div>
    <div class="form-group" >
      <label for="inputAddress" class="col-lg-2 control-label">Address</label>
      <div class="col-lg-10">
        <?php
        $ADDRESS = $_POST['inputAddress'];
        echo "<input type='text' class='form-control' name='inputAddress' value='$ADDRESS' placeholder='Address'>"
         ?>
      </div>
    </div>
    <div class="form-group">
      <label for="inputPassword" class="col-lg-2 control-label">Password</label>
      <div class="col-lg-10">
        <input type="password" class="form-control" name="inputPassword" placeholder="Password">
      </div>
    </div>
    <div class="form-group">
      <label for="inputConfirmPassword" class="col-lg-2 control-label">Confirm Password</label>
      <div class="col-lg-10">
        <input type="password" class="form-control" name="inputConfirmPassword" placeholder="Confirm Password">
      </div>
    </div>
    <div class="form-group">
      <div class="col-lg-10 col-lg-offset-2">
        <button type="reset" class="btn btn-default">Reset fields</button>
        <button type="submit" class="btn btn-primary">Sign up</button>
      </div>
    </div>
  </fieldset>
</form>
</div>
		</body>
		</html>

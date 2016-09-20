<?php

 

if(!empty($_POST['inputUsername']) && !empty($_POST['inputPassword'])
	&& !empty($_POST['inputAddress']) && !empty($_POST['inputConfirmPassword'])){

$USERNAME=
$PASSWORD=
$ADDRESS=

$query = mysqli_query($con, "INSERT INTO `users` (`USERNAME`, `PASSWORD`, `ADDRESS`) VALUES
('$username', '$password', '$address');");

}
?>


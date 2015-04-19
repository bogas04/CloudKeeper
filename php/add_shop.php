<?php
session_start();
require_once('db.php');
require_once('funcs.php');
if(!isset($_SESSION['user']) || !isset($_SESSION['user']['username'])) {
  header('Location: index.php');
  die();
}
?>

<?php

	$mysqli = dbConnect();
	
	$query = 'INSERT INTO `shops` (`owner_id`,`name`,`address`,`state`,`country`,`pin_code`) VALUES ('.
	"'".$_SESSION['user']['owner_id']."',".
	"'".$_POST['name']."',".
	"'".$_POST['address']."',".
	"'".$_POST['state']."',".
	"'".$_POST['country']."',".
	"'".$_POST['pincode']."')";
	
	$result = $mysqli->query($query);
	
	if($result)
		echo "<h1>Added</h1>";
?>	
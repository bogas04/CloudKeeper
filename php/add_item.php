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
	
	$query = 'INSERT INTO `items` (`name`,`description`,`MRP`) VALUES ('.
	"'".$_POST['name']."',".
	"'".$_POST['description']."',".
	"'".$_POST['MRP']."')";
	
	$result = $mysqli->query($query);
	$temp = $mysqli->insert_id;
	if($result)
		echo "<h1>Added to items table</h1>";
	$query = 'INSERT INTO `owner_items` (`owner_id`,`item_id`,`cost_price`,`sell_price`,`quantity`) VALUES('.
	"'".$_SESSION['user']['owner_id']."',".
	"'".$temp."',".
	"'".$_POST['costprice']."',".
	"'".$_POST['sellprice']."',".
	"'".$_POST['quantity']."')";
	$result = $mysqli->query($query);
	if($result)
		echo "<h1>Added to owner_items table</h1>";
	
?>	
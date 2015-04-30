<?php
require_once('db.php');
require_once('funcs.php');

startSession();

if(!isLoggedIn()) { 
  logout(); 
  respond(true, "Login in again");
}

$mysqli = dbConnect();

$item_id = $_POST['item_id'];

$query = 'INSERT INTO `owner_items` (`owner_id`,`item_id`,`cost_price`,`sell_price`,`quantity`) VALUES('.
  "'".$mysqli->real_escape_string($_SESSION['user']['owner_id'])."',".
  "'".$mysqli->real_escape_string($item_id)."',".
  "'".$mysqli->real_escape_string($_POST['cost_price'])."',".
  "'".$mysqli->real_escape_string($_POST['sell_price'])."',".
  "'".$mysqli->real_escape_string($_POST['quantity'])."')";

$result = $mysqli->query($query);

if(!$result) {
  respond(true, 'Database error', $mysqli->error);
}

respond(false, 'Item successfully added');


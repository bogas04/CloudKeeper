<?php
require_once('db.php');
require_once('funcs.php');

startSession();

if(!isLoggedIn()) { 
  logout(); 
}

$mysqli = dbConnect();

// TODO: Validations
$query = 'INSERT INTO `items` (`name`,`description`,`mrp`) VALUES ('.
  "'".$_POST['name']."',".
  "'".$_POST['description']."',".
  "'".$_POST['mrp']."')";

$result = $mysqli->query($query);

$item_id = $mysqli->insert_id;

if(!$result) {
  respond(true, 'Database error', $mysqli->error);
} 

$query = 'INSERT INTO `owner_items` (`owner_id`,`item_id`,`cost_price`,`sell_price`,`quantity`) VALUES('.
  "'".$_SESSION['user']['owner_id']."',".
  "'".$item_id."',".
  "'".$_POST['cost_price']."',".
  "'".$_POST['sell_price']."',".
  "'".$_POST['quantity']."')";

$result = $mysqli->query($query);

if(!$result) {
  respond(true, 'Database error', $mysqli->error);
}

respond(false, 'Item successfully added');

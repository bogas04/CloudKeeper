<?php
require_once('db.php');
require_once('funcs.php');

startSession();

if(!isLoggedIn()) { 
  logout(); 
  respond(true, 'Logout please');
}

$mysqli = dbConnect();

foreach($_POST as $key => $p) {
  if(!isset($_POST[$key]) || strlen($p) === 0) {
    respond(true, 'Please fill all the details');
  }
}
// TODO: Validations
$query = 'INSERT INTO `items` (`name`,`description`,`mrp`) VALUES ('.
  "'".$mysqli->real_escape_string($_POST['name'])."',".
  "'".$mysqli->real_escape_string($_POST['description'])."',".
  "'".$mysqli->real_escape_string($_POST['mrp'])."')";

$result = $mysqli->query($query);
$item_id = $mysqli->insert_id;

if(!$result) {
  respond(true, 'Database error', $mysqli->error);
} 

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

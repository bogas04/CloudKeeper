<?php
require_once('db.php');
require_once('funcs.php');

startSession();
if(!isLoggedIn()) { 
  logout(); 
  respond(true, 'Logout please');
}
foreach($_POST as $key => $p) {
  if(!isset($_POST[$key]) || count($p) === 0 || strlen($p) === 0) {
    respond(true, 'Please fill all the details');
  }
}

$mysqli = dbConnect();

$query = 'INSERT INTO `invoices` (`shop_id`) VALUES("'.$mysqli->real_escape_string($_POST['shop_id']).'")';

$result = $mysqli->query($query);
$temp = $mysqli->insert_id;

if(!$result) {
  respond(true, "Database error", $mysqli->error);
}

$query = 'INSERT INTO `invoice_items`(`item_id`, `invoice_id`, `quantity`, `price`) VALUES '; 

foreach($_POST['items'] as $p) {
  $query .= "('".$mysqli->real_escape_string($p['item_id']).
           "','".$mysqli->real_escape_string($temp).
           "','".$mysqli->real_escape_string($p['quantity']).
           "','".$mysqli->real_escape_string($p['price'])."'),";
}
$query[strlen($query) - 1] = ';';

$result = $mysqli->query($query);

if(!$result) {
  respond(true, "Database error", [$mysqli->error, $query]);
}

respond(false, "Successfully inserted!");

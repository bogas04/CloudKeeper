<?php
session_start();
require_once('db.php');
require_once('funcs.php');

if(!isLoggedIn()) { 
  logout(); 
}

$mysqli = dbConnect();

$query = 'INSERT INTO `invoices` (`shop_id`) VALUES("'.$_POST['shop_id'].'")';

$result = $mysqli->query($query);
$temp = $mysqli->insert_id;

if(!$result) {
  respond(true, "Database error", $mysqli->error);
}

$query = 'INSERT INTO `invoice_items`(`item_id`, `invoice_id`, `quantity`, `price`) VALUES '; 

foreach($_POST['items'] as $p) {
  $query .= "('{$p['item_id']}', '$temp', '{$p['quantity']}', '{$p['price']}'),";
}
$query[strlen($query) - 1] = ';';

$result = $mysqli->query($query);

if(!$result) {
  respond(true, "Database error", [$mysqli->error, $query]);
}

respond(false, "Successfully inserted!");

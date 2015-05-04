<?php
require_once('db.php');
require_once('funcs.php');

startSession();
if(!isLoggedIn()) { 
  logout(); 
  respond(true, 'login first');
}
foreach($_POST as $key => $p) {
  if(!isset($_POST[$key]) || count($p) === 0 || strlen($p) === 0) {
    respond(true, 'Please fill all the details');
  }
}

$mysqli = dbConnect();

$owner_id = $_SESSION['user']['owner_id'];
$invoice_id = $mysqli->real_escape_string($_POST['invoice_id']);

$query = "SELECT item_id, quantity FROM invoice_items WHERE invoice_items.invoice_id = '$invoice_id'";
$result = $mysqli->query($query);
if(!$result) {
  respond(true, $mysqli->error);
}
$count = 0;
while($item = $result->fetch_assoc()) {
  $count++;
  $item_id = $item['item_id'];
  $quantity = $item['quantity'];
  $query = "UPDATE `owner_items` SET owner_items.quantity = owner_items.quantity + $quantity 
    WHERE owner_items.item_id = '$item_id' AND owner_items.owner_id = '$owner_id'";
  $updateResult = $mysqli->query($query);
  if(!$updateResult) {
    respond(true, $mysqli->error);    
  }
}

$query = "DELETE FROM invoices WHERE invoice_id = '$invoice_id' and shop_id IN (SELECT shop_id FROM shops WHERE owner_id = '".$owner_id."')";

$result = $mysqli->query($query);

if(!$result) {
  respond(true, $mysqli->error, [$query]);
}
respond(false, 'Successfully deleted '. $mysqli->affected_rows.' invoice(s) with '.$count.' items', [$query]);

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

$query = "DELETE FROM shops WHERE shop_id = '".$mysqli->real_escape_string($_POST['shop_id'])."' and owner_id = '".$owner_id."'";

$result = $mysqli->query($query);

if(!$result) {
  respond(true, $mysqli->error, [$query]);
}
respond(false, 'Successfully deleted'. $result->num_rows.' shop');

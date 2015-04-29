<?php
require_once('db.php');
require_once('funcs.php');

startSession();

if(!isLoggedIn()) { logout(); respond(true, 'login first'); }

$mysqli = dbConnect();

$owner_id = $_SESSION['user']['owner_id'];

$shop_id = $_POST['shop_id'];

$query = 'UPDATE `shops` SET';
foreach($_POST as $key => $value) {
  if($key != 'owner_id' && $key != 'shop_id')
  $query .= ("`$key` = '$value',");
}
$query[strlen($query) - 1] = ' ';
$query .= ' WHERE shop_id = "'. $shop_id.'" and owner_id = "'.$owner_id.'";'; 

$result = $mysqli->query($query);

if(!$result) {
  respond(false, 'Database error', $mysqli->error);
}
respond(false, 'Shop successfully updated!');


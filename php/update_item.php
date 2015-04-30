<?php
require_once('db.php');
require_once('funcs.php');

startSession();

if(!isLoggedIn()) { logout(); respond(true, 'login first'); }

$mysqli = dbConnect();

$owner_id = $_SESSION['user']['owner_id'];

$item_id = $_POST['item_id'];

$query = 'UPDATE `owner_items` SET';
foreach($_POST as $key => $value) {
  if($key != 'owner_id' && $key != 'item_id')
  $query .= (" `$key` = '$value',");
}
$query[strlen($query) - 1] = ' ';
$query .= ' WHERE `item_id` = "'. $item_id.'" and `owner_id` = "'.$owner_id.'";'; 

$result = $mysqli->query($query);

if(!$result) {
  respond(false, 'Database error', $mysqli->error);
}
respond(false, 'Item successfully updated!');

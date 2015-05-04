<?php
require_once('db.php');
require_once('funcs.php');

startSession();

if(!isLoggedIn()) { logout(); respond(true, 'login first'); }

$mysqli = dbConnect();

$owner_id = $_SESSION['user']['owner_id'];

$query = "SELECT items.item_id as item_id, name, description, quantity, cost_price, sell_price, mrp FROM `owner_items`, `items` WHERE items.item_id = owner_items.item_id and `owner_id` = '". $owner_id ."'";

if(isset($_GET['keyword']) && strlen($_GET['keyword']) > 0) {
  $query = "SELECT items.item_id as item_id, name, description, quantity, cost_price, sell_price, mrp FROM `owner_items`, `items` WHERE 
    items.item_id = owner_items.item_id AND 
    `owner_id` = '". $owner_id ."' AND (
      items.name LIKE '%".$mysqli->real_escape_string($_GET['keyword'])."%' 
      OR items.description LIKE '%".$mysqli->real_escape_string($_GET['keyword'])."%'
    )";
}
$result = $mysqli->query($query);

if(!$result) {
  respond(true, $mysqli->error);
}

if($result->num_rows == 0) {
  respond(false, 'You have no items', []);
} else {
  $items = [];
  while($item = $result->fetch_assoc()) {
    $items[] = $item;
  }
  respond(false, 'You have '. count($items) . ' item(s)', $items);
}

<?php
require_once('db.php');
require_once('funcs.php');

startSession();

if(!isLoggedIn()) { logout(); respond(true, 'login first'); }

$mysqli = dbConnect();

$owner_id = $_SESSION['user']['owner_id'];

$query = "SELECT * FROM `items`";

$result = $mysqli->query($query);

if(!$result) {
  respond(true, $mysqli->error);
}

if($result->num_rows == 0) {
  respond(false, 'We have no items', []);
} else {
  $items = [];
  while($item = $result->fetch_assoc()) {
    $items[] = $item;
  }
  respond(false, 'We have '. count($items) . ' item(s)', $items);
}


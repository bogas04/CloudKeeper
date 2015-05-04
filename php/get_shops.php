<?php
require_once('db.php');
require_once('funcs.php');

startSession();

if(!isLoggedIn()) { logout(); respond(true, 'login first'); }

$mysqli = dbConnect();

$owner_id = $_SESSION['user']['owner_id'];

$query = 'SELECT * FROM `shops` WHERE `owner_id` = "'. $owner_id.'"';

if(isset($_GET['keyword']) && strlen($_GET['keyword']) > 0) {
  $query = 'SELECT * FROM `shops` WHERE `owner_id` = "'. $owner_id.'" AND (
    name LIKE "%'.$mysqli->real_escape_string($_GET['keyword']).'%"
    OR address LIKE "%'.$mysqli->real_escape_string($_GET['keyword']).'%"
  )';
}

$result = $mysqli->query($query);

if(!$result) {
  respond(true, $mysqli->error);
}

if($result->num_rows == 0) {
  respond(false, 'You have no shops', []);
} else {
  $shops = [];
  while($shop = $result->fetch_assoc()) {
    $shops[] = $shop;
  }
  respond(false, 'You have '. count($shops) . ' shop(s)', $shops);
}

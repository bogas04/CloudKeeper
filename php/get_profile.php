<?php
require_once('db.php');
require_once('funcs.php');

startSession();

if(!isLoggedIn()) { logout(); respond(true, 'login first'); }

$mysqli = dbConnect();

$owner_id = $_SESSION['user']['owner_id'];
$query = 'SELECT first_name as firstName, last_name as lastName, username FROM `owner` WHERE `owner_id` = "'. $owner_id.'"';

$result = $mysqli->query($query);

if(!$result) {
  respond(true, $mysqli->error);
}

if($result->num_rows == 0) {
  logout();
  respond(true, 'Logout now', []);
} else {
  $profile = $result->fetch_assoc();
  $query = 'SELECT phone_number FROM `phonenumbers` WHERE `owner_id` = "'.$owner_id.'"';
  $result = $mysqli->query($query);
  $profile['phoneNumbers'] = $result->fetch_all();
  respond(false, 'Profile Data', $profile);
}

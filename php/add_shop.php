<?php
require_once('db.php');
require_once('funcs.php');

startSession();

if(!isLoggedIn()) { 
  logout(); 
  respond(true, 'Logout please');
}
$mysqli = dbConnect();

foreach($_POST as $key => $p) {
  if(!isset($_POST[$key]) || strlen($p) === 0) {
    respond(true, 'Please fill all the details');
  }
}

if(!validState($_POST['state'])) {
  respond(true, 'Enter a valid state');
}
// TODO: Validations
$query = 'INSERT INTO `shops` (`owner_id`,`name`,`address`,`state`,`pin_code`) VALUES ('.
  "'".$mysqli->real_escape_string($_SESSION['user']['owner_id'])."',".
  "'".$mysqli->real_escape_string($_POST['name'])."',".
  "'".$mysqli->real_escape_string($_POST['address'])."',".
  "'".$mysqli->real_escape_string($_POST['state'])."',".
  "'".$mysqli->real_escape_string($_POST['pin_code'])."')";

$result = $mysqli->query($query);

if(!$result) {
  respond(false, 'Database error', $mysqli->error);
}

respond(false, 'Shop successfully created');


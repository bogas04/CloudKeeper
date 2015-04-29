<?php
require_once('db.php');
require_once('funcs.php');

startSession();

if(!isLoggedIn()) { 
  logout(); 
  header('Location: ../'); 
  die();
}
$mysqli = dbConnect();

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


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
  "'".$_SESSION['user']['owner_id']."',".
  "'".$_POST['name']."',".
  "'".$_POST['address']."',".
  "'".$_POST['state']."',".
  "'".$_POST['pincode']."')";

$result = $mysqli->query($query);

if(!$result) {
  respond(false, 'Database error', $mysqli->error);
}

respond(false, 'Shop successfully created');


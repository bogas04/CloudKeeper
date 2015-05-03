<?php
require_once('db.php');
require_once('funcs.php');

startSession();
if(!isLoggedIn()) { 
  logout(); 
  respond(true, 'Logout please');
}
foreach($_POST as $key => $p) {
  if(!in_array($key, ['oldPassword', 'newPassword']) && (!isset($_POST[$key]) || count($p) === 0 || strlen($p) === 0)) {
    respond(true, 'Please fill all the details');
  }
}
$owner_id = $_SESSION['user']['owner_id'];

if($owner_id != $_POST['owner_id']) { 
  logout(); 
  respond(true, 'Logout please');
}

if(rejectUsername($_POST['username'])) {
  respond(true, 'Username can only have alphanumerics and underscore');
}
$password = $_SESSION['user']['password'];

if(isset($_POST['oldPassword']) && strlen($_POST['oldPassword']) !== 0) {
  //if(rejectPassword($_POST['oldPassword']) ||
  if(!password_verify($_POST['oldPassword'], $password)) {
    respond(true, 'Incorrect old password');
  } else if(!isset($_POST['newPassword']) || rejectPassword($_POST['newPassword'])) {
    respond(true, 'Password must be of length 8-16'); 
  } else {
    $password = password_hash($_POST['newPassword'], PASSWORD_BCRYPT, ['cost' => 10]); 
  }
}

$mysqli = dbConnect();

$query = 'UPDATE owner SET 
  first_name = "'.$mysqli->real_escape_string($_POST['firstName']).'",
    last_name = "'.$mysqli->real_escape_string($_POST['lastName']).'",
    password = "'.$password.'",
    username = "'.$mysqli->real_escape_string($_POST['username']).'" WHERE owner_id = "'.$owner_id.'"';

$result = $mysqli->query($query);
if(!$result) {
  respond(true, "Database error", $mysqli->error);
}
// updating session
foreach($_SESSION['user'] as $key => $value) {
  $_SESSION['user'][$key] = $_POST[$key]; 
}

// TODO : Phone number validation
$phoneNumbers = $_POST['phoneNumbers'] || [];

// Deleting numbers that are not present in new phone numbers
$toDelete = array_diff($_SESSION['user']['phoneNumbers']);
if(count($toDelete) > 0) {
  $query = 'DELETE FROM phonenumbers WHERE owner_id = "'.$owner_id.'" and phone_number IN (';
  foreach(array_diff($_SESSION['user']['phoneNumbers'], $phoneNumbers) as $p) {
    $query .= ('"' . $p . '",');
  }
  $query[strlen($query)] = ')';

  $result = $mysqli->query($query);
  if(!$result) {
    respond(true, "Database error", $mysqli->error);
  }
  // updating session
  foreach($_SESSION['user'] as $key => $value) {
    $_SESSION['user'][$key] = $_POST[$key]; 
  }
}

// Adding numbers that are not present in existing phone numbers
$toAdd = array_diff($_SESSION['user']['phoneNumbers']);
if(count($toAdd) > 0) {
  $query = 'INSERT INTO `phonenumbers` (`owner_id`, `phone_number`) VALUES '; 
  foreach($toAdd as $p) {
    $query .= ' ("'.$owner_id.'","' . $mysqli->real_escape_string($p) . '"),';
  }
  $query[strlen($query)] = ';';

  $result = $mysqli->query($query);
  if(!$result) {
    respond(true, "Database error", [$mysqli->error, $query]);
  }
  // updating session
  foreach($_SESSION['user'] as $key => $value) {
    $_SESSION['user'][$key] = $_POST[$key]; 
  }
}

respond(false, "Successfully updated!");


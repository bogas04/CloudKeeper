<?php
require_once('db.php');
require_once('funcs.php');

startSession();

// validation
if(isset($_SESSION['user']['loggedIn']) && $_SESSION['user']['loggedIn'] === true) {  
  header("Location: dashboard.php");
}

if(!isset($_POST['username']) || !isset($_POST['password'])){
  respond(true, 'fill all details', $_POST);
} else if (rejectUsername($_POST['username'])) {
  respond(true, 'username must have alphanumerics or underscore', $_POST);
} else if (rejectPassword($_POST['password'])) {
  respond(true, 'password must be of length 8-16', $_POST);
} 
$_POST['username'] = trim(strtolower($_POST['username']));

// connect to db
$mysqli = dbConnect();

// query to find user
$query = 'SELECT first_name as firstName, last_name as lastName, username, owner_id, password FROM `owner` WHERE `username` = "' . strtolower($mysqli->real_escape_string($_POST['username'])) .'"';
$result = $mysqli->query($query);

// db error
if(!$result) {
  respond(true, 'Database error');
}
// user not found
if($result->num_rows !== 1) {
  respond(true, 'User not found', $_POST['username']);
}

// collect user details
$userDetails = $result->fetch_assoc();

// verify password
if(password_verify($_POST['password'], $userDetails['password'])) {
  $query = 'SELECT phone_number FROM phonenumbers WHERE owner_id = "'.$userDetails['owner_id'].'"';
  $mysqli->query($query);
  if($result && $result->num_rows > 0) {
   $userDetails['phoneNumbers'] = $result->fetch_all(); 
  }
  $userDetails['phoneNumbers'] = [];
  // update session
  $_SESSION['user'] = $userDetails; 
  $_SESSION['user']['loggedIn'] = true;
  respond(false, 'Logged in');
} else {
  unset($_SESSION['user']);
  session_destroy();
  respond(true, 'Incorrect password');  
}

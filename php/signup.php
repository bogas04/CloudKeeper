<?php
require_once('db.php');
require_once('funcs.php');

// start session
session_start();

// validation
if(isset($_SESSION['user']['loggedIn']) && $_SESSION['user']['loggedIn'] === true) {  
  respond(true, $_SESSION['user']['username'] . ' is already logged in.');    
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
$query = 'SELECT * FROM `person` WHERE `username` = "' . ($_POST['username'] .'"');
$result = $mysqli->query($query);

// user not found
if($result->num_rows !== 0) {
  respond(true, 'username is taken', $_POST['username']);
}

$query = 'INSERT INTO `person`'.
  '(`first_name`, `last_name`, `username`, `password`) VALUES '.
  '("'. strtolower($mysqli->real_escape_string($_POST['first_name'])) .'","'.  
        strtolower($mysqli->real_escape_string($_POST['last_name'])) .'","'.  
        strtolower($mysqli->real_escape_string($_POST['username'])) . '","'.
        password_hash($_POST['password'], PASSWORD_BCRYPT, ['cost' => 10]) . '")';

$result = $mysqli->query($query);
if($result->num_rows === 1) {
  respond(false, 'successfully signed up');
} else {
  respond(true, 'unexpected error', $result->error());
}

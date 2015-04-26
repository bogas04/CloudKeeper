<?php
require_once('db.php');
require_once('funcs.php');

startSession();

if(!isLoggedIn()) { 
  logout(); 
}

$mysqli = dbConnect();

$query = 'UPDATE `shops` SET';
foreach($_POST['update'] as $key => $value) {
  if($key != 'owner_id' && $key != 'shop')
  $query .= ("`$key` = '$value',");
}
$query[strlen($query) - 1] = ';'; 

respond(false, $query);
$result = $mysqli->query($query);

if(!$result) {
  respond(false, 'Database error', $mysqli->error);
}

respond(false, 'Shop successfully created');


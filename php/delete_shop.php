<?php
require_once('db.php');
require_once('funcs.php');

startSession();

if(!isLoggedIn()) { logout(); respond(true, 'login first'); }

$mysqli = dbConnect();

$owner_id = $_SESSION['user']['owner_id'];

$query = "DELETE FROM shops shop_id = '".$_POST['shop_id']."' and owner_id = '".$_SESSION['user']['owner_id']."'";

$result = $mysqli->query($query);

if(!$result) {
  respond(true, $mysqli->error);
}
respond(false, 'Successfully deleted '. $result->num_rows.' shop');

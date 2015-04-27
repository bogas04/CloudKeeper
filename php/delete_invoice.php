<?php
require_once('db.php');
require_once('funcs.php');

startSession();

if(!isLoggedIn()) { logout(); respond(true, 'login first'); }

$mysqli = dbConnect();

$owner_id = $_SESSION['user']['owner_id'];

$query = "DELETE FROM invoices WHERE invoice_id = '".$_POST['invoice_id']."' and shop_id IN (SELECT shop_id FROM shops WHERE owner_id = '".$owner_id."')";

$result = $mysqli->query($query);

if(!$result) {
  respond(true, $mysqli->error, [$query]);
}
respond(false, 'Successfully deleted'. $result->num_rows.' invoice', [$query]);

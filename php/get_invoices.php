<?php
require_once('db.php');
require_once('funcs.php');

startSession();

if(!isLoggedIn()) { logout(); respond(true, 'login first'); }

$mysqli = dbConnect();

$owner_id = $_SESSION['user']['owner_id'];

$query = "SELECT 
  DISTINCT(invoices.invoice_id), 
  shops.name as `shop name`, 
  invoices.invoice_amount as `invoice amount`, 
  (invoices.invoice_time) as `invoice time` 
  FROM `invoices`, `invoice_items`, `shops` 
  WHERE 
    invoices.invoice_id = invoice_items.invoice_id 
    and invoices.shop_id = shops.shop_id 
    and shops.owner_id = '". $_SESSION['user']['owner_id']."'
  ORDER BY invoice_time desc";

$result = $mysqli->query($query);

if(!$result) {
  respond(true, $mysqli->error, [$query]);
}

if($result->num_rows == 0) {
  respond(false, 'You have no invoices', []);
} else {
  $invoices = [];
  while($invoice = $result->fetch_assoc()) {
    $invoices[] = $invoice;
  }
  respond(false, 'You have '. count($invoices) . ' invoice(s)', $invoices);
}

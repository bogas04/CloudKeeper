<?php
require_once('db.php');
require_once('funcs.php');

startSession();

if(!isLoggedIn()) { logout(); respond(true, 'login first'); }

$mysqli = dbConnect();

$owner_id = $_SESSION['user']['owner_id'];

$query = "SELECT 
  shops.name as `shop_name`, 
  invoices.invoice_time,
  invoices.invoice_id, 
  invoices.invoice_amount, 
  invoice_items.item_id, 
  items.name as `item_name`, 
  invoice_items.quantity, 
  invoice_items.price 
  FROM 
    `invoices` NATURAL JOIN `invoice_items` NATURAL JOIN `shops`, `items` 
  WHERE invoice_items.item_id = items.item_id AND owner_id = '$owner_id' 
  ORDER BY invoice_time desc;";
$result = $mysqli->query($query);

if(!$result) {
  respond(true, $mysqli->error, [$query]);
}

if($result->num_rows == 0) {
  respond(false, 'You have no invoices', []);
} else {
  $invoices = [];
  while($invoice = $result->fetch_assoc()) {
    $key = -1; 
    foreach($invoices as $index => $i) {
      if($i['invoice_id'] === $invoice['invoice_id']) {
        $key = $index;
        break;
      }
    }
    if($key === -1) {
      $key = count($invoices);  
    }
    
    $invoices[$key]['shop_name'] = $invoice['shop_name'];
    $invoices[$key]['invoice_id'] = $invoice['invoice_id'];
    $invoices[$key]['invoice_time'] = $invoice['invoice_time'];
    $invoices[$key]['amount'] = $invoice['invoice_amount'];
    if(!isset($invoices[$key]['items'])) {
      $invoices[$key]['items'] = [];
    }
    $invoices[$key]['items'][] = [
      'item_id' => $invoice['item_id'],
      'item_name' => $invoice['item_name'],
      'price' => $invoice['price'],
      'quantity' => $invoice['quantity']
      ];
  }
  respond(false, 'You have '. count($invoices) . ' invoice(s)', $invoices);
}

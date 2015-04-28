<?php
require_once('db.php');
require_once('funcs.php');

//startSession();

//if(!isLoggedIn()) { logout(); respondPretty(true, 'login first'); }

$mysqli = dbConnect();

//$owner_id = $_SESSION['user']['owner_id'];
$owner_id = 1;

function generate($query) {
  global $mysqli;
  global $response;
  $result = $mysqli->query($query[0]);
  if(!$result) {
    respondPretty(true, $query[0], $mysqli->error);
  }
  if($result || $result->num_rows) {
    $response[$query[1]] = $result->fetch_all(MYSQLI_ASSOC);
  }
}

$response = [];
$queries = [];

$queries[] = ["SELECT item_id, myCount FROM (SELECT item_id,count(*) as myCount FROM `invoices` natural join `invoice_items` natural join `shops` WHERE owner_id = '$owner_id' GROUP BY `item_id`) as t1 order by myCount limit 1,5", 'most_sold'];

$queries[] = ["Select item_id, myCount FROM (Select item_id,count(*) as myCount FROM `invoices` natural join `invoice_items` natural join `shops`where owner_id = '$owner_id' GROUP BY `item_id`) as t1 order by myCount desc limit 1,5", 'least_sold'];

$queries[] = ["SELECT g.item_id,g.w FROM (Select owner_id,owner_items.item_id,sum(price-cost_price)*invoice_items.quantity as w, price FROM `owner_items` ,`invoice_items` WHERE owner_items.item_id = invoice_items.item_id group by owner_items.item_id) as g limit 5", 'most_profitable'];

$queries[] = ["SELECT g.item_id,min(g.w) as profit FROM (Select owner_id,owner_items.item_id,sum(price-cost_price)*invoice_items.quantity as w, price FROM `owner_items` ,`invoice_items` WHERE owner_items.item_id = invoice_items.item_id group by owner_items.item_id) as g;", 'least_profitable'];

$queries[] = ["Select sum((invoice_items.price-owner_items.cost_price)*invoice_items.quantity) as revenue From `invoice_items`, `owner_items` WHERE invoice_items.item_id = owner_items.item_id and `owner_id`='$owner_id'", 'total_revenue'];

$queries[] = ["Select item_id,DATE(invoice_time) From `invoice_items`, `invoices` WHERE invoices.invoice_id = invoice_items.invoice_id and shop_id IN (SELECT shop_id FROM `shops` natural join `owner` where owner_id = '$owner_id')", 'invoice_timeline'];

$queries[] = ["Select shop_id, sum((price-cost_price)*invoice_items.quantity) From `invoice_items`, `invoices`, `owner_items` WHERE invoices.invoice_id = invoice_items.invoice_id and invoice_items.item_id = owner_items.item_id and shop_id IN (SELECT shop_id FROM `shops` natural join `owner` where owner_id = '$owner_id') group by shop_id", 'revenue_by_shop'];

foreach($queries as $q) generate($q);

respondPretty(false, "Analytics", $response);

<?php
require_once('db.php');
require_once('funcs.php');
startSession();

if(!isLoggedIn()) { logout(); respondPretty(true, 'login first'); }

$mysqli = dbConnect();

$owner_id = $_SESSION['user']['owner_id'];

function generate($query) {
  global $mysqli;
  global $response;
  $result = $mysqli->query($query[0]);
  if(!$result) {
    respond(true, 'error in '. $query[1], $mysqli->error);
  } else {
    if(isset($query[2]) && $query[2]) { 
      $response[$query[1]] = $result->fetch_assoc(); 
    } else {
      $response[$query[1]] = $result->fetch_all(MYSQLI_ASSOC); 
    }
  }
}

$response = [];
$queries = [];

$queries[] = [
  "SELECT
    year(invoices.invoice_time) as year
    ,month(invoices.invoice_time) as month
    ,sum(invoice_amount) as revenue
    ,sum(_profit) as profit 
  FROM `invoices`
    ,(SELECT invoice_id
      ,invoice_items.item_id
      ,(invoice_items.price-owner_items.cost_price)*invoice_items.quantity as _profit 
      FROM `invoice_items`, `owner_items`
      WHERE invoice_items.item_id = owner_items.item_id) as table2
  WHERE table2.invoice_id = invoices.invoice_id AND getOwnerId(table2.invoice_id) = '$owner_id' 
  GROUP BY YEAR(invoice_time),MONTH(invoice_time)
  ORDER BY invoice_time"
, 'monthlyRevenueProfit'];

// Too many charts to show, TODO: in future
$queries[] = [
  "SELECT
    shops.shop_id
    ,year(invoices.invoice_time) as year
    ,month(invoices.invoice_time) as month
    ,sum(invoice_amount) as revenue
    ,sum(_profit) as profit 
  FROM `invoices`
    ,(SELECT invoice_id
      ,invoice_items.item_id
      ,(invoice_items.price-owner_items.cost_price)*invoice_items.quantity as _profit 
      FROM `invoice_items`, `owner_items`
      WHERE invoice_items.item_id = owner_items.item_id) as table2, `shops`
  WHERE table2.invoice_id = invoices.invoice_id AND shops.shop_id = invoices.shop_id AND shops.owner_id = '$owner_id'
  GROUP BY shops.shop_id,YEAR(invoice_time),MONTH(invoice_time)"
, 'shopWiseMonthlyRevenueProfit'];

// Too many charts to show, TODO: in future
$queries[] = [
  "SELECT shop_id, year(invoices.invoice_time),sum(invoice_amount),sum(profit) FROM
  `invoices`, (SELECT invoice_id,invoice_items.item_id,(invoice_items.price-owner_items.cost_price)*invoice_items.quantity as profit FROM `invoice_items`, `owner_items` WHERE invoice_items.item_id = owner_items.item_id) as table2 
  WHERE table2.invoice_id = invoices.invoice_id 
  GROUP BY shop_id,year(invoice_time)
  HAVING shop_id in(SELECT shop_id FROM `shops` WHERE owner_id = '$owner_id')", 'shopWiseYearlyRevenueProfit'];

$queries[] = [
  "SELECT item_id
  ,getName(item_id)
  ,sum(profit)
  ,sum(revenue) 
  FROM `invoices`, (SELECT invoice_id 
      ,invoice_items.item_id 
      ,(invoice_items.price-owner_items.cost_price)*invoice_items.quantity as profit
      ,invoice_items.price*invoice_items.quantity as revenue FROM `invoice_items`
      ,`owner_items` WHERE invoice_items.item_id = owner_items.item_id and owner_id = '$owner_id') as table2
  WHERE table2.invoice_id = invoices.invoice_id GROUP BY item_id", 'productWiseRevenueProfit'];

$queries[] = [
  "SELECT invoice_items.item_id, getName(item_id) as `item name`, quantity as quantity, (UNIX_TIMESTAMP(invoice_time)*1000) as invoice_time_utc FROM
  `invoice_items` NATURAL JOIN `invoices` 
  WHERE getOwnerId(invoices.invoice_id) = '$owner_id'
  ORDER BY invoice_time", 'productWiseQuantity'];

$queries[] = [
  "SELECT 
  item_id ,getName(item_id) as `item name` ,shops.shop_id ,shops.name as `shop name` ,count(item_id) as frequency FROM 
  (`invoice_items` NATURAL JOIN `invoices`) NATURAL JOIN `shops`
  WHERE owner_id = '$owner_id'
  GROUP BY `item_id`
  ORDER BY frequency desc limit 5", 'mostSold'];

$queries[] = [
  "SELECT 
  item_id ,getName(item_id) as `item name` ,shops.shop_id ,shops.name as `shop name` ,count(item_id) as frequency FROM 
  (`invoice_items` NATURAL JOIN `invoices`) NATURAL JOIN shops
  WHERE owner_id = '$owner_id'
  GROUP BY `item_id`
  ORDER BY frequency limit 5", 'leastSold'];

$queries[] = [
  "SELECT 
  invoice_items.item_id, getName(invoice_items.item_id) as `item name`, count(invoice_items.item_id) as frequency, AVG(price) as 'average price', SUM(price - cost_price)*invoice_items.quantity as profit, SUM(price) as revenue FROM
  `invoice_items`, `owner_items`
  WHERE owner_id = '$owner_id' AND invoice_items.item_id = owner_items.item_id AND getOwnerId(invoice_items.invoice_id) = '$owner_id'
  GROUP BY item_id
  ORDER BY profit desc limit 5", 'mostProfitable'];

$queries[] = [
  "SELECT 
  invoice_items.item_id, getName(invoice_items.item_id) as `item name`, count(invoice_items.item_id) as frequency, AVG(price) as 'average price', SUM(price - cost_price)*invoice_items.quantity as profit, SUM(price) as revenue FROM
  `invoice_items`, `owner_items`
  WHERE owner_id = '$owner_id' AND invoice_items.item_id = owner_items.item_id AND getOwnerId(invoice_items.invoice_id) = '$owner_id'
  GROUP BY item_id
  ORDER BY profit limit 5", 'leastProfitable'];

$queries[] = [
  "SELECT 
    itemCount, shopCount, invoiceCount FROM
    (SELECT COUNT(DISTINCT(item_id)) as itemCount FROM owner_items WHERE owner_id = '$owner_id') as Q1,
    (SELECT COUNT(DISTINCT(invoice_id)) as invoiceCount FROM invoices NATURAL JOIN shops WHERE owner_id = '$owner_id') AS Q2,
    (SELECT COUNT(DISTINCT(shop_id)) as shopCount FROM shops WHERE owner_id = '$owner_id') AS Q3", 'counts', true];

// TODO : Figure out why natural join doesn't work here 
$queries[] = [
  "SELECT 
  SUM((invoice_items.price - owner_items.cost_price)*invoice_items.quantity) as netProfit
  ,SUM(price*invoice_items.quantity) as netRevenue
  FROM
  `invoice_items`, `owner_items`
  WHERE invoice_items.item_id = owner_items.item_id AND `owner_id`='$owner_id' AND getOwnerId(invoice_items.invoice_id) = '$owner_id'
  ", 'ownerData', true];

$queries[] = [
  "SELECT shops.name, SUM((price-getCostPrice(invoice_items.item_id,'$owner_id'))*invoice_items.quantity) as profit, SUM(price*invoice_items.quantity) as revenue FROM
  `invoice_items`, `invoices`, `shops`
  WHERE 
  invoices.invoice_id = invoice_items.invoice_id
  AND invoices.shop_id = shops.shop_id
  AND shops.owner_id = '$owner_id'
  GROUP BY shops.shop_id", 'shopData'];

foreach($queries as $q) generate($q);

$response['queries'] = $queries;
respond(false, "Analytics", $response);

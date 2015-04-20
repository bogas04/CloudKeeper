<?php
session_start();
require_once('db.php');
require_once('funcs.php');
if(!isset($_SESSION['user']) || !isset($_SESSION['user']['username'])) {
  header('Location: index.php');
  die();
}
$mysqli = dbConnect();

$query = 'INSERT INTO `invoice` (.'
  "'".$_POST['']."',".
  "'".$_POST['']."',".
  "'".$_POST['']."',".
  "'".$_POST['']."',".
  "'".$_POST['']."')";

$result = $mysqli->query($query);
$temp = $mysqli->insert_id;

if($result)
  echo "<h1>Added to items table</h1>";

$query = 'INSERT INTO `invoice_items` () VALUES('.
  "'".$temp."',".
  "'".$_POST['']."',".
  "'".$_POST['']."',".
  "'".$_POST['']."',".
  "'".$_POST['']."',".
  "'".$_POST['']."')";
$result = $mysqli->query($query);
if($result)
  echo "<h1>Added to owner_items table</h1>";

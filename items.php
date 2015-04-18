<?php
require_once('php/db.php');
require_once('php/funcs.php');

$mysqli = dbConnect();

$query = "SELECT * FROM `items`";

$result = $mysqli->query($query);

if($result->num_rows == 0) {
  echo "We have no items in our records. <a href='dashboard.php#add-item'>Add one</a> now!";
} else {
  while($item = $result->fetch_assoc(MYSQLI_ASSOC)) {
    echo "<pre>",print_r($item), "</pre>";
  }
}

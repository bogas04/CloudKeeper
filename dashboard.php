<?php
session_start();
require_once('php/db.php');
require_once('php/funcs.php');
if(!isset($_SESSION['user']) || !isset($_SESSION['user']['username'])) {
  header('Location: index.php');
  die();
}
$mysqli = dbConnect();
?>
<!doctype html>
<html>
  <head>
    <title> Dashboard </title>
    <meta charset="utf-8"/>
    <link rel="stylesheet" href="css/bootstrap.min.css"/>
  </head>
  <body>
<div class="container-fluid">
    <h1> Dashboard | <small> <a href="php/logout.php">Logout</a></small></h1>

    <div class="container">
      <div class="col-md-6">  
        <h4> Your Shops </h4>
<?php
// TODO : Move to php/get_shops.php
$query = "SELECT * FROM `shops` WHERE `owner_id` = '". $_SESSION['user']['owner_id']."'";
$result = $mysqli->query($query);
if(!$result) {
  die("Database error");
}
if($result->num_rows == 0) {
  echo "You have no shops.";
} else {
  while($shop = $result->fetch_assoc()) {
    echo '<div>';
    print_r($shop);
    echo '</div>';
  }
}
?>
<button type="button" class="btn btn-link" data-toggle="modal" data-target="#add-shop"> Add a Shop </button>
      </div>
      <div class="col-md-6">
        <h4> Your Items </h4>
<?php
// TODO : Move to php/get_shops.php
$query = "SELECT * FROM `owner_items` WHERE `owner_id` = '". $_SESSION['user']['owner_id']."'";
$result = $mysqli->query($query);
if($result->num_rows == 0) {
  echo "You have no items.";
} else {
  while($item = $result->fetch_assoc()) {
    echo '<div>';
    print_r($item);
    echo '</div>';
  }
}
?>
        You may <a href="items" target="_blank">choose items from our database</a>, 
        or you can <button type="button" class="btn btn-link" data-toggle="modal" data-target="#add-item"> add one yourself </button>
      </div>

    </div>
<div class="modal fade" id="add-shop" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"> Enter Shop Details </h3>
      </div>
      <div class="modal-body">
    <form action="php/add_shop.php" method="post">
      <div class="form-group">
        <input name="name" type="text" class="form-control" placeholder="Name of Shop"/> 
      </div>
      <div class="form-group">
        <textarea name="address" class="form-control" placeholder="Shop Address"></textarea> 
      </div>
      <div class="form-group">
        <input type="text" name="state" class="form-control" placeholder="State"/>
      </div>
      <div class="form-group">
        <input type="text" name="country" class="form-control" placeholder="Country"/>
      </div>
      <div class="form-group">
        <input type="text" name="pincode" class="form-control" placeholder="Pin Code"/> 
      </div>
    </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button class="btn btn-primary"> Add Shop </button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="add-item" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Enter Item Details</h4>
      </div>
      <div class="modal-body">
    <form action="php/add_item.php" method="post">
      <div class="form-group">
        <input name="name" type="text" class="form-control" placeholder="Name of Item"/> 
      </div>
      <div class="form-group">
        <textarea name="description" class="form-control" placeholder="Description"></textarea> 
      </div>
      <div class="form-group">
        <input type="text" name="MRP" class="form-control" placeholder="MRP"/>
      </div>
      <div class="form-group">
        <input name="sellprice" type="text" class="form-control" placeholder="Sell Price"/> 
      </div>
      <div class="form-group">
        <input name="costprice" type="text" class="form-control" placeholder="Cost Price"/>
      </div>
      <div class="form-group">
        <input name="quantity" type="text" class="form-control" placeholder="Quantity"/>
      </div>
    </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button class="btn btn-primary"> Add Item </button>
      </div>
    </div>
  </div>
</div>
</div>
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/dashboard.js"></script>
  </body>
</html>

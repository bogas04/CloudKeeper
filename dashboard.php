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
  </head>
  <body>
    <h1> Dashboard | <small> <a href="php/logout.php">Logout</a></small></h1>

    <div class="container">
      <div class="col-md-6">  
        <h4> Your Shops </h4>
<?php
$query = "SELECT * FROM `shops` WHERE `owner_id` = '". $_SESSION['user']['owner_id']."'";
$result = $mysqli->query($query);
if($result->num_rows == 0) {
  echo "You have no shops.";
} else {
  while($shop = $result->fetch_assoc(MYSQLI_ASSOC)) {
    print_r($shop);
  }
}
?>
        <!-- <button class="btn btn-primary" id="addShop"> Add a shop </button> -->
        <a href="#add-shop"> Add a Shop </a>
      </div>
      <div class="col-md-6">
        <h4> Your Items </h4>
<?php
$query = "SELECT * FROM `owner_items` WHERE `owner_id` = '". $_SESSION['user']['owner_id']."'";
$result = $mysqli->query($query);
if($result->num_rows == 0) {
  echo "You have no items.";
} else {
  while($shop = $result->fetch_assoc()) {
    print_r($shop);
  }
}
?>
        <!-- <button class="btn btn-primary" id="addItem"> Add an Item </button> -->
        You may <a href="items">choose items from our database</a>, or you can <a href="#add-item">add one yourself</a>.
      </div>

    </div>
<?php
echo '<pre>',print_r($_SESSION), '</pre>';
?>
  <div id="add-shop">
    <h4> Enter Shop Details </h3>
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
      <button class="btn btn-primary"> Add Shop </button>
    </form>
  </div>
  <div id="add-item">
    <h4> Enter Item Details </h3>
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
      <button class="btn btn-primary"> Add Item </button>
    </form>
  </div>
  </body>
</html>

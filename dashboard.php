<?php
require_once('php/db.php');
require_once('php/funcs.php');
if(!isLoggedIn()) {
logout();
header('Location: index.php');
die();
}
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
      <h1> <span class="glyphicon glyphicon-cloud"></span> Dashboard | <small><a href="php/logout.php">Logout</a></small></h1>

      <div class="col-md-4">  
        <h3 class="text-center"> <span class="glyphicon glyphicon-shopping-cart"></span> Shops </h3>

        <p class="text-center"> <a href="#add-shop" data-toggle="modal" data-target="#add-shop"> Add a Shop </a> </p>

        <div id="shops"></div>

      </div>

      <div class="col-md-4">
        <h3 class="text-center"> <span class="glyphicon glyphicon-transfer"></span> Invoices </h3>

        <p class="text-center"> <a href="#add-invoice" data-toggle="modal" data-target="#add-invoice"> Add a Invoice </a> </p>

        <div id="invoices"></div>
      </div>

      <div class="col-md-4">
        <h3 class="text-center"> <span class="glyphicon glyphicon-list-alt"></span> Items </h3>

        <p> You may choose items from <a href="items" target="_blank">our database</a>, 
        or you can <a href="#add-item" data-toggle="modal" data-target="#add-item">add item</a> yourself. </p>

        <div id="items"></div>
      </div>
    </div>

    <!-- MODALS -->
    <!-- SHOP MODAL -->
    <div class="modal fade" id="add-shop" tabindex="-1" role="dialog" aria-labelledby="addShop" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h3 class="modal-title"> Enter Shop Details </h3>
          </div>
          <form id="add-shop-form" action="php/add_shop.php" method="post">
            <div class="modal-body">
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
              <div class="message alert"></div>
            </div>
            <div class="modal-footer">
              <a href="#" class="btn btn-default" data-dismiss="modal">Close</a>
              <button class="btn btn-primary"> Add Shop </button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- ITEM MODAL -->
    <div class="modal fade" id="add-item" tabindex="-1" role="dialog" aria-labelledby="addItem" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h3 class="modal-title">Enter Item Details</h3>
          </div>
          <form id="add-item-form" action="php/add_item.php" method="post">
            <div class="modal-body">
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
              <div class="message alert"></div>
            </div>
            <div class="modal-footer">
              <a href="#" class="btn btn-default" data-dismiss="modal">Close</a>
              <button class="btn btn-primary"> Add Item </button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- INVOICE MODAL -->
    <div class="modal fade" id="add-invoice" tabindex="-1" role="dialog" aria-labelledby="addInvoice" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h3 class="modal-title">Enter Invoice Details</h3>
          </div>
          <form id="add-invoice-form" action="php/add_invoice.php" method="post">
            <div class="modal-body">
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
              <div class="message alert"></div>
            </div>
            <div class="modal-footer">
              <a href="#" class="btn btn-default" data-dismiss="modal">Close</a>
              <button class="btn btn-primary"> Add Invoice </button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- SCRIPTS -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/dashboard.js"></script>
  </body>
</html>

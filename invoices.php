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
    <title> Invoices - Dashboard </title>
    <meta charset="utf-8"/>
    <link rel="stylesheet" href="css/bootstrap.min.css"/>
  </head>
  <body>
    <!-- MAIN CONTAINER -->
    <div class="container-fluid">

      <h1> <span class="glyphicon glyphicon-cloud"></span> Dashboard | <small><a href="php/logout.php">Logout</a></small></h1>

      <div class="container-fluid">
        <!-- SIDE MENU -->
        <div class="col-md-2">
          <div class="row">
            <h2> <span class="glyphicon glyphicon-wrench"></span> Settings </h2>
            <ul class="nav nav-pills nav-stacked">
              <li><a href="dashboard.php"><span class="glyphicon glyphicon-cloud"></span> Overview</a> </li>
              <li><a href="shops.php"><span class="glyphicon glyphicon-shopping-cart"></span> Shops</a> </li>
              <li><a href="items.php"><span class="glyphicon glyphicon-list-alt"></span> Items</a> </li>
              <li class="active"><a href="invoices.php"><span class="glyphicon glyphicon-transfer"></span> Invoices</a> </li>
              <li><a href="analytics.php"><span class="glyphicon glyphicon-calendar"></span> Analytics</a> </li>
            </ul>
          </div>
        </div>
        <!-- SIDE MENU ENDS -->
        
        <!-- VIEW -->
        <div class="col-md-10">
          <div class="row">
            <div class="col-md-12">
              <h2> 
                <span class="glyphicon glyphicon-transfer"></span> Invoices 
                <a href="#add-invoice" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#add-invoice"> Add a Invoice </a> 
              </h2>
              <div id="invoices"></div>
            </div>
          </div>
        </div>
        <!-- VIEW ENDS -->
      </div>
    </div>
    <!-- MAIN CONTAINER ENDS -->

    
    <!-- MODALS -->
    <!-- SHOP MODAL -->
    <div class="modal fade" id="add-shop" tabindex="-1" role="dialog" aria-labelledby="addShop" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h2 class="modal-title"> Enter Shop Details </h2>
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
    <!-- EDIT SHOP MODAL -->
    <div class="modal fade" id="edit-shop" tabindex="-1" role="dialog" aria-labelledby="editShop" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h2 class="modal-title"> Enter New Shop Details </h2>
          </div>
          <form id="edit-shop-form" action="php/edit_shop.php" method="post">
            <div class="modal-body">
              <div class="form-group">
                <input name="name" type="text" class="form-control" placeholder="Name of Shop"/> 
              </div>
              <div class="form-group">
                <textarea name="editress" class="form-control" placeholder="Shop Address"></textarea> 
              </div>
              <div class="form-group">
                <input type="text" name="state" class="form-control" placeholder="State"/>
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
            <h2 class="modal-title">Enter Item Details</h2>
          </div>
          <form id="add-item-form" action="php/add_item.php" method="post">
            <div class="modal-body">
              <div class="form-group">
                <label>Item Name</label>
                <input name="name" type="text" class="form-control" placeholder="Name of Item"/> 
                <label>Description</label>
                <textarea name="description" class="form-control" rows="4" placeholder="Description"></textarea> 
              </div>
              <div class="form-group form-inline">
                <label>Maximum Retail Price</label>
                <input type="text" name="mrp" class="form-control" placeholder="MRP"/>
                <label>Sell Price</label>
                <input name="sellprice" type="text" class="form-control" placeholder="Sell Price"/> 
                <label>Cost Price</label>
                <input name="costprice" type="text" class="form-control" placeholder="Cost Price"/>
              </div>
              <div class="form-group">
                <label>Quantity</label>
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

    <!-- EDIT ITEM MODAL -->
    <div class="modal fade" id="edit-item" tabindex="-1" role="dialog" aria-labelledby="addItem" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h2 class="modal-title">Enter Item Details</h2>
          </div>
          <form id="add-item-form" action="php/add_item.php" method="post">
            <div class="modal-body">
              <div class="form-group">
                <label>Item Name</label>
                <input name="name" type="text" class="form-control" placeholder="Name of Item"/> 
                <label>Description</label>
                <textarea name="description" class="form-control" rows="4" placeholder="Description"></textarea> 
              </div>
              <div class="form-group form-inline">
                <label>Maximum Retail Price</label>
                <input type="text" name="mrp" class="form-control" placeholder="MRP"/>
                <label>Sell Price</label>
                <input name="sellprice" type="text" class="form-control" placeholder="Sell Price"/> 
                <label>Cost Price</label>
                <input name="costprice" type="text" class="form-control" placeholder="Cost Price"/>
              </div>
              <div class="form-group">
                <label>Quantity</label>
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
            <h2 class="modal-title">Enter Invoice Details</h2>
          </div>
          <form id="add-invoice-form" action="php/add_invoice.php" method="post">
            <div class="modal-body">
              <div class="form-group form-inline">
                <label> For Shop </label> 
                <select class="form-control" name="shop-id"></select>
              </div>
              <div id="added-items"></div>
              <div class="form-group form-inline">
                <label> Choose Item : </label>
                <select class="form-control" id="item-to-add-id"></select>
                <div class="input-group">
                  <div class="input-group-addon">@</div>
                  <input class="form-control" type="text" id="item-to-add-price" placeholder="Enter price"/>
                </div>
                <div class="input-group">
                  <div class="input-group-addon">x</div>
                  <input class="form-control" type="text" id="item-to-add-quantity" placeholder="Enter quantity"/>
                </div>
                <span id="totalItemPrice"></span>
                <div class="btn btn-info" id="add-this-item">Add</div>
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


    <!-- DELETE MODAL -->
    <div class="modal fade" id="del-invoice" tabindex="-1" role="dialog" aria-labelledby="deleteInvoice" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h2 class="modal-title">Are you sure you want to delete this invoice?</h2>
          </div>
          <div class="modal-body">
            <div class="message alert"></div>
          </div>
          <div class="modal-footer">
            <a href="#" class="btn btn-default" data-dismiss="modal">Close</a>
            <button class="btn btn-primary"> Delete Invoice </button>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="del-shop" tabindex="-1" role="dialog" aria-labelledby="deleteShop" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h2 class="modal-title">Are you sure you want to delete this shop?</h2>
          </div>
          <div class="modal-body">
            <div class="message alert"></div>
          </div>
          <div class="modal-footer">
            <a href="#" class="btn btn-default" data-dismiss="modal">Close</a>
            <button class="btn btn-primary"> Delete Shop </button>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="del-item" tabindex="-1" role="dialog" aria-labelledby="deleteItem" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h2 class="modal-title">Are you sure you want to delete this item?</h2>
          </div>
          <div class="modal-body">
            <div class="message alert"></div>
          </div>
          <div class="modal-footer">
            <a href="#" class="btn btn-default" data-dismiss="modal">Close</a>
            <button class="btn btn-primary"> Item </button>
          </div>
        </div>
      </div>
    </div>

    <!-- SCRIPTS -->
    <script src="bower_components/jquery/dist/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/dashboard.js"></script>
  </body>
</html>

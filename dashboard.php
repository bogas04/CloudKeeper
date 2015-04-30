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
    <!--<link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css"/>-->
    <link rel="stylesheet" href="css/style.css"/>
  </head>
  <body>
    <div class="loading-bar"></div>
    <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a href="#" class="navbar-brand"><span class="glyphicon glyphicon-cloud"></span>  CloudKeeper | Dashboard</a>
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <ul class="nav navbar-nav">
            <li class="active"><a class="text-info" href="dashboard.php">Home</a></li>
            <li><a class="text-success" href="profile.php">Profile</a></li>
            <li><a class="text-success" href="all_items.php">Our Items</a></li>
            <li><a class="text-danger" href="php/logout.php">Logout</a></li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- MAIN CONTAINER -->
    <div class="container-fluid">
      <div class="container-fluid">
        <!-- SIDE MENU -->
        <div class="col-md-2">
          <div class="row">
            <h2> <span class="glyphicon glyphicon-dashboard"></span> Dashboard </h2>
            <ul class="nav nav-pills nav-stacked">
              <li class="active"><a href="dashboard.php"><span class="glyphicon glyphicon-cloud"></span> Overview</a> </li>
              <li><a href="shops.php"><span class="glyphicon glyphicon-shopping-cart"></span> Shops</a> </li>
              <li><a href="items.php"><span class="glyphicon glyphicon-list-alt"></span> Items</a> </li>
              <li><a href="invoices.php"><span class="glyphicon glyphicon-transfer"></span> Invoices</a> </li>
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
                <span class="glyphicon glyphicon-shopping-cart"></span> Shops 
                <a href="#add-shop" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#add-shop"> Add a Shop </a>
              </h2>
              <div id="shops"></div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <h2> 
                <span class="glyphicon glyphicon-transfer"></span> Invoices 
                <a href="#add-invoice" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#add-invoice"> Add a Invoice </a> 
              </h2>
              <div id="invoices"></div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <h2> <span class="glyphicon glyphicon-list-alt"></span> Items </h2>
              <p> 
              You may choose items from <a href="all_items.php" target="_blank">our database</a>, 
              or you can <a href="#add-item" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#add-item">add item</a> yourself.
              </p>
              <div id="items"></div>
            </div>
          </div>
        </div>
        <!-- VIEW ENDS -->
      </div>
    </div>
    <!-- MAIN CONTAINER ENDS -->


    <!-- MODALS -->
    <!-- ADD MODALS -->
    <!-- SHOP MODAL -->
    <div class="modal fade add-modal" id="add-shop" tabindex="-1" role="dialog" aria-labelledby="addShop" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h2 class="modal-title"> Enter Shop Details </h2>
          </div>
          <form id="add-shop-form" action="php/add_shop.php" method="post">
            <div class="modal-body">
              <div class="form-group">
                <label>Name of Shop</label>
                <input name="name" type="text" class="form-control" placeholder="Name of Shop"/> 
              </div>
              <div class="form-group">
                <label>Address</label>
                <textarea name="address" rows="4" class="form-control" placeholder="Shop Address"></textarea> 
              </div>
              <div class="form-group">
                <label>State</label>
                <select name="state" class="form-control">
                  <option>Andaman and Nicobar Islands</option>
                  <option>Andhra Pradesh</option>
                  <option>Arunachal Pradesh</option>
                  <option>Assam</option>
                  <option>Bihar</option>
                  <option>Chandigarh</option>
                  <option>Chhattisgarh</option>
                  <option>Dadra and Nagar Haveli</option>
                  <option>Daman and Diu</option>
                  <option>Delhi</option>
                  <option>Goa</option>
                  <option>Gujarat</option>
                  <option>Haryana</option>
                  <option>Himachal Pradesh</option>
                  <option>Jammu and Kashmir</option>
                  <option>Jharkhand</option>
                  <option>Karnataka</option>
                  <option>Kerala</option>
                  <option>Lakshadweep</option>
                  <option>Madhya Pradesh</option>
                  <option>Maharashtra</option>
                  <option>Manipur</option>
                  <option>Meghalaya</option>
                  <option>Mizoram</option>
                  <option>Nagaland</option>
                  <option>Odisha</option>
                  <option>Puducherry</option>
                  <option>Punjab</option>
                  <option>Rajasthan</option>
                  <option>Sikkim</option>
                  <option>Tamil Nadu</option>
                  <option>Telangana</option>
                  <option>Tripura</option>
                  <option>Uttarakhand</option>
                  <option>Uttar Pradesh</option>
                  <option>West Bengal</option>
                </select>
              </div>
              <div class="form-group">
                <label>Pin Code</label>
                <input type="text" name="pin_code" class="form-control" placeholder="Pin Code"/> 
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
    <div class="modal fade add-modal" id="add-item" tabindex="-1" role="dialog" aria-labelledby="addItem" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h2 class="modal-title">Enter Item Details</h2>
          </div>
          <form id="add-item-form" action="php/add_item.php" method="post">
            <div class="modal-body">
              <div class="form-group form-inline">
                <label>Item Name</label>
                <input name="name" type="text" class="form-control" placeholder="Name of Item" /> 
                <label>Maximum Retail Price ₹</label>
                <input type="text" name="mrp" class="form-control" placeholder="Maximum Retail Price" />
              </div>
              <div class="form-group">
                <label>Description</label>
                <textarea name="description" class="form-control" rows="4" placeholder="Description" ></textarea> 
              </div>
              <div class="form-group form-inline">
                <label>Sell Price ₹</label>
                <input name="sell_price" type="text" class="form-control" placeholder="Sell Price"/> 
                <label>Cost Price ₹</label>
                <input name="cost_price" type="text" class="form-control" placeholder="Cost Price"/>
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
    <div class="modal fade add-modal" id="add-invoice" tabindex="-1" role="dialog" aria-labelledby="addInvoice" aria-hidden="true">
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
              <div id="total-amount"></div>
              <div id="added-items"></div>
              <div class="form-group form-inline">
                <label> Choose Item : </label>
              </div>
              <div class="form-group form-inline form-group-sm">
                <select class="form-control" id="item-to-add-id"></select>
                <div class="input-group">
                  <div class="input-group-addon">@ ₹</div>
                  <input class="form-control" type="text" id="item-to-add-price" placeholder="Enter price"/>
                </div>
                <div class="input-group">
                  <div class="input-group-addon">&times;</div>
                  <input class="form-control" type="text" id="item-to-add-quantity" placeholder="Enter quantity"/>
                  <div class="input-group-addon">=₹ <span id="total-item-price"></span></div>
                </div>
                <div class="btn btn-info" id="item-to-add">Add</div>
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


    <!-- DELETE MODALS -->
    <!-- DELETE INVOCIE -->
    <div class="modal fade delete-modal" id="del-invoice" tabindex="-1" role="dialog" aria-labelledby="deleteInvoice" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h2 class="modal-title">Are you sure you want to delete this invoice?</h2>
          </div>
          <form id="del-invoice-form" action="php/delete_invoice.php" method="post">
            <div class="modal-body">
              This action can not be undone!
              <input type="text" name="invoice_id" class="to-delete-id" value=-1 hidden>
              <div class="message alert"></div>
            </div>
            <div class="modal-footer">
              <a href="#" class="btn btn-default" data-dismiss="modal">Close</a>
              <button class="btn btn-primary"> Delete Invoice </button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- DELETE SHOP -->
    <div class="modal fade delete-modal" id="del-shop" tabindex="-1" role="dialog" aria-labelledby="deleteShop" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h2 class="modal-title">Are you sure you want to delete this shop?</h2>
          </div>
          <form id="del-shop-form" action="php/delete_shop.php" method="post">
            <div class="modal-body">
              This action can not be undone! It will also delete all the invoices related to this shop.
              <input type="text" name="shop_id" class="to-delete-id" value=-1 hidden>
              <div class="message alert"></div>
            </div>
            <div class="modal-footer">
              <a href="#" class="btn btn-default" data-dismiss="modal">Close</a>
              <button class="btn btn-primary"> Delete Shop </button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- DELETE ITEM -->
    <div class="modal fade delete-modal" id="del-item" tabindex="-1" role="dialog" aria-labelledby="deleteItem" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h2 class="modal-title">Are you sure you want to delete this item?</h2>
          </div>
          <form id="del-item-form" action="php/delete_item.php" method="post">
            <div class="modal-body">
              This action can not be undone! This will also delete the invoices done with this item.
              <input type="text" name="item_id" class="to-delete-id" value=-1 hidden>
              <div class="message alert"></div>
            </div>
            <div class="modal-footer">
              <a href="#" class="btn btn-default" data-dismiss="modal">Close</a>
              <button class="btn btn-primary"> Delete Item </button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- EDIT MODALS -->
    <!-- EDIT SHOP MODAL -->
    <div class="modal fade edit-modal" data-type='shop' id="edit-shop" tabindex="-1" role="dialog" aria-labelledby="editShop" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h2 class="modal-title"> Enter New Shop Details </h2>
          </div>
          <form id="edit-shop-form" action="php/update_shop.php" method="post">
            <div class="modal-body">
              <input name="shop_id" class="to-edit-id" hidden/>
              <div class="form-group">
                <label>Name of Shop</label>
                <input name="name" type="text" class="form-control" placeholder="Name of Shop"/> 
              </div>
              <div class="form-group">
                <label>Address</label>
                <textarea name="address" rows="4" class="form-control" placeholder="Shop Address"></textarea> 
              </div>
              <div class="form-group">
                <label>State</label>
                <select name="state" class="form-control">
                  <option>Andaman and Nicobar Islands</option>
                  <option>Andhra Pradesh</option>
                  <option>Arunachal Pradesh</option>
                  <option>Assam</option>
                  <option>Bihar</option>
                  <option>Chandigarh</option>
                  <option>Chhattisgarh</option>
                  <option>Dadra and Nagar Haveli</option>
                  <option>Daman and Diu</option>
                  <option>Delhi</option>
                  <option>Goa</option>
                  <option>Gujarat</option>
                  <option>Haryana</option>
                  <option>Himachal Pradesh</option>
                  <option>Jammu and Kashmir</option>
                  <option>Jharkhand</option>
                  <option>Karnataka</option>
                  <option>Kerala</option>
                  <option>Lakshadweep</option>
                  <option>Madhya Pradesh</option>
                  <option>Maharashtra</option>
                  <option>Manipur</option>
                  <option>Meghalaya</option>
                  <option>Mizoram</option>
                  <option>Nagaland</option>
                  <option>Odisha</option>
                  <option>Puducherry</option>
                  <option>Punjab</option>
                  <option>Rajasthan</option>
                  <option>Sikkim</option>
                  <option>Tamil Nadu</option>
                  <option>Telangana</option>
                  <option>Tripura</option>
                  <option>Uttarakhand</option>
                  <option>Uttar Pradesh</option>
                  <option>West Bengal</option>
                </select>
              </div>
              <div class="form-group">
                <label>Pin Code</label>
                <input type="text" name="pin_code" class="form-control" placeholder="Pin Code"/> 
              </div>
              <div class="message alert"></div>
            </div>
            <div class="modal-footer">
              <a href="#" class="btn btn-default" data-dismiss="modal">Close</a>
              <button class="btn btn-info"> Update Shop </button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- EDIT ITEM MODAL -->
    <div class="modal fade edit-modal" data-type="item" id="edit-item" tabindex="-1" role="dialog" aria-labelledby="addItem" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h2 class="modal-title">Enter New Item Details</h2>
          </div>
          <form id="edit-item-form" action="php/update_item.php" method="post">
            <div class="modal-body">
              <input name="item_id" class="to-edit-id" hidden/>
              <div class="form-group form-inline">
                <label>Item Name</label>
                <input name="name" type="text" class="form-control" placeholder="Name of Item" disabled/> 
                <label>Maximum Retail Price ₹</label>
                <input type="text" name="mrp" class="form-control" placeholder="Maximum Retail Price" disabled/>
              </div>
              <div class="form-group">
                <label>Description</label>
                <textarea name="description" class="form-control" rows="4" placeholder="Description" disabled></textarea> 
              </div>
              <div class="form-group form-inline">
                <label>Sell Price ₹</label>
                <input name="sell_price" type="text" class="form-control" placeholder="Sell Price"/> 
                <label>Cost Price ₹</label>
                <input name="cost_price" type="text" class="form-control" placeholder="Cost Price"/>
                <label>Quantity</label>
                <input name="quantity" type="text" class="form-control" placeholder="Quantity"/>
              </div>
              <div class="message alert"></div>
            </div>
            <div class="modal-footer">
              <a href="#" class="btn btn-default" data-dismiss="modal">Close</a>
              <button class="btn btn-info"> Update Item </button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- SCRIPTS -->
    <script src="bower_components/jquery/dist/jquery.min.js"></script>
    <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="js/views.js"></script>
    <script src="js/service.js"></script>
    <script src="js/handlers.js"></script>
    <script src="js/dashboard.js"></script>
  </body>
</html>

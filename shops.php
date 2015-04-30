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
              <li><a href="dashboard.php"><span class="glyphicon glyphicon-cloud"></span> Overview</a> </li>
              <li class="active"><a href="shops.php"><span class="glyphicon glyphicon-shopping-cart"></span> Shops</a> </li>
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
                <input type="text" name="state" class="form-control" placeholder="State"/>
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

    <!-- DELETE MODALS -->
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
                <input type="text" name="state" class="form-control" placeholder="State"/>
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

    <!-- SCRIPTS -->
    <script src="bower_components/jquery/dist/jquery.min.js"></script>
    <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="js/views.js"></script>
    <script src="js/service.js"></script>
    <script src="js/handlers.js"></script>
    <script src="js/dashboard.js"></script>
  </body>
</html>

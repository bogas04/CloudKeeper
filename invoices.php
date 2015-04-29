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
    <!-- DETAILED INVOICE -->
    <div class="modal fade" id="detailed-invoice" tabindex="-1" role="dialog" aria-labelledby="addInvoice" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h2 class="modal-title">Invoice Details</h2>
          </div>
          <div class="modal-body">
            Invoice Details :
            <div class="detailed-invoice"></div>
            Invoice Items :
            <div class="detailed-items"></div>
          </div>
          <div class="modal-footer">
            <a href="#" class="btn btn-default" data-dismiss="modal">Close</a>
          </div>
        </div>
      </div>
    </div>
    <!-- ADD MODALS -->
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

    <!-- SCRIPTS -->
    <script src="bower_components/jquery/dist/jquery.min.js"></script>
    <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="js/views.js"></script>
    <script src="js/service.js"></script>
    <script src="js/handlers.js"></script>
    <script src="js/invoices.js"></script>
  </body>
</html>

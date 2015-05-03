<?php
require_once('php/db.php');
require_once('php/funcs.php');
require_once('views/index.php');
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
    <link rel="stylesheet" href="assets/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="assets/css/style.css"/>
  </head>
  <body>
    <div class="loading-bar"></div>
    <?php navbar('dashboard'); ?>
    <!-- MAIN CONTAINER -->
    <div class="container-fluid">
      <div class="container-fluid">
        <div class="col-md-2">
          <div class="row">
            <?php sidebar('overview'); ?>
          </div>
        </div>

        <!-- VIEW -->
        <div class="col-md-10">
          <div class="row">
            <div class="col-md-12">  
              <h2>
                <span class="glyphicon glyphicon-shopping-cart"></span> Shops 
                <a href="#add-shop" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#add-shop"> Add a Shop </a>
              </h2>
              <div id="shops" class="scrollable"></div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <h2> 
                <span class="glyphicon glyphicon-transfer"></span> Invoices 
                <a href="#add-invoice" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#add-invoice"> Add a Invoice </a> 
              </h2>
              <div id="invoices" class="scrollable"></div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <h2> <span class="glyphicon glyphicon-list-alt"></span> Items </h2>
              <p> 
              You may choose items from <a href="all_items.php" target="_blank">our database</a>, 
              or you can <a href="#add-item" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#add-item">add item</a> yourself.
              </p>
              <div id="items" class="scrollable"></div>
            </div>
          </div>
        </div>
        <!-- VIEW ENDS -->
      </div>
    </div>
    <!-- MAIN CONTAINER ENDS -->


    <!-- MODALS -->
    <?php modal(); ?>

    <!-- SCRIPTS -->
    <script src="bower_components/jquery/dist/jquery.min.js"></script>
    <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="assets/js/views.js"></script>
    <script src="assets/js/service.js"></script>
    <script src="assets/js/handlers.js"></script>
    <script src="assets/js/dashboard.js"></script>
  </body>
</html>

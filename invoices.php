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
            <?php sidebar('invoices'); ?>
          </div>
        </div>

        <!-- VIEW -->
        <div class="col-md-10">
          <div class="row">
            <div class="col-md-12">
              <h2> <span class="glyphicon glyphicon-transfer"></span> Invoices </h2>
                <form action="php/get_detailed_invoices.php" id="search-form"> 
                  <div class="form-group form-inline">
                    <input name="keyword" type="text" class="form-control keyword" placeholder="Enter search keyword"/>
                    <button class="btn btn-default" id="search-button"><span class="glyphicon glyphicon-search"></span> Search</button>
                    <a class="btn btn-primary pull-right" id="refresh-button"><span class="glyphicon glyphicon-refresh"></span> Refresh</a>
                  </div>
                </form>
              <div id="invoices"></div>
            </div>
          </div>
        </div>
        <!-- VIEW ENDS -->
      </div>
    </div>
    <!-- MAIN CONTAINER ENDS -->

    <!-- MODALS -->
    <?php modal('invoice'); ?>

    <!-- SCRIPTS -->
    <script src="bower_components/jquery/dist/jquery.min.js"></script>
    <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="assets/js/views.js"></script>
    <script src="assets/js/service.js"></script>
    <script src="assets/js/handlers.js"></script>
    <script src="assets/js/invoices.js"></script>
  </body>
</html>

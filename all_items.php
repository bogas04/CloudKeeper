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
    <title> Our Items </title>
    <meta charset="utf-8"/>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="assets/css/style.css"/>
  </head>
  <body>
    <div class="loading-bar"></div>
    <?php navbar('all_items'); ?>
    <!-- MAIN CONTAINER -->
    <div class="container-fluid">
      <div class="container-fluid">
        <div class="col-md-2">
          <div class="row">
            <?php sidebar('all_items'); ?>
          </div>
        </div>

        <!-- VIEW -->
        <div class="col-md-10">
          <h2> Our Items </h2>
          <div class="help-block"> Showing items that you don't own </div>
          <div class="row">
            <div id="all-items"></div>
          </div>
        </div>
        <!-- VIEW ENDS -->
      </div>
    </div>
    <!-- MAIN CONTAINER ENDS -->

    <!-- MODALS -->
    <?php modal('add_from_items'); ?>

    <!-- SCRIPTS -->
    <script src="bower_components/jquery/dist/jquery.min.js"></script>
    <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="assets/js/views.js"></script>
    <script src="assets/js/service.js"></script>
    <script src="assets/js/handlers.js"></script>
    <script src="assets/js/all_items.js"></script>
  </body>
</html>

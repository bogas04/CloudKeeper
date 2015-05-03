<?php
require_once('php/db.php');
require_once('php/funcs.php');
require_once('views/index.php');
if(!isLoggedIn()) {
  logout();
  header('Location index.php');
  die();
}
?>
<!doctype html>
<html>
  <head>
    <title> Dashboard </title>
    <meta charset="utf-8"/>
    <link rel="stylesheet" href="css/bootstrap.min.css"/>
    <link rel="stylesheet" href="css/style.css"/>
  </head>
  <body>
    <div class="loading-bar"></div>
    <?php navbar('dashboard'); ?>
    <!-- MAIN CONTAINER -->
    <div class="container-fluid">
      <div class="container-fluid">
        <div class="col-md-2">
          <div class="row">
            <?php sidebar('analytics'); ?>
          </div>
        </div>
        <!-- VIEW -->
        <div class="col-md-10">
          <h2> <span class="glyphicon glyphicon-calendar"></span> Analytics </h2>
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-4">
                <div class="panel panel-success tile">
                  <div class="panel-heading">
                    <h3>Most Sold Items</h3>
                    <div class="most-sold-items"></div>
                    <h3>Least Sold Items</h3>
                    <div class="least-sold-items"></div>
                  </div> 
                </div>
              </div>
              <div class="col-md-4">
                <div class="panel panel-danger tile">
                  <div class="panel-heading">
                    <h3>Overview</h3>
                    <div class="counts"></div>
                    <h3>Profit/Revenue by Shop</h3>
                    <div class="revenue-by-shop"></div>
                  </div>  
                </div>
              </div>
              <div class="col-md-4">
                <div class="panel panel-active tile">
                  <div class="panel-heading">
                    <h3>Most Profitable Items</h3>
                    <div class="most-profitable-items"></div>
                    <h3>Least Profitable Items</h3>
                    <div class="least-profitable-items"></div>
                  </div> 
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12>">
              <div id="chart" style="margin: 20px;"></div>
              </div>
            </div>
          </div>
        </div>
        <!-- VIEW ENDS -->
      </div>
    </div>
    <!-- MAIN CONTAINER ENDS -->

    <!-- SCRIPTS -->
    <script src="bower_components/jquery/dist/jquery.min.js"></script>
    <script src="bower_components/jquery-knob/dist/jquery.knob.min.js"></script>
    <script src="bower_components/highcharts-release/highcharts.js"></script>
    <script src="bower_components/highcharts-release/highcharts-more.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/views.js"></script>
    <script src="js/analytics.js"></script>
  </body>
</html>

<?php
require_once('php/db.php');
require_once('php/funcs.php');
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
    <!--<link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css"/>-->
    <link rel="stylesheet" href="css/style.css"/>
  </head>
  <body>
    <div class="loading-bar"></div>
    <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <h1> <span class="glyphicon glyphicon-cloud"></span> Dashboard | <small><a href="php/logout.php">Logout</a></small></h1>
        </div>
      </div>
    </nav>
    <!-- MAIN CONTAINER -->
    <div class="container-fluid">
      <div class="container-fluid">
        <!-- SIDE MENU -->
        <div class="col-md-2">
          <div class="row">
            <h2> <span class="glyphicon glyphicon-wrench"></span> Settings </h2>
            <ul class="nav nav-pills nav-stacked">
              <li><a href="dashboard.php"><span class="glyphicon glyphicon-cloud"></span> Overview</a> </li>
              <li><a href="shops.php"><span class="glyphicon glyphicon-shopping-cart"></span> Shops</a> </li>
              <li><a href="items.php"><span class="glyphicon glyphicon-list-alt"></span> Items</a> </li>
              <li><a href="invoices.php"><span class="glyphicon glyphicon-transfer"></span> Invoices</a> </li>
              <li class="active"><a href="analytics.php"><span class="glyphicon glyphicon-calendar"></span> Analytics</a> </li>
            </ul>
          </div>
        </div>
        <!-- SIDE MENU ENDS -->

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

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
    <title> Profile </title>
    <meta charset="utf-8"/>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="assets/css/style.css"/>
  </head>
  <body>
    <div class="loading-bar"></div>
    <?php navbar('profile'); ?>
    <!-- MAIN CONTAINER -->
    <div class="container-fluid">
      <div class="container-fluid">
        <div class="col-md-2">
          <div class="row">
            <?php sidebar(''); ?>
          </div>
        </div>
        <!-- VIEW -->
        <div class="col-md-10">
          <h2> <span class="glyphicon glyphicon-user"></span> Profile <a href="#edit-profile" data-target="#edit-profile" data-toggle="modal" class="btn btn-warning pull-right"> <span class="glyphicon glyphicon-cog"></span> Edit Profile </a> </h2>
          <div id="profile-info" class="jumbotron">
            <dl class="dl-horizontal profile">
              <dt>First Name</dt> <dd class="first-name"></dd>
              <dt>Last Name</dt> <dd class="last-name"></dd>
              <dt>Username</dt> <dd class="username" style="text-transform:none;"></dd>
              <dt>Mobile Phones</dt> <dd class="phones">N/A</dd>
            </dl>
          </div>
        </div>
        <!-- VIEW ENDS -->
      </div>
    </div>
    <!-- MAIN CONTAINER ENDS -->

    <!-- MODALS -->
    <?php modal('profile'); ?>

    <!-- SCRIPTS -->
    <script src="bower_components/jquery/dist/jquery.min.js"></script>
    <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="assets/js/handlers.js"></script>
    <script src="assets/js/views.js"></script>
    <script src="assets/js/service.js"></script>
    <script src="assets/js/profile.js"></script>
  </body>
</html>

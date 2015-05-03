<?php
function modal($arr = ['shop', 'item', 'invoice']) {
  $done = ['invoice' => false, 'shop' => false, 'item' => false, 'add_from_items' => false];
  $arr = is_array($arr) ? $arr : [$arr];
  foreach($arr as $name) {
    if(array_key_exists($name, $done) && !$done[$name]) {
      include_once($name . '.html');
      $done[$name] = true;
    }
  }
}
function navbar($selected) {
  echo '
  <!-- NAVBAR -->
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
          <li' . ($selected === 'dashboard'? ' class="active"' : ''). '><a href="dashboard.php">Home</a></li>
          <li' . ($selected === 'profile'? ' class="active"' : ''). '><a href="profile.php">Profile</a></li>
          <li' . ($selected === 'all_items'? ' class="active"' : ''). '><a href="all_items.php">Our Items</a></li>
          <li><a href="php/logout.php">Logout</a></li>
        </ul>
      </div>
    </div>
    </nav>
';
}
function sidebar($selected) {
  echo ' 
    <!-- SIDEBAR -->
    <h2> <span class="glyphicon glyphicon-dashboard"></span> Dashboard </h2>
    <ul class="nav nav-pills nav-stacked">
    <li'.($selected === 'overview'? ' class="active"':'').'><a href="dashboard.php"><span class="glyphicon glyphicon-cloud"></span> Overview</a> </li>
    <li'.($selected === 'shops'? ' class="active"':'').'><a href="shops.php"><span class="glyphicon glyphicon-shopping-cart"></span> Shops</a> </li>
    <li'.($selected === 'items'? ' class="active"':'').'><a href="items.php"><span class="glyphicon glyphicon-list-alt"></span> Items</a> </li>
    <li'.($selected === 'invoices'? ' class="active"':'').'><a href="invoices.php"><span class="glyphicon glyphicon-transfer"></span> Invoices</a> </li>
    <li'.($selected === 'analytics'? ' class="active"':'').'><a href="analytics.php"><span class="glyphicon glyphicon-calendar"></span> Analytics</a> </li>
    </ul>
';
}

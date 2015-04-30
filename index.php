<?php
require_once('php/funcs.php');
if(isLoggedIn()) {
header('Location: dashboard.php');
die();
}
?>
<!doctype html>
<html> 
  <head>
    <meta charset="utf-8" />
    <title>CloudKeeper</title>
    <link rel="stylesheet" href="css/bootstrap.min.css"/>
  </head>
  <body>
    <div class="jumbotron" style="height:100vh">
      <div class="container">
        <h1><span style="font-size:500%" class="glyphicon glyphicon-cloud"></span> Welcome to CloudKeeper</h1>
        <hr>
        <p>A mobile friendly cloud based service to give powerful shopkeeping management tool and analytics, to low ender vendors. For free!</p>
        <a href="#login-form" class="btn btn-lg btn-primary">Login Now</a> 
        <a href="#signup-form" class="btn btn-lg btn-info">or Sign Up For Free</a>
      </div>
    </div>
    <div class="container-fluid" style="height:100vh">
      <div class="col-md-6">
        <h4> Login </h4>
        <form id="login-form" action="php/login.php" method="post">
          <div class="form-group">
            <label> Username </label>
            <input class="form-control" type="text" name="username" placeholder="Enter your username">
          </div>
          <div class="form-group">
            <label> Password  </label>
            <input class="form-control" type="password" name="password" placeholder="Enter your password">
          </div>
          <div class="message alert"> </div>
          <button class="btn btn-primary"> Log In </button>
        </form>
      </div>
      <div class="col-md-6">
        <h4> Signup </h4>
        <form id="signup-form" action="php/signup.php" method="post">
          <div class="form-group">
            <label> Username </label>
            <input class="form-control" type="text" name="username" placeholder="Enter your username">
          </div>
          <div class="form-group">
            <label> Password </label>
            <input class="form-control" type="password" name="password" placeholder="Enter your password">
          </div>
          <div class="form-group">
            <label> First Name </label>
            <input class="form-control" type="text" name="first_name" placeholder="Enter your first name">
          </div>
          <div class="form-group">
            <label> Last Name </label>
            <input class="form-control" type="text" name="last_name" placeholder="Enter your last name">
          </div>
          <div class="message alert"></div>
          <button class="btn btn-default"> Sign Up </button>
        </form>
      </div>
    </div>
    <h3 class="text-center"><a href="https://github.com/bogas04/CloudKeeper">Github</a></h3>
    <script src="bower_components/jquery/dist/jquery.min.js"></script>
    <script src="js/register.js"></script>
  </body>
</html>

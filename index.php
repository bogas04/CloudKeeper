<?php
  require_once('php/funcs.php');
  init();
?>
<!doctype html>
<html> 
  <head>
    <meta charset="utf-8" />
    <title>CloudKeeper</title>
  </head>
  <body>
    <h1> Welcome to Cloud Keeper </h1>
    <h4> Login </h4>
    <form action="php/login.php" method="post">
      <input type="text" name="username" placeholder="Enter your username">
      <input type="password" name="password" placeholder="Enter your password">
      <button> Log In </button>
    </form>
    <h4> Signup </h4>
    <form action="php/signup.php" method="post">
      <input type="text" name="type" value="owner" hidden/>
      <input type="text" name="username" placeholder="Enter your username">
      <input type="password" name="password" placeholder="Enter your password">
      <input type="text" name="first_name" placeholder="Enter your first name">
      <input type="text" name="last_name" placeholder="Enter your last name">
      <button> Sign Up </button>
    </form>
  </body>
</html>

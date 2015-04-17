<?php
session_start();
if(!isset($_SESSION['user']) || !isset($_SESSION['user']['username'])) {
  header('Location: index.php');
  die();
}
?>
<!doctype html>
<html>
  <head>
    <title> Dashboard </title>
    <meta charset="utf-8"/>
  </head>
  <body>
    <h1> Dashboard | <small> <a href="php/logout.php">Logout</a></small></h1>
  
    <?php
      echo '<pre>',print_r($_SESSION), '</pre>';
      
      
    ?>
  </body>
</html>

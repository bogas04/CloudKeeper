<?php

// helper functions
function respond($error , $msg = "", $data = null) {
  if($error) { session_destroy(); }
  die(json_encode($arr = [ 'error' => $error, 'msg' => $msg, 'data' => $data ]));
}
function init() {
  session_start();
  if(isset($_SESSION['user']) && isset($_SESSION['user']['username'])) {
    header("Location: dashboard.php");
  } else {
    unset($_SESSION['user']);
    session_destroy();
    
    if(!strstr($_SERVER['PHP_SELF'], 'index.php')) {
      header("Location: index.php");
    }
  }
}


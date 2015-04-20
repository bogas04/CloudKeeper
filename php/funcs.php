<?php

// helper functions
function respond($error , $msg = "", $data = null) {
  if($error) { session_destroy(); }
  die(json_encode($arr = [ 'error' => $error, 'msg' => $msg, 'data' => $data ]));
}
function isLoggedIn() {
  session_start();
  return isset($_SESSION['user']) && isset($_SESSION['user']['username']);
}
function logout() {
  session_start();
  unset($_SESSION['user']);
  session_destroy();
}

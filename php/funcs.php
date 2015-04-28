<?php
// helper functions
function respond($error , $msg = "", $data = null) {
  die(json_encode($arr = [ 'error' => $error, 'msg' => $msg, 'data' => $data ]));
}
function respondPretty($error, $msg = "", $data = null) {
  echo "<pre>";
  print_r( [ 'error' => $error, 'msg' => $msg, 'data' => $data ]);
  echo "</pre>";
  die();
}
function isLoggedIn() {
  startSession();
  return isset($_SESSION['user']) && isset($_SESSION['user']['username']);
}
function logout() {
  startSession();
  unset($_SESSION['user']);
  session_destroy();
}
function startSession() {
  if(session_status() == PHP_SESSION_NONE) {
    session_start();
  }
}

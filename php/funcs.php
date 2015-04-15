<?php

// helper functions
function respond($error , $msg = "", $data = null) {
  if($error) { session_destroy(); }
  die(json_encode($arr = [ 'error' => $error, 'msg' => $msg, 'data' => $data ]));
}


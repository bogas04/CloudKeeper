<?php

require_once('funcs.php');
session_start();
if(!isset($_SESSION['user'])) {
  respond(true, 'log in first', []);
} else {
  unset($_SESSION['user']);
  session_destroy();
  respond(false, 'successfuly logged out', []);
}


<?php
require_once('defines.php');

function rejectUsername($username) {
  return strlen($username) < 4 || preg_match('/^[0-9a-zA-Z_]+$/', $username) !== 1;
}
function rejectPassword($password) {
  return !isset($password) || strlen($password) < 8 || strlen($password) > 20;
}
function hashPassword($password) {
  $options = [
    'cost' => 11,
    'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
  ];
  return password_hash($password, PASSWORD_BCRYPT, $options);
}
function dbConnect($host = DB_HOST, $user = DB_USER, $password = DB_PASS, $database = DB_NAME) {
  return new mysqli($host, $user, $password, $database);  
}


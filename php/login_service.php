<?php

session_start();

if($_SESSION['logged_in'] === true) {
  // redirect to page where it came from.
  header("Location: index.php");
} else {
  $username = $_POST['username'];
  $password = $_POST['password'];
  // Validate
  // if(!isset($username) || !isset($password)) {
  //
  //  header("Location: index.php?m=1");
  //
  // }
  // Sanitize
  //  
  // Query DB
  //
  // Set session
  // $_SESSION['logged_in'] = true;
  //
  // redirect
}

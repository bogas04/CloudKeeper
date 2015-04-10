<?php
session_start();
if($_SESSION['logged_in']) {
  echo "Logged in ! <a href='logout.php'> Log Out </a>";
} else {
  echo "Please ";
  echo "<a href='login.php'> Log In </a>";
}


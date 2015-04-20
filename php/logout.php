<?php
require_once('funcs.php');
session_start();
unset($_SESSION['user']);
session_destroy();
header("Location: ../");
die();

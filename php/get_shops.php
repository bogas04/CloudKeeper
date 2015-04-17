<?php
require_once('db.php');
require_once('funcs.php');
init();

$username = $_SESSION['user']['username'];

$query = "SELECT * FROM `shops` WHERE "



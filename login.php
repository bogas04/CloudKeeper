<?php
session_start();

$_SESSION['logged_in'] = true;

header("Location: index.php");

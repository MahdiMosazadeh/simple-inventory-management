<?php 
session_start();
require_once '../Scripts/functions.php';

$_SESSION['logged_in']= null;
redirect('../');
?>
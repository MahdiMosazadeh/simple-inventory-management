<?php 
session_start();
require_once '../Scripts/functions.php';

$_SESSION['logged_in']= null;// خالی کردن متغییر وضعیت لاگین کاربر
redirect('../');
?>
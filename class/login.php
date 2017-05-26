<?php
session_start();
require("login.class.php");
$email=filter_var(trim($_POST['usr']), FILTER_SANITIZE_EMAIL);
$password=strip_tags(trim($_POST['pwd']));
$log = new Login($email,$password);
echo $log->msg;
?>

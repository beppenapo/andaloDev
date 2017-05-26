<?php
session_start();
$sessione=(!isset($_SESSION['id']))?'hidden':'';
if (isset($_SESSION['id'])) {
    $sessione ='';
    $logInOut = '<a href="#" data-toggle="tooltip" data-placement="left" id="logout" title="termina sessione di lavoro"><i class="fa fa-sign-out" aria-hidden="true"></i> logout</a>';
}else {
    $sessione = 'hidden';
    $logInOut = '<a href="#" data-toggle="tooltip" data-placement="left" id="login" title="accedi alla tua bacheca personale"><i class="fa fa-sign-in" aria-hidden="true"></i> login</a>';
}
?>

<?php
session_start();
require("../class/geom.class.php");
$class = new Geom();
echo $class->extent();
?>

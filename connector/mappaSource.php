<?php
session_start();
require("../class/geom.class.php");
$class = new Geom();
$json = $class->geoJson();
echo $json[0]['punti'];
?>

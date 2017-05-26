<?php
require("conn.class.php");
$id=39;
$email="beppenapo@gmail.com";
$pwd = "Strat0Caster";
$dbConn = new Conn;
$pdo = $dbConn->pdo();
$salt = '$2y$11$' . substr(md5(uniqid(rand(), true)), 0, 22);
$password =hash('sha512',$pwd . $salt);
$sql= "UPDATE usr SET pwd = :pwd, salt = :salt WHERE id = :id";
$prep = $pdo->prepare($sql);
$prep->bindParam(':pwd',$password);
$prep->bindParam(':salt',$salt);
$prep->bindParam(':id',$id);
$exec=$prep->execute();
echo $exec===TRUE ?'ok password aggiornata': 'errore da qualche parte';
?>

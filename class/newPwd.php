<?php
require("conn.class.php");
$dbConn = new Conn;
$pdo = $dbConn->pdo();
$pwd = "Strat0Caster";
//$pwdRand = array_merge(range('A','Z'), range('a','z'), range(0,9));
//for($i=0; $i < 10; $i++) {$pwd .= $pwdRand[array_rand($pwdRand)];}
$key = '$2y$11$';
$salt = substr(hash('sha512',uniqid(rand(), true).$key.microtime()), 0, 22);
$password =hash('sha512',$pwd . $salt);

$sql= "INSERT INTO usr(email,pwd,salt,classe,attivo) VALUES('beppenapo@arc-team.com', '".$password."', '".$salt."', 1,1);";
$prep = $pdo->prepare($sql);
try {
    $exec=$prep->execute();
    echo 'ok utente creato';
} catch (Exception $e) {
    echo "errore: ".$e->getMessage();
}

?>

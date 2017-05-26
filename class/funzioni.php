<?php
function fotoRandom(){
    $dbConn = new Conn;
    $pdo = $dbConn->pdo();
    $sql= "SELECT s.dgn_numsch, f.path FROM scheda s, file f WHERE f.id_scheda = s.id ORDER BY random() LIMIT 6;";
    $exec = $pdo->prepare($sql);
    try {
        $exec->execute();
        $arr = $exec->fetchAll(PDO::FETCH_ASSOC);
        return $arr;
    } catch (Exception $e) {
        return  "errore: ".$e->getMessage();
    }
}
?>

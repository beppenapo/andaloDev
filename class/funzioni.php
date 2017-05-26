<?php
function fotoRandom(){
    $dbConn = new Conn;
    $pdo = $dbConn->pdo();
    $sql= "SELECT s.id as scheda, s.dgn_numsch, f.path FROM scheda s, file f WHERE f.id_scheda = s.id ORDER BY random() LIMIT 3;";
    $exec = $pdo->prepare($sql);
    try {
        $exec->execute();
        $arr = $exec->fetchAll(PDO::FETCH_ASSOC);
        return $arr;
    } catch (Exception $e) {
        return  "errore: ".$e->getMessage();
    }
}
function comuniCoo(){
    $dbConn = new Conn;
    $pdo = $dbConn->pdo();
    $sql= "SELECT comune, st_xmin(geom) as xmin, st_ymin(geom) as ymin, st_xmax(geom) as xmax, st_ymax(geom) as ymax FROM comuni GROUP BY comune, geom ORDER BY comune ASC;";
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

<?php
/**
 *
 */
require("conn.class.php");
class Db extends Conn{

    public function select($sql){
        $pdo = $this->pdo();
        $exec = $pdo->prepare($sql);
        try {
            $exec->execute();
            $out = $exec->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            $out =  "errore: ".$e->getMessage();
        }
        return $out;
    }

    public function row($sql){
        try {
            $row = $this->pdo()->query($sql)->rowCount();
            return $row;
        } catch (Exception $e) {
            return  "errore: ".$e->getMessage();
        }
    }
}

?>

<?php /**
 *
 */
require("db.class.php");
class statIndex extends Db{

    public function tot(){
        $sql = "select s.id from scheda s, ricerca r where r.hub=1 and s.fine = 2 and s.cmp_id = r.id;";
        return $this->row($sql);
    }
    public function totFonti(){
        $tot = $this->tot();
        $sql = "select l.id,l.etichetta, l.fonte, count(s.*) as tot, case l.id
            when 1 then '#52C734'
            when 2 then '#008000'
            when 4 then '#FF00FF'
            when 5 then '#FFCA01'
            when 6 then '#71FF40'
            when 7 then '#00FF00'
            when 8 then '#FF0000'
            when 9 then '#0095D8'
            when 10 then '#FF5C76'
            else '#ffffff' end as css from scheda s, lista_tipo_scheda l, ricerca r where r.hub = 1 and s.fine = 2 and s.cmp_id = r.id and s.dgn_tpsch = l.id group by l.id order by tot desc;";
        return $this->select($sql);
    }

    public function tpschList(int $tpsch){
        $sql = "SELECT scheda.id, scheda.dgn_dnogg FROM scheda, ricerca WHERE scheda.cmp_id = ricerca.id AND scheda.fine = 2 AND ricerca.hub = 1 AND dgn_tpsch = ".$tpsch.";";
        return json_encode($this->select($sql));
    }
}
 ?>

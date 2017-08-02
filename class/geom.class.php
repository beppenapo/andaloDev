<?php /**
 *
 */
require("fonte.class.php");
class Geom extends Fonte{
    public function geoJson(){
        $sql = "SELECT row_to_json(poi) as punti FROM (
                    SELECT 'FeatureCollection' As type, array_to_json(array_agg(f)) As features FROM (
                        SELECT 'Feature' As type, ST_AsGeoJSON(st_centroid(centroidi.the_geom))::json As geometry, row_to_json(dati) As properties
                        FROM (select id_area, the_geom from area_int_poly union select id_area, the_geom from area_int_line) As centroidi
                        INNER JOIN (
                            SELECT scheda.id as id_scheda, area.id as id_area, area.nome as area, scheda.dgn_numsch, scheda.dgn_tpsch, tipo.fonte, scheda.dgn_dnogg, prv.denric AS provenienza, case scheda.dgn_tpsch when 1 then '#52C734' when 2 then '#008000' when 4 then '#FF00FF' when 5 then '#FFCA01' when 6 then '#71FF40' when 7 then '#00FF00' when 8 then '#FF0000' when 9 then '#0095D8' when 10 then '#FF5C76' else '#ffffff' end as css
                            FROM area, aree_scheda, scheda, ricerca cmp, ricerca prv, lista_tipo_scheda tipo
                            WHERE aree_scheda.id_scheda = scheda.id AND aree_scheda.id_area = area.id AND scheda.cmp_id = cmp.id AND scheda.prv_id = prv.id AND scheda.dgn_tpsch = tipo.id AND cmp.hub = 1 AND scheda.fine = 2 AND area.tipo = 1
                        ) As dati ON centroidi.id_area = dati.id_area
                    ) As f
                )  As poi;";
        return $this->select($sql);
    }

    public function extent(){
        $sql="select st_extent(st_collect(p.the_geom, l.the_geom)) as extent from area_int_poly p, area_int_line l;";
        $ext = $this->select($sql);
        $ext = substr($ext[0]['extent'],4,-1);
        $ext = str_replace(' ',',',$ext);
        $extent = explode(',',$ext);
        return $ext;
    }
}
 ?>

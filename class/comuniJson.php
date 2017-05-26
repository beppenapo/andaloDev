<?php
/**
 * GET GeoJSON from PostGIS
 * Query a PostGIS table or view and return the results in GeoJSON format, suitable for use in OpenLayers, Leaflet, etc.
 * Author:  Bryan R. McBride, GISP, adapted by G.Moes
 * Contact: bryanmcbride.com
 * GitHub:  https://github.com/bmcbride/PHP-Database-GeoJSON
 *
 * @param       string      $geotable       The PostGIS layer name *REQUIRED*
 * @param       string      $geomfield      The PostGIS geometry field *REQUIRED*
 * @param       string      $srid           The SRID of the returned GeoJSON *OPTIONAL (If omitted, EPSG: 2169 will be used)*
 * @param       string      $fields         Fields to be returned *OPTIONAL (If omitted, all fields will be returned)*
 *                              NOTE- Uppercase field names should be wrapped in double quotes
 * @param       string      $parameters     SQL WHERE clause parameters *OPTIONAL*
 * @param       string      $orderby        SQL ORDER BY constraint *OPTIONAL*
 * @param       string      $sort           SQL ORDER BY sort order (ASC or DESC) *OPTIONAL*
 * @param       string      $limit          Limit number of results returned *OPTIONAL*
 * @param       integer     $precision      digits of returned geojson 6 = 0.111 m submeter as DEFAULT *OPTIONAL*
 * @param       real        $simplify       simplify geometry to >5.0m as DEFAULT *OPTIONAL*
 * @param       string      $offset         Offset used in conjunction with limit *OPTIONAL*
 * @return      string                  resulting geojson string
 */


# Connect to PostgreSQL database You need to pass here the credentials to connect to Your database
require("conn.class.php");
$dbConn = new Conn;
$pdo = $dbConn->pdo();


function escapeJsonString($value) { # list from www.json.org: (\b backspace, \f formfeed)
    $escapers = array("\\", "/", "\"", "\n", "\r", "\t", "\x08", "\x0c");
    $replacements = array("\\\\", "\\/", "\\\"", "\\n", "\\r", "\\t", "\\f", "\\b");
    $result = str_replace($escapers, $replacements, $value);
    return $result;
}

# Retrive URL variables
if (empty($_GET['geotable'])) {
    echo "devi inserire il nome della tabella: <i>geotable</i>";
    exit;
} else {
    $geotable = $_GET['geotable'];
}
if (empty($_GET['geomfield'])) {
    $geomfield='geom';
} else {
    $geomfield = $_GET['geomfield'];
}
if (empty($_GET['srid'])) {
    $srid = 3857;    // change this if You need another standard SRID
} else {
    $srid = $_GET['srid'];
}
if (empty($_GET['fields'])) {
    $fields = '*';
} else {
    $fields = $_GET['fields'];
    $parameters = $_GET['where'];
    $bbox = $_GET['bbox'];
}

if (empty($_GET['precision'])) {
    $precision = 6;    // change this to Your needs
} else {
    $precision = $_GET['precision'];
}
if (empty($_GET['simplify'])) {
    $simplify = 5.0;   // change this to Your needs
} else {
    $simplify = $_GET['simplify'];
}
if (empty($_GET['sort'])) {
    $sort = 'ASC';
} else {
    $sort = $_GET['sort'];
}
$orderby = $_GET['orderby'];
$limit      = $_GET['limit'];
$offset     = $_GET['offset'];

# Build SQL SELECT statement and return the geometry as a GeoJSON element in EPSG: 4326
//$sql = "SELECT " . pg_escape_string($fields) . ", st_asgeojson(st_transform(ST_SimplifyPreserveTopology(" . pg_escape_string($geomfield) . ",".$simplify."),4326),".$precision.") AS geojson FROM " . pg_escape_string($geotable);
$sql = "SELECT " . pg_escape_string($fields) . ", st_asgeojson(" . pg_escape_string($geomfield) . ") AS geojson FROM " . pg_escape_string($geotable);
if (strlen(trim($parameters)) > 0) { $sql .= " WHERE " . str_replace("''", "'", pg_escape_string($parameters)); }
if (strlen(trim($parameters)) > 0 AND strlen(trim($bbox)) > 0){ $sql .= " AND geom &&  st_transform(st_makeenvelope(".pg_escape_string ($bbox).",4326),".$srid.")";}
if (strlen(trim($parameters)) <= 0 AND strlen(trim($bbox)) > 0) { $sql .= " WHERE geom &&  st_transform(st_makeenvelope(".pg_escape_string ($bbox).",4326),".$srid.")";}
if (strlen(trim($orderby)) > 0) { $sql .= " ORDER BY " . pg_escape_string($orderby) . " " . $sort;}
if (strlen(trim($limit)) > 0) { $sql .= " LIMIT " . pg_escape_string($limit);}
if (strlen(trim($offset)) > 0) { $sql .= " OFFSET " . pg_escape_string($offset);}
//echo $sql;
$prep = $pdo->prepare($sql);

$output    = '';
$rowOutput = '';
try {
    $prep->execute();
    $out = $prep->fetchAll(PDO::FETCH_ASSOC);
    foreach ($out as $key => $row) {
        $rowOutput = (strlen($rowOutput) > 0 ? ',' : '') . '{"type": "Feature", "geometry": ' . $row['geojson'] . ', "properties": {';
        $props = '';
        $id    = '';
        foreach ($row as $key => $val) {
            if ($key != "geojson") {
                $props .= (strlen($props) > 0 ? ',' : '') . '"' . $key . '":"' . escapeJsonString($val) . '"';
            }
            if ($key == "id") {
                $id .= ',"id":"' . escapeJsonString($val) . '"';
            }
        }

        $rowOutput .= $props . '}';
        $rowOutput .= $id;
        $rowOutput .= '}';
        $output .= $rowOutput;
    }
    $output = '{"type": "FeatureCollection", "features": [ ' . $output . ' ]}';

    header('Content-type:application/json;charset=utf-8');
    echo json_encode( $sql);

} catch (Exception $e) {
    echo "errore: ".$e->getMessage();
}
?>

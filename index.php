<?php
require('class/init.php');
require("class/fonte.class.php");
$stat = new Fonte();
$tot = $stat->tot();
$totFonti = $stat->totFonti();
$z = 0;
foreach ($totFonti as $key => $value) {
    $z++;
    $isto .= "<input type='hidden' value='".$value['tot']."' id='".$value['fonte']."' class='istoDiv' name='istoValue' data-id='".$value['id']."' data-bg='".$value['css']."' />";
}
?>
<!DOCTYPE html>
<html lang="it">
    <head>
        <?php require("inc/head.php"); ?>
        <link href="css/footable.bootstrap.min.css" rel="stylesheet">
        <link href="css/index.css" rel="stylesheet" media="screen" />
    </head>
    <body>
        <header id="mainHeader"><?php require("inc/header.php"); ?></header>
        <aside id="mainNavigation" class="animate"><?php require("inc/navigation.php"); ?></aside>
        <section id="mainSection" class="animate">
            <div class="container-fluid">
                <div class="row" id="totFonti">
                    <?php echo $isto; ?>
                    <div id="istoTitle" class="bg-green">
                        <span>TOT. FONTI</span>
                        <span><?php echo $tot; ?></span>
                    </div>
                    <div id="isto" class="bg-green">
                        <svg id="chart"></svg>
                    </div>
                </div>
                <div class="row" id="lista">
                    <div class="col-xs-12">
                        <div class="panel panel-inverse">
                            <div class="panel-heading">
                                <div class="col-xs-10">Lista delle fonti che parlano di <strong></strong></div>
                                <div class="col-xs-2 text-right"><i class="fa fa-times"></i></div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="lista">
                                <table class="table table-hover foo" id="tableSchede" data-target="#schedaFiltro"></table>
                            </div>
                            <div class="panel-footer" id="schedaFiltro"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="panel panel-inverse">
                            <div class="panel-heading">Mappa dei siti</div>
                            <div id="mappa" class="panel-body">
                                <div id="mapToolBar">
                                    <div class="btn-toolbar" role="toolbar" aria-label="...">
                                        <div class="btn-group" role="group" aria-label="...">
                                            <button class="btn btn-primary hidden-xs hidden-sm hidden-md" id="status" disabled="disabled">ciao qui vengono scritti i nomi dei siti</button>
                                        </div>

                                        <div class="btn-group" role="group" aria-label="...">
                                            <button type="button" class="btn btn-default" id="zoomin"><i class="fa fa-plus"></i></button>
                                            <button type="button" class="btn btn-default" id="zoomout"><i class="fa fa-minus"></i></button>
                                            <button type="button" class="btn btn-default" id="zoomHome"><i class="fa fa-bullseye"></i></button>
                                            <button type="button" class="btn btn-default" id="geoloc"><i class="fa fa-map-marker"></i></button>
                                        </div>
                                        <div class="btn-group" data-toggle="buttons" role="group" aria-label="...">
                                            <label class="btn btn-default active tt" for="osm" title="openstreetmap"> <input type="radio" name="baseLyr" id="osm" value="osm" autocomplete="off" checked><i class="fa fa-map"></i></label>
                                            <label class="btn btn-default tt" for="sat" title="foto satellitare"> <input type="radio" name="baseLyr" id="sat" value="sat" autocomplete="off"><i class="fa fa-globe"></i></label>
                                            <label class="btn btn-default tt active" for="switch" title="punti di interesse"> <input type="checkbox" name="vectorLyr" id="lyr" value="lyr" autocomplete="off" checked><i class="fa fa-list"></i></label>
                                        </div>
                                    </div>
                                </div>
                                <div id="switchLayer" class="panel panel-default">
                                    <div class="panel-heading"><i class="fa fa-ban"></i> Aree di interesse</div>
                                    <div class="list-group" id="btnLayer"></div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <footer id="mainFooter"><?php require("inc/footer.php"); ?></footer>
        <div id="popup"></div>

        <?php require("lib/script.php"); ?>
        <script src="http://d3js.org/d3.v3.min.js" language="JavaScript"></script>
        <script src="js/areaChart.js" language="JavaScript"></script>
        <script src="js/index.js" language="JavaScript"></script>
    </body>
</html>

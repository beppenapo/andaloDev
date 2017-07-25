<?php
require('class/init.php');
require("class/statIndex.class.php");
$stat = new statIndex();
$tot = $stat->tot();
$totFonti = $stat->totFonti();
$z = 0;
foreach ($totFonti as $key => $value) {
    $z++;
    // $isto .= "<div class='istoDiv bg-".$value['css']."' id='".$value['fonte']."' data-tot='".$value['tot']."' data-zindex='".$z."'>".$value['etichetta']." (".$value['tot'].")</div>";
    $isto .= "<input type='hidden' value='".$value['tot']."' id='".$value['fonte']."' class='istoDiv' name='istoValue' data-bg='".$value['css']."' />";
}
?>
<!DOCTYPE html>
<html lang="it">
    <head>
<<<<<<< HEAD
        <?php require("inc/head.php"); ?>
        <link href="css/index.css" rel="stylesheet" media="screen" />
=======
        <link href="https://cdn.rawgit.com/novus/nvd3/v1.8.1/build/nv.d3.css" rel="stylesheet" media="screen" />
        <?php require("inc/head.php"); ?>
>>>>>>> eb2328d3627aa1a4546ec6c58658daa4986c8042
    </head>
    <body onload="initindex()">
        <header id="mainHeader"><?php require("inc/header.php"); ?></header>
        <aside id="mainNavigation" class="animate"><?php require("inc/navigation.php"); ?></aside>
        <section id="mainSection" class="animate">
            <div class="container-fluid">
                <div class="row" id="totFonti">
                    <div id="istoTitle" class="bg-green">
                        <span>TOT. FONTI</span>
                        <span><?php echo $tot; ?></span>
                    </div>
                    <?php echo $isto; ?>
                    <div id="isto" class="bg-green">
                        <svg id="chart"></svg>
                    </div>
                </div>
                <div class="row">
<<<<<<< HEAD
                    <div class="col-xs-12">
=======
                    <div class="col-xs-12 chartWrap">
                        <div id='chart'></div>
                    </div>
                </div>
                <div class="row">
                    <div class="fotoTitle col-sm-4 col-lg-3">
                        <div id="totFonti" class="widget bg-red">
                            <div class="widget-title">
                                <h3>FOTO CARICATE</h3>
                                <h1>9563</h1>
                            </div>
                            <div class="widget-icon"><i class="fa fa-camera-retro" aria-hidden="true"></i></div>
                        </div>
                    </div>
                    <div class="fotoListDiv col-sm-8 col-lg-9">
                        <div class="overlayTip"><h4>Foto random <small class="visible-xs-block visible-sm-block visible-md-block">clicca sulla foto per aprire la scheda relativa</small></h4></div>
                        <div class="list-group">
                            <?php
                            $fotoArr = fotoRandom();
                            foreach ($fotoArr as $key => $foto) {
                                echo "<div class='fotoList list-group-item col-sm-4' data-scheda='".$foto['scheda']."' data-path='foto/".$foto['path']."' data-tooltip='tooltip' title='apri la scheda ".$foto['dgn_numsch']."'></div>";
                            }
                            ?>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-8 col-xs-12">
>>>>>>> eb2328d3627aa1a4546ec6c58658daa4986c8042
                        <div class="panel panel-inverse">
                            <div class="panel-heading">Mappa dei siti</div>
                            <div id="mappa" class="panel-body"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <footer id="mainFooter"><?php require("inc/footer.php"); ?></footer>
        <div id="popup"></div>

        <?php require("lib/script.php"); ?>
<<<<<<< HEAD
        <script src="http://d3js.org/d3.v3.min.js" language="JavaScript"></script>
        <script src="js/areaChart.js" language="JavaScript"></script>
=======
        <script src="https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.2/d3.min.js" charset="utf-8"></script>
        <script src="https://cdn.rawgit.com/novus/nvd3/v1.8.1/build/nv.d3.min.js"></script>
        <script src="js/lineGraph.js"></script>
>>>>>>> eb2328d3627aa1a4546ec6c58658daa4986c8042
        <script>
        $(document).ready(function(){
            setChart();
            var data=[], bg=[], text=[];
            var istoDiv = $(".istoDiv");
            $.each(istoDiv, function(i,el){
                var e = {value:$(el).val(), label: $(el).attr('id')};
                data.push(e);
                bg.push($(el).data('bg'));
            });
            var config = rectangularAreaChartDefaultSettings();
            config.expandFromLeft = false;
            config.expandFromTop = false;
            config.maxValue = 100;
            config.labelAlignDiagonal = true;
            config.colorsScale = d3.scale.ordinal().range(bg);
            config.textColorScale = d3.scale.ordinal().range(["#fff"]);
            config.animateDelay = 50;
            loadRectangularAreaChart("chart", data, config);
        });

        function setChart(){
            var istoWidth = getCss('isto',null,'width');
            var istoTitleWidth = getCss('istoTitle',null,'width');
            document.getElementById('chart').setAttribute("width", istoWidth-istoTitleWidth+50);
            document.getElementById('chart').setAttribute("height", '120');
        }
        </script>
    </body>
</html>

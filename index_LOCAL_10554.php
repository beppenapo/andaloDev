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
        <?php require("inc/head.php"); ?>
        <link href="css/index.css" rel="stylesheet" media="screen" />
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
                    <div class="col-xs-12">
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
        <script src="http://d3js.org/d3.v3.min.js" language="JavaScript"></script>
        <script src="js/areaChart.js" language="JavaScript"></script>
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

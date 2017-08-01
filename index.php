<?php
require('class/init.php');
require("class/statIndex.class.php");
$stat = new statIndex();
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
    <body onload="initindex()">
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
                                <div class="col-xs-11">Lista delle fonti che parlano di <strong></strong></div>
                                <div class="col-xs-1 text-right"><i class="fa fa-times"></i></div>
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
            var schedeArr = getTipoSk();
            setChart();
            var data=[], bg=[];
            var istoDiv = $(".istoDiv");
            $.each(istoDiv, function(i,el){
                var e = {value:$(el).val(), label: $(el).attr('id'), tpsch:$(el).data('id')};
                data.push(e);
                bg.push($(el).data('bg'));
            });
            //console.log(data[0].bg);
            var config = rectangularAreaChartDefaultSettings();
            config.expandFromLeft = false;
            config.expandFromTop = false;
            config.maxValue = 100;
            config.labelAlignDiagonal = true;
            config.colorsScale = d3.scale.ordinal().range(bg);
            config.textColorScale = d3.scale.ordinal().range(["#fff"]);
            config.animateDelay = 50;
            loadRectangularAreaChart("chart", data, config);

            $("rect").on('click', function(){
                var t = $(this).data('tpsch'), lista='';
                var obj = $.grep(schedeArr, function(e){ return e.id == t; });
                $(".panel-heading>div>strong").html(obj[0].argomento);
                $(".panel-heading i").css({"cursor":"pointer"}).on('click', function(){$("#lista").slideUp('fast');});
                $("#schedaFiltro").html('');
                $.ajax({
                    type: "POST",
                    url: "connector/tpschList.php",
                    dataType:'json',
                    data: {tpsch:t},
                    success: function(data){
                        $.each(data,function(k,v){
                            lista += "<tr>";
                            lista += "<td>"+v.dgn_dnogg+"</td>";
                            lista += "<td data-type='html'><a href='scheda.php?sk="+v.id+"' title='apri scheda' data-tooltip='tooltip'><i class='fa fa-arrow-right'></i></a></td>";
                            lista += "</tr>";
                        });
                        $("#tableSchede").html(lista);
                        $('.foo').footable({ "filtering": { "enabled": true } });
                        $("#tableSchede>thead>tr>th>form")
                            .removeClass('form-inline')
                            .detach()
                            .appendTo("#schedaFiltro")
                            .find('button.dropdown-toggle')
                            .remove();
                        if(!$('#lista').is(":visible")){$("#lista").slideDown('fast');}
                    }
                });
            });
        });



        </script>
    </body>
</html>

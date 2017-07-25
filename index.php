<?php
require('class/init.php');
require("class/statIndex.class.php");
$stat = new statIndex();
$tot = $stat->tot();
$totFonti = $stat->totFonti();
$isto;
foreach ($totFonti as $key => $value) {
    $isto .= "<div class='istoDiv' id='".$value['fonte']."' data-perc='".$value['perc']."'>".$value['etichetta']." (".$value['tot'].")</div>";
}
?>
<!DOCTYPE html>
<html lang="it">
    <head>
        <?php require("inc/head.php"); ?>
        <style>
            .istoDiv{display:inline-block;border:1px solid #f10808;}
            .widget>div{display:inline-block;}
        </style>
    </head>
    <body onload="initindex()">
        <header id="mainHeader"><?php require("inc/header.php"); ?></header>
        <aside id="mainNavigation" class="animate"><?php require("inc/navigation.php"); ?></aside>
        <section id="mainSection" class="animate">
            <div class="container-fluid">
                <div class="row" id="totFonti">
                    <div class="col-xs-12">
                        <div class="widget bg-green">
                            <div class="widget-title">
                                <h3>TOT. FONTI</h3>
                                <h1><?php echo $tot; ?></h1>
                            </div>
                            <!-- <div class="widget-icon"><i class="fa fa-archive" aria-hidden="true"></i></div> -->
                            <div id="isto"><?php echo $isto; ?></div>
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
        <script>
        $(document).ready(function(){
            var heightFotoList = $(".fotoTitle").innerHeight();
            $(".row:nth-child(even)").css({"margin-top":"10px","margin-bottom":"10px"});
            $(".fotoList").each(function(){
                var path = $(this).data('path');
                var scheda = $(this).data('scheda');
                $(this)
                    .css({"cursor":"pointer","height":heightFotoList+"px","background":"url("+path+") no-repeat center center","-webkit-background-size":"cover","-moz-background-size":"cover","-o-background-size":"cover","background-size":"cover"})
                    .click(function(){window.location.href="../andalo/scheda_archeo.php?id="+scheda;});

            });
            $(".fotoListDiv").on({
                mouseenter:function(){$('.overlayTip').fadeIn('fast');},
                mouseleave:function(){$('.overlayTip').fadeOut('fast');}
            });
        });
        </script>
    </body>
</html>

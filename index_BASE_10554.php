<?php
require('class/init.php');
require("class/conn.class.php");
require("class/funzioni.php");
?>
<!DOCTYPE html>
<html lang="it">
    <head><?php require("inc/head.php"); ?></head>
    <body onload="initindex()">
        <header id="mainHeader"><?php require("inc/header.php"); ?></header>
        <aside id="mainNavigation" class="animate"><?php require("inc/navigation.php"); ?></aside>
        <section id="mainSection" class="animate">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-4 col-lg-3">
                        <div id="totFonti" class="widget bg-green">
                            <div class="widget-title">
                                <h3>TOT. FONTI</h3>
                                <h1>12345</h1>
                            </div>
                            <div class="widget-icon"><i class="fa fa-archive" aria-hidden="true"></i></div>
                        </div>
                    </div>
                    <div class="col-sm-8 col-lg-9">
                        <div class="widget no-padding">
                            <div class="list-group fonti-group">
                                <a href="#" class="list-group-item bg-archeo animate"><span class="badge">134</span> ARCHEOLOGICHE</a>
                                <a href="#" class="list-group-item bg-architett animate"><span class="badge">146</span> ARCHITETTONICHE</a>
                                <a href="#" class="list-group-item bg-archiv animate"><span class="badge">1114</span> ARCHIVISTICHE</a>
                                <a href="#" class="list-group-item bg-biblio animate"><span class="badge">134</span> BIBLIOGRAFICHE</a>
                                <a href="#" class="list-group-item bg-carto animate"><span class="badge">146</span> CARTOGRAFICHE</a>
                                <a href="#" class="list-group-item bg-foto animate"><span class="badge">1114</span> FOTOGRAFICHE</a>
                                <a href="#" class="list-group-item bg-mat animate"><span class="badge">134</span> MATERIALI</a>
                                <a href="#" class="list-group-item bg-audio animate"><span class="badge">146</span> ORALI</a>
                                <a href="#" class="list-group-item bg-stoart animate"><span class="badge">1114</span> STORICO-ARTISTICHE</a>
                            </div>
                        </div>
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
                        <div class="panel panel-inverse">
                            <div class="panel-heading">Mappa dei siti</div>
                            <div id="mappa" class="panel-body"></div>
                        </div>
                    </div>
                    <div class="col-md-4 hidden-sm hidden-xs">
                        <div class="panel panel-inverse">
                            <div class="panel-heading">Comuni</div>
                            <div class="list-group">
                                <?php
                                $comuniArr = comuniCoo();
                                foreach ($comuniArr as $key => $comune) {
                                    echo "<a href='#' class='list-group-item prevent zoom2ext' data-xmin='".$comune['xmin']."' data-ymin='".$comune['ymin']."' data-xmax='".$comune['xmax']."' data-ymax='".$comune['ymax']."'>".$comune['comune']."</a>";
                                }
                                ?>
                            </div>
                            <div class="panel-footer">
                                <p>La lista elenca i Comuni coinvolti nel progetto NOME DEL PROGETTO.</p>
                                <p>Qui si può scrivere qualcosa sui Comuni o dare altre informazioni di tipo topografico in modo da riempire lo spazio vuoto</p>
                                <p>Invece dei Comuni si possono inserire le ultime X aree d'interesse o altri elementi geoetrici</p>
                            </div>
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

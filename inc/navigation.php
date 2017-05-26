<nav>
    <div id="divUsr" class="<?php echo $sessione; ?>">
        <a href="#" title="Gestisci dati personali" class="mainLink"><i class="fa fa-user-circle" aria-hidden="true"></i><?php echo $_SESSION['username']; ?></a>
    </div>
    <ul id="mainMenuList">
        <li><a href="#" id="index" class="mainLink" title="home page"><i class="fa fa-home" aria-hidden="true"></i> home</a></li>
        <li><a href="#" id="database" class="mainLink" title="naviga tra i record presenti nel database"><i class="fa fa-database" aria-hidden="true"></i> database</a></li>
        <li><a href="#" id="webgis" class="mainLink" title="Scopri il territorio attraverso la mappa interattiva"><i class="fa fa-map-marker" aria-hidden="true"></i> mappa</a></li>
        <?php if($_SESSION['id']){ ?>
        <li class="panel">
            <a href="#cataloghi" class="toggleMenu" data-toggle="collapse"  data-parent="#mainMenuList" title="cataloghi" aria-expanded="false" aria-controls="cataloghi">
                <i class="fa fa-archive" aria-hidden="true"></i>
                cataloghi
                <span class="caret"></span>
            </a>
            <ul id="cataloghi" class="collapse submenu">
                <li><a href="#" title="">ricerche</a></li>
                <li><a href="#" title="">schede</a></li>
                <li><a href="#" title="">rubrica</a></li>
                <li><a href="#" title="">aree/ubicazioni</a></li>
            </ul>
        </li>
        <li class="panel">
            <a href="#scheda" class="toggleMenu" data-toggle="collapse"  data-parent="#mainMenuList" title="inserisci una nuova scheda" aria-expanded="false" aria-controls="scheda">
                <i class="fa fa-archive" aria-hidden="true"></i>
                nuova scheda
                <span class="caret"></span>
            </a>
            <ul id="scheda" class="collapse submenu">
                <li><a href="#" title="">archeologica</a></li>
                <li><a href="#" title="">architettonica</a></li>
                <li><a href="#" title="">archivistica</a></li>
                <li><a href="#" title="">bibliografica</a></li>
                <li><a href="#" title="">cartografica</a></li>
                <li><a href="#" title="">fotografica</a></li>
                <li><a href="#" title="">materiale</a></li>
                <li><a href="#" title="">orale</a></li>
                <li><a href="#" title="">storico-artistica</a></li>
            </ul>
        </li>
        <li class="panel">
            <a href="#liste" class="toggleMenu" data-toggle="collapse"  data-parent="#mainMenuList" title="gestisci liste valori" aria-expanded="false" aria-controls="liste">
                <i class="fa fa-th-list" aria-hidden="true"></i>
                liste valori
                <span class="caret"></span>
            </a>
            <ul id="liste" class="collapse submenu">
                <li><a href="#" title="">Vocabolari</a></li>
                <li><a href="#" title="">Stato</a></li>
                <li><a href="#" title="">Provincia</a></li>
                <li><a href="#" title="">Comuni</a></li>
                <li><a href="#" title="">Località</a></li>
                <li><a href="#" title="">Indirizzi</a></li>
            </ul>
        </li>
        <li class="panel">
            <a href="#account" class="toggleMenu" data-toggle="collapse"  data-parent="#mainMenuList" title="dati personali" aria-expanded="false" aria-controls="account">
                <i class="fa fa-user" aria-hidden="true"></i>
                account
                <span class="caret"></span>
            </a>
            <ul id="account" class="collapse submenu">
                <li><a href="#" title="Gestisci le informazioni personali">dati utente</a></li>
            </ul>
        </li>
        <li><a href="#" title="gestisci utenti"><i class="fa fa-users" aria-hidden="true"></i> utenti</a></li>
        <?php } ?>
        <li><?php echo $logInOut; ?></li>
    </ul>
</nav>

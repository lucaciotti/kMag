<?php
include($_SERVER['DOCUMENT_ROOT'] . "/kMag2/src/_layouts/header.php");
?>


<center>
    <img src="../../assets/images/logo.jpg" />
    <br />&nbsp;<br />
    <h2>Elenco Funzioni PC</h2>
</center>

<div>
    <button class="pc" onclick="$('span.menu').hide(); $('#plUtilsMenu').toggle();">Utility Packing List</button>
    <span id='plUtilsMenu' class='menu'>
        <ul>
            <?php if (!isFiliale()) { ?>
                <li><img src="../../assets/images/b_props.gif" />&nbsp;<a href="../plUtils/pl-ready.php">Distinta Partenza PL</a></li>
            <?php } ?>
            <li><img src="../../assets/images/b_props.gif" />&nbsp;<a href="../plUtils/ask_pl_edit.php">Dettaglio PL (Richiede Login)</a></li>
                <!-- <li><img src="../bcreader.gif" />&nbsp;<a href="askpl-banc.php">Gestione bancali</a></li>
                <li><img src="../bcreader.gif" />&nbsp;<a href="askpl-banc-rep.php">Riassegnazione bancali per reparto</a></li> -->
            </ul>
        </span>

        <?php if (!isFiliale()) { ?>
            <button onclick="$('span.menu').hide(); $('#ricevUtilsMenu').toggle();">Utility Ricevimento Merci</button>
            <span id='ricevUtilsMenu' class='menu'>
                <ul>
                    <li><img src="../../assets/images/arca.gif" />&nbsp;<a href="gestione.php">Gestione documenti prelevabili</a></li>
                    <li><img src="../../assets/images/arca.gif" />&nbsp;<a href="sparati.php">Elenco righe acquisite</a></li>
                </ul>
            </span>
        <?php } ?>

        <button onclick="$('span.menu').hide(); $('#invUtilsMenu').toggle();">Utility INVENTARIO</button>
        <span id='invUtilsMenu' class='menu'>
            <ul>
                <li><img src="../../assets/images/b_props.gif" />&nbsp;<a href="invTable.php">Riepilogo Sparate Inventario (Richiede Login)</a></li>
                <li><img src="../../assets/images/arca.gif" />&nbsp;<a href="inv_xls.php">Carico inventario da Excel</a></li>
            </ul>
        </span>

        <br>
        <hr />
        <!--
                    <li><img src="../bcreader.gif" />&nbsp;<a href="start.php">Prelievo documenti nominativo</a></li>
                    <li><img src="../bcreader.gif" /><a href="listaart.php">Prelievo per articolo</a></li>
                    <li><img src="../bcreader.gif" /><a href="start_rep.php">Prelievo per reparto</a></li>
                    -->

    </div>

    <?php
    goMain();
    include($_SERVER['DOCUMENT_ROOT'] . "/kMag2/src/_layouts/footer.php");
    ?>
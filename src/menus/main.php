<?php
    include($_SERVER['DOCUMENT_ROOT']."/kMag2/src/_layouts/header.php");
?>


<center>
    <img src="../../assets/images/logo.jpg" />
    <br />&nbsp;<br />
    <h2>Elenco Funzioni per Pistole</h2>
</center>

<div>
    <button onclick="$('span.menu').hide(); $('#artMenu').toggle();">Funzioni Articoli</button>
    <span id='artMenu' class='menu'>
        <ul>
            <li><img src="../../assets/images/bcreader.gif" />&nbsp;<a href="../artDetail/01ask.php">Ricerca disponibilit&agrave; articoli</a></li>
            <li><img src="../../assets/images/bcreader.gif" />&nbsp;<a href="askubicx.php">Sostituzione ubicazione</a></li>
        </ul>
    </span>

    <button onclick="$('span.menu').hide(); $('#ricevMenu').toggle();">Ricevimento Merci</button>
    <span id='ricevMenu' class='menu'>
        <ul>
            <!--li><img src="../bcreader.gif" />&nbsp;<a href="lista.php">Prelievo documenti globale</a></li
            <li><img src="../bcreader.gif" />&nbsp;<a href="getdoc.php">Prelievo documenti barcode</a></li> -->
            <li><img src="../../assets/images/bcreader.gif" />&nbsp;<a href="getfordoc.php">Prelievo documenti barcode</a></li>
        </ul>
    </span>

    <button onclick="$('span.menu').hide(); $('#prodMenu').toggle();">Produzione Interna</button>
    <span id='prodMenu' class='menu'>
        <ul>
            <!--li><img src="../bcreader.gif" />&nbsp;<a href="askcd.php">Prelievo da C/Deposito</a></li-->
            <li><img src="../../assets/images/bcreader.gif" />&nbsp;<a href="asklp.php">Gestione lista prelievo</a></li>
            <li><img src="../../assets/images/bcreader.gif" />&nbsp;<a href="askdb.php">Prelievo componenti da distinta base</a></li>
            <li><img src="../../assets/images/bcreader.gif" />&nbsp;<a href="askcp.php">Carico produzione</a></li>
        </ul>
    </span>

    <button class="pc" onclick="$('span.menu').hide(); $('#makePlMenu').toggle();">Packing List</button>
    <span id='makePlMenu' class='menu'>
        <ul>
            <li><img src="../../assets/images/bcreader.gif" />&nbsp;<a href="../plMake/01_ask.php">Gestione packing list</a></li>
            <li><img src="../../assets/images/bcreader.gif" />&nbsp;<a href="reprint-pl.php">Ristampa etichette colli</a></li>
            <li><img src="../../assets/images/bcreader.gif" />&nbsp;<a href="reprint-banc.php">Ristampa etichette bancali</a></li>
        </ul>
    </span>

    <button onclick="$('span.menu').hide(); $('#invMenu').toggle();">Inventario</button>
    <span id='invMenu' class='menu'>
        <ul>
            <li><img src="../../assets/images/bcreader.gif" />&nbsp;<a href="inventario.php">Procedura d'inventario</a></li>
        </ul>
    </span>

    <br>
    <hr />

    <ul>
        <?php if(!isMobile()){ ?>
            <li><strong><img src="../../assets/images/b_props.gif" />&nbsp;<a href="index-pc.php">Funzioni per PC</a></strong></li>
        <?php } ?>
        <li><strong><img src="../../assets/images/b_props.gif" />&nbsp;<a href="index-util.php">Utility</a></strong></li>
    </ul>
        <!--
        <li><img src="../bcreader.gif" />&nbsp;<a href="start.php">Prelievo documenti nominativo</a></li>
        <li><img src="../bcreader.gif" /><a href="listaart.php">Prelievo per articolo</a></li>
        <li><img src="../bcreader.gif" /><a href="start_rep.php">Prelievo per reparto</a></li>
        -->

</div>

<?php
    include($_SERVER['DOCUMENT_ROOT']."/kMag2/src/_layouts/footer.php");
?>
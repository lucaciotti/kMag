<?php
    include($_SERVER['DOCUMENT_ROOT']."/kMag2/src/_layouts/header.php");
?>

<center>
    <img src="../../assets/images/logo.jpg" />
    <br />&nbsp;<br />
    <h2>Elenco Funzioni per Pistole</h2>
</center>

<div>
    <ul>
        <h4>Funzioni di Magazzino</h4>
        <li><img src="../bcreader.gif" />&nbsp;<a href="../artDetail/01ask.php">Ricerca disponibilit&agrave; articoli</a></li>
        <li><img src="../bcreader.gif" />&nbsp;<a href="askubicx.php">Sostituzione ubicazione</a></li>

        <h4>Ricevimento Merci</h4>
        <!--li><img src="../bcreader.gif" />&nbsp;<a href="lista.php">Prelievo documenti globale</a></li
<li><img src="../bcreader.gif" />&nbsp;<a href="getdoc.php">Prelievo documenti barcode</a></li> -->
        <li><img src="../bcreader.gif" />&nbsp;<a href="getfordoc.php">Prelievo documenti barcode</a></li>

        <h4>Produzione Interna</h4>
        <!--li><img src="../bcreader.gif" />&nbsp;<a href="askcd.php">Prelievo da C/Deposito</a></li-->
        <li><img src="../bcreader.gif" />&nbsp;<a href="asklp.php">Gestione lista prelievo</a></li>
        <li><img src="../bcreader.gif" />&nbsp;<a href="askdb.php">Prelievo componenti da distinta base</a></li>
        <li><img src="../bcreader.gif" />&nbsp;<a href="askcp.php">Carico produzione</a></li>

        <h4>Spedizione Merci</h4>
        <li><img src="../bcreader.gif" />&nbsp;<a href="pl_01_ask.php">Gestione packing list</a></li>
        <li><img src="../bcreader.gif" />&nbsp;<a href="reprint-pl.php">Ristampa etichette colli</a></li>
        <li><img src="../bcreader.gif" />&nbsp;<a href="reprint-banc.php">Ristampa etichette bancali</a></li>

        <h4>INVENTARIO</h4>
        <li><img src="../bcreader.gif" />&nbsp;<a href="inventario.php">Procedura d'inventario</a></li>
        <br>
        <hr />

        <li><strong><img src="b_props.gif" />&nbsp;<a href="index-pc.php">Funzioni per PC</a></strong></li>
        <li><strong><img src="b_props.gif" />&nbsp;<a href="index-util.php">Utility</a></strong></li>
    </ul>
    <!--
<li><img src="../bcreader.gif" />&nbsp;<a href="start.php">Prelievo documenti nominativo</a></li>
<li><img src="../bcreader.gif" /><a href="listaart.php">Prelievo per articolo</a></li>
<li><img src="../bcreader.gif" /><a href="start_rep.php">Prelievo per reparto</a></li>
-->

</div> <!-- fine accordion -->

<?php
    include($_SERVER['DOCUMENT_ROOT']."/kMag2/src/_layouts/footer.php");
?>
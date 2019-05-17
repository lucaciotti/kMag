<?php
    include($_SERVER['DOCUMENT_ROOT']."/kMag2/src/_layouts/header.php");
?>
<!-- <style>
    label	{float: left; width: 100px;}
    body	{
        width: 600px;
        margin-left: auto;
        margin-right: auto;
        }
    table, td, tr 	{border-style: none; border-collapse: collapse;}
    /* div { text-align: center; } */
    button { 
        width: 80%;
        padding: 14px 40px;
        border-radius: 4px;
        background-color: white;
        color: black;
        border: 2px solid #e7e7e7; /* Green */
        cursor: pointer;
        text-align: center;
        text-decoration: none;
        font-size: 20px;
        font-weigh: bold;
        margin-left: 10%;
        margin-bottom: 5px;
        }
    button:hover {
        background-color: #555555;
        color: white;
    }
    button.pc {
        background-color: #008CBA;
        color: white;
    }
    button.pc:hover {
        background-color: white; 
        color: black; 
        border: 2px solid #008CBA;
    }
    span.menu { display: none; }
    ul { margin-left: 15%; }
    /* On screens that are 992px wide or less, go from four columns to two columns */
    /* @media screen and (max-width: 992px) {
        body	{ width: max-width; }
    } */

    /* On screens that are 600px wide or less, make the columns stack on top of each other instead of next to each other */
    /* @media screen and (max-width: 600px) {
        body	{ width: max-width; }
    } */
</style> -->

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

    <button class="pc" onclick="$('span.menu').hide(); $('#makePlMenu').toggle();">Packing List</button>
    <span id='makePlMenu' class='menu'>
        <ul>
            <li><img src="../../assets/images/bcreader.gif" />&nbsp;<a href="../plMake/01_ask.php">Gestione packing list</a></li>
            <li><img src="../../assets/images/bcreader.gif" />&nbsp;<a href="reprint-pl.php">Ristampa etichette colli</a></li>
            <li><img src="../../assets/images/bcreader.gif" />&nbsp;<a href="reprint-banc.php">Ristampa etichette bancali</a></li>
        </ul>
    </span>

    <ul>
        <h4>Ricevimento Merci</h4>
        <!--li><img src="../bcreader.gif" />&nbsp;<a href="lista.php">Prelievo documenti globale</a></li
        <li><img src="../bcreader.gif" />&nbsp;<a href="getdoc.php">Prelievo documenti barcode</a></li> -->
        <li><img src="../../assets/images/bcreader.gif" />&nbsp;<a href="getfordoc.php">Prelievo documenti barcode</a></li>

        <h4>Produzione Interna</h4>
        <!--li><img src="../bcreader.gif" />&nbsp;<a href="askcd.php">Prelievo da C/Deposito</a></li-->
        <li><img src="../../assets/images/bcreader.gif" />&nbsp;<a href="asklp.php">Gestione lista prelievo</a></li>
        <li><img src="../../assets/images/bcreader.gif" />&nbsp;<a href="askdb.php">Prelievo componenti da distinta base</a></li>
        <li><img src="../../assets/images/bcreader.gif" />&nbsp;<a href="askcp.php">Carico produzione</a></li>

        <h4>Spedizione Merci</h4>
        <li><img src="../../assets/images/bcreader.gif" />&nbsp;<a href="../plMake/01_ask.php">Gestione packing list</a></li>
        <li><img src="../../assets/images/bcreader.gif" />&nbsp;<a href="reprint-pl.php">Ristampa etichette colli</a></li>
        <li><img src="../../assets/images/bcreader.gif" />&nbsp;<a href="reprint-banc.php">Ristampa etichette bancali</a></li>

        <h4>INVENTARIO</h4>
        <li><img src="../../assets/images/bcreader.gif" />&nbsp;<a href="inventario.php">Procedura d'inventario</a></li>
        <br>
        <hr />
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
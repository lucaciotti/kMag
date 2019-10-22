<?php
    include($_SERVER['DOCUMENT_ROOT']."/kMag2/src/_layouts/header.php");
    
    include($_SERVER['DOCUMENT_ROOT']."/kMag2/models/Article.php");
    include($_SERVER['DOCUMENT_ROOT']."/kMag2/models/DocRig.php");
    include($_SERVER['DOCUMENT_ROOT']."/kMag2/models/MagAna.php");    
    include($_SERVER['DOCUMENT_ROOT']."/kMag2/models/PLUtils.php");
    
    $idTesPl = $_GET['id'];
    $idRowPL = getNumeric('id_riga');
    $collo = getNumeric('collo');
    $prtBanc = CONFIG::$BANC_PRT;
    $banc = getNumeric('banc');
    $artCollo = ( isset($_GET['artcollo']) ? $_GET['artcollo'] : "" );
    $desCollo = ( isset($_GET['descollo']) ? $_GET['descollo'] : "" );
    $nColli = ( isset($_GET['ncolli']) ? $_GET['ncolli'] : 1 );
    $default_prt = ( isset($_COOKIE['plprinter']) ? $_COOKIE['plprinter'] : "##" );
    $prtlist = CONFIG::$PRINTERS;

    $anno = current_year();
    // $pesocollo = 0;
    $pesocollo = PLUtils::getPesoNettoCollo($idTesPl, $idRowPL, $collo);
?>

<form method="get" action="07_print.php">

    <select id="prt" name="prt" onchange="setPrinter(this.value);">
            <?php for($i = 0; $i < count($prtlist); $i++) { ?>
                <option value="<?php print $prtlist[$i] ?>" <?php ($default_prt==$prtlist[$i] ? print "selected=selected" : "") ?>>
                    <?php print $prtlist[$i] ?>
                </option>
            <?php } ?>
        </select>


    <?php if($pesocollo >= 15){ ?>
		<span>ATTENZIONE Stampare Etichette Peso Maggiore di 15KG? (Se SI flaggare sotto)</span>
        </br>
		<input type="checkbox" name="warnpeso" id="warnpeso" value="1"> SI 
        </br>
	<?php } ?>

	<?php if ($idRowPL != 0){ ?>
		<span>Peso collo di $pesocollo KG</span>
        </br>
	<?php } else { ?>
		<span>Peso dell'intera PL fino ad ora di <?php print $pesocollo ?> KG</span>
        </br>
	<?php } ?>

    <?php
        hiddenField("idTesPl", $idTesPl);
        hiddenField("idRowPL", $idRowPL);
        hiddenField("collo", $collo);
        hiddenField("artcollo", trim($artCollo));
        hiddenField("descollo", trim($desCollo));
        hiddenField("ncolli", $ncolli);
        hiddenField("prtbanc", $prtBanc);
        hiddenField("banc", $banc);
    ?>

	<input type="submit" value="Stampa">
</form>

<?php
    disableCR();
    goMain();
    include($_SERVER['DOCUMENT_ROOT']."/kMag2/src/_layouts/footer.php");
?>
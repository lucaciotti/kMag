<?php
    include($_SERVER['DOCUMENT_ROOT']."/kMag2/src/_layouts/header.php");
    
    include($_SERVER['DOCUMENT_ROOT']."/kMag2/models/Article.php");
    include($_SERVER['DOCUMENT_ROOT']."/kMag2/models/DocRig.php");
    include($_SERVER['DOCUMENT_ROOT']."/kMag2/models/Anagrafe.php");    
    include($_SERVER['DOCUMENT_ROOT']."/kMag2/models/PLUtils.php");
    
    $id = substr(trim($_GET['id']),3,-1);
    $closed = ""; //VARIABILE COLLO non Chiuso! & CONTROLLO
    $collo = 0;
    $isDisabled = "";
    $btn_disabled = "";
    $chiudicollo = "";

    $plGet = DocRig::getById($id, 'codicearti,descrizion,quantita,quantitare,numerodoc,datadoc,codicecf,unmisura,fatt,lotto,id_testa,gruppo,u_origpref');
    // SE NON CI SONO ERRORI VADO AVANTI
    if(!empty($plGet['data']) && empty($plGet['error'])) {
        $cliGet = Anagrafe::getAnagraf($plGet['data'][0]['codicecf'], 'codice,descrizion as ragsoc,u_soloce,settore');
        $artGet = Article::getArticle($plGet['data'][0]['codicearti'], 'unmisura,unmisura1,unmisura2,unmisura3,fatt1,fatt2,fatt3,lotti,u_ncolli,u_artcollo,u_descollo,u_duplpref');

        //VARIABILI OTTENUTE
        {
            $articolo = trim($plGet['data'][0]['codicearti']);
            $desc = htmlentities(trim($plGet['data'][0]['descrizion']));
            $qtaRes =  $plGet['data'][0]['quantitare'];
            $numerodoc =  $plGet['data'][0]['numerodoc'];
            $datadoc = $plGet['data'][0]['datadoc'];
            $codicecf = $plGet['data'][0]['codicecf'];
            $umDoc = $plGet['data'][0]['unmisura'];
            $fattDoc = $plGet['data'][0]['fatt'];
            $lotto = $plGet['data'][0]['lotto'];
            $id_pl = $plGet['data'][0]['id_testa'];
            $gruppo = $plGet['data'][0]['gruppo'];
            $ragsociale = htmlentities(trim($cliGet['data'][0]['ragsoc']));
            $nColli = $artGet['data'][0]['u_ncolli'];
            $artCollo = trim($artGet['data'][0]['u_artcollo']);
            $desCollo = trim($artGet['data'][0]['u_desccollo']);
            $umP = $artGet['data'][0]['unmisura'];
            $um1 = $artGet['data'][0]['unmisura1'];
            $um2 = $artGet['data'][0]['unmisura2'];
            $um3 = $artGet['data'][0]['unmisura3'];
            $fatt1 = $artGet['data'][0]['fatt1'];
            $fatt2 = $artGet['data'][0]['fatt2'];
            $fatt3 = $artGet['data'][0]['fatt3'];
            $lottoOb = $artGet['data'][0]['lotti'];
            $cliSoloCe = $cliGet['data'][0]['u_soloce'];
            $cliSettore = $cliGet['data'][0]['settore'];
        }
        
        //VERIFICHE VARIE
        if (!empty($artCollo) && !empty($nColli) && $nColli>1) {
			//VUOL DIRE CHE IL COLLO è DOPPIO
            $nColli = 2;
            //SE DOPPIO COLLO => CHIUDO COLLO DEFAULT!
            $chiudicollo = "checked='checked'";
        }
        if($qtaRes > 0){
            $collo = PLUtils::getCollo($id_pl, $termid);
        } else {
            $isDisabled = " readonly='readonly'";
            $btn_disabled = " disabled='disabled'";
        }
    } else {
        header("Location: error.php?errMessage=".htmlentities('Riga PackingList non Trovata'));
    }

?>

<link rel="stylesheet" type="text/css" href="../../assets/css/bootstrap.min.css">
<div style="font-size: 11pt; font-weight:bold;">
    <span style="font-size: 14pt;">PL <?php print $numerodoc; ?></span>
     del <?php print $datadoc; ?>
</div>

<div style='font-size: 11pt; font-weight:bold;'>
    &nbsp; per <?php print $ragsociale;?> [<?php print $codicecf; ?>]
</div>

<form name="plrow" id="plrow" method="post" action="03_write.php" onsubmit="checkForm('idtesta', 'collo', 'close', 'nColli');">
    <table border="1">
        <tr>
            <th>Art.</th>
            <th id='codArt' style='font-size:14pt;'> <?php print $articolo; ?> </th>
        </tr>
        <tr>
            <th>Descrizione</th>
            <th id='descart' style='font-size:9pt;'> <?php print $desc; ?> </th>
        </tr>
        <tr>
            <th>Barcode Art.</th>
            <td><input type="text" id="controllo" onchange="decodeArt(this)"></td>
        </tr>
        <tr>
            <th>Cod. Lotto</th>
            <td>
                <input type="text" name='lotto' id="lotto" value='<?php print $lotto; ?>' $isDisabled onblur="checkLotto(this)">
                <span id="lottoobb"><?php ($lottoOb ? print "Obbligatorio" : ""); ?></span>
            </td>
        </tr>
        <tr>
            <th>Quantit&agrave Residua</th>
            <td><b><?php print $qtaRes; ?> <?php print $umDoc; ?> <?php if($qtaRes<=0) print("- TUTTO SPARATO"); ?></b></td>
        </tr>
        <tr>
            <th>Qt&agrave Sparata</th>
            <td>
                <input type="text" name="qta" id="qta" size="6" value=<?php print $qtaRes; ?> $disabled onblur="checkQta(this);">
                <select name="um" id="um">
                    <option <?php ($umP == $umDoc ? print("selected='selected'") : "") ?> value='1'><?php print $umP; ?></option>
                    <?php if($um1 != "  " && $um1 != $umP) { ?>
                        <option <?php ($um1 == $umDoc ? print("selected='selected'") : "") ?> value='<?php print $fatt1; ?>'><?php print $um1; ?></option>
                    <?php } ?>
                    <?php if($um2 != "  " && $um2 != $umP) { ?>
                        <option <?php ($um2 == $umDoc ? print("selected='selected'") : "") ?> value='<?php print $fatt2; ?>'><?php print $um2; ?></option>
                    <?php } ?>
                    <?php if($um3 != "  " && $um3 != $umP) { ?>
                        <option <?php ($um3 == $umDoc ? print("selected='selected'") : "") ?> value='<?php print $fatt3; ?>'><?php print $um3; ?></option>
                    <?php } ?>
                </select>
            </td>
        </tr>
        <tr>
            <th>Collo N.</th>
            <td>
                <input type="text" size="4" name="collo" id="collo" value='<?php print $collo; ?>' onkeyup="soloNumeri('collo')" onblur="checkCollo('idtesta', this.value, '', <?php print $nColli; ?>);" $isDisabled>
                &nbsp
                <input type="checkbox" name="close" id="close" value="0" $isDisabled $chiudicollo>
                <label for="close">Chiudi collo</label>
                <?php if($isDisabled == "") { ?>
                    <input type="checkbox" name="print" id="print" value="1">
                    <label for="print">Stampa collo</label>
                <?php } else { ?>
                    <a style="float: right;" class="menu" href="reprint-pl-select.php?num=<?php print trim($numerodoc); ?>&anno=<?php print $anno; ?>">Ristampa colli</a>
                <?php } ?>
            </td>
        </tr>
    </table>

    <input type="hidden" name="id" id="id" value="<?php print $id; ?>">
    <input type="hidden" name="idtesta" id="idtesta" value="<?php print $id_pl; ?>">
    <input type="hidden" name="umDoc" id="umDoc" value="<?php print $umDoc; ?>">
    <input type="hidden" name="fattDoc" id="fattDoc" value="<?php print $fattDoc; ?>">
    <input type="hidden" name="qtaRes" id="qtaRes" value="<?php print $qtaRes; ?>">
    <input type="hidden" name="oldFatt" id="oldFatt" value="0">
    <input type="hidden" name="newFatt" id="newFatt" value="0">
    <input type="hidden" name="gruppo" id="gruppo" value="<?php print $gruppo; ?>">
    <input type="hidden" name="ncolli" id="ncolli" value="<?php print $nColli; ?>">
    <input type="hidden" name="artcollo" id="artcollo" value="<?php print $artCollo; ?>">
    <input type="hidden" name="descollo" id="descollo" value="<?php print $desCollo; ?>">
    <input type="hidden" name="soloCeCli" id="soloCeCli" value="<?php print ($cliSoloCe ? 'true' : 'false'); ?>">
    <input type="hidden" name="settoreCli" id="settoreCli" value="<?php print $cliSettore; ?>">

    <input style="float: right" type="submit" name="btnok" id="btnok" value="Procedi" $isDisabled>
</form>

<?php if($nColli>1) { ?>
    <table>
        <tr>
            <td><h3>Dati Pannello</h3></td>
            <td style='text-align:center;'>
                <input type="checkbox" id='chkColloPann' onclick='chkColloPann_click();'>
                <labal for='chkColloPann'>Non generare Collo aggiuntivo</labal>
            </td>
        </tr>
        <tr>
            <th>Codice</th>
            <td><?php print $artCollo ?></td>
        </tr>
        <tr>
            <th>Descrizione</th>
            <td><?php print $desCollo ?></td>
        </tr>
        <tr>
            <th>Collo</th>
            <td><span id='colloPann'><?php print $collo+1 ?></span></td>
        </tr>
        <tr>
            <th>Gruppo</th>
            <td><?php print $gruppo ?></td>
        </tr>
    </table>
<?php } ?>

<script type='text/javascript'>
    var codArt = "";
    var soloceCli = false;
    var settoreCli = "";
    var esercizio = <?php print(current_year()); ?>;
    var termid = <?php print $termid; ?>;
    var detailLotto = {};
    $(document).ready(function () {
        // listaLotti = $.parseJSON(decodeURIComponent($("#listaLotti").val()));
        codArt = $("#codArt").text().trim();
        soloceCli = $("#soloCeCli").val()=='false' ? false : true;
        settoreCli = $("#settoreCli").val();
    });
</script>

<?php
    setFocus("controllo");
    disableCR();
    goMain();
    include($_SERVER['DOCUMENT_ROOT']."/kMag2/src/_layouts/footer.php");
?>
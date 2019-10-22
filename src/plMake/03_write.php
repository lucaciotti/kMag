<?php
    include($_SERVER['DOCUMENT_ROOT']."/kMag2/src/_layouts/header.php");
    
    include($_SERVER['DOCUMENT_ROOT']."/kMag2/models/Article.php");
    include($_SERVER['DOCUMENT_ROOT']."/kMag2/models/DocRig.php");
    include($_SERVER['DOCUMENT_ROOT']."/kMag2/models/Anagrafe.php");    
    include($_SERVER['DOCUMENT_ROOT']."/kMag2/models/PLUtils.php");

    $anno = current_year();
    $id = $_POST['id'];
    $idtesta = $_POST['idtesta'];
    $qta = $_POST['qta'];
    $collo = ($_POST['collo'] == "" ? 0 : $_POST['collo']);
    $lotto = trim($_POST['lotto']);
    $prt = ( $_POST['print'] == "" ? 0 : $_POST['print']);
    $newfatt = ($_POST['newFatt'] == 0 ? 1 : $_POST['newFatt']);
    $fatt = ($_POST['fattDoc'] == 0 ? 1 : $_POST['fattDoc']);
    $fatt = ($fatt == 0 ? 1 : $fatt);
    $um = $_POST['umDoc'];
    $close = ( isset($_POST['close']) ? $_POST['close'] : 0 );
    $gruppo = (isset($_POST['gruppo']) ? $_POST['gruppo'] : "");
    $nColli = (isset($_POST['ncolli']) ? $_POST['ncolli'] : 1);
    $artCollo = (isset($_POST['artcollo']) ? $_POST['artcollo'] : "");
    $desCollo = (isset($_POST['descollo']) ? $_POST['descollo'] : "");
    
    //TORNO INIZIO...NO COLLO!!!
    if($collo == 0) {
        header("location: 01_ask.php");
        exit();
    }

    $qta = $qta * $newfatt / $fatt;

    //CERCO LA PL
    $plGet = DocRig::getById($id, 'quantita,quantitare,id_testa,codicearti,descrizion,unmisura,fatt,riffromr');
    if ($plGet['rows']==0) print "<p> 01 - C'é un errore: " . $plGet['error'] . "<p>" and die;

    //CERCO LA RIGA OC COLLEGATA
	if($plGet['data'][0]['riffromr'] == 0) {
		print("<br>ATTENZIONE: Impossibile recuperare OC...riga PL manomessa.<br>Informare il CED.<br>");
		exit();
    }
    
    $qtaRes = $plGet['data'][0]['quantitare'];
    
    if($qtaRes>=$qta){
        $pbIns = PLUtils::insPBRow($id, $qta, $collo, $lotto, $fatt, $um, '', '', 0, 0, 0, 0, 0, 0, 0);
        if ($pbIns!='success') print "<p> 01 - C'é un errore: " . $pbIns['error'] . "<p>" and die;

        if(!empty($artCollo)){
            $collo2 = ($nColli>1) ? $collo+1 : $collo;
            print("Inserimento secondo collo<br>");
            $pbInsCollo2 = PLUtils::insPBRow($id, $qta, $collo2, $lotto, $fatt, $um, $artCollo, '', 0, 0, 0, 0, 0, 0, 0);
            if ($pbInsCollo2!='success') print "<p> 01 - C'é un errore: " . $pbInsCollo2['error'] . "<p>" and die;
        }

        $pbRotella = PLUtils::addRotellaRows($plGet['data'][0]['riffromr'], $id, $qta, $collo);

        if($lotto != "") {
            $ocMod = PLUtils::insOCRow($plGet['data'][0]['riffromr'], $qta, $lotto);
            if ($ocMod!='success') print "<p> 01 - C'é un errore: " . $ocMod['error'] . "<p>" and die;
        }

        $plRes = PLUtils::updQtaResPl($id, $qtaRes-$qta);
        if ($plRes != 'success') print "<p> 01 - C'é un errore: " . $plRes['error'] . "<p>" and die;

        if($close == 1) {
            //Nel dubbio chiudo tutto
            $chiudiCollo = PLUtils::chiudiCollo($idtesta, $termid, $collo);
            if ($chiudiCollo!='success') print "<p> 01 - C'é un errore: " . $chiudiCollo['error'] . "<p>" and die;
            if($nColli>1){
                $chiudiCollo = PLUtils::chiudiCollo($idtesta, $termid, $collo+1);
                if ($chiudiCollo!='success') print "<p> 01 - C'é un errore: " . $chiudiCollo['error'] . "<p>" and die;
            }

            header("location: 04_imb.php?id_pl=$idtesta&id=$id&collo=$collo&prt=$prt&ncolli=$nColli&artcollo=$artCollo&descollo=$desCollo");
            exit();
        }


        if($prt > 0 && $close==0) {
            header("location: 06_selPrt.php?id=$idtesta&id_riga=$id&collo=$collo&ncolli=$nColli&artcollo=$artCollo&descollo=$desCollo");
        } else {
            header("location: 01_ask.php");
        }
    } else {
        header("Location: error.php?errMessage=" . htmlentities('Qta Maggiore di Qta Residua'));
    }
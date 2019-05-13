<?php
    include($_SERVER['DOCUMENT_ROOT']."/kMag2/src/_layouts/header.php");
    
    include($_SERVER['DOCUMENT_ROOT']."/kMag2/models/DocRig.php"); 
    include($_SERVER['DOCUMENT_ROOT']."/kMag2/models/PLUtils.php");

    $anno = current_year();
    $collo = getNumeric('collo');
    print("Letti parametri per collo $collo<br>");
    if($collo == 0) {
        header("location: pl_01_ask.php");
        exit();
    }
    $idRowPl = $_GET['id'];
    $idTesPl = $_GET['id_pl'];
    $art = getString('art');
    print("Letti parametri per art $art<br>");
    $prt = getNumeric('prt');
    $prtBanc = getNumeric('prtbanc');
    $artCollo = getString('artcollo');
    $desCollo = getString('descollo');
    $nColli = getNumeric('ncolli');
    $rep = $_GET['rep'];
    $hasbanc = isset($_GET['hasbanc']);
    $banc = getNumeric('bancnum');
    $banc = ($hasbanc ? $banc : 0);
    $codBanc = getString('codbanc');
    $pal_u_misural = getNumeric('pal_u_misural');
    $pal_u_misuras = getNumeric('pal_u_misuras');
    $altezza = getNumeric('altezza');
    $imb_u_misural = getNumeric('imb_u_misural');
    $imb_u_misurah = getNumeric('imb_u_misurah');
    $imb_u_misuras = getNumeric('imb_u_misuras');
    $pesocollo = getNumeric('pesocollo');
    $pesobanc = getNumeric('pesobanc');
    $art2 = getString('art2');
    print("Letti parametri per art2 $art2<br>");
    $imb_u_misural2 = getNumeric('imb_u_misural2');
    $imb_u_misurah2 = getNumeric('imb_u_misurah2');
    $imb_u_misuras2 = getNumeric('imb_u_misuras2');
    $pesocollo2 = getNumeric('pesocollo2');
    $collo2 = $collo + ($nColli > 1 ? 0 : 1);

    //Tolgo la eventuale virgola nel peso
    $pesocollo = str_replace(",", ".", $pesocollo);
    $pesocollo2 = str_replace(",", ".", $pesocollo2);
    $pesobanc = str_replace(",", ".", $pesobanc);

    if( $art != "") {
        $pbIns = PLUtils::insPBRow($idRowPl, 1, $collo, '', 1, '', $art, $rep, $banc, $altezza, $imb_u_misural, $imb_u_misurah, $imb_u_misuras, $pesocollo);
        if ($pbIns!='success') print "<p> 01 - C'é un errore: " . $pbIns['error'] . "<p>" and die;

        if($nColli>1){
            $pbInsCollo2 = PLUtils::insPBRow($idRowPl, 1, $collo2, '', 1, '', $art2, $rep, $banc, $altezza, $imb_u_misural2, $imb_u_misurah2, $imb_u_misuras2, $pesocollo2);
            if ($pbInsCollo2!='success') print "<p> 01 - C'é un errore: " . $pbInsCollo2['error'] . "<p>" and die;
        }

        if($hasbanc) {
            //TODOOOOOO
        }
    }

    if( $prt > 0) {
        header("location: 06_selPrt.php?id=$id_pl&id_riga=$id&collo=$collo&ncolli=$nColli&artcollo=$artCollo&descollo=$desCollo&split=$split&prtbanc=$prtBanc&banc=$banc ");
    } else {
        if( $prtbanc > 0) {
            // ho chiesto la stampa del bancale ma non del collo
            header("location: 07_prt.php?id=$id_pl&id_riga=$id&collo=0&ncolli=$nColli&artcollo=$artCollo&descollo=$desCollo&split=$split&prtbanc=$prtBanc&banc=$banc ");
        } else {
            header("location: 01_ask.php");
        }
    }
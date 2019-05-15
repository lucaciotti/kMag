<?php
    include($_SERVER['DOCUMENT_ROOT']."/kMag2/src/_layouts/header.php");
    
    include($_SERVER['DOCUMENT_ROOT']."/kMag2/models/DocRig.php"); 
    include($_SERVER['DOCUMENT_ROOT']."/kMag2/models/PLUtils.php");

    $anno = current_year();
    $idTesPl = $_GET['idTesPl'];
    $collo = getNumeric('collo');
    $banc = getNumeric('banc');
    $artCollo = ( isset($_GET['artcollo']) ? $_GET['artcollo'] : "" );
    $desCollo = ( isset($_GET['descollo']) ? $_GET['descollo'] : "" );
    $prt = ( isset($_GET['prt']) ? $_GET['prt'] : "0" );
    $prtBanc = getNumeric('prtbanc');
    $warnpeso = getNumeric('warnpeso');
    $ncolli = $_GET['ncolli'];

    $pbTesGet = DocTes::getByRifId($idTesPl, 'id,tipodoc');
        if($pbTesGet['rows']>0){
            if($pbTesGet['data'][0]['tipodoc']=='PB'){
                $idTesPB = $pbTesGet['data'][0]['id']; 
                
                if( $collo > 0 ) {
                    $insEtichCollo = PLUtils::insEtichPB($idTesPB, $collo, $prn, $artCollo, $desCollo, $warnpeso);
                    if ($insEtichCollo!='success') print "<p> 01 - C'é un errore: " . $insEtichCollo['error'] . "<p>" and die;

                    if($ncolli>1){
                        $insEtichCollo2 = PLUtils::insEtichPB($idTesPB, $collo+1, $prn, $artCollo, $desCollo, $warnpeso);
                        if ($insEtichCollo2!='success') print "<p> 01 - C'é un errore: " . $insEtichCollo2['error'] . "<p>" and die;
                    }
                }

                if( $prtBanc > 0 && $BANC_PRT!='') {
                    $insEtichBanc = PLUtils::insEtichPB($idTesPB, -$banc, $prtBanc, $artCollo, $desCollo, $warnpeso);
                    if ($insEtichBanc!='success') print "<p> 01 - C'é un errore: " . $insEtichBanc['error'] . "<p>" and die;
                }
            }
        }
        
    header("location: 01_ask.php");
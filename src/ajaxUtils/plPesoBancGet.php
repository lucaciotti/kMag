<?php
    include_once($_SERVER['DOCUMENT_ROOT']."/kMag2/models/PLUtils.php");

    $mode = $_GET['mode'];
    $idTesPl = $_GET['idTesPl'];
    $idRowPl = $_GET['idRowPl'];
    $nBanc = $_GET['banc'];
    
    // if $nCollo == -1; Prendo tutte le righe del bancale nBanc

    $errMessage = "";
    $ret = '';
    if($mode=='netto'){
        $result = PLUtils::getPesoNettoBanc($idTesPl, $idRowPl, $nBanc);
    } else {
        $result = PLUtils::getPesoLordoBanc($idTesPl, $idRowPl, $nBanc);
    }
    print $result;
<?php
    include_once($_SERVER['DOCUMENT_ROOT']."/kMag2/models/PLUtils.php");

    $mode = $_GET['mode'];
    $idTesPl = $_GET['idTesPl'];
    $idRowPl = $_GET['idRowPl'];
    $nCollo = $_GET['collo'];
    
    // if $nCollo == -1; Prendo tutte le righe del bancale nBanc

    $errMessage = "";
    $ret = '';

    $result = PLUtils::getPesoNettoCollo($idTesPl, $idRowPl, $nCollo);
    print $result;
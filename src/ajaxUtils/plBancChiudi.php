<?php
    include_once($_SERVER['DOCUMENT_ROOT']."/kMag2/models/PLUtils.php");
    $id = $_GET['id'];
    $rep = $_GET['rep'];
    $nBanc = $_GET['banc'];
    $errMessage = "";
    $ret = '';

    $result = PLUtils::chiudiBanc($id, $rep, $nBanc);
    print $result;
<?php
    include_once($_SERVER['DOCUMENT_ROOT']."/kMag2/models/PLUtils.php");
    $id = $_GET['id'];
    $termid = $_GET['termid'];
    $collo = $_GET['collo'];
    $errMessage = "";
    $ret = '';

    $result = PLUtils::chiudiCollo($id, $termid, $collo);
    print $result;
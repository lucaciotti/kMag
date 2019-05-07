<?php
    include_once($_SERVER['DOCUMENT_ROOT']."/kMag2/models/PLUtils.php");
    $id = $_GET['id'];
    $collo = $_GET['collo'];
    $errMessage = "";
    $ret = '';

    $result = PLUtils::getColloByCollo($id, $collo);
    print $result;
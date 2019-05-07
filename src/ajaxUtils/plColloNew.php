<?php
    include_once($_SERVER['DOCUMENT_ROOT']."/kMag2/models/PLUtils.php");
    $id = $_GET['id'];
    // $termid = $_GET['termid'];
    $errMessage = "";
    $ret = '';

    $result = PLUtils::getNewCollo($id);
    print $result;
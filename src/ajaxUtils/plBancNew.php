<?php
    include_once($_SERVER['DOCUMENT_ROOT']."/kMag2/models/PLUtils.php");
    $id = $_GET['id'];
    // $rep = $_GET['rep'];
    $errMessage = "";
    $ret = '';

    $result = PLUtils::getNewBanc($id);
    print $result;
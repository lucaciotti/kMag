<?php
    include($_SERVER['DOCUMENT_ROOT']."/kMag2/models/Article.php");
    $codeArt = strtoupper($_GET['cod']);
    $codeLot = strtoupper($_GET['lotto']);
    if(empty($codeLot)){
        $codeLot = null;
    }
    $errMessage = "";
    $ret = '';

    $result = Article::getGiacLot($codeArt, $codeLot, true);
    
    if(empty($result['error']) && !empty($result['data'])) {
        header('Content-Type: application/json');
        header('Cache-Control: no-cache');
        header('Cache-Control: no-store' , false);
        echo json_encode($result['data']);
    } else {
        var_dump($result);
    }
    
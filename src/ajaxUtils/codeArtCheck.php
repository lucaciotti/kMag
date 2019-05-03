<?php
    include($_SERVER['DOCUMENT_ROOT']."/kMag2/models/Article.php");
    $codeArt = strtoupper($_GET['cod']);
    $errMessage = "";
    $ret = '';

    $result = Article::getArticle($codeArt, 'codice');
    $ret = trim($result['data'][0]['codice']);
    // Cerco il BARCODE
    if($result['error']) {
        $result = Article::getArtByBarcode($codeArt, 'codicearti');
        $ret = trim($result['data'][0]['codicearti']);
    }
    // Cerco BARCODE nei Codici Alternativi
    if($result['error']) {
        $result = Article::getArtByCodAlt($codeArt, 'codicearti');
        $ret = trim($result['data'][0]['codicearti']);
    }
    
    if($result['error'] || empty($result['data'])){
        print('*error*');
    } else {
        print($ret);
    }

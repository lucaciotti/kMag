<?php
    include_once($_SERVER['DOCUMENT_ROOT']."/kMag2/models/Article.php");
    include_once($_SERVER['DOCUMENT_ROOT'].'/kMag2/config/global_config.php');

    $codArt = $_GET['cod'];
    $codLotto = $_GET['lotto'];
    $esercizio = $_GET['esercizio'];
    $codMag = $_GET['lotto'];

    if(empty($codMag)){
        $codMag=CONFIG::$DEFAULT_MAG;
    }

    if(empty($codLotto)){
        $result = Article::getGiacArt($codArt, $esercizio, null, false, null, $codMag);
    } else {
        $result = Article::getGiacLot($codArt, $codLotto);
    }

    if($result['rows']>0){
        print $result['data'][0]['esistenza'];
    } else {
        print "*error*";
    }
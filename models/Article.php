<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/kMag2/libs/arcaRestAPI.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/kMag2/config/global_config.php');

class Article {
    private static $initialized;
    private static $conn;

    private static function initialize(){
        if (self::$initialized) return;

        self::$conn = new arcaRestAPI();
        self::$initialized = true;
    }

    public static function getArticle($codeArt, $columns=null){
        self::initialize();

        $url = 'article/'.$codeArt;
        $queryUrl = '';
        if($columns) $queryUrl = 'col='.$columns;

        return self::$conn->get($url, $queryUrl);
    }

    public static function getArtByBarcode($barCode, $columns=null){
        self::initialize();

        $url = 'artbarcode/'.$barCode;
        $queryUrl = '';
        if($columns) $queryUrl = 'col='.$columns;

        return self::$conn->get($url, $queryUrl);
    }

    public static function getArtByCodAlt($barCode, $columns=null){
        self::initialize();

        $url = 'artbarcode2/'.$codeArt;
        $queryUrl = '';
        if($columns) $queryUrl = 'col='.$columns;

        return self::$conn->get($url, $queryUrl);
    }

    public static function getGiacArt($codeArt, $esercizio, $onlyGiac=null, $withOrdImp=true, $onlyDisp=null, $codMag=null, $columns=null){
        self::initialize();
        
        $url = 'giacArt/'.$esercizio.'/'.$codeArt;
        if($codMag) $url = $url.'/'.$codMag;

        $queryUrl = '';
        if($columns) $queryUrl = (!empty($queryUrl) ? '&' : '').'col='.$columns;
        if($onlyGiac) $queryUrl = (!empty($queryUrl) ? '&' : '').'onlygiac=1';
        if($withOrdImp) $queryUrl = (!empty($queryUrl) ? '&' : '').'withordimp=1';
        if($onlyDisp) $queryUrl = (!empty($queryUrl) ? '&' : '').'onlydisp=1';
        
        return self::$conn->get($url, $queryUrl);
    }

    public static function getGiacLot($codeArt, $codeLot=null, $onlyGiac=null, $codMag=null, $columns=null){
        self::initialize();
        
        if(empty($codMag)){
            $codMag=CONFIG::$DEFAULT_MAG;
        }

        $url = 'giacArtLot/'.$codMag.'/'.$codeArt;
        if($codeLot) $url = $url.'/'.$codeLot;
        // print($url);
        $queryUrl = '';
        if($columns) $queryUrl = 'col='.$columns;
        if($onlyGiac) $queryUrl = (!empty($queryUrl) ? '&' : '').'onlygiac=1';
        
        return self::$conn->get($url, $queryUrl);
    }
}
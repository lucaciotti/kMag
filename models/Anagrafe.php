<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/kMag2/libs/arcaRestAPI.php');

class Anagrafe {
    private static $initialized;
    private static $conn;

    private static function initialize(){
        if (self::$initialized) return;

        self::$conn = new arcaRestAPI();
        self::$initialized = true;
    }

    public static function getAnagraf($codicecf, $columns=null){
        self::initialize();

        $url = 'anagraf/'.$codicecf;
        $queryUrl = '';
        if($columns) $queryUrl = 'col='.$columns;

        return self::$conn->get($url, $queryUrl);
    }

    public static function getSetInd($codSettore, $columns=null){
        self::initialize();

        $url = '/anagraf/getSetInd/'.$codSettore;
        $queryUrl = '';
        if($columns) $queryUrl = 'col='.$columns;

        return self::$conn->get($url, $queryUrl);
    }
    
}
<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/kMag2/libs/arcaRestAPI.php');

class MagAna {
    private static $initialized;
    private static $conn;

    private static function initialize(){
        if (self::$initialized) return;

        self::$conn = new arcaRestAPI();
        self::$initialized = true;
    }

    public static function getMaga($codMag, $columns=null){
        self::initialize();

        $url = 'magana/'.$codMag;
        $queryUrl = '';
        if($columns) $queryUrl = 'col='.$columns;

        return self::$conn->get($url, $queryUrl);
    }

    public static function getMagaRight($codMag, $columns=null){
        self::initialize();

        $url = 'magana/right/'.$codMag;
        $queryUrl = '';
        if($columns) $queryUrl = 'col='.$columns;

        return self::$conn->get($url, $queryUrl);
    }

    public static function getReparti($codRep=null, $columns=null){
        self::initialize();

        $url = 'reparti/';
        if(!empty($codRep)) $url = $url.$codRep;
        
        $queryUrl = '';
        if($columns) $queryUrl = 'col='.$columns;

        return self::$conn->get($url, $queryUrl);
    }

}
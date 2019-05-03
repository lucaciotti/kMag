<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/kMag2/libs/arcaRestAPI.php');

class DocTes {
    private static $initialized;
    private static $conn;

    private static function initialize(){
        if (self::$initialized) return;

        self::$conn = new arcaRestAPI();
        self::$initialized = true;
    }

    public static function getById($id, $columns=null){
        self::initialize();

        $url = 'doctesID/'.$id;
        $queryUrl = '';
        if($columns) $queryUrl = 'col='.$columns;

        return self::$conn->get($url, $queryUrl);
    }

    public static function getByTipo($esercizio, $tipodoc, $numerodoc=null, $columns=null){
        self::initialize();

        $url = 'doctestipo/'.$esercizio.'/'.$tipodoc;
        if($numerodoc) $url = $url.'/'.$numerodoc;

        $queryUrl = '';
        if($columns) $queryUrl = 'col='.$columns;

        return self::$conn->get($url, $queryUrl);
    }

}
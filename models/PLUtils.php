<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/kMag2/libs/arcaRestAPI.php');
// include_once($_SERVER['DOCUMENT_ROOT'].'/kMag2/models/DocRig.php');

class PLUtils {
    private static $initialized;
    private static $conn;

    private static function initialize(){
        if (self::$initialized) return;

        self::$conn = new arcaRestAPI();
        self::$initialized = true;
    }

    public static function getCollo($idtesta, $termid){
        self::initialize();

        $url = 'plUtils/getColloByTermId/'.$idtesta.'/'.$termid.'/';
        $res = self::$conn->get($url, null);
        if(!empty($res['data']) && empty($res['error'])) {
            return (integer)$res['data'][0]['collo'];
        } else {
            $url = 'plUtils/getLastCollo/'.$idtesta;
            $res = self::$conn->get($url, null);
            if(!empty($res['data']) && empty($res['error'])) {
                $last=(integer)$res['data'][0]['lastcollo'];
                return $last+1;
            } else {
		        return 1;
		    }
        }
    }

}
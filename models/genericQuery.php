<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/kMag2/libs/arcaRestAPI.php');

class genericQuery {
    private static $initialized;
    private static $conn;

    private static function initialize(){
        if (self::$initialized) return;

        self::$conn = new arcaRestAPI();
        self::$initialized = true;
    }

    public static function getSelect($select, $from, $where, $orderby = '', $groupby = '')
    {
        self::initialize();
        $data = array(
            "select"       => $select,
            "from"       => $from,
            "where"     => $where,
            "orderby"     => $orderby,
            "groupby"     => $groupby,
        );
        // var_dump($data);
        $url = 'genericQuery';
        $res = self::$conn->post($url, $data);
        return $res;
    }

}
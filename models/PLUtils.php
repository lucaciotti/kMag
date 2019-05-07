<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/kMag2/libs/arcaRestAPI.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/kMag2/models/DocRig.php');

class PLUtils {
    private static $initialized;
    private static $conn;

    private static function initialize(){
        if (self::$initialized) return;

        self::$conn = new arcaRestAPI();
        self::$initialized = true;
    }

    public static function getColloByTermId($idtesta, $termid){
        self::initialize();

        $url = 'plUtils/getColloByTermId/'.$idtesta.'/'.$termid.'/';
        $res = self::$conn->get($url, null);
        if($res['rows']>0) {
            return (integer)$res['data'][0]['collo'];
        } else {
            return -1;
        }
    }

    public static function getColloByCollo($idtesta, $collo){
        self::initialize();

        $url = 'plUtils/getColloByNCollo/'.$idtesta.'/'.$collo.'/';
        $res = self::$conn->get($url, null);
        if($res['rows']>0) {
            return (integer)$res['data'][0]['id_term'];
        } else {
            return -1;
        }
    }

    public static function getNewCollo($idtesta){
        self::initialize();
        $url = 'plUtils/getLastCollo/'.$idtesta;
        $res = self::$conn->get($url, null);
        if($res['rows']>0) {
            $last=(integer)$res['data'][0]['lastcollo'];
            return $last+1;
        } else {
            //PL immacolata
            return 1;
        }
    }

    public static function insCollo($idtesta, $termid, $collo){
        self::initialize();

        $data = array(
            "id"        => $idtesta,
            "nCollo"    => $collo,
            "termid"    => $termid
        );
        // var_dump($data);
        $url = 'plUtils/insertCollo';
        $res = self::$conn->post($url, $data);
        return $res;
    }

    public static function chiudiCollo($idtesta, $termid, $collo){
        self::initialize();

        $data = array(
            "id"        => $idtesta,
            "nCollo"    => $collo,
            "termid"    => $termid
        );
        // var_dump($data);
        $url = 'plUtils/chiudiCollo';
        $res = self::$conn->put($url, $data);
        return $res;
    }

    public static function insPBRow($id, $qta=0, $collo, $lotto='', $fatt=0, $um='', $articolo='', $reparto='', $bancale=0, $altezza=0, $misural=0, $misuras=0, $misurah=0, $peso=0, $modify=0){
        self::initialize();
        $data = array(
            "id"        => $id,
            "articolo"  => $articolo,
            "qta"       => $qta,
            "nCollo"    => $collo,
            "lotto"     => $lotto,
            "fatt"      => $fatt,
            "um"        => $um,
            "reparto"   => $reparto,
            "bancale"   => $bancale,
            "altezza"   => $altezza,
            "misural"   => $misural,
            "misuras"   => $misuras,
            "misurah"   => $misurah,
            "peso"      => $peso,
            "modify"    => $modify
        );
        // var_dump($data);
        $url = 'plUtils/insertPlMod';
        $res = self::$conn->post($url, $data);
        return $res;
    }

    public static function insOCRow($rfr, $qta=0, $lotto=''){
        self::initialize();
        $data = array(
            "rfr"       => $rfr,
            "qta"       => $qta,
            "lotto"     => $lotto
        );
        // var_dump($data);
        $url = 'plUtils/insertOcMod';
        $res = self::$conn->post($url, $data);
        return $res;
    }

    public static function updQtaResPl($ip, $qta){
        self::initialize();

        $data = array(
            "id"        => $idtesta,
            "qta"    => $qta
        );
        // var_dump($data);
        $url = 'plUtils/updateQtaResPl';
        $res = self::$conn->put($url, $data);
        return $res;
    }

    public static function addRotellaRows($idOC, $idPL, $qta, $collo){
        $ocGet = DocRig::getById($idOC, 'fogliomis');
        $xmlRotella = $ocGet['data'][0]['fogliomis'];
        $cfType = simplexml_load_string($xmlRotella, NULL, NULL, "cf", true);
	    $type = $cfType->type;
	    print("$type<br>");
	    if ("EGO" == $type) {
		    $cfData = simplexml_load_string($xmlRotella);           
		    $cod = $cfData->serratura1->codice;
            if ("." != $cod) {
                $this->insPBRow($idPL, $qta, $collo, '', 1, 'NR', $cod, '', 0, 0, 0, 0, 0, 0 );
                print("Inserimento scasso 1<br>");
            }
		    $cod = $cfData->serratura2->codice;
		    if ("." != $cod) {
			    $this->insPBRow($idPL, $qta, $collo, '', 1, 'NR', $cod, '', 0, 0, 0, 0, 0, 0 );
			    print("Inserimento scasso 2<br>");
            }
            $cod = $cfData->serratura->codice;
            if ("." != $cod) {
                $this->insPBRow($idPL, $qta, $collo, '', 1, 'NR', $cod, '', 0, 0, 0, 0, 0, 0 );
                print("Inserimento serratura<br>");
            }
	    }
    }

}
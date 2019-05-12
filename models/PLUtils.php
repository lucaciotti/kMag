<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/kMag2/libs/arcaRestAPI.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/kMag2/models/DocRig.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/kMag2/models/DocTes.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/kMag2/models/Article.php');

class PLUtils {
    private static $initialized;
    private static $conn;

    private static function initialize(){
        if (self::$initialized) return;

        self::$conn = new arcaRestAPI();
        self::$initialized = true;
    }

    // FUNZIONI COLLO
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

    // FUNZIONI BANCALE
        public static function getBancByRep($idtesta, $rep){
            self::initialize();

            $url = 'plUtils/getBancByReparto/'.$idtesta.'/'.$rep.'/';
            $res = self::$conn->get($url, null);
            if($res['rows']>0) {
                return (integer)$res['data'][0]['bancale'];
            } else {
                return -1;
            }
        }

        public static function getBancByBanc($idtesta, $banc){
            self::initialize();

            $url = 'plUtils/getBancByNBanc/'.$idtesta.'/'.$banc.'/';
            $res = self::$conn->get($url, null);
            if($res['rows']>0) {
                return (integer)$res['data'][0]['reparto'];
            } else {
                return -1;
            }
        }

        public static function getNewBanc($idtesta){
            self::initialize();
            $url = 'plUtils/getLastBanc/'.$idtesta;
            $res = self::$conn->get($url, null);
            if($res['rows']>0) {
                $last=(integer)$res['data'][0]['lastbanc'];
                return $last+1;
            } else {
                //PL immacolata
                return 1;
            }
        }

        public static function insBanc($idtesta, $reparto, $nBanc){
            self::initialize();

            $data = array(
                "id"        => $idtesta,
                "nBanc"     => $nBanc,
                "reparto"   => $reparto
            );
            // var_dump($data);
            $url = 'plUtils/insertBanc';
            $res = self::$conn->post($url, $data);
            return $res;
        }

        public static function chiudiBanc($idtesta, $reparto, $nBanc){
            self::initialize();

            $data = array(
                "id"        => $idtesta,
                "nBanc"     => $nBanc,
                "reparto"   => $reparto
            );
            // var_dump($data);
            $url = 'plUtils/chiudiBanc';
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
                self::insPBRow($idPL, $qta, $collo+1, '', 1, 'NR', $cod, '', 0, 0, 0, 0, 0, 0 );
                print("Inserimento scasso 1<br>");
            }
		    $cod = $cfData->serratura2->codice;
		    if ("." != $cod) {
			    self::insPBRow($idPL, $qta, $collo+1, '', 1, 'NR', $cod, '', 0, 0, 0, 0, 0, 0 );
			    print("Inserimento scasso 2<br>");
            }
            $cod = $cfData->serratura->codice;
            if ("." != $cod) {
                self::insPBRow($idPL, $qta, $collo, '', 1, 'NR', $cod, '', 0, 0, 0, 0, 0, 0 );
                print("Inserimento serratura<br>");
            }
        }
        return true;
    }

    // RESTITUISCE RIGHE CHE SONO ANCORA IN TABELLA TEMP U_PLMOD
    public static function getPLModRows($idPlRow, $nCollo=-1, $nBanc=null){
        // se nCollo = -1 restituisce tutte le righe (se nBanc filtra righe bancale)
        // se nCollo = 0 resituisce tutti le righe bancale (se nBanc solo riga bancale)
        self::initialize();
        $url = 'plUtils/getPlMod/'.$idPlRow.'/'.$nCollo;
        if($nBanc){
            $url = $url.'/'.$nBanc;
        }
        $res = self::$conn->get($url, null);
        return res;
    }

    // RESTITUISCE RIGHE CREATE IN PB - preformattate per calcolo pesi
    public static function getPBRows($idPbTes, $nCollo=-1, $nBanc=null){
        // se nCollo = -1 restituisce tutte le righe (se nBanc filtra righe bancale)
        // se nCollo = 0 resituisce tutti le righe bancale (se nBanc solo riga bancale)
        self::initialize();
        $url = 'plUtils/getPBRows/'.$idPbTes.'/'.$nCollo;
        if($nBanc){
            $url = $url.'/'.$nBanc;
        }
        $res = self::$conn->get($url, null);
        return res;
    }

    // FUNZIONI PER IL CALCOLO DEL PESO NELLE PL
        public static function getPesoNettoCollo($idTesPL, $idRowPL, $nCollo){
            $isPB = false;
            $isPlMod = false;
            $pesoTot = 0;

            $pbTesGet = DocTes::getByRifId($idTesPL, 'id,tipodoc');
            if($pbTesGet['rows']>0){
                if($pbTesGet['data'][0]['tipodoc']=='PB'){
                    $idTesPB = $pbTesGet['data'][0]['id']; 
                    $pbRowsGet = self::getPBRows($idTesPB, $nCollo);
                    if($pbRowsGet['rows']>0) $isPB = true;
                }
            }
            $plModRows = self::getPLModRows($idRowPL, $nCollo);
            if($plModRows['rows']>0) $isPlMod = true;

            // Unisco i due risultati
            if($isPB && $isPlMod) $allRows = array_merge($pbRowsGet['data'], $plModRows['data']);
            if($isPB && !$isPlMod) $allRows = $pbRowsGet['data'];
            if(!$isPB && $isPlMod) $allRows = $plModRows['data'];
            if(!$isPB && !$isPlMod) return 0;

            foreach ($allRows as $row) {
                $fatt = $row['fatt'];
                $pesounit = $row['pesounit'];
                $qtat = $row['quantita'];
                $pesoTot = $pesoTot + ($fatt*$pesounit*$qtat);
            }
            return $pesoTot;
        }

        public static function getPesoNettoBanc($idTesPL, $idRowPL, $nBanc){
            $isPB = false;
            $isPlMod = false;
            $pesoTot = 0;
            $nCollo = -1; //Prendo tutte le righe del bancale nBanc

            $pbTesGet = DocTes::getByRifId($idTesPL, 'id,tipodoc');
            if($pbTesGet['rows']>0){
                if($pbTesGet['data'][0]['tipodoc']=='PB'){
                    $idTesPB = $pbTesGet['data'][0]['id']; 
                    $pbRowsGet = self::getPBRows($idTesPB, $nCollo, $nBanc);
                    if($pbRowsGet['rows']>0) $isPB = true;
                }
            }
            $plModRows = self::getPLModRows($idRowPL, $nCollo, $nBanc);
            if($plModRows['rows']>0) $isPlMod = true;

            // Unisco i due risultati
            if($isPB && $isPlMod) $allRows = array_merge($pbRowsGet['data'], $plModRows['data']);
            if($isPB && !$isPlMod) $allRows = $pbRowsGet['data'];
            if(!$isPB && $isPlMod) $allRows = $plModRows['data'];
            if(!$isPB && !$isPlMod) return 0;

            foreach ($allRows as $row) {
                $fatt = $row['fatt'];
                $pesounit = $row['pesounit'];
                $qtat = $row['quantita'];
                $pesoTot = $pesoTot + ($fatt*$pesounit*$qtat);
            }
            return $pesoTot;
        }

        public static function getPesoLordoBanc($idTesPL, $idRowPL, $nBanc){
            $isPB = false;
            $isPlMod = false;
            $pesoTot = 0;
            $nCollo = -1; //Prendo tutte le righe del bancale nBanc

            $pbTesGet = DocTes::getByRifId($idTesPL, 'id,tipodoc');
            if($pbTesGet['rows']>0){
                if($pbTesGet['data'][0]['tipodoc']=='PB'){
                    $idTesPB = $pbTesGet['data'][0]['id']; 
                    $pbRowsGet = self::getPBRows($idTesPB, $nCollo, $nBanc);
                    if($pbRowsGet['rows']>0) $isPB = true;
                }
            }
            $plModRows = self::getPLModRows($idRowPL, $nCollo, $nBanc);
            if($plModRows['rows']>0) $isPlMod = true;

            // Unisco i due risultati
            if($isPB && $isPlMod) $allRows = array_merge($pbRowsGet['data'], $plModRows['data']);
            if($isPB && !$isPlMod) $allRows = $pbRowsGet['data'];
            if(!$isPB && $isPlMod) $allRows = $plModRows['data'];
            if(!$isPB && !$isPlMod) return 0;

            foreach ($allRows as $row) {
                $fatt = $row['fatt'];
                $pesolordo = $row['pesolordo'];
                $qtat = $row['quantita'];
                $pesoTot = $pesoTot + ($fatt*$pesolordo*$qtat);
            }
            return $pesoTot;
        }
    
    public static function getRepartoPl($idRowPL){
        $rep = '';
        $plGet = DocRig::getById($idRowPL, 'rifcer,codicearti');
        if($plGet['rows']>0){
            $rep = $plGet['rows'][0]['rifcer'];
            if(empty($rep)){
                $artGet = Article::getArticle($plGet['rows'][0]['codicearti'], 'u_reparto');
                if($artGet['rows']>0) $rep = $artGet['rows'][0]['u_reparto'];
            }
        }
        return $rep;
    }

}
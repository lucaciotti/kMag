<?php
    include($_SERVER['DOCUMENT_ROOT']."/kMag2/models/Article.php");
    
    $codeArt = strtoupper($_GET['cod']);
    $codeArt= str_replace("*", "", $codeArt);
    $cCF = $_GET['cf'];

    $errMessage = "";
    $code = '';
    $unmisura = '';

    $result = Article::getArticle($codeArt, 'codice,unmisura');
    $code = trim($result['data'][0]['codice']);
    $unmisura = trim($result['data'][0]['unmisura']);
    // Cerco il BARCODE
    if(!empty($result['error']) || empty($result['data'])) {
        $result = Article::getArtByBarcode($codeArt, 'codicearti,unmisura');
        $code = trim($result['data'][0]['codicearti']);
        $unmisura = trim($result['data'][0]['unmisura']);
    }
    // Cerco BARCODE nei Codici Alternativi
    if(!empty($result['error']) || empty($result['data'])) {
        $result = Article::getArtByCodAlt($codeArt, 'codicearti');
        $code = trim($result['data'][0]['codicearti']);
    }
    
    if(!empty($result['error']) || empty($result['data'])){
        $out = "<artinfo>";
        $out .= "<codice>*error*</codice>";
        $out .= "</artinfo>";
    } else {
        
        $result = Article::getArticle($code, 'descrizion,ubicazione,u_reparto,lotti,unmisura,danger,u_misural,u_misurah,u_misuras,pesounit,unmisura1,unmisura2,unmisura3,fatt1,fatt2,fatt3');
        if($unmisura=='') {
            $unmisura = trim($result['data'][0]['unmisura']);
        }

        $out = "<artinfo>";
        $out .= "<codice>".htmlspecialchars($code)."</codice>";
        $out .= "<descrizion>" . htmlspecialchars(trim($result['data'][0]['descrizion'])) . "</descrizion>";
        $out .= "<ubicazione>" . trim($result['data'][0]['ubicazione']) . "</ubicazione>";
        $out .= "<reparto>" . trim($result['data'][0]['u_reparto']) . "</reparto>";
        $out .= "<unmisura>$unmisura</unmisura>";
        $out .= "<unmisura1>" . trim($result['data'][0]['unmisura1']). "</unmisura1>";
        $out .= "<unmisura2>" . trim($result['data'][0]['unmisura2']) . "</unmisura2>";
        $out .= "<unmisura3>" . trim($result['data'][0]['unmisura3']) . "</unmisura3>";
        $out .= "<fatt1>" . $result['data'][0]['fatt1'] . "</fatt1>";
        $out .= "<fatt2>" . $result['data'][0]['fatt2'] . "</fatt2>";
        $out .= "<fatt3>" . $result['data'][0]['fatt3']. "</fatt3>";
        $out .= "<u_misural>" . $result['data'][0]['u_misural'] . "</u_misural>";
        $out .= "<u_misurah>" . $result['data'][0]['u_misurah'] . "</u_misurah>";
        $out .= "<u_misuras>" . $result['data'][0]['u_misuras'] . "</u_misuras>";
        $out .= "<pesounit>" . $result['data'][0]['pesounit'] . "</pesounit>";
        $out .= "<imballo>" . ($result['data'][0]['danger'] ? 1 : 0) . "</imballo>";
        $out .= "<lottoob>" . ($result['data'][0]['lotti'] ? 1 : 0) . "</lottoob>";
        $out .= "<lotti>";
            // $Query = "select codice from lotti where codicearti ='".$return."' order by codice desc";
            // if (!$dbtest->Execute($Query)) print "<p> 01 - C'� un errore: " . $db->errorMsg() . "<p>";
            // while(!$dbtest->EOF && trim($dbtest->getField(codice))!="") {
            //     $out .= "<lotto>" . trim($dbtest->getField(codice)) . "</lotto>";
            //     $dbtest->MoveNext();
            // }
        $out .= "</lotti>";
            // $Query = "select codice from u_pallet where codice ='".$return."'";
            // if (!$dbtest->Execute($Query)) print "<p> 01 - C'� un errore: " . $db->errorMsg() . "<p>";
        $out .= "<pallet></pallet>";
        $out .= "</artinfo>";
    }

    header('Content-Type: text/xml');
    header('Cache-Control: no-cache');
    header('Cache-Control: no-store' , false);     // false => this header not override the previous similar header
    print("<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>");
    print($out); 
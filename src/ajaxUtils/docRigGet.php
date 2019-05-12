<?php
    include($_SERVER['DOCUMENT_ROOT']."/kMag2/models/DocRig.php");

    $id = trim($_GET['cod']);

    $errMessage = "";
    $code = '';
    $unmisura = '';

    $result = DocRig::getById($id, 'codicearti,quantita,quantitare,lotto,tipodoc,numerodoc,datadoc,esercizio,id_testa');
    
    if($result['rows']==0){
        $out = "<rigadoc>";
        $out .= "<codice>*error*</codice>";
        $out .= "</rigadoc>";
    } else {
        $code = trim($result['data'][0]['codicearti']);
        
        $out = "<rigadoc>";
        $out .= "<codicearti>".htmlspecialchars($code)."</codicearti>";
        $out .= "<quantita>" . $result['data'][0]['quantita'] . "</quantita>";
        $out .= "<quantitare>" . $result['data'][0]['quantitare'] . "</quantitare>";
        $out .= "<lotto>" . trim($result['data'][0]['lotto']) . "</lotto>";
        $out .= "<tipodoc>" . trim($result['data'][0]['tipodoc']) . "</tipodoc>";
        $out .= "<numerodoc>" . trim($result['data'][0]['numerodoc']) . "</numerodoc>";
        $out .= "<datadoc>" . $result['data'][0]['datadoc'] . "</datadoc>";
        $out .= "<esercizio>" . $result['data'][0]['esercizio'] . "</esercizio>";
        $out .= "<id_testa>" . $result['data'][0]['idtesta'] . "</id_testa>";
        $out .= "</rigadoc>";
    }

    header('Content-Type: text/xml');
    header('Cache-Control: no-cache');
    header('Cache-Control: no-store' , false);     // false => this header not override the previous similar header
    print("<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>");
    print($out); 
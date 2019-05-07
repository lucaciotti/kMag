<?php
    include($_SERVER['DOCUMENT_ROOT']."/kMag2/models/Anagrafe.php");
    $code = strtoupper($_GET['cod']);
    $errMessage = "";
    $ret = '';

    $result = Anagrafe::getSetInd($code);
    
    if(empty($result['error']) && !empty($result['data'])) {
        header('Content-Type: application/json');
        header('Cache-Control: no-cache');
        header('Cache-Control: no-store' , false);
        echo json_encode($result['data']);
    } else {
        if(empty($result['error'])){
            // $result['error'] = 'Not Found!';
            header('Content-Type: application/json');
            header('Cache-Control: no-cache');
            header('Cache-Control: no-store' , false);
            echo json_encode('*error*');

        } else {
            var_dump($result);
        }
    }
<?php
include($_SERVER['DOCUMENT_ROOT']."/kMag2/libs/odbcSocket/odbcSocketObj.php");
include($_SERVER['DOCUMENT_ROOT']."/kMag2/libs/commonUtils.php");

error_reporting(E_ALL & ~(E_STRICT|E_NOTICE));

session_start();

//IMPORTO le Configurazioni Personalizzate
include_once($_SERVER['DOCUMENT_ROOT']."/kMag2/config/global_config.php");
// include($_SERVER['DOCUMENT_ROOT']."/kMag2/config/odbcSocket.php");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="it">

<head>
    <title>k-Mag</title>
    <link rel="shortcut icon" href="../../assets/images/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="../../assets/css/style.css" type="text/css">
    <!-- <link rel="stylesheet" href="../../assets/css/style_pc.css" type="text/css"> -->

    <script type="text/javascript" src="../../assets/js/jQuery/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="../../assets/js/jQuery/jquery.ui.core.min.js"></script>
    <script type="text/javascript" src="../../assets/js/jQuery/jquery.ui.widget.min.js"></script>
    <script type="text/javascript" src="../../assets/js/jQuery/jquery.tablesorter.min.js"></script>
    <script type="text/javascript" src="../../assets/js/ajaxlib.js"></script>

    <script type="text/javascript" src="../../assets/js/arcaJS/artLib.js"></script>
    <script type="text/javascript" src="../../assets/js/arcaJS/pickingLib.js"></script>
    <script type="text/javascript" src="../../assets/js/arcaJS/plLib.js"></script>
    <script type="text/javascript" src="../../assets/js/arcaJS/printLib.js"></script>
    <script type="text/javascript" src="../../assets/js/arcaJS/anagrafLib.js"></script>
</head>
<body>
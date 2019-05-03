<?php 
/************************************************************************/
/* Project ArcaWeb                               		        */
/* ===========================                                          */
/*                                                                      */
/* Copyright (c) 2003-2007 by Roberto Ceccarelli                             */
/*                                                                      */
/************************************************************************/

include("header.php");


$id_testa = $_GET['id'];
$user = $_GET['user'];

$db = getODBCSocket();
//$conn = new COM("ADODB.Connection");
//$conn->Open($connectionstring);

/* aggiornimao tutte le righe con lo stesso id_testa */

$Query = 'update u_picklist set user = "' .$user .'" where id_testa = ' . $id_testa;

print($Query);
if (!$db->Execute($Query)) print "<p> 01 - C'é un errore: " . $db->errorMsg() . "<p>";

 
?>
<?php 
/************************************************************************/
/* Project ArcaWeb                               		      			*/
/* ===========================                                          */
/*                                                                      */
/* Copyright (c) 2003-2013 by Roberto Ceccarelli                        */
/*                                                                      */
/************************************************************************/

include("header.php");

$id = $_GET['id'];
$collo = ( isset($_GET['collo']) ? $_GET['collo'] : 0 );
$artCollo = ( isset($_GET['artcollo']) ? $_GET['artcollo'] : "" );
$desCollo = ( isset($_GET['descollo']) ? $_GET['descollo'] : "" );
$prt = ( isset($_GET['prt']) ? $_GET['prt'] : "0" );
$warnpeso = ( isset($_GET['warnpeso']) ? $_GET['warnpeso'] : "0" );
$split = ( isset($_GET['split']) ? $_GET['split'] : 0);
$ncolli = $_GET['ncolli'];

//$conn = new COM("ADODB.Connection");
//$conn->Open($connectionstring);
$dbPrint = getODBCSocket();

if( $split >0) {
	for($j=0; $j < $split; $j++) {
		$Query = "insert into u_etichpl (id_doc, collo, printer, artcollo, descollo, extracollo, warnpeso) values ($id, ($collo + $j), '".$prt."', '', '', 0, $warnpeso)";
		if (!$dbPrint->Execute($Query)) print "<p> 01 - C'é un errore: " . $dbPrint->errorMsg() . "<p>" and die();
	}
} else {

	if($nColli < 2){
		$Query = "insert into u_etichpl (id_doc, collo, printer, artcollo, descollo, extracollo, warnpeso) ";
			$Query .= "values ($id, $collo, '".$prt."', '', '', 0, $warnpeso)";
		if (!$dbPrint->Execute($Query)) print "<p> 01 - C'é un errore: " . $dbPrint->errorMsg() . "<p>" and die();
	}
	else{
		//se il collo ha anche il collo supplementare allora faccio due sparate nella tabella
		//una con il codice originario e l'altra con il codice dell'articolo del collo
		$collosup = $collo + 1;
		$Query = "insert into u_etichpl (id_doc, collo, printer, artcollo, descollo, extracollo, warnpeso) ";
			$Query .= "values ($id, $collosup, '".$prt."', '".$artCollo."', '".$desCollo."', 0, $warnpeso)";
		if (!$dbPrint->Execute($Query)) print "<p> 01 - C'é un errore: " . $dbPrint->errorMsg() . "<p>" and die();

		$Query = "insert into u_etichpl (id_doc, collo, printer, artcollo, descollo, extracollo, warnpeso) ";
			$Query .= "values ($id, $collosup, '".$prt."', '', '', 0, $warnpeso)";
		if (!$dbPrint->Execute($Query)) print "<p> 01 - C'é un errore: " . $dbPrint->errorMsg() . "<p>" and die();
	}
}
//diconnect from database 
//$conn->Close();
//$rs = null;
//$conn = null;

header("location: askpl.php"); 

?>
<?php 
/************************************************************************/
/* Project ArcaWeb                               				        */
/* ===========================                                          */
/*                                                                      */
/* Copyright (c) 2003-2013 by Roberto Ceccarelli                        */
/* 																		*/
/************************************************************************/

include("header.php");

$db = getODBCSocket();
//$conn = new COM("ADODB.Connection");
//$conn->Open($connectionstring);

$id = $_GET['id'];
$id_pl = $_GET['id_pl'];
$qta = $_GET['qta'];
$collo = ($_GET['collo'] == "" ? 0 : $_GET['collo']);
$fatt = ($_GET['um'] == 0 ? 1 : $_GET['um']);
$um = $_GET['umdesc'];
$totcolli = $_GET['totcolli'];
$prt = ( $_GET['print'] == "" ? 0 : $_GET['print']);

head("test");
// if($collo == 0) {
	// header("location: askpl.php"); 
	// exit();
// }

$qtacollo = $totcolli;
$totcolli = ceil($qta / $qtacollo);
echo $qtacollo;
for($j=1; $j <= $totcolli-1; $j++) {
	$Query = "insert into u_plmod (id, quantita, collo, lotto, fatt, unmisura, articolo, reparto, bancale, altezza, u_misural, u_misurah, u_misuras ) ";
	$Query .= "values ($id, $qtacollo, $collo + $j -1, '', $fatt, '".$um."', '', '', 0, 0, 0, 0, 0 )";
	if (!$db->Execute($Query)) print "<p> 01 - C'é un errore: " . $db->errorMsg() . "<p>" and die();
	if($j > 1) {
		$Query = "insert into u_termpl (id_term, id_pl, collo) values ( ";
		$Query .= "$id_term+1, $id_pl, $collo + $j -1)";
		if (!$db->Execute($Query)) print "<p> 01 - C'é un errore: " . $db->errorMsg() . "<p>" and die();
	}
	echo "<br>Collo $collo + $j -1";
}

$Query = "update docrig";
$Query .= " set u_costk=" . ($collo+ $totcolli -1);
$Query .= ", quantita = quantita - ($qtacollo * ($totcolli-1))"; 
$Query .= ", quantitare = quantitare - ($qtacollo * ($totcolli-1))";
$Query .= " where id=$id";
echo "<br>$Query";
if (!$db->Execute($Query)) print "<p> 01 - C'é un errore: " . $db->errorMsg() . "<p>" and die();


//if( $prt > 0) {
//  header("location: pl-selectprt.php?id=$id_pl&collo=$collo&ncolli=$totcolli&artcollo=&descollo=&split=1");
	header("location: pl-imb.php?id=$id&id_pl=$id_pl&collo=$collo&prt=$prt&ncolli=$totcolli&artcollo=&descollo=&split=$totcolli");
//} else {
//	header("location: askpl.php"); 
//}
?>
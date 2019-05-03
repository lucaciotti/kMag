<?php 
/************************************************************************/
/* Project ArcaWeb                               		      			*/
/* ===========================                                          */
/*                                                                      */
/* Copyright (c) 2003-2013 by Roberto Ceccarelli                        */
/*                                                                      */
/************************************************************************/

include("header.php");
headx("TEST");

$id = $_GET['id'];
$id_pl = $_GET['id_pl'];
$art = $_GET['art'];
$collo = ($_GET['collo'] == "" ? 0 : $_GET['collo']);
$prt = ( $_GET['prt'] == "" ? 0 : $_GET['prt']);
$artCollo = (isset($_GET['artcollo']) ? $_GET['artcollo'] : "" );
$desCollo = (isset($_GET['descollo']) ? $_GET['descollo'] : "" );
$nColli = (isset($_GET['ncolli']) ? $_GET['ncolli'] : "" );
$rep = $_GET['rep'];
$hasbanc = isset($_GET['hasbanc']);
$banc = (isset($_GET['bancnum']) ? ($_GET['bancnum'] == "" ? 0 : $_GET['bancnum']) : 0);
$banc = ($hasbanc ? $banc : 0);
$altezza = (isset($_GET['altezza']) ? ($_GET['altezza'] == "" ? 0 : $_GET['altezza']) : 0);
$collopl = 0;
$codBanc = (isset($_GET['codbanc']) ? $_GET['codbanc'] : "" );
$split = (isset($_GET['split']) ? $_GET['split'] : 0 );

$imb_u_misural = (isset($_GET['imb_u_misural']) ? ($_GET['imb_u_misural'] == "" ? 0 : $_GET['imb_u_misural']) : 0);
$imb_u_misurah = (isset($_GET['imb_u_misurah']) ? ($_GET['imb_u_misurah'] == "" ? 0 : $_GET['imb_u_misurah']) : 0);
$imb_u_misuras = (isset($_GET['imb_u_misuras']) ? ($_GET['imb_u_misuras'] == "" ? 0 : $_GET['imb_u_misuras']) : 0);
$pal_u_misural = (isset($_GET['pal_u_misural']) ? ($_GET['pal_u_misural'] == "" ? 0 : $_GET['pal_u_misural']) : 0);
$pal_u_misuras = (isset($_GET['pal_u_misuras']) ? ($_GET['pal_u_misuras'] == "" ? 0 : $_GET['pal_u_misuras']) : 0);

$db = getODBCSocket();

if($collo == 0) {
	header("location: askpl.php"); 
	exit();
}

if($nColli < 2) {
    $collopl = $collo;
} else {
    $collopl = $collo + 1;
}

if( $art != "") {
	//$conn = new COM("ADODB.Connection");
	//$conn->Open($connectionstring);

	if( $split > 0) {
		// split automatico colli
		for($j=0; $j < $split; $j++) {
			$Query = "insert into u_plmod (id, quantita, collo, lotto, fatt, unmisura, articolo, reparto, bancale, altezza, u_misural, u_misurah, u_misuras ) ";
			$Query .= "values ($id, 1, ($collopl + $j), '', 1, '', '".$art."', '".$rep."', $banc, $altezza, $imb_u_misural, $imb_u_misurah, $imb_u_misuras )";
			print("$Query<br>");
			if (!$db->Execute($Query)) print "<p> 01 - C'é un errore: " . $db->errorMsg() . "<p>" and die();
		}
	} else {
		if($nColli < 2) {
			$Query = "insert into u_plmod (id, quantita, collo, lotto, fatt, unmisura, articolo, reparto, bancale, altezza, u_misural, u_misurah, u_misuras ) ";
			$Query .= "values ($id, 1, $collopl, '', 1, '', '".$art."', '".$rep."', $banc, $altezza, $imb_u_misural, $imb_u_misurah, $imb_u_misuras )";
			print("$Query<br>");
			if (!$db->Execute($Query)) print "<p> 01 - C'é un errore: " . $db->errorMsg() . "<p>" and die();
		} else {
			// ROBERTO 11.09.2013
			// anche il collo aggiuntivo ha un imballo...
			$Query = "insert into u_plmod (id, quantita, collo, lotto, fatt, unmisura, articolo, reparto, bancale, altezza, u_misural, u_misurah, u_misuras ) ";
			$Query .= "values ($id, 1, $collopl, '', 1, '', '".$art."', '".$rep."', $banc, $altezza, $imb_u_misural, $imb_u_misurah, $imb_u_misuras )";
			print("$Query<br>");
			if (!$db->Execute($Query)) print "<p> 01 - C'é un errore: " . $db->errorMsg() . "<p>" and die();
			// Se l'imballo e' "doppio" mi regolo
			$Query = "select u_artcollo, u_misural, u_misurah, u_misuras from magart where codice ='".$art."'";
			print("$Query<br>");
			if (!$db->Execute($Query)) print "<p> 01 - C'é un errore: " . $db->errorMsg() . "<p>";
			if( trim($db->getField(u_artcollo)) != "") {
				$art = $db->getField(u_artcollo);
				$imb_u_misural = $db->getField(u_misural);
				$imb_u_misurah = $db->getField(u_misurah);
				$imb_u_misuras = $db->getField(u_misuras);
			}
			$Query = "insert into u_plmod (id, quantita, collo, lotto, fatt, unmisura, articolo, reparto, bancale, altezza, u_misural, u_misurah, u_misuras ) ";
			$Query .= "values ($id, 1, $collo, '', 1, '', '".$art."', '".$rep."', $banc, $altezza, $imb_u_misural, $imb_u_misurah, $imb_u_misuras )";
			print("$Query<br>");
			if (!$db->Execute($Query)) print "<p> 01 - C'é un errore: " . $db->errorMsg() . "<p>" and die();
		}
	}
	
	if($hasbanc) {
		// gestione bancale
		if($split > 0) {
			$Query = "update docrig set u_costk1 = $banc where id_testa = $id_pl and u_costk = ($collo + $split - 1)";
		} else {
			$Query = "update docrig set u_costk1 = $banc where id_testa = $id_pl and u_costk = $collo";
			if($nColli > 1) {
				$Query = "update docrig set u_costk1 = $banc where id_testa = $id_pl and (u_costk = $collo or u_costk = $collopl)";
			}
		}
		print("$Query<br>");
		if (!$db->Execute($Query)) print "<p> 01 - C'é un errore: " . $db->errorMsg() . "<p>" and die();
		$Query = "update u_plmod set bancale = $banc where id = $id";
		print("$Query<br>");
		if (!$db->Execute($Query)) print "<p> 01 - C'é un errore: " . $db->errorMsg() . "<p>" and die();
		if(isset($_GET['closebanc'])) {
			$artBanc = (isset($_GET['codbanc']) ? $_GET['codbanc'] : "" );
			$Query = "update docrig set u_traverso = $altezza where u_costk1 = $banc and id_testa = $id_pl";
			print("$Query<br>");
			if (!$db->Execute($Query)) print "<p> 01 - C'é un errore: " . $db->errorMsg() . "<p>" and die();
			$Query = "insert into u_plmod (id, quantita, collo, lotto, fatt, unmisura, articolo, reparto, bancale, altezza, u_misural, u_misurah, u_misuras ) ";
			$Query .= "values ($id, 1, 0, '', 1, '', '".$artBanc."', '".$rep."', $banc, $altezza, $pal_u_misural, 0, $pal_u_misuras )";
			print("$Query<br>");
			if (!$db->Execute($Query)) print "<p> 01 - C'é un errore: " . $db->errorMsg() . "<p>" and die();
		}
	}

}

if( $prt > 0) {
    header("location: pl-selectprt.php?id=$id_pl&id_riga=$id&collo=$collo&ncolli=$nColli&artcollo=$artCollo&descollo=$desCollo&split=$split ");
} else {
	header("location: askpl.php"); 
}

?>
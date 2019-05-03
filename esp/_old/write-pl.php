<?php
/************************************************************************/
/* Project ArcaWeb                               		      			*/
/* ===========================                                          */
/*                                                                      */
/* Copyright (c) 2003-2013 by Roberto Ceccarelli                        */
/*                                                                      */
/************************************************************************/

include("header.php");

$id = $_POST['id'];
$id_pl = $_POST['id_pl'];
$qta = $_POST['qta'];
$collo = ($_POST['collo'] == "" ? 0 : $_POST['collo']);

$anno = current_year();
$db = getODBCSocket();
$dbWrite = getODBCSocket();
$db2 = getODBCSocket();

//TORNO INIZIO...NO COLLO!!!
if($collo == 0) {
	header("location: askpl.php");
	exit();
}

$lotto = trim($_POST['lotto']);
$prt = ( $_POST['print'] == "" ? 0 : $_POST['print']);
$newfatt = ($_POST['newFatt'] == 0 ? 1 : $_POST['newFatt']);
$fatt = ($_POST['oldFatt'] == 0 ? 1 : $_POST['oldFatt']);
$fatt = ($fatt == 0 ? 1 : $fatt);
$um = $_POST['umdesc'];
$close = ( isset($_POST['close']) ? $_POST['close'] : 0 );
$gruppo = (isset($_POST['gruppo']) ? $_POST['gruppo'] : "");
$nColli = (isset($_POST['ncolli']) ? $_POST['ncolli'] : 1);
$artCollo = (isset($_POST['artcollo']) ? $_POST['artcollo'] : "");
$desCollo = (isset($_POST['descollo']) ? $_POST['descollo'] : "");

//print($qta ." Ac".$newfatt ."B c".$fatt."\n");

// inizializziamo la pagina per tracciare eventuali problemi
head("Scrittura PL");

$qta = $qta * $newfatt / $fatt;

//print($qta ." A".$newfatt ."B ".$fatt);


$collopl = 0;
if($nColli < 2) {
    $collopl = $collo;
} else {
    //la riga va tutta nel collo con numero più alto.
    $collopl = $collo+1;
}

if( $prt < 2) {

	$Query = "SELECT quantita, quantitare, id_testa, codicearti, descrizion, unmisura, fatt, riffromr FROM docrig WHERE id = ".$id."";
	if (!$db->Execute($Query)) print "<p> 01 - C'é un errore: " . $db->errorMsg() . "<p>" and die;

	print("Ricerca riga<br>");
	if($db->getField(riffromr) == 0) {
		print("<br>ATTENZIONE: riga PL manomessa.<br>Informare il CED.<br>");
		exit();
	}

	$qtaold = $db->getField(quantita);
	if($db->getField(unmisura) != $um) {
		//devo eseguire la conversione di unit�
		$qtaold = $qtaold * $db->getField(fatt) / $fatt;
	}
	if($qta >= $qtaold) {
		if(trim($artCollo)=="") {
			$Query = "UPDATE docrig set u_costk = ".$collopl.", quantita = ".$qta.", quantitare = ".$qta.", lotto = '".$lotto."', ";
			$Query .= "rifstato = 'S', unmisura = '".$um."', fatt = ".$fatt." where id = ".$id."";
			print("Aggiornamento PL collo singolo<br>");
			if (!$dbWrite->Execute($Query)) print "<p> 01 - C'é un errore: " . $dbWrite->errorMsg() . "<p>" and die;
		} else {
			// ROBERTO 11.09.2013
			// nella packing list devo sdoppiare la riga in caso di doppio collo
			$Query = "UPDATE docrig set u_costk = ".$collo.", quantita = $qta, quantitare = $qta, lotto = '".$lotto."', ";
			$Query .= "rifstato = 'S', unmisura = '".$um."', fatt = $fatt where id = $id";
			print("Aggiornamento PL collo doppio<br>");
			if (!$dbWrite->Execute($Query)) print "<p> 01 - C'é un errore: " . $dbWrite->errorMsg() . "<p>" and die;
			$Query = "INSERT into u_plmod (id, quantita, collo, lotto, fatt, unmisura, articolo, reparto, bancale, altezza, u_misural, u_misurah, u_misuras ) ";
			$Query .= "values ($id, $qta, $collopl, '".$lotto."', $fatt, '".$um."', '".$artCollo."', '', 0, 0, 0, 0, 0 )";
			print("Inserimento secondo collo<br>");
			if (!$dbWrite->Execute($Query)) print "<p> 01 - C'é un errore: " . $dbWrite->errorMsg() . "<p>" and die;
		}
	} else {
		if($qta == 0) {
			// LUCA 25/02/2014 Mascherato con CLAUDIO (SE quantità sparata è 0 cancella la riga nella PL)
			//$Query = "DELETE from docrig where id = $id";
			//if (!$dbWrite->Execute($Query)) print "<p> 01 - C'é un errore: " . $dbWrite->errorMsg() . "<p>" and die;
		} else {
			if(trim($artCollo)=="") {
				$Query = "INSERT into u_plmod (id, quantita, collo, lotto, fatt, unmisura, articolo, reparto, bancale, altezza, u_misural, u_misurah, u_misuras ) ";
				$Query .= "values ($id, $qta, $collopl, '".$lotto."', $fatt, '".$um."', '', '', 0, 0, 0, 0, 0 )";
				print("Inserimento riga suddivisione<br>");
				if (!$dbWrite->Execute($Query)) print "<p> 01 - C'é un errore: " . $dbWrite->errorMsg() . "<p>" and die;
			} else {
				// ROBERTO 11.09.2013
				// nella packing list devo sdoppiare la riga in caso di doppio collo
				$Query = "INSERT into u_plmod (id, quantita, collo, lotto, fatt, unmisura, articolo, reparto, bancale, altezza, u_misural, u_misurah, u_misuras ) ";
				$Query .= "values ($id, $qta, $collo, '".$lotto."', $fatt, '".$um."', '', '', 0, 0, 0, 0, 0 )";
				print("Inserimento riga suddivisione collo doppio<br>");
				if (!$dbWrite->Execute($Query)) print "<p> 01 - C'é un errore: " . $dbWrite->errorMsg() . "<p>" and die;
				$Query = "insert into u_plmod (id, quantita, collo, lotto, fatt, unmisura, articolo, reparto, bancale, altezza, u_misural, u_misurah, u_misuras ) ";
				$Query .= "values ($id, $qta, $collopl, '".$lotto."', $fatt, '".$um."', '".$artCollo."', '', 0, 0, 0, 0, 0 )";
				print("Inserimento secondo collo<br>");
				if (!$dbWrite->Execute($Query)) print "<p> 01 - C'é un errore: " . $dbWrite->errorMsg() . "<p>" and die;
			}
			$Query = "UPDATE docrig set quantita = ($qtaold - $qta), quantitare = ($qtaold - $qta), ";
			$Query .= "rifstato = 'S', unmisura = '".$um."', fatt = $fatt where id = $id";
			print("Aggiornamento residuo PL<br>");
			if (!$dbWrite->Execute($Query)) print "<p> 01 - C'é un errore: " . $dbWrite->errorMsg() . "<p>" and die;
		}
	}

	// gestione del lotto sull'ordine (se necessario)
	if($lotto != "") {
		$rfr = (integer)$db->getField(riffromr);
		//TEST NON SERVE PIU'...ORA MODIFICHIAMO SEMPRE RIGA ORDINE FINO AD OTTENERE QTA RES = 0
		/*$Query = "select lotto from docrig where id = $rfr";
		if (!$db2->Execute($Query)) print "<p> 01 - C'é un errore: " . $db2->errorMsg() . "<p>" and die;
		$lotto_ord = trim($db2->getField(lotto));
		if($lotto_ord == "") {
			// nell'ordine non c'� il lotto, gli assegnamo quello sparato
			$Query = "update docrig set lotto = '".$lotto."' where id = $rfr";
			if (!$dbWrite->Execute($Query)) print "<p> 01 - C'é un errore: " . $dbWrite->errorMsg() . "<p>" and die;
		}
		elseif($lotto_ord != $lotto) {*/
			// facciamo partire la gestione FOX
			$Query = "insert into u_plocmod (id, lotto, qta) values ($rfr, '".$lotto."', $qta)";
			print("Aggiornamento residuo ordine<br>");
			if (!$dbWrite->Execute($Query)) print "<p> 01 - C'é un errore: " . $dbWrite->errorMsg() . "<p>" and die;
		//}
	}


	/*diconnect from database
	$conn->Close();
	$rs = null;
	$rs1 = null;
	$rso = null;
	$conn = null;*/
}

//echo "close: $close, prt: $prt, collo: $collo  \n";
if($close == 1) {
//	echo "test.ok";
	$Query = "select id_term from u_termpl where id_pl = $id_pl and collo = ".$collo."";
	if (!$db2->Execute($Query)){
       print "<p> 02 - C'é un errore: " . $db2->errorMsg() . "<p>";
    }
	$tf = $db2->getField(id_term);
    $termFound = (integer)$tf;
	$Query = "update u_termpl set id_term = ($termFound + 1) where id_pl = ".$id_pl." and collo = ".$collo."";
	if (!$db2->Execute($Query)){
       print "<p> 02 - C'é un errore: " . $db2->errorMsg() . "<p>";
    }
    header("location: pl-imb.php?id_pl=$id_pl&id=$id&collo=$collo&prt=$prt&ncolli=$nColli&artcollo=$artCollo&descollo=$desCollo");
	exit();
}

if( $prt > 0) {
    header("location: pl-selectprt.php?id=$id_pl&id_riga=$id&collo=$collo&ncolli=$nColli&artcollo=$artCollo&descollo=$desCollo");
} else {
	header("location: askpl.php");
}

?>

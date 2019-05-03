<?php 
/************************************************************************/
/* Project ArcaWeb                               		      			*/
/* ===========================                                          */
/*                                                                      */
/* Copyright (c) 2003-2013 by Roberto Ceccarelli                        */
/*                                                                      */
/************************************************************************/

include("header.php");
?>
<script type="text/javascript">
//<![CDATA[
var createCookie = function(name,value,days) {
	if (days) {
		var date = new Date();
		date.setTime(date.getTime()+(days*24*60*60*1000));
		var expires = "; expires="+date.toGMTString();
	}
	else var expires = "";
	document.cookie = name+"="+value+expires+"; path=/";
};

var setPrinter = function() {
	createCookie("plprinter", document.getElementById("prt").value, 10);
	return true;
};
//]]>
</script>
<?php
$id = $_GET['id'];
$id_riga = ( isset($_GET['id_riga']) ? $_GET['id_riga'] : 0 );
$collo = ( isset($_GET['collo']) ? $_GET['collo'] : 0 );
$artCollo = ( isset($_GET['artcollo']) ? $_GET['artcollo'] : "" );
$desCollo = ( isset($_GET['descollo']) ? $_GET['descollo'] : "" );
$nColli = ( isset($_GET['ncolli']) ? $_GET['ncolli'] : 1 );
$default_prt = ( isset($_COOKIE['plprinter']) ? $_COOKIE['plprinter'] : "##" );
$split = (isset($_GET['split']) ? $_GET['split'] : 0);

head("Scelta stampante");

$db = getODBCSocket();
$anno = current_year();
$peso = 0;
$error = false;

if ($id_riga != 0 && $collo != 0){
	$Query = "Select docrig.codicearti, docrig.quantita, docrig.u_costk as collo";
	$Query .= ", docrig.unmisura, docrig.fatt, magart.pesounit ";
	$Query .= " from docrig left join magart on magart.codice = docrig.codicearti ";
	$Query .= " where docrig.id_testa = $id AND docrig.u_costk = $collo "; 
	$Query .= " UNION Select iif(EMPTY(u_plmod.articolo), docrig.codicearti, u_plmod.articolo) as codicearti, u_plmod.quantita, u_plmod.collo";
	$Query .= ", u_plmod.unmisura, u_plmod.fatt, magart.pesounit ";
	$Query .= " from u_plmod left join docrig on docrig.id = u_plmod.id";
	$Query .= "  left join magart on magart.codice = iif(EMPTY(u_plmod.articolo), docrig.codicearti, u_plmod.articolo)  ";
	$Query .= " where u_plmod.id = $id_riga AND u_plmod.collo = $collo"; 
	if (!$db->Execute($Query)) print "<p> 01 - C'é un errore: " . $db->errorMsg() . "<p>" and die();
} else {
	if ($id_riga == 0 && $collo == 0){
		$Query = "Select docrig.codicearti, docrig.quantita, docrig.u_costk as collo";
		$Query .= ", docrig.unmisura, docrig.fatt, magart.pesounit ";
		$Query .= " from docrig left join magart on magart.codice = docrig.codicearti ";
		$Query .= " where docrig.id_testa = $id AND docrig.u_costk != $collo "; 
		if (!$db->Execute($Query)) print "<p> 01 - C'é un errore: " . $db->errorMsg() . "<p>" and die();
	} else {
		print("ERRORE CONTATTARE AMMINISTRATORE!");
		$error = true;
	}
}

if(!$error){
	while (!$db->EOF) {
		$fatt = $db->getField(fatt);
		$pesounit = $db->getField(pesounit);
		$qtat = $db->getField(quantita);
		$peso = $peso + ($fatt*$pesounit*$qtat);
		$db->MoveNext();
	}

	print("<form method=\"get\" action=\"pl-print.php\" onsubmit=\"return setPrinter();\">\n");
	hiddenField("id", $id);  
	hiddenField("collo", $collo);
	hiddenField("artcollo", trim($artCollo));
	hiddenField("descollo", trim($desCollo));
	hiddenField("split", $split);
	hiddenField("ncolli", $ncolli);
	print("<select name=\"prt\" id=\"prt\">\n");
	for($i = 0; $i < count($prtlist); $i++) {
		print("<option value=\"" . $prtlist[$i] . "\"");
		print( $prtlist[$i] == $default_prt ? " selected=\"selected\">" : ">" );
		print($prtlist[$i]);
		print("</option>\n");
	}
	print("</select>\n<br>\n");

	if($peso >= 15){
		print("<span>ATTENZIONE Stampare Etichette Peso Maggiore di 15KG? (Se SI flaggare sotto)</span></br>");
		print("<input type=\"checkbox\" name=\"warnpeso\" id=\"warnpeso\" value=\"1\"> SI </br>\n");
	}
	if ($id_riga != 0){
		print("<span>Peso collo di $peso KG</span></br>");
	} else {
		print("<span>Peso dell'intera PL fino ad ora di $peso KG</span></br>");
	}
	
	print("<input type=\"submit\" value=\"Stampa\">\n");
	print("</form>");
}

footer();
?>
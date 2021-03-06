<?php 
/************************************************************************/
/* Project ArcaWeb                               				        */
/* ===========================                                          */
/*                                                                      */
/* Copyright (c) 2003-2013 by Roberto Ceccarelli                        */
/*                                                                      */
/************************************************************************/

include("header.php");
 
/*$conn = new COM("ADODB.Connection");
$conn->Open($connectionstring);*/

$db = getODBCSocket();

$id = $_GET['id'];
$id_pl = $_GET['id_pl'];
$collo = ($_GET['collo'] == "" ? 0 : $_GET['collo']);
$prt = ( $_GET['prt'] == "" ? 0 : $_GET['prt']);
$artCollo = (isset($_GET['artcollo']) ? $_GET['artcollo'] : "" );
$desCollo = (isset($_GET['descollo']) ? $_GET['descollo'] : "" );
$nColli = (isset($_GET['nColli']) ? $_GET['nColli'] : "" );
$split = (isset($_GET['split']) ? $_GET['split'] : 0 );

headx("Imballo");
disableCR();

?>
<style>
label	{float: left; width: 60px;}
label.checkbox	{float: none; width: 100px;}
body	{width: 250px;}
</style>
<script type="text/javascript" src="../pl-imb-util.js"></script>
<?php	
print("<div style=\"width: 250px\"><form name=\"plimb\" method=\"get\" action=\"write-imb.php\" onsubmit=\"return checkForm();\">\n");
hiddenField("id",$id);
hiddenField("id_pl",$id_pl);
hiddenField("collo",$collo);
hiddenField("prt",$prt);
hiddenField("artcollo",$artCollo);
hiddenField("descollo",$desCollo);
hiddenField("ncolli",$nColli);
hiddenField("split",$split);

print("<label for=\"art\">Imballo</label>\n");
print("<input type=\"text\" id=\"art\" name=\"art\" onblur=\"decodeImb(this);\">\n");
//print("<input type=\"text\" id=\"art\" name=\"art\" onblur=\"alert(this.value);\">\n");
print("<br>\n");
print("<fieldset>\n<legend>Dimensioni</legend>\n");
print("<input style=\"width: 40px\" type=\"text\" size=\"4\" name=\"imb_u_misural\" id=\"imb_u_misural\" ");
print("onblur=\"copiaVal(this, document.getElementById('pal_u_misural'));\">&nbsp;X\n"); 
print("<input style=\"width: 40px\" type=\"text\" size=\"4\" name=\"imb_u_misuras\" id=\"imb_u_misuras\" "); 
print("onblur=\"copiaVal(this, document.getElementById('pal_u_misuras'));\">&nbsp;X\n"); 
print("<input style=\"width: 40px\" type=\"text\" size=\"4\" name=\"imb_u_misurah\" id=\"imb_u_misurah\" "); 
print("onblur=\"copiaVal(this, document.getElementById('altezza'));\"> in cm\n"); 
print("</br>(Largh. x Profondità x (H)Altezza)");
print("</fieldset>\n");
print("<label for=\"rep\">Reparto</label>\n");
selectReparti($db, $id);
print("<br><br>\n");

print("<input type=\"checkbox\" id=\"hasbanc\" name=\"hasbanc\" value=\"hasbanc\" onclick=\"clickBancale();\">\n");
print("<label for=\"hasbanc\" class=\"checkbox\">Bancalato</label>\n");
print("<div id=\"askbanc\" style=\"display: none;\">\n");
print("<label for=\"bancnum\">Bancale</label>\n");
print("<input type=\"text\" id=\"bancnum\" name=\"bancnum\" size=\"2\" value=\"1\">\n");
print("<input type=\"checkbox\" id=\"closebanc\" name=\"closebanc\" value=\"close\" onclick=\"showHideText(this, 'askcodbanc');\">\n");
print("<label for=\"closebanc\" class=\"checkbox\">Chiudi bancale</label>\n");
print("<div id=\"askcodbanc\" style=\"display: none;\">\n");
print("<label for=\"codbanc\">Tipo</label>\n");
print("<select style=\"width: 280px; font-size: 78%\" id=\"codbanc\" name=\"codbanc\" onchange=\"decodeBanc(this);\">\n");
print("<option value=\"\"> - Scegli bancale - </option>\n");
$Query = "select magart.codice, magart.descrizion from magart where magart.codice in (select u_pallet.codice from u_pallet)";
if (!$db->Execute($Query)) print "<p> 01 - C'é un errore: " . $db->errorMsg() . "</p>";
while(!$db->EOF) {
	print("<option value=\"" . trim($db->getField(codice)) . "\">" . trim($db->getField(descrizion)) . "</option>\n"); 
	$db->MoveNext();
}
print("</select>\n");
print("<fieldset>\n<legend>Dimensioni</legend>\n");
print("<input style=\"width: 40px\" type=\"text\" size=\"4\" name=\"pal_u_misural\" id=\"pal_u_misural\">&nbsp;X\n"); 
print("<input style=\"width: 40px\" type=\"text\" size=\"4\" name=\"pal_u_misuras\" id=\"pal_u_misuras\">&nbsp;X\n");
print("<input style=\"width: 40px\" type=\"text\" size=\"4\" name=\"altezza\" id=\"altezza\"> in cm\n");
print("</br>(Largh. x Profondità x (H)Altezza)");
print("</fieldset>\n");
print("</div>\n");
print("</div>\n");

print("<br>\n");
print("<input style=\"float: right\" type=\"submit\" value=\"Procedi\">\n");
print("</form> </div>\n");
setFocus("art");

footer();

function getReparto($db, $id) {
	$Query = "select codicearti, rifcer from docrig where id = $id";
	if (!$db->Execute($Query)) print "<p> 01 - C'é un errore: " . $db->errorMsg() . "<p>" and die;
    echo $id;
    echo $Query;
	$rep = trim($db->getField(rifcer));
	if("" == $rep) {
		$Query = "select u_reparto from magart where codice = '" . $db->getField(codicearti) . "'";
		$rs = $conn->Execute($Query) or die;
		$rep = trim($db->getField(u_reparto));
	}
	return $rep;
}

function selectReparti($db, $id) {
	print("<select id=\"rep\" name=\"rep\">\n");
	reparti(getReparto($db, $id), $db);
	print("</select>\n");
}
?>
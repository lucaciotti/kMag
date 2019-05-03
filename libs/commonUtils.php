<?php

$termid = 0;
if( isset($_COOKIE["tid"]) ) {
	$termid = $_COOKIE["tid"];
} else {
	$termid = date("His") . "0";
	setcookie("tid",$termid,time()+3600*24*365);
}

// Calcolo dell'anno corrente
function current_year() {
// $lt = localtime(time(), true);
// return ($lt[tm_year]+1900);
return date("Y");
}


// Formatta le date in modo che siano piu' leggibili
function format_date($foxdate) {
	return strftime("%d/%m/%Y", mktime(0,0,0,substr($foxdate,5,2),substr($foxdate,8,2),substr($foxdate,0,4) )) ;
}

// Campi hidden per passaggio parametri
function hiddenField($id, $val) {
	print("<input type=\"hidden\" id=\"$id\" name=\"$id\" value=\"$val\">\n");
}

// Script per l'impostazione del focus
function setFocus($id) {
	print("<script type=\"text/javascript\">\n");
	print("//<![CDATA[\n");
	print("document.getElementById(\"$id\").focus();\n");
	print("//]]>\n");
	print("</script>\n");
}

// Script per disabilitare il CR
function disableCR() {
	print("<script type=\"text/javascript\">\n");
	print("//<![CDATA[\n");
	print("document.onkeypress = stopRKey;\n");
	print("//]]>\n");
	print("</script>\n");
}

// ritorna la url completa della pagina
function curPageURL() {
 $pageURL = 'http';
 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 return $pageURL;
}

// Link per il ritorno al menu principale
function goMain() {
	print ("<br>\n<a class=\"menu\" href=\"../menus/main.php\"><img noborder src=\"b_home.gif\">Menu principale</a>\n");
}

// Riempie la combobox dei reparti
function reparti($current, $db) {
//global $connectionstring;

$current=trim($current);
$reparto="";
print("<option value=\"$reparto\"");
if ($reparto == $current) {
  print(" selected=\"selected\""); }
print(">$reparto</option>\n");

//$conn = new COM("ADODB.Connection");
//$conn->Open($connectionstring);
$Query = "select * from u_reparti order by descrizion";
if (!$db->Execute($Query)) print "<p> 01 - C'é un errore: " . $db->errorMsg() . "<p>";
while(!$db->EOF) {
  $reparto= trim($db->getField(codice));
  print("<option value=\"$reparto\"");
  if ($reparto == $current) {
    print(" selected=\"selected\""); }
  print(">" . trim($db->getField(descrizion)) . "</option>\n");
  $db->MoveNext();
  }

}

// prende il valore numerico di un parametro controllandone l'esistenza
function getNumeric($param) {
	return isset($_GET[$param]) ? ($_GET[$param] == "" ? 0 : $_GET[$param]) : 0;
}

function getString($param) {
	return isset($_GET[$param]) ? $_GET[$param] : "";
}


// Riempie la combobox degli utenti
function utenti($current) {
$current=trim($current);
$user="";
print('<option value="' . $user .'"');
if ($user == $current) {
  print(' selected="selected"'); }
print('>' . $user .'</option>');

$user="fabrizio";
print('<option value="' . $user .'"');
if ($user == $current) {
  print(' selected="selected"'); }
print('>' . $user .'</option>');

$user="santarsiere";
print('<option value="' . $user .'"');
if ($user == $current) {
  print(' selected="selected"'); }
print('>' . $user .'</option>');

$user="paolo";
print('<option value="' . $user .'"');
if ($user == $current) {
  print(' selected="selected"'); }
print('>' . $user .'</option>');

$user="arfelli";
print('<option value="' . $user .'"');
if ($user == $current) {
  print(' selected="selected"'); }
print('>' . $user .'</option>');

}

?>

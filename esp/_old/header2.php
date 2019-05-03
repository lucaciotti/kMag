<?php
/************************************************************************/
/*Project ArcaWeb                               		        		*/
/* ===========================                                          */
/*                                                                      */
/* Copyright (c) 2003-2013 by Roberto Ceccarelli                        */
/*                                                                      */
/************************************************************************/
include("odbcsocketserverobj.php");
include("../baseheader.php");

session_start();

$prtlist = array(	
	0 => "Francia-Zebra"
//	1 => "Kanna_2"
//	2 => "5"
//	3 => "4",
//	4 => "5",
//	5 => "6",
//  6 => "IT_0_ZM400_110x73"
);

//Mi permette di costruire quante più connessioni necessito 
function getODBCSocket(){
	$db = new ODBCSocketServer;
	$db->_setHostName("172.16.2.102");
	$db->_setPort(9628);
	$db->_setConnectionString("Provider=vfpoledb.1;Data Source=d:\arca\Arca_Francia\ditte\FRANCIA\Private.dbc;Collating Sequence=Machine");
	return $db;
}
//popUp Errori, Warning o Msg generici
function popupMsg($msg, $type){
	if($type == "E"){

		echo "<script type='text/javascript'>alert('FATAL ERROR: $msg  Contattare Amministratore! $prevPage');  history.go(-1);</script>";
		// TODO log 
		// INTERROMPO L?ESECUZIONE DELLA PAGINA
		//header("location: ".$_SERVER['HTTP_REFERER']); window.location.assign(".$prevPage.")
	} else {
		echo "<script type='text/javascript'>alert('WARNING $msg ');</script>";
	}
}

function logOut(){
	if(isset($_SESSION['UserPL'])){
		print ("<br>\n<a class=\"menu\" href=\"login.php?logOut=yes\"><img noborder src=\"../img/b_drop.png\">LogOut</a>\n");
	}
}

function checkPermission(){
	if(!isset($_SESSION['UserPL'])){
		Header("Location: login.php?error=1");
	}
}
?>
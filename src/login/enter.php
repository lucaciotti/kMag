<?php

include($_SERVER['DOCUMENT_ROOT'] . "/kMag2/src/_layouts/header.php");
// da questo punto gestione a sessioni
session_start();

$user =  $_POST['codice'];
$pwd =  $_POST['password'];

//connect to database
$USERMAP = array(
	"albert" => "albert",
	"ced" => "qazxsw",
	"emanuela" => "manuprio" );

if(array_key_exists($user, $USERMAP)) {
	if ($USERMAP[$user] == $pwd){
		 session_start();
		 $_SESSION["UserPL"] = "$user";
		 Header("Location: index-pl.php");
	} else
	{
		//session_register_shutdown();
		Header("Location: index.php?error=2");
	}
} else
{
	//session_register_shutdown();
	Header("Location: index.php?error=1");
}

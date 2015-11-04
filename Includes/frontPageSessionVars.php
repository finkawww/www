<?php
/*
-----------------------------
Modul ustawia zmienne sesyjne 
na wartosci domyslne
Utworzono: 30.08.2007
Mod: 30.08.2007
Autor: P. Brodziński
-----------------------------
*/
/*
if (!isset($_SESSION))
{
	session_start();
	session_regenerate_id();
}
*/
//---------------------//


/*if (!isset($_SESSION['koszyk']))
{
	{
		$_SESSION['koszyk'] = new Koszyk();		
	}
}*/

if (!isset($_SESSION["mp"]))
{
	$_SESSION["mp"] = -1;
}
if (!isset($_SESSION["ap"]))
{
	$_SESSION["ap"] = -1;
}

if (!isset($_GET["mp"]))
{
	$m = 43;
}
else
{
	$m = $_GET["mp"];
	$_SESSION["mp"] = $m;
	//jezeli wybrano pozycje menu - kasuje zmienna cahce (sesyjna) akcji
	$_SESSION["ap"] = -1;
	
}

if (!isset($_GET['a']))
{
	//$a = $_SESSION["ap"];
	$a = -1;
	$_SESSION["ap"]=-1;
}
else
{
	$a = $_GET['a'];
	$_SESSION["ap"] = $a;
}

if (isset($_POST['a']))
{

	$a = $_POST['a'];
	
	$_SESSION["ap"] = $a;
	
}
if (isset($_POST['mp']))
{
	$m = $_POST['mp'];
	$_SESSION["mp"] = $m;
}

if(!isset($_SESSION['lang']))
{
	$_SESSION['lang'] = 'PL';  
}
if(!isset($_SESSION["userid"]))
{
	$_SESSION["userid"] = -1;
}

function saveActionValue()
{
	$_SESSION['ActionSessionValue'] = $_SESSION['ap'];	
}

function restoreActionValue()
{
	$_SESSION['ap'] = $_SESSION['ActionSessionValue'];
}


?>
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
if (!isset($_SESSION))
	session_start();

//---------------------//
session_regenerate_id();


if (!isset($_SESSION["m"]))
{
	$_SESSION["m"] = -1;
}
if (!isset($_SESSION["a"]))
{
	$_SESSION["a"] = -1;
}

if (!isset($_GET["m"]))
{
	$m = $_SESSION['m'];
}
else
{
	$m = $_GET["m"];
	$_SESSION["m"] = $m;
	//jezeli wybrano pozycje menu - kasuje zmienna cahce (sesyjna) akcji
	$_SESSION["a"] = -1;
	
}

if (!isset($_GET['a']))
{
	$a = $_SESSION["a"];
	//$a = -1;
}
else
{
	$a = $_GET['a'];
	$_SESSION["a"] = $a;
}

if (isset($_POST['a']))
{
	$a = $_POST['a'];
	$_SESSION["a"] = $a;
	
}
if (isset($_POST['m']))
{
	$m = $_POST['m'];
	$_SESSION["m"] = $m;
}

if(!isset($_SESSION['lang']))
{
	$_SESSION['lang'] = 'PL';  
}
if(!isset($_SESSION["adminId"]))
{
	$_SESSION["adminId"] = -1;
}

function saveActionValue()
{
	$_SESSION['ActionSessionValue'] = $_SESSION['a'];	
}

function restoreActionValue()
{
	$_SESSION['a'] = $_SESSION['ActionSessionValue'];
}


?>
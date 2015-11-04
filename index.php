<?php
error_reporting(E_ALL & ~E_DEPRECATED);// & ~E_DEPRECATED & ~E_NOTICE & ~ E_WARNING); 
ini_set('display_errors',1);

//error_reporting(~E_DEPRECATED & ~E_NOTICE & ~E_WARNING & ~E_STRICT & ~E_ALL); 
//ini_set('display_errors',0);


//wlaczabuforowanie - wyniki nie sa wysyane do przegldarki tylko do bufora
ob_start();

//require_once('DB.php');

if (!DEFINED('rootPath'))
   DEFINE('rootPath', '/home4/finka/public_html');

require_once rootPath.'/Modules/Sklep/SklepClass/PrzegladanieKoszyka.class.php';
require_once rootPath.'/Modules/Sklep/SklepClass/PrzegladanieGrupOfert.php';
require_once rootPath.'/Modules/Sklep/SklepClass/KoszykModel/Koszyk.php';
require_once rootPath.'/Modules/Sklep/SklepClass/Global/Global.php';
require_once rootPath.'/Modules/Sklep/SklepClass/KoszykView/KoszykView.php';
require_once rootPath.'/Modules/Sklep/Includes.php';

if (!isset($_SESSION))
{
	session_start();
}
if (!isset($_SESSION['klient']))
	$_SESSION['klient']=0;
	
include './FrontPage/page.php';

//wysyla bufor do przegldarki i wylacza buforowanie
ob_end_flush();

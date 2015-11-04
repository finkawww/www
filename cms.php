<?php
ob_start();

error_reporting(E_ALL ^E_NOTICE ^E_DEPRECATED); 
ini_set('display_errors',1);

//error_reporting(~E_DEPRECATED & ~E_NOTICE & ~E_WARNING & ~E_STRICT & ~E_ALL);
//ini_set('display_errors',0);

require_once('DB.php');

if (!DEFINED('rootPath'))
   DEFINE('rootPath', '/home4/finka/public_html/');

require_once '/home4/finka/public_html/Includes/application.inc.php';


require_once rootPath.'/Modules/Sklep/SklepClass/PrzegladanieKoszyka.class.php';

require_once rootPath.'/Modules/Sklep/SklepClass/AdministracjaTowar.php';

require_once rootPath.'/Modules/Sklep/SklepClass/AdministracjaKraje.php';

require_once rootPath.'/Modules/Sklep/SklepClass/AdministracjaDostawy.php';

require_once rootPath.'/Modules/Sklep/SklepClass/AdministracjaOferta.php';
require_once rootPath.'/Modules/Sklep/SklepClass/AdministracjaPlatnosci.php';
require_once rootPath.'/Modules/Sklep/SklepClass/KoszykModel/Koszyk.php';
require_once rootPath.'/Modules/Sklep/SklepClass/KrajModel/Kraj.php';
require_once rootPath.'/Modules/Sklep/SklepClass/Global/Global.php';
require_once rootPath.'/Modules/Sklep/SklepClass/KoszykView/KoszykView.php';
require_once rootPath.'/Modules/Sklep/Includes.php';

$cmsIndexPage = new cmsIndex();

$cmsIndexPage->showPage($a, $m);
ob_end_flush();

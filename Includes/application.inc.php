<?php
if (!DEFINED('rootPath'))
   DEFINE('rootPath', '/home4/finka/public_html/');

if (!DEFINED('dnsPath'))
   DEFINE('dnsPath', 'http://dev.finka.pl/');

if (!DEFINED('buttonAddIcon'))
	DEFINE('buttonAddIcon', dnsPath.'/Cms/Files/Img/add-16x16.png');
if (!DEFINED('buttonBackIcon'))	
	DEFINE('buttonBackIcon', dnsPath.'/Cms/Files/Img/back-16x16.png');
if (!DEFINED('buttonEditIcon'))
	DEFINE('buttonEditIcon',dnsPath.'/Cms/Files/Img/stock_edit-16.png');
if (!DEFINED('buttonDelIcon'))
	DEFINE('buttonDelIcon', dnsPath.'/Cms/Files/Img/stock_delete-16.png');
if (!DEFINED('buttonChooseIcon'))
	DEFINE('buttonChooseIcon', dnsPath.'/Cms/Files/Img/accept-16x16.png');
if (!DEFINED('cssFile'))
	DEFINE('cssFile', dnsPath.'/FrontPage/Style/style.css');

require_once(rootPath.'/Includes/sessionVars.php');
require_once(rootPath.'/Includes/paths.inc.php');
require_once(rootPath.'/PHPMailer/class.phpmailer.php');

include rootPath.'/Includes/db.conf.php';
//include './Includes/smarty.conf.php';
require_once(logClassPath);
require_once(sectionsClassPath);
require_once(exceptionClassPath);
require_once(formsClassPath);
require_once(dbClassPath);
require_once(contentRendererClassPath);
require_once(menuRendererClassPath);
require_once(menuClassPath);
require_once(mySmartyClassPath);
require_once(modulesMgrPath);
require_once(pagesMgrPath);
require_once(installerClassPath);
require_once(moduleClassPath);
require_once(gridClass);
require_once(translatorClassPath);
require_once(dialogClass);
require_once(buttonClass);
require_once(cmsIndexClass);
?>
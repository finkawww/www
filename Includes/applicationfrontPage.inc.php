<?php
include rootPath.'/Includes/frontPageSessionVars.php';
if (!DEFINED('dnsPath'))
   DEFINE('dnsPath', 'http://dev.finka.pl/');

require_once(rootPath.'/Includes/frontPagePaths.inc.php');
require_once(rootPath.'/Includes/db.conf.php');
require_once(rootPath.'/PHPMailer/class.phpmailer.php');
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
//require_once(cmsIndexClass);
?>
<?php
/*
--------------------------
Modul definiuje sciezki  
Created: 20.08.2007			 
Author: P.Brodzi�ski		
Last mod: 20.08.2007
--------------------------
*/

//consts
if (!defined('logClassPath'))
{
	DEFINE('logClassPath', './Class/adminLog.class.php');
}
if (!defined('dbClassPath'))
{
	DEFINE('dbClassPath', './Class/db.class.php');
}
if (!defined('exceptionClassPath'))
{
	DEFINE('exceptionClassPath', './Class/exception.class.php');
}
if (!defined('menuClassPath'))
{	
	DEFINE('menuClassPath', './Class/menu.class.php');
}
if (!defined('menuRendererClassPath'))
{
	DEFINE('menuRendererClassPath', './Class/menuRenderer.class.php');	
}
if (!defined('moduleClassPath'))
{
	DEFINE('moduleClassPath', './Class/module.class.php');
}
if (!defined('contentRendererClassPath'))
{
	DEFINE('contentRendererClassPath', './Class/contentRenderer.class.php');
}
if (!defined('sectionsClassPath'))
{
	DEFINE('sectionsClassPath', './Class/sectionsMgr.class.php');
}
if (!defined('translatorClassPath'))
{
	DEFINE('translatorClassPath', './Class/translator.class.php');
}
if (!defined('pagesMgrPath'))
{
	DEFINE('pagesMgrPath', './Class/pagesMgr.class.php');
}
if (!defined('modulesMgrPath'))
{
	DEFINE('modulesMgrPath', './Class/modulesMgr.class.php');
}
if (!defined('formsClassPath'))
{
	DEFINE('formsClassPath','./Class/forms.class.php');
}
if (!defined('mySmartyClassPath'))
{
	DEFINE('mySmartyClassPath','./Class/mySmarty.class.php');
}
if (!defined('installerClassPath'))
{
	DEFINE('installerClassPath','./Class/installer.class.php');
}
if (!defined('fckEditorPath'))
{
	DEFINE('fckEditorPath','./fckeditor/fckeditor_php5.php');
}
if (!defined('gridClass'))
{
	DEFINE('gridClass', './Class/grid.class.php');
}
if (!defined('dialogClass'))
{
	DEFINE('dialogClass', './Class/dialog.class.php');
}
if (!defined('buttonClass'))
{
	DEFINE('buttonClass', './Class/button.class.php');
}
if (!defined('cmsIndexClass'))
{
	DEFINE('cmsIndexClass', './Cms/mainClass/cmsIndex.php');
}

if (!DEFINED('imgPath'))
   DEFINE('imgPath', '/FrontPage/Files/ImgShop/');
//ikonki na przyciski


?>
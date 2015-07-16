<?php
//Pobieram menuId
if (!isset($_GET["m"]))
{
	$m = -1;
}
else
{
	$m = $_GET["m"];
}

if (!isset($_GET["a"]))
{
	$a = -1;
}
else
{
	$a = $_GET["a"];
}
include '../Includes/application.inc.php';
//generacja menu
$menuRnd = new menuRenderer('admin');
//generacja content
$contentRnd = new contentRenderer();

$smarty = new mySmarty();
$smarty->assign('title', 'CMS - zarządzanie treścią');
//$smarty->assign('menu_top', $menuRnd->render($m, 't'));
$smarty->assign('menu_left', $menuRnd->render($m, 'l'));
//$smarty->assign('menu_right', $menuRnd->render($m, 'r'));
$smarty->assign('content', $contentRnd->renderContent($m, $a));
$smarty->display('cmsIndex.tpl');
?>

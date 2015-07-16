<?php
include_once './Includes/applicationfrontPage.inc.php';
include_once './FrontPage/FrontPageClass.php';
$frontPage = new FrontPage();

//sklep internestowy
$module = new ModulesMgr();
$module->loadModule('Sklep');



if (isset($_GET['action']))
{

	

	if ($_GET['action']=='platnosci_err')
	{
		$a = $module->getModuleActionIdByName('URLNegatywnyCallback');
	}
	else if ($_GET['action']=='platnosci_ok')
	{
		$a = $module->getModuleActionIdByName('URLPozytywnyCallback');
	}
	else if ($_GET['action']=='platnosci_online')
	{
		$a = $module->getModuleActionIdByName('URLOnlineCallback');
	}
	else if ($_GET['action']=='BasketAdd')
	{
		if (isset($_GET['item']))
		{
			
			$uid = $_GET['item'];
			$towTmp = new Towar();
			$idTow = $towTmp->GetTowarIdByUID($uid);
			if ($idTow != 0)
			{
						
				$koszykTmp = GlobalObj()->Koszyk();
				$koszykTmp->AddTowar($idTow, 1);
				GlobalObj()->RefreshCookieKoszyk();			
			}
		}
		$a = $module->getModuleActionIdByName('PokazKoszykFull');
	}
	unset($module);
}

$frontPage->showPage($a, $m);

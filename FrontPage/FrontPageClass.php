<?php

class SSLRedirector
{
	public function RedirectIfNeeded($a, $m)
	{
		//if ()

		//if ($m == '')
		//{
		//	$m = $_SESSION['mp'];
		//}

		$queryString = '';
		if ($a != '')
		{
			$queryString .= "ap=$a";
		}
		if ($m != '')
		{
			if ($queryString != '')
			{
				$queryString .= '&';
			}
			$queryString .= "mp=$m";
		}

		$module = new ModulesMgr();

		if ($module->IsActionSecured($a) || ($module->IsAdmin($a)))
		{
			if (!isset($_SERVER['HTTPS']))
			{
				header('Status-Code: 301');
				header('Location: https://'.$_SERVER["HTTP_HOST"].$_SERVER['REQUEST_URI']);
			}
		}
		else
		{
			if (isset($_SERVER['HTTPS']))
			{
				header('Status-Code: 301');
				header('Location: http://'.$_SERVER["HTTP_HOST"].$_SERVER['REQUEST_URI']);
			}
		}

	}
}

class FrontPage
{

	//tech

	private $a = -1;
	private $m = -1;
	private $module = null;
	private $action = -1;
	private $logoutAct;
	private $menu_left;
	private $contentHeader;

	private $contentRnd = null;
	private $dbInt;
	private $menuMgr = null;
	private $menuRnd = null;

	//page
	private $pageId = 0;
	private $pageName = '';
	private $shortName = '';
	private $active = 'N';
	private $admin = 'N';
	private $authorizedOnly = 'T';
	private $printMenuTop = 'T';
	private $printMenuLeft = 'T';
	private $printMenuRight = 'N';
	private $printMenuBottom = 'N';
	private $templateId = 0;

	//config
	private $defLang = 'PL';
	private $title = '';
	private $keyWords = '';
	private $description = '';
	private $author = '';
	private $cpoyright = '';
	private $cache = '';
	private $robots = '';

	public function __construct()
	{


		$this->menuMgr = MenuMGr::getInstance();
		$this->dbInt = DBSingleton::getInstance();
		$this->contentRnd = new ContentRenderer();
		$this->menuRnd = new MenuRenderer('public');
	}

	public function showPage($a = -1, $m = -1)
	{
		$sslRedirector = new SSLRedirector();
		$sslRedirector->RedirectIfNeeded($a, $m);

		$module = new ModulesMgr();
		$module->loadModule('Sklep');
		if ($a == $module->getModuleActionIdByName('URLOnlineCallback'))
		{
			$module->moduleExecuteAction('URLOnlineCallback', null);
		}
		else
		{

			$this->a = $a;

			$sqlChk = "SELECT count(*) as ile from `cmsMenu` WHERE `id`=$m and `AdminMenu`='N'";
			$ile = 0;
			$dbResult = $this->dbInt->ExecQuery($sqlChk);


			$recData = $dbResult->fetchRow(DB_FETCHMODE_ASSOC);
			$ile = $recData['ile'];

			if ($ile > 0)
			{
				$this->m = $m;
			}
			else
			{
				$sql = 'SELECT id from cmsMenu Where Fk_PageId = (SELECT DefaultPageFk FROM cmsConfig)';
				$dbResult1 = $this->dbInt->ExecQuery($sql);
				$recData1 = $dbResult1->fetchRow(DB_FETCHMODE_ASSOC);
				$this->m = $recData1['id'];
				$_SESSION['mp']=$this->m;
			}

			$this->showFrontPage();
		}
		unset($module);

	}

	private function renderTopMenu()
	{
		return '';
	}

	private function renderLeftMenu()
	{
		return '';
	}

	private function renderRightMenu()
	{
		return '';
	}

	private function renderBottomMenu()
	{
		return '';
	}


	private function setConfigData()
	{
		$configSql = '
					SELECT
						c.Title, COALESCE(l.ShortName, "PL") AS Lang, 
						c.Keywords, c.PageDescription, c.PageAuthor, c.Copyrights, 
						CASE 
							WHEN c.Cache = "nocache" THEN "NO-CACHE" 
							WHEN c.Cache = "cache" THEN "CACHE"
							ELSE "NO-CACHE"
						END AS CacheMeta,							
						CASE
							WHEN c.Robots = "indexfollow" THEN "Index, Follow"
							WHEN c.Robots = "indexnofollow" THEN "Index, NoFollow"
							WHEN c.Robots = "noindexnofollow" THEN "NoIndex, NoFollow"
							WHEN c.Robots = "All" THEN "All"							
							ELSE "NoIndex, NoFollow"
						END AS RobotsMeta
					FROM 
						cmsConfig c LEFT JOIN cmsLang l
							ON (c.DefaultLanguageFk = l .id)
				';
		$dbResult = $this->dbInt->ExecQuery($configSql);
		$recData = $dbResult->fetchRow(DB_FETCHMODE_ASSOC);

		$this->defLang = $recData['Lang'];
		$this->title = $recData['Title'];
		$this->keyWords = $recData['Keywords'];
		$this->description = $recData['PageDescription'];
		$this->author = $recData['PageAuthor'];
		$this->cpoyright = $recData['Copyrights'];
		$this->cache = $recData['CacheMeta'];
		$this->robots = $recData['RobotsMeta'];
	}

	private function setPageData()
	{

		$this->pageId = $this->menuMgr->getMenuPage($this->m);
		$pageSql = "SELECT
						id, PageName, ShortName, Active, Admin, AuthorizedOnly, MenuTop,
						MenuRight, MenuLeft, MenuBottom, TemplateId, PageTitle, PageDescription, PageKeywords
					FROM 
						cmsPages
					Where
						id = $this->pageId
					";
			

		$dbResult = $this->dbInt->ExecQuery($pageSql);
		if ($dbResult != null)
		{
			$recData = $dbResult->fetchRow(DB_FETCHMODE_ASSOC);
			$this->pageName = $recData['PageName'];
			$this->shortName = $recData['ShortName'];
			$this->active = $recData['Active'];
			$this->admin = $recData['Admin'];
			$this->PageTitle = $recData['PageTitle'];
			$this->PageDescription = $recData['PageDescription'];
			$this->PageKeywords = $recData['PageKeywords'];
			$this->authorizedOnly = $recData['AuthorizedOnly'];
			$this->printMenuTop = $recData['MenuTop'];
			$this->printMenuLeft = $recData['MenuLeft'];
			$this->printMenuRight = $recData['MenuRight'];
			$this->printMenuBottom = $recData['MenuBottom'];
			$this->templateId = $recData['TemplateId'];
			return true;
		}
		else
		{
			return false;
		}
	}
	private function getTemplateById($id)
	{
		$pageSql = "SELECT
						FileName
					FROM 
						cmsTemplates
					Where
						id = $id
					";

		$dbResult = $this->dbInt->ExecQuery($pageSql);
		$recData = $dbResult->fetchRow(DB_FETCHMODE_ASSOC);
		return $recData['FileName'];
	}
	private function showFrontPage()
	{

		$pageMgr = new PagesMgr();

		//$this->renderPage();
		if ($this->m == -1)
		{
			//pobieram wartosci strony domyslnej
			//TODO Dodać sprawdzenie czy jest strona domyślna (startowa)
			$sql = 'SELECT id from cmsMenu Where Fk_PageId = (SELECT DefaultPageFk FROM cmsConfig)';
			$dbResult = $this->dbInt->ExecQuery($sql);
			$recData = $dbResult->fetchRow(DB_FETCHMODE_ASSOC);
			$this->m = $recData['id'];
				
		}
			
		//Renderuje strone
		//1. Pobieram parametry strony z bazy danych
		$smarty = new mySmarty();
		if ($this->setPageData())
		{

			$this->setConfigData();

			if (!isset($_SESSION['lang']))
			$_SESSION['lang']= $this->defLang;

				
			$params = array();
				
			if($this->PageTitle != null) {
				$smarty->assign('title', $this->PageTitle);
			}
			else {
				$smarty->assign('title', $this->title);
			}
			if($this->PageDescription != null) {
				$smarty->assign('desc', $this->PageDescription);
			}
			else {
				$smarty->assign('desc', $this->description);
			}
			if($this->PageKeywords != null) {
				$smarty->assign('keywords', $this->PageKeywords);
			}
			else {
				$smarty->assign('keywords', $this->keyWords);
			}
			
			$smarty->assign('author', $this->author);
			$smarty->assign('robots', $this->robots);
			$smarty->assign('cache', $this->cache);
			
			//	TODO Dodać css oraz ikone

			if ($this->printMenuTop == 'T')
			{
				$topMenu = $this->menuRnd->render($this->m, 't');
				$smarty->assign('topMenu', $topMenu);
			}
			if ($this->printMenuLeft == 'T')
			{
				$leftMenu = $this->menuRnd->render($this->m, 'l');
				$smarty->assign('leftMenu', $leftMenu);
			}
			if ($this->printMenuRight == 'T')
			{
				$rightMenu = $this->menuRnd->render($this->m, 'r');
				$smarty->assign('menuRight', $rightMenu);
			}
			if ($this->printMenuBottom == 'T')
			{
				$bottomMenu = $this->menuRnd->render($this->m, 'b');
				$smarty->assign('menuBottom', $bottomMenu);
			}
			
                        //newsletter status                        
                        $moduleTmp = new ModulesMgr();
			$moduleTmp->loadModule('Newsletter');
			$res = $moduleTmp->moduleExecuteAction('ShowNewsletterFrontRegist', null);
			$smarty->assign('Newsletter', $res);
			unset($moduleTmp);
                        
                        $moduleTmp = new ModulesMgr();
			$moduleTmp->loadModule('KontaktHeader');
			$res = $moduleTmp->moduleExecuteAction('Display', null);
			$smarty->assign('KontaktHeader', $res);
			unset($moduleTmp);
                        
                        //koszyk status
				
			$moduleTmp = new ModulesMgr();
			$moduleTmp->loadModule('Lang');
			$res = $moduleTmp->moduleExecuteAction('ShowStatusLangs', null);
			$smarty->assign('PokazLangStatus', $res);
			unset($moduleTmp);
				
			$moduleTmp = new ModulesMgr();
			$moduleTmp->loadModule('Sklep');
			$res = $moduleTmp->moduleExecuteAction('PokazKlientStatus', null);
			$smarty->assign('PokazKlientStatus', $res);
			$res = $moduleTmp->moduleExecuteAction('PokazKoszykStatus', null);
			$smarty->assign('PokazKoszykStatus', $res);
			unset($moduleTmp);
			$moduleTmp = new ModulesMgr();
			$moduleTmp->loadModule('Szukanie');
			$res = $moduleTmp->moduleExecuteAction('SzukajStatus', null);
			$smarty->assign('SzukajStatus', $res);
			unset($moduleTmp);
				
			$content = $this->contentRnd->renderContent($this->m, $this->a, $params);
			
			$smarty->assign('content', $content);
			$templateName = $this->getTemplateById($this->templateId);
			$smarty->display($templateName);
		}
		else
		{
			$content = "Brak przypisanej strony";
			echo $content;
		}
			

			
	}


	private function renderPage()
	{

	}
}

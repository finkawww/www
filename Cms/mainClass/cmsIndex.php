<?php

class cmsIndex
{
	private $a = -1;
	private $m = -1;
	private $module = null;
	private $action = -1;
	private $logoutAct;
	private $menu_left;
	private $contentHeader;
	private $contentRnd = null;
		
	public function __construct()
	{
	    //error_reporting(E_ALL); 
		//ini_set('display_errors',1); 
	}
	
	public function showPage($a = -1, $m = -1)
	{
		$this->a = $a;
		$this->m = $m;
		$loginForm = false;
		if (!isset($_SESSION["adminId"]) || ($_SESSION["adminId"] == -1))
		{
			$this->showLoginForm();	
		}
		else
		{
			$this->showCmsPage();
		}
	}
	
	private function showCmsPage()
	{
		$this->renderPage();
		if ($this->m == -1)
		{
			$moduleTmp = new ModulesMgr();
			$moduleTmp->loadModule('CmsInfo');
			$menuTmp= MenuMgr::getInstance();
			$this->m = $menuTmp->getMenuIdByName('CmsInfo');
			$this->a = $moduleTmp->getModuleActionIdByName('ShowCmsInfo');
		}
			 
		if (!isset($_GET['onlycontent']))
		{
			$params = array();
			$moduleAdmin = new ModulesMgr();
			$moduleAdmin->loadModule('AdminUsr');
			$adminLogin = $moduleAdmin->moduleExecuteAction('getLogin', $params);
			$adminName = $moduleAdmin->moduleExecuteAction('getName', $params);
			$adminLastName = $moduleAdmin->moduleExecuteAction('getLastName', $params);
			$adminSessionBegin = $moduleAdmin->moduleExecuteAction('getSessionBeginTime', $params);
			$logoutAct = $moduleAdmin->getModuleActionIdByName('adminLogout');
			unset($moduleAdmin);
			
			$content = $this->contentRnd->renderContent($this->m, $this->a, $params);
			
			$smarty = new mySmarty();
			$smarty->assign('adminLogin', $adminLogin);
			$smarty->assign('adminName', $adminName);
			$smarty->assign('adminLastName', $adminLastName);
			$smarty->assign('adminSessionBegin', $adminSessionBegin);
			$smarty->assign('logoutAct', $logoutAct);
			
			$smarty->assign('menu_left', $this->menu_left);
			$smarty->assign('contentHeader', $this->contentHeader);
			$smarty->assign('content', $content);			
			
			$smarty->display('./cms/cmsIndex.tpl');
					
		}
		else
		{
			// popup
			$params = array();
			$content = $this->contentRnd->renderContent($this->m, $this->a, $params);
			$smarty = new mySmarty();
			$smarty->assign('content', $content);
			$smarty->display('./cms/popupWindow.tpl');
					
		}
	}
	
	private function showPopupPage($id, $a)
	{
		$this->id = $id;
		$this->a = $a;
	}
	
	private function showLoginForm()
	{
		$this->module = new modulesMgr();
	 	$this->module->loadModule('AdminUsr');
	 	$this->action = $this->module->getModuleActionIdByName('adminLogin');
	 	$_SESSION["a"] = $this->action;
 		$this->a = $this->action;
 		$_SESSION["m"] = -1;
 		$this->m = -1;
 		$loginForm = true;
		$content = '';
	 	$params = array();
	 	$this->contentRnd = new contentRenderer();
		$content = $this->contentRnd->renderContent($this->m, $this->a, $params);
		$smarty = new mySmarty();
		$smarty->assign('content', $content);
		$smarty->display('cms/loginWindow.tpl');
		
							
	}

	private function renderPage()
	{
		$menuRnd = new menuRenderer('admin');
	
		//generacja zawartosci strony
		$this->contentRnd = new contentRenderer();
		$this->contentHeader = $this->contentRnd->getContentPath($this->m);
		$this->menu_left = $menuRnd->render($this->m, 'L');
	
		$module = new modulesMgr();
		$module->loadModule('AdminUsr');
		$this->logoutAct = $module->getModuleActionIdByName('adminLogOut');
	}
}
?>
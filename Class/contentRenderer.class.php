<?php
/*..ta klasa bedzie sluzyla do wypelniania stron trescia
Raczej oprze� na wzorcu State, by mozna bylo za pomoca klasy wysylac wynik zarowno na erkan przegladarki jak i drukarki a w przyszlosci moze jeszcze na cos - nie bedzie potrzebna zmiana
*/

/*
----------------------
Page content rederer
Author: P. Brodzinski
Created: 20.08.2007
Mod: 20.08.2007
----------------------
*/

class contentRenderer
{
	private static $instance = null;
	
	private $pagesMgr = null;
	private $modulesMgr = null;  
	
	
	public function getContentPath($menuId)
	{
		$menuMgr = menuMgr::getInstance();
		if ($menuId > -1)
		{
			$result = $menuMgr->getMenuPageTitle($menuId);
		}
		else
		{
			$result = '';
		}
		return $result;
	}
	public function renderContent($menuId, $actionId, $params)
	{
		//tu create na pagesMgr
		//i metody getContent
		try
		{		
		if ($actionId == '-1')
		{
			//echo 'ActionId=-1;MenuId='.$menuId;
			$menuMgr = menuMgr::getInstance();
			$pageName = $menuMgr->getMenuPageName($menuId);
			$pageMgr = new pagesMgr();
			$content = $pageMgr->getContent($pageName);
			unset($pageMgr);
		}
		else //gdy jest actionId
		{
			//echo 'ActionId<>-1;MenuId='.$menuId;
			
			$DBInt = DBSingleton::getInstance();
			$result = $DBInt->ExecQuery('Select ActionShortName  from cmsModulesActions where id='.$actionId);
			$data = $result->fetchRow(DB_FETCHMODE_ASSOC);
			$action = $data['ActionShortName'];
			$module = new modulesMgr();
			$moduleName = $module->getModuleNameByActionId($actionId);
			$module->loadModule($moduleName);
			$acnName = $module->getModuleActionNameById($actionId);
			$content = $module->moduleExecuteAction($acnName, $params);
			
		}
		
		}
		Catch (Exception $e)
		{
			$exc = new ExceptionClass($e, 'contentRenderer.php');
   			$content = $exc->writeException();
		}
		
		//jezeli actionId=-1
		//odczytuje strone o id pobranej z menuMgr=x
		//wczytuje sekcje wg kolejnosci
		/*
		dla kazdej sekcji:
		- sprawedzam zawartosc
			-jezeli modul sprawdzam action i wykonuje
			-jezeli strona - zwracam zawartosc z bd
	Jezeli actionId>-1 to
		Pobieram actionName z tabeli Actions
		Wykonuje modulesMgr.ExecutAction(actionName) 
		*/
		
		
		if ($content == '')
		{
			$content = 'Przepraszamy. Strona jest w tym momencie niedostępna. Proszę spróbować później.';	
		}
		return $content;
	}
	
}

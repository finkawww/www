<?php
// ta klasa bedzie sluzyla do generowania menu (wizualnego) na podstawie tabeli menu

//klasa przechowujaca elementy menu - wspolna dla wszystkich menu
final class MenuItem
{
	public $id = 0;
	public $parentMenu = 0;
	public $shortName = '';
	public $pageId = '';
	public $level = 0;
	public $index = 0;
	public $caption = '';
	public $sel = 0;
	public $active = true;
	public $grupa;
	public $menuLinkText;
	public $menuRenderText;
}


class menuRenderer
{
	private $mode = '';
	private $menuActive = 0;
	private $menuPosition;//t - top; l - left; r - right; b- bottom
	private $spaceText = '';
	private $activeMenuPath = array();
	private $arrayIndex = 0;
	
	private $dbInt = null;
	private $menuMgr = null;
	private $lastMenuId;
	
	private $selectedTop=0;
	private $selectedLeft=0;
	private $selectedRight=0;
	private $menuLeftAncestorArr = array();
	private $menuLeft = array();
	
	//private function isLeftMenu($menuId)
	
	private function getMenuLeftAncestor($menuId)
	{
		//pobieram bezposredni wezel nadrzedny danego menuItem
		$sqlLev = "
			SELECT 
				id
			FROM
				cmsMenu
			WHERE
				Position  = 'L' AND id = (SELECT FK_ParentMenuItem from cmsMenu WHERE id = $menuId)
				";
		 
		 
		 $resultDb = $this->dbInt->ExecQuery($sqlLev);
		 $menuData = $resultDb->fetchRow(DB_FETCHMODE_ASSOC);
		 //echo count($resultDb);
		 
		 if ($menuData != null)
		 {
		 	$this->menuLeftAncestorArr[] = $menuData['id'];
		 	$this->getMenuLeftAncestor($menuData['id']);
		 	$this->lastMenuId = $menuId;
		 }
		 else
		 {
		 	$this->menuLeftAncestorArr[] = $_SESSION['mp'];
		 }
		  			
	}
	
	private function recurseRenderLeft($menuRoot, $lev)
	{
		//$lev = 0;
		if(!isset($lev))
			$lev = 1;
			
		$selMenu = $_SESSION['mp'];
		
		
		$sqlLev = "
			SELECT 
				id, ShortName, Fk_PageId, Fk_ParentMenuItem, `Index`, Active, grupa, MenuLinkText
			FROM
				cmsMenu
			WHERE
				Position  = 'L' AND FK_ParentMenuItem = $menuRoot
			ORDER BY 
				`Index`
				"; 
		
		$resultDb = $this->dbInt->ExecQuery($sqlLev);
		
		while ($menuData = $resultDb->fetchRow(DB_FETCHMODE_ASSOC))
		{
			
			$menuItem = new MenuItem();
 			$menuItem->id = $menuData['id'];
 			$menuItem->index = $menuData['Index'];
 			$menuItem->pageId = $menuData['Fk_PageId'];
 			$menuItem->parentMenu = $menuData['Fk_ParentMenuItem'];
 			$menuItem->caption = $this->menuMgr->getMenuCaption($menuItem->id, $_SESSION['lang']);
 			$menuItem->level = $lev;
 			$menuItem->active = ($menuData['Active'] == 'T');
 			$menuItem->grupa = ($menuData['grupa']); 			
			$menuItem->menuLinkText = ($menuData['MenuLinkText']);
			//<a class="inactiveMenuLeft" href="?mp={$menuItem->id}">{$menuItem->caption}</a>
			if ($menuItem->menuLinkText!='')
			{
				$menuItem->menuRenderText = dnsPath.$menuItem->menuLinkText;
			}
			else
			{
				$menuItem->menuRenderText = dnsPath.'?mp='.$menuItem->id;
			}
			
			
			
 			if ($menuItem->id == $this->selectedLeft)
 				$menuItem->sel = 1;
 			else
 				$menuItem->sel = 0;
 				 
			//echo $this->menuMgr->getMenuCaption($menuItem->id, $_SESSION['langp']);			
 			$this->menuLeft[] = $menuItem;
 			
 			
 			//tu dodaje podrzedne
			$mid = $menuItem->id;
 			$sqlCount = "SELECT count(1) AS ile FROM cmsMenu WHERE Position='L' AND FK_ParentMenuItem = $mid";	
			$resDb = $this->dbInt->ExecQuery($sqlCount);
			$countData = $resDb->fetchRow(DB_FETCHMODE_ASSOC);


			//if ($countData['ile'] > 0) 
 			//{
 				$lev++;
 				$this->recurseRenderLeft($menuData['id'], $lev);
 				$lev --;
 		//	}
 			
		}
	
	}
	
	private function renderLeftMenu()
	{
		//$selMenu = $_SESSION['mp'];
		//FIXME Tu zmienilem - zeby zawsze bylo rozwiniete lewe menu
		$selMenu = $this->selectedLeft;
		$result = '';
		
		
		//tablica przodkow aktywnego menuLeft
		$this->menuLeftAncestorArr = array();
		
		//menu top
		$rootMenu = $this->getBaseActiveItem($selMenu);
		
		$this->selectedTop = $rootMenu;
		
		if 	($this->menuMgr->getMenuLocation($selMenu) == 'L')
		{
			$this->getMenuLeftAncestor($selMenu);
		}
		
		$this->recurseRenderLeft($rootMenu, 1);
		
		$smarty = new mySmarty();
		$smarty->assign('menuLeft', $this->menuLeft);
		$result = $smarty->fetch('menuLeft.tpl');	
				
		return $result;
	}
	
	private function getMenuParent($menuId)
	{
		$sqlParent = "
			SELECT 
				id
			FROM
				cmsMenu
			WHERE
				id = (SELECT FK_ParentMenuItem from cmsMenu WHERE id = $menuId)
				";
		 
		 $resultDb = $this->dbInt->ExecQuery($sqlParent);
		 $menuData = $resultDb->fetchRow(DB_FETCHMODE_ASSOC);
		 
		 if ($menuData != null)
		 {
		 	return $menuData['id'];		 	 		 	
		 }
		 else
		 	return 0;
		 
	}
	
	private function renderRightMenu()
	{
		
		$selMenu = $_SESSION['mp'];
		
		$menuLocation = $this->menuMgr->getMenuLocation($selMenu);
		
		$menuLeftId = 0;

		if ($menuLocation == 'L')
		{
			$menuLeftId = $selMenu;
		}
		else if ($menuLocation == 'R')
		{
			$menuLeftId = $this->getMenuParent($selMenu);
		}
		$this->selectedLeft = $menuLeftId;
		
		
		$sql = "
			SELECT 
				id, ShortName, Fk_PageId, Fk_ParentMenuItem, `Index`, grupa,MenuLinkText
			FROM 
				cmsMenu
			WHERE
				Position  = 'R' AND FK_ParentMenuItem = $menuLeftId
			ORDER BY
				`Index`			 
				";
		
		$menuRight = array();
		$res = '';
		//wczytuje wszystkie rekordy TopMenu (wszelkie parametry) do tablicy
		
				
		//ide po rekordach i zwracam niezbedne wartosaci do szablonu
		$result = $this->dbInt->ExecQuery($sql);
 		 		
 		//$tmpMenuMgr = MenuMGR::getInstance();
 		
 		while ($menuData = $result->fetchRow(DB_FETCHMODE_ASSOC))
 		{
 			$menuItem = new MenuItem();
 			$menuItem->id = $menuData['id'];
 			$menuItem->index = $menuData['Index'];
 			$menuItem->level = 0;
 			$menuItem->pageId = $menuData['Fk_PageId'];
 			$menuItem->parentMenu = $menuData['Fk_ParentMenuItem'];
 			$menuItem->caption = $this->menuMgr->getMenuCaption($menuItem->id, $_SESSION['lang']);
 			$menuItem->grupa = ($menuData['grupa']); 			
 			if ($menuItem->id == $this->selectedRight)
 				$menuItem->sel = 1;
 			else
 				$menuItem->sel = 0;
			$menuItem->menuLinkText = ($menuData['MenuLinkText']);
			//<a class="inactiveMenuLeft" href="?mp={$menuItem->id}">{$menuItem->caption}</a>
			if ($menuItem->menuLinkText!='')
			{
				$menuItem->menuRenderText = dnsPath.$menuItem->menuLinkText;
			}
			else
			{
				$menuItem->menuRenderText = dnsPath.'?mp='.$menuItem->id;
			} 				 
			//echo $this->menuMgr->getMenuCaption($menuItem->id, $_SESSION['langp']);			
 			$menuRight[] = $menuItem;
 			 			 			
 		}
 		
 		$smarty = new mySmarty();
		$smarty->assign('menuRight', $menuRight);
		$res = $smarty->fetch('menuRight.tpl');
		
		return $res;
		
	}
	private function renderTopMenu()
	{
		$menuTop = array();
		$res = '';
		//wczytuje wszystkie rekordy TopMenu (wszelkie parametry) do tablicy
                
		$sql = "
			SELECT 
				id, ShortName, Fk_PageId, Fk_ParentMenuItem, `Index`, grupa,MenuLinkText 
			FROM 
				cmsMenu
			WHERE
				Position  = 'T' and Active = 'T'
			ORDER BY
				`Index`			 
				";
				
		//ide po rekordach i zwracam niezbedne wartosaci do szablonu
		$result = $this->dbInt->ExecQuery($sql);
 		 		
 		//$tmpMenuMgr = MenuMGR::getInstance();
 		
 		while ($menuData = $result->fetchRow(DB_FETCHMODE_ASSOC))
 		{
 			$menuItem = new MenuItem();
 			$menuItem->id = $menuData['id'];
 			$menuItem->index = $menuData['Index'];
 			$menuItem->level = 0;
 			$menuItem->pageId = $menuData['Fk_PageId'];
 			$menuItem->parentMenu = $menuData['Fk_ParentMenuItem'];
 			$menuItem->caption = $this->menuMgr->getMenuCaption($menuItem->id, $_SESSION['lang']);
 			$menuItem->grupa = ($menuData['grupa']); 			
 			if ($menuItem->id == $this->selectedTop)
 				$menuItem->sel = 1;
 			else
 				$menuItem->sel = 0;
			$menuItem->menuLinkText = ($menuData['MenuLinkText']);
			//<a class="inactiveMenuLeft" href="?mp={$menuItem->id}">{$menuItem->caption}</a>
			if ($menuItem->menuLinkText!='')
			{
				$menuItem->menuRenderText = dnsPath.$menuItem->menuLinkText;
			}
			else
			{
				$menuItem->menuRenderText = dnsPath.'?mp='.$menuItem->id;
			} 		
			
			$sql_child = "SELECT id, Name, ShortName, Fk_PageId, Fk_ParentMenuItem, `Index`, grupa,MenuLinkText  FROM `cmsMenu` WHERE FK_ParentMenuItem = $menuItem->id 	AND Active = 'T' AND Submenu = 'T' ORDER BY `Index`";
			$query_child = $this->dbInt->ExecQuery($sql_child);

			$menuItem->child = array();
			while ($childItem = $query_child->fetchRow(DB_FETCHMODE_ASSOC)){
				$childId = $childItem['id'];

				
				$second_parent_id = $childId;
				$sql_second_child = "SELECT id, Name, ShortName, Fk_PageId, Fk_ParentMenuItem, `Index`, grupa,MenuLinkText  FROM `cmsMenu` WHERE FK_ParentMenuItem = $second_parent_id 	AND Active = 'T' ORDER BY `Index`";
				$query_second_child = $this->dbInt->ExecQuery($sql_second_child);
				
				
					$childItem['child'] = array();
					while ($secondChildItem = $query_second_child->fetchRow(DB_FETCHMODE_ASSOC)){
						array_push($childItem['child'], $secondChildItem);
					}
				array_push($menuItem->child, $childItem);				
			}
			
			//echo $this->menuMgr->getMenuCaption($menuItem->id, $_SESSION['langp']);			
 			$menuTop[] = @$menuItem; 			
 		}

 		$smarty = new mySmarty();
		$smarty->assign('menuTop', $menuTop);
		$res = $smarty->fetch('menuTop.tpl');
 				
		return $res;
	}
	private function renderBottomMenu()
	{
		$menuBottom = array();
		$res = '';
		//wczytuje wszystkie rekordy TopMenu (wszelkie parametry) do tablicy
		$sql = "
			SELECT 
				id, ShortName, Fk_PageId, Fk_ParentMenuItem, `Index`, grupa,MenuLinkText
			FROM 
				cmsMenu
			WHERE
				Position  = 'B'
			ORDER BY
				`Index`			 
				";
				
		//ide po rekordach i zwracam niezbedne wartosaci do szablonu
		$result = $this->dbInt->ExecQuery($sql);
 		 		
 		//$tmpMenuMgr = MenuMGR::getInstance();
 		
 		while ($menuData = $result->fetchRow(DB_FETCHMODE_ASSOC))
 		{
 			$menuItem = new MenuItem();
 			$menuItem->id = $menuData['id'];
 			$menuItem->index = $menuData['Index'];
 			$menuItem->level = 0;
 			$menuItem->pageId = $menuData['Fk_PageId'];
 			$menuItem->parentMenu = $menuData['Fk_ParentMenuItem'];
 			$menuItem->caption = $this->menuMgr->getMenuCaption($menuItem->id, $_SESSION['lang']);
			//echo $this->menuMgr->getMenuCaption($menuItem->id, $_SESSION['lang']);
 			$menuItem->grupa = ($menuData['grupa']);
			if ($menuItem->id == $_SESSION['mp'])
 				$menuItem->sel = 1;
 			else
 				$menuItem->sel = 0;
 			$menuItem->menuLinkText = ($menuData['MenuLinkText']);
			//<a class="inactiveMenuLeft" href="?mp={$menuItem->id}">{$menuItem->caption}</a>
			if ($menuItem->menuLinkText!='')
			{
				$menuItem->menuRenderText = dnsPath.$menuItem->menuLinkText;
			}
			else
			{
				$menuItem->menuRenderText = dnsPath.'?mp='.$menuItem->id;
			}	
 			$menuBottom[] = @$menuItem;
 			 			 			
 		}
 		
 		$smarty = new mySmarty();
		$smarty->assign('menuBottom', $menuBottom);
		$res = $smarty->fetch('menuBottom.tpl');
 				
		return $res;
	}
	
	
	private function isInActiveArray($id)
	{
		$result = 0;
		
		for ($i = 0; $i < $this->arrayIndex; $i++)
		{
			if ($id == $this->activeMenuPath[$i])
			  $result = 1;
		}	
		return $result;
	}
	private function getBaseActiveItem($mActive)
	{
		//pobieram id oraz parentId dla menuActive
		//$DBInt = DBSingleton::getInstance();
		$query = "Select FK_ParentMenuItem from cmsMenuView where id = $mActive";
		$result = $this->dbInt->ExecQuery($query);
 		$userData = $result->fetchRow(DB_FETCHMODE_ASSOC);
 		//if ($user['FK_ParentMenuItem'] > 0)
 		//{
 		$this->activeMenuPath[$this->arrayIndex] = $mActive;//$user['FK_ParentMenuItem'];
 		$this->arrayIndex++;
 		//} 
 		if ($userData['FK_ParentMenuItem'] == 0)
 		{
 			$res = $mActive;
 		}
 		else
 		{
 			//wolam rekurencyjnie
 			$res = $this->getBaseActiveItem($userData['FK_ParentMenuItem']);
 		}
		return $res; 
	}
	private function collapse($itemBase, $itemFinal, $itemActual)
	{
		//funkcja rekurencyjnie, zaglebiajac sie w dol tworzy podmenu
		/*
		1. tab .= 2; Pobieram id rekordow, dla ktorych parentMenu = itemActual (order by index) oraz wpisuje <tr><td>$tab menuitem
		2. if ($itemActual <> $itemFinal) && (isInActiveMenuPath($itemActual)) collapse($itemBase, $itemFinal, $id) 
		*/ 
		
		//1.
		$menuContent = '';
		//$DBInt = DBSingleton::getInstance();
		$query = "Select id, Name from cmsMenuView where FK_ParentMenuItem = $itemActual order By `index`";
		$result = $this->dbInt->ExecQuery($query);
 		$localText = $this->spaceText .= '&nbsp;&nbsp;&nbsp;';
 		
 		$tmpMenuMgr = MenuMGR::getInstance();
 		
 		while ($userData = $result->fetchRow(DB_FETCHMODE_ASSOC))
 		{
 			
 			  
 			if ($this->printMenu($userData['id']))
 			{
 				$menuContent .= '<tr><td>'.$localText.'<img src="../Cms/Files/Img/corner-dots.gif" borger="0"><a class="leftmenu" href=?m='.$userData['id'].'>&nbsp;'.$tmpMenuMgr->getMenuCaption($userData['id'],'PL').'</a></td></tr>';
 			}
 			if (($itemActual != $itemFinal) && (($this->isInActiveArray($userData['id']/*$itemActual*/)) == 1)) 
 			{
 				$menuContent .= $this->collapse($itemBase, $itemFinal, $userData['id']);
 			}
 	 			 	
 		}
 		
 		return $menuContent;
 		
	}
	
	private function printMenu($menuId)
	{
		$result = false;
		$sectionsIds = array();
		$menu = MenuMgr::getInstance();
		$pageId = $menu->getMenuPage($menuId);
		if (!isset($pageId))
		{
			return true;
			exit;
		}
		$sectionMgr = new SectionsMgr();
		$sectionsIds = $sectionMgr->getPageSections($pageId);
		$module = new ModulesMgr();
		for($i=0;$i<sizeof($sectionsIds);$i++)
		{
			$actionId = $sectionMgr->getSectionAction($sectionsIds[$i]);
			if ($actionId == 0)
			{
				$result = true;
			}
			else
			{
				$result = $module->checkPrivilege($module->getModuleActionNameById($actionId));
			}
			if ($result == false)
				break;	
		}
		return $result;
	}
	//render menu dla cms
	private function renderAdmin($parentMenu)
	{
		//Ta procedura jedynie dla leftmenu!!!!Dla pozostalych menu jednopoziomowe
		//1. pobieram wszystkie items dla adminmenu (l lub r lub t lub b) 
		//2. szukam bazowego menuitem (korzenia) dla ActiveMenu
		//3. wyswietlam wszystkie, dla ktorych parentmenu = 0, gdy napotkany=bazowy to:
		//4. wyykonuje rekurencyjna funkcje collapse(ItemBase, itemFinal, itemActual (zmienne)). Wyswietlam w niej cala "galaz menu do dzieci itemFinal (wlacznie) - czyli itemActual = itemFinal 
		
		$activeBaseItem = 0;
		//1.
		//$DBInt = DBSingleton::getInstance();
 
		$result = $this->dbInt->ExecQuery("Select id, Name from cmsMenuView Where AdminMenu='T' and Position = 'L' and FK_ParentMenuItem = 0 Order By `Index`");
		//2.
		if ($this->menuActive > 0)
		{
			$activeBaseItem = $this->getBaseActiveItem($this->menuActive);
					
		}
		$menuContent='<table>';
		$tmpMenuMgr = MenuMGR::getInstance();
		while ($userData = $result->fetchRow(DB_FETCHMODE_ASSOC))
		{
			if ($this->printMenu($userData['id']))
			{
				$menuContent .= '<tr><td><img src="../Cms/Files/Img/crumb.gif"><a class="leftmenu" href=?m='.$userData['id'].'>&nbsp;'.$tmpMenuMgr->getMenuCaption($userData['id'],'PL')."</a></td></tr>";
			}
		
			if (($userData['id'] == $activeBaseItem))
			{
				$menuContent .= $this->collapse($activeBaseItem, $this->menuActive, $userData['id']); 
			}
		//var_dump($userData);
		}
		$menuContent.='</table>';
		return $menuContent;
	}
	// render dla strony
	private function renderPublic()
	{
	 	//tu juz uwzgleniam menuPosition
	 	if ($this->menuPosition == 'l')
	 	{
			$result = $this->renderLeftMenu();	 				
	 	}
	 	else if ($this->menuPosition == 't')
	 	{
	 		$result = $this->renderTopMenu();
	 	}
	 	else if ($this->menuPosition == 'r')
	 	{
	 		$result = $this->renderRightMenu();
	 	}
		else if ($this->menuPosition == 'b')
	 	{
	 		$result = $this->renderBottomMenu();
	 	}
	 	else //bottom
	 	{
	 		
	 	}
	 	return $result;
	}
	private function setMenuSel($menuId)
	{
		$location = $this->menuMgr->getMenuLocation($menuId);
		
		if ($location == 'T')
		{
			$this->selectedTop = $menuId;
			$this->selectedLeft = $menuId;
		}
		else if ($location == 'L')
		{ 
			$this->selectedLeft = $menuId;
			$this->selectedTop = $this->getBaseActiveItem($menuId);
						
		} 
		else if ($location == 'R')
		{
			$this->selectedRight = $menuId;
			$this->selectedLeft = $this->getMenuParent($menuId);
			$this->selectedTop = $this->getBaseActiveItem($this->selectedLeft);
		} 
	}
	public function __construct($mode)
	{
		$this->mode = $mode;
		$this->arrayIndex = 0;
		$this->dbInt = DBSingleton::getInstance();
		$this->menuMgr = MenuMGR::getInstance();
		
		if ($this->mode == 'public')
			$this->setMenuSel($_SESSION['mp']);
		else
			$this->setMenuSel($_SESSION['m']);
		
	}
	
	public function render($menuActive, $menuPosition)
	{
			$this->menuActive = $menuActive;
			$this->menuPosition = $menuPosition;
	
			if ($this->mode == 'admin')
			{
		
				$result = $this->renderAdmin(0);
			}	
			else if ($this->mode == 'public')
			{
		
				$result = $this->renderPublic($menuPosition);
			}
		return $result;
	}
}
?>
<?php

/**
* Moduł MenuFrontend służy do zarządzania menu dla strony wynikowej.
* Umożlwia wykonanie wszelkich operacji dot punktów menu:
* 
* Dodawnie
* Edycję
* Usuwanie.
* 
* Operacje dodawnia, usuwania, edycji oraz renderowania są wykonywane
* poprzez wykorzystanie jako agregacji klasy menu oraz menuRenderer
* 
* Menu Frontend ma nastepujaca mozliwosci wyswietlania
* - menu top: wyswietlanie jednopoziomowe, pozycja Parent jest pusta
* - menu left: wyswietlanie wielopoziomowe, pozycja parent wskazuje na menuTop lub menu nadrzedne w hierarchii
* - menu right: bez heirarchii, pozycja Parent wskazuje na leftMenuItem 
* - menu bottom: tak samo jak menu top
* 
*/

class FrontendMenu extends moduleTemplate
{
	private $menuObj = null;
	
	//-------------inicjalizacja i niszczenie--------
	
	public function __construct()
	{
		require_once rootPath.'/Modules/FrontendMenu/FrontendMenuClass/FrontendMenu.class.php';
		$this->menuObj = new FrontendMenuClass();
	}
		
	public function __destruct()
	{
		unset($this->menuObj);	
	}
	
	public function executeAction($actionName, $l, $varArray)
	{
				
		if ($actionName == 'showMenuList')
		{
			return $this->showMenuList();
		}
		
		if ($actionName == 'showMenuItemAdd')
		{
			return $this->menuObj->showAddMenuForm();
		}
		
		if ($actionName == 'RebuildHtaccess')
		{
			return $this->menuObj->RebuildHtaccess();
		}
		
		if ($actionName == 'showMenuListChoose')
		{
			//if (isset($_GET['menuPosition']))
			{
				//$menuPosition = $_GET('menuPosition');
				return $this->menuObj->showMenuChooseList();
				
			}
			//else
			{
				//echo "Nei okroeslono MenuPosition";
			}
			
		}
		if ($actionName == 'showMenuPagesChoose')
		{
			return $this->menuObj->assignMenuToPage();
		}
		if ($actionName == 'showMenuItemEdit')
		{
			$id = 0;
			
			if (isset($_GET['id']))
			{
				$id = $_GET['id'];
			}
			else if (isset($_POST['id']))
			{
				$id = $_POST['id'];
			}
			
			return $this->menuObj->showAddMenuForm($id);	
		}
		if ($actionName == 'menuUp')
		{
			$id = 0;
			
			if (isset($_GET['id']))
			{
				$id = $_GET['id'];
			}
			else if (isset($_POST['id']))
			{
				$id = $_POST['id'];
			}
			
			return $this->menuObj->moveUp($id);
		}
		if ($actionName == 'menuDown')
		{
			$id = 0;
			
			if (isset($_GET['id']))
			{
				$id = $_GET['id'];
			}
			else if (isset($_POST['id']))
			{
				$id = $_POST['id'];
			}
			
			return $this->menuObj->moveDown($id);
		}
		if ($actionName == 'delMenuItemDo')
		{
			$id = 0;
			if (isset($_GET['id']))
			{
				$id = $_GET['id'];
			}
			else if (isset($_POST['id']))
			{
				$id = $_POST['id'];
			}
			return $this->menuObj->delMenuItemDo($id);
		}
		if ($actionName == 'delMenuItem')
		{
			$id = 0;
			if (isset($_GET['id']))
			{
				$id = $_GET['id'];
			}
			else if (isset($_POST['id']))
			{
				$id = $_POST['id'];
			}
			if ($id == 0)
			{
				$module = new ModulesMgr();
				$module->loadModule('Menu');
				$okAction = $module->getModuleActionIdByName('ShowMenuList');
				$dialog = new dialog('Usuwanie' , 'Pozycja menu nie istnieje', 'alert', 300, 150);
				$dialog->setAlign('center');
				$dialog->setOkCaption('Ok');
				$dialog->setOkAction($okAction);
				$result = $dialog->show(1);	
			}
			else
				return $this->menuObj->delMenuItem($id);
		}
	}
	//wyswietlenie okna wyboru menu
	public function showMenuListChoose($menuPosition)
	{
		return $this->menuObj->showMenuChooseList();
	}
	
	//-------------- Dostepne akcje------------------
	
	/**
	 * Wyświetlenie listy pozycji menu (administracja)
	 * @return nil
	 * @autor Piotr Brodziński
	 * @access public
	 */
	public function showMenuList()
	{
		if (isset($_GET['menuPosition']))
		{
			$menuPosition = $_GET('menuPosition');
			if (($menuPosition != 'l')&&($menuPosition != 'r')&&($menuPosition != 't')&&($menuPosition != 'b'))
			{
				throw new Exception('Błędna wartośc parametru menuPosition w Menu::showMenuList : '.$menuPosition);
			}
		}
		else
		{
			$menuPosition = 'l';	
		}
		return $this->menuObj->showMenuList($menuPosition);
	}
	
	/**
	 * Wyświetltnie ekranu dodawania pozycji menu
	 * @autor Piotr Brodziński
	 * @access public
	 */
	public function showMenuItemAdd()
	{
				
	}
	
	/**
	 * Wyświetlenie ekranu edycji MenuItem
	 * @autor Piotr Brodziński
	 * @access public 
	 */
	public function showMenuItemEdit()
	{
		
	}
	
	/**
	 * Akcja fizycznego dodania MenuItem
	 * @autor Piotr Brodziński
	 * @access public
	 */
	public function addMenuItem()
	{
		
	}
	
	/**
	 * Akcja fizycznego usuwania MenuItem
	 * @autor Piotr Brodziński
	 * @access public
	 */
	public function delMenuItem()
	{
		
	}
	
	/**
	 * Akcja fizycznej modyfikacji danych MenuItem
	 * @autor Piotr Brodziński
	 * @access public
	 */
	public function modifyMenuItem()
	{
		
	}
	
	/**
	 * Akcja przyporządkowania elementu menu do strony
	 * @access public 
	 */
	public function assignMenuToPage()
	{
		
	}
	
	/**
	 * Wyświetlenie formualrza przyporządkowania danego menuItem do strony
	 * @access public 
	 */
	public function showAssignMenuToPageForm()
	{
		//$id, pageId		
	}
	
	//-------------------------------------
	
	//-----------Metody prytwatne - pomocnicze
}

?>
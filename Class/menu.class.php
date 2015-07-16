<?php
//ta klasa bedzie sluzyla do pobierania zawartosci menu, tworzenie menu(dodawanie menuitems),  itp

class menuMgr
{
	private static $instance;
	private $dbInt; 
	
	private  function __construct()
	{
		Try
		{
			$this->dbInt = DBSingleton::getInstance();			
		}
		Catch(Exception $e)
		{
			$exc = new ExceptionClass($e, 'menuMgr.Construct');
   			$exc->writeException();   	   	
		}
	}
	
	public function __destruct()
	{
		$this->dbInt = null;
		self::$instance = null; 
	}
	
	public static function getInstance()
	{
		Try
		{
			if (empty(self::$instance))
		  	{
		  	 	self::$instance = new menuMgr();
	  		}
	  		return self::$instance;
		}
		Catch(Exception $e)
		{
			$exc = new ExceptionClass($e, 'menuMgr.getInstance');
   			$exc->writeException();   	   	
		}	  
	}
	
	//metody dodawania menuItem + pomocnicze

	//pobieranie wolnego indexu menu
	public function getFreeMenuIndex()
	{
		Try
		{
			$result = $this->dbInt->ExecQuery('Select max(`Index`) as indeks from cmsMenu');
			$userData = $result->fetchRow(DB_FETCHMODE_ASSOC);
			$indeks = $userData['indeks'];
			return $indeks;		
		}
		Catch(Exception $e)
		{
			$exc = new ExceptionClass($e, 'menuMgr.getFreeMenuIndex');
   			$exc->writeException();   	   	
		}
	}
	
	//dodaje nowy MenuItem
	public function addMenuItem($parentMenuName, $name, $shortName, $pageName, $index, $isAdmin, $position, $active='T', $menuLinkText='')
	{
		Try
		{
			$dmlMenu = "INSERT INTO `cmsMenu`(`Name`, `ShortName`, `Index`, `AdminMenu`, `Position`, `Active`, `MenuLinkText`) 
						Values ('$name', '$shortName', $index, '$isAdmin', '$position', '$active', '$menuLinkText');";
			
			$this->dbInt->ExecQuery($dmlMenu);
						
			if ($pageName != '')
			{
				$pageMgr = New pagesMgr();
				$pageId = $pageMgr->getPageIdByName($pageName);
				$dmlMenu = "Update cmsMenu Set FK_PageId=$pageId Where ShortName='$shortName'";
				$this->dbInt->ExecQuery($dmlMenu);				
			}
			if ($parentMenuName != '')
			{
				$parentId = $this->getMenuIdByName($parentMenuName);
				$dmlMenu = "Update cmsMenu Set FK_ParentMenuItem=$parentId Where ShortName='$shortName'";
				$this->dbInt->ExecQuery($dmlMenu); 
			}
			
		}
		Catch(Exception $e)
		{
			$exc = new ExceptionClass($e, 'menuMgr.addMenuItem');
   			$exc->writeException();   	   	
		}
		
	}
	public function setMenuCaption($menuId, $langShortName, $Caption)
	{
		$dmlUpdateCaption = 
			"	UPDATE 
					`cmsMenuItemsCaptions`
				SET
					`Caption` = '$Caption'
				WHERE 
					FkMenu = $menuId AND
					FKLang = (	SELECT id FROM cmsLang WHERE ShortName = '$langShortName')";
		$dmlInsertCaption = 
			"
				INSERT INTO 
					`cmsMenuItemsCaptions`(`FkLang`, `FkMenu`, `Caption`) 
					VALUES((SELECT id FROM cmsLang WHERE ShortName = '$langShortName'), $menuId, '$Caption')
			";
		
		if ($this->menuCaptionExists($menuId, $langShortName))
			$query = $dmlUpdateCaption;
		else
			$query = $dmlInsertCaption;
		
			
		$this->dbInt->ExecQuery($query);
	}
	
	public function menuCaptionExists($menuId, $langShortName)
	{
		
	  	$captionQuery = 
					"
				SELECT
					Count(`id`) as Ilosc 
				FROM
					`cmsMenuItemsCaptions`
				WHERE
					`FKMenu` = $menuId AND
					`FKLang` = (SELECT 
									`id` 
								FROM 
									`cmsLang` 
								WHERE 
									`ShortName` = '$langShortName')
					";
		
		$qRes = $this->dbInt->ExecQuery($captionQuery);
		$data = $qRes->fetchRow(DB_FETCHMODE_ASSOC);
		if ($data['Ilosc'] == 0)
		{
			return false;
		}
		else
		{
			return true;
		}
		
		
		
	}
	
	//Przypisanie strony do menu
	public function setMenuItemPage($menuShortName, $pageShortName)
	{
		Try
		{
			$pageMgr = new pagesMgr();
			$pageId = $pageMgr->getPageIdByName($pageShortName);
			$sqlUpdate = "Update cmsMenu Set Fk_PageId = $pageId Where ShortName = '$menuShortName'";
			$this->dbInt->ExecQuery($sqlUpdate);
		}
		Catch(Exception $e)
		{
			$exc = new ExceptionClass($e, 'menuMgr.setMenuItemPage');
   			$exc->writeException();   	   	
		}
	}
	public function setMenuActive($menuName, $value)
	{
		Try
		{
			if ($value == 'T')
			{
				$val = 'T';
			}
			else if ($value == 'N')
			{
				$val = 'N';
			}
			else
			{
				throw new Exception('Przekazana wartosc argumentu jest nieprawidlowa. setMenuActive');
			}
			
			$sqlUpdate = "Update cmsMenu Set Active = $val Where ShortName = '$menuName'";
			$this->dbInt->ExecQuery($sqlUpdate);
		}
		Catch(Exception $e)
		{
			$exc = new ExceptionClass($e, 'menuMgr.setMenuActive');
   			$exc->writeException();   	   	
		}
		
	}
	public function delMenuItem($menuShortName)
	{
		Try
		{
			$sqlDelete = "Delete * From cmsMenu Where ShortName = '$menuShortName'";
			$this->dbInt->ExecQuery($sqlDelete);
		}
		Catch(Exception $e)
		{
			$exc = new ExceptionClass($e, 'menuMgr.delMenuItem');
   			$exc->writeException();   	   	
		}
	}
		
	public function getMenuLocation($menuId)
	{
		$result = $this->dbInt->ExecQuery("Select Position from cmsMenu Where id=".$menuId);
		$userData = $result->fetchRow(DB_FETCHMODE_ASSOC);
		$position = $userData['Position'];
		return $position;
	}
	public function getMenuPage($menuId)
	{
		//zwraca pageId
		//$DBInt = DBSingleton::getInstance();
		
		$result = $this->dbInt->ExecQuery("Select FK_PageId from cmsMenu Where id=".$menuId);
		$userData = $result->fetchRow(DB_FETCHMODE_ASSOC);
		$pageId = $userData['FK_PageId'];
		return $pageId;
	}
	public function getMenuPageName($menuId)
	{
		//zwraca pageId
		//$DBInt = DBSingleton::getInstance();
		$query = 'Select p.ShortName from cmsMenu m inner join cmsPages p on m.id='.$menuId.' and p.id = m.FK_PageId';
		$result = $this->dbInt->ExecQuery($query);
		$userData = $result->fetchRow(DB_FETCHMODE_ASSOC);
		$pageName = $userData['ShortName'];
		return $pageName;
	}
	public function getMenuPageTitle($menuId)
	{
		//zwraca pageId
		//$DBInt = DBSingleton::getInstance();
		$query = 'Select p.PageName from cmsMenu m inner join cmsPages p on m.id='.$menuId.' and p.id = m.FK_PageId';
		$result = $this->dbInt->ExecQuery($query);
		$userData = $result->fetchRow(DB_FETCHMODE_ASSOC);
		$pageName = $userData['PageName'];
		return $pageName;
	}
	public function getMenuIdByName($name)
	{
		//$DBInt = DBSingleton::getInstance();
		$query = 'Select id From cmsMenu Where ShortName="'.$name.'"';
		
		$result = $this->dbInt->ExecQuery($query);
		$userData = $result->fetchRow(DB_FETCHMODE_ASSOC);
		return $userData['id'];
		//return $pageName;
	}
	public function getMenuNameById($id)
	{
		//$DBInt = DBSingleton::getInstance();
		$query = "Select ShortName From cmsMenu Where id=$id";
		$result = $this->dbInt->ExecQuery($query);
		$userData = $result->fetchRow(DB_FETCHMODE_ASSOC);
		return $userData['ShortName'];
		//return $pageName;
	}
	public function getMenuCaption($menuId, $langShortName)
	{
		$captionQuery = 
					"
				SELECT
					Caption 
				FROM
					cmsMenuItemsCaptions
				WHERE
					FKMenu = $menuId AND
					FKLang = (	SELECT 
									id 
								FROM 
									cmsLang 
								WHERE 
									ShortName = '$langShortName')
					";
		
		 $qResult = $this->dbInt->ExecQuery($captionQuery);
		 $data = $qResult->fetchRow(DB_FETCHMODE_ASSOC);
		 return $data['Caption'];
	}
}
?>

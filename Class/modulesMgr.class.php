<?php

//ta klasa sluz do zarzadzania modulami9 - to przez nia wywolujemy metody modulow (nazwa modulu, nazwa funkcji).
//Klasa wykorzystuje bd do pozyskania informacji o modulach


class modulesMgr
{
  	private $moduleName;
  	private $moduleVersion;
  	private $modulePath;
  	private $moduleDirPath;
  	private $objModule = null;
  	private $loadedModule = 0;
  	private $dbInt;

  	//--------------------------------dodawanie modulow i funkcje dodatkowe
  	
  	public function __construct()
  	{
  		$this->dbInt = DBSingleton::GetInstance();
  	}
 	
  	public function addModule($name, $shortName, $version, $path, $dirPath)
  	{
  		Try
  		{
  			$ddlModuleAddToCmsModules = "Insert Into cmsModules 
  					(`ModuleName`, `ModuleShortName`, `ModuleVersion`, `ModulePath`, `ModuleDirPath`) 
		    	Values ('$name', '$shortName', $version, '$path', '$dirPath')";
			$this->dbInt->ExecQuery($ddlModuleAddToCmsModules);
  		}
  		
  		Catch(Exception $e)
		{
			$exc = new ExceptionClass($e, 'moduleMgr.AddModule');
   			$exc->writeException();   	   	
		}	
  	}
  	
  	public function setModuleVersion($shortName, $newVersion)
  	{
  		Try
  		{
  			$dml = "Update cmsModules Set `ModuleVersion` = $newVersion Where `ModuleShortName` = '$shortName''";
  			$this->dbInt->ExecQuery($dml);
  		}
  		Catch(Exception $e)
		{
			$exc = new ExceptionClass($e, 'moduleMgr.SetModuleVersion');
   			$exc->writeException();   	   	
		}
  	}
  	
   	public function addModuleAction($actnName, $actnShortName, $moduleName, $Admin = 'T', $Authorization = 'N')
  	{
		try
		{
  			$moduleId = $this->getModuleIdByName($moduleName);
  			$ddlActionAdd = "Insert Into cmsModulesActions (`ActionNAme`, `ActionShortName`, `Admin`, `Authorization`, `FK_ModuleId`)
							values ('$actnName', '$actnShortName', '$Admin', '$Authorization' , $moduleId)";
			$this->dbInt->ExecQuery($ddlActionAdd);
			$actnId = $this->getModuleActionIdByName($actnShortName);
			$ddlPrivilege = "INSERT INTO `cmsPrivileges`(`ModulesActionFk`, `UsersFk`) VALUES ($actnId, 1)";
			$this->dbInt->ExecQuery($ddlPrivilege);
		}
 	 	Catch(Exception $e)
		{
			$exc = new ExceptionClass($e, 'moduleMgr.AddModuleAction');
   			$exc->writeException();   	   	
		}
  	}
  	//--------------------------------
 	//---------------------Inne metody----------
 	
  	public function getModulePath()
  	{
  		if ($this->loadedModule == 0) 
  		{
  			throw new Exception('modulesMgr::getModulePath');
  		}
  		else
  		{
  			return $this->modulePath;
  		}
  	}
  	
	public function getModuleDirPath()
  	{
  		if ($this->loadedModule == 0) 
  		{
  			throw new Exception('modulesMgr::getModulePath');
  		}
  		else
  		{
  			return $this->moduleDirPath;
  		}
  	}
  	
  	public function __create()
  	{
  		
  	}
  	
  	public function loadModule($moduleName)
  	{
  		
		//$DBInt = DBSingleton::getInstance();
		$query = "Select ModuleShortName, ModuleVersion, ModulePath, ModuleDirPath from cmsModules Where ModuleShortName = '$moduleName'";
		$result = $this->dbInt->ExecQuery($query);
		$data = $result->fetchRow(DB_FETCHMODE_ASSOC);
		$this->moduleName = $data['ModuleShortName'];
		$this->moduleVersion = $data['ModuleVersion'];
		$this->modulePath = $data['ModulePath'];
		$this->moduleDirPath = $data['ModuleDirPath'];
		$this->loadedModule = 1;
		
		//FIXME Tu dodac pobieranie AdminModeOnly
		
  	}
  	private function chkActiveAction($actionName)
  	{
  		$query = "SELECT Active FROM cmsModulesActions WHERE ActionShortName = '$actionName'";
		$result = $this->dbInt->ExecQuery($query);
		$data = $result->fetchRow(DB_FETCHMODE_ASSOC);
		$active = $data['Active'];
		if ($active == 'T')
		{
			return true;
		}
		else
		{
			return false;
		}
		
  	}
  	private function chkAdmin($actionName)
  	{
		$result = false;
		
		if (!isset($_SESSION['adminId']))
			$_SESSION['adminId'] = -1;
			
		//jezeli akcja jest dla admina to sprawdzam czy zalogowany. Jeżeli nie to zwracam true
		$query = "SELECT Admin FROM cmsModulesActions WHERE ActionShortName = '$actionName'";
		$result = $this->dbInt->ExecQuery($query);
		$data = $result->fetchRow(DB_FETCHMODE_ASSOC);
		$admin = $data['Admin'];
		if (($admin == 'N') || (($admin == 'T')&&($_SESSION["adminId"] > 0)) || ($actionName == 'adminLogin'))
		{
			$res = true; 
		}
		else
		{
			$res = false;
		}
				
  		return $res;
  	}
  	private function chkAuth($actionName)
  	{
  		$result = false;
		//jezeli akcja jest dla admina to sprawdzam czy zalogowany. Jeżeli nie to zwracam true
		$query = "SELECT Authorization FROM cmsModulesActions WHERE ActionShortName = '$actionName'";
		$result = $this->dbInt->ExecQuery($query);
		$data = $result->fetchRow(DB_FETCHMODE_ASSOC);
		$auth = $data['Authorization'];
		if (($auth == 'N') || (($auth == 'T')&&(isset($_SESSION['klient']))&&($_SESSION['klient'] > 0)||(isset($_SESSION['adminId'])&&($_SESSION['adminId'] > 0))))
		{
			$result = true; 
		}
		else
		{
			$result = false;
		}
				
  		return $result; 
  	}
  	
  	public function moduleExecuteAction($actionName, $params)
  	{
  		//session_start();
  		$checkActive = false;
  		$checkAdmin = false;
  		$checkAuthorization = false;
  		if (($this->loadedModule == 0)) 
  		{
  			throw new Exception('modulesMgr::moduleExecuteAction');
  		}
  		else
  		{
  			
  			$checkActive = $this->chkActiveAction($actionName);
  			$checkAdmin = $this->chkAdmin($actionName);
  			$checkAuthorization = $this->chkAuth($actionName);
  		
  			
  		//	session_start();
  		//FIXME Jezeli AdminModeOnly to nie wykonuje dalej jezeli nie zalogowany admin (czyli jest ustawiona Session AdminId i jest > -1)  - przekierowywuje do index.php strony www
  		//if ($actionName=='chkPrivileges')
  			if (!$checkActive)
  			{
  				//TODO Dodać log z $actionName
  				$privilegeError = new dialog('Akcje', "Akcja nieczynna, skontaktuj się z administratorem", 'alert', 350, 100);
  				$modTmp = new ModulesMgr();
  				$modTmp ->loadModule('CmsInfo');
  				$actn = $modTmp ->getModuleActionIdByName('showCmsInfo');
  				$privilegeError->setOkAction($actn);
  				$privilegeError->setOkCaption('Ok');
  				$privilegeError->setAlign('center');
  				return $privilegeError->show(1);
  				 
  			}
  			else if (($actionName=='chkPrivileges')||($actionName=='adminLogout')||(($actionName=='adminLogin'))||($this->checkPrivilege($actionName)))
  			{
  				if ( ($checkAdmin)&&($checkAuthorization))
  				{
  					if ($this->modulePath == '')
  						throw new exception('Nie ustawione modulePAth');
  						
  					include_once(rootPath.$this->modulePath);
  					$className = $this->moduleName;
  					$this->objModule = new $className();
  					return $this->objModule->executeAction($actionName, $_SESSION['lang'], $params);
  				}
  				else
  				{
  					if (!$checkAdmin)
  					{
  						return 'Akcja tylko dla administratorów!'; 
  					}
  					if (!$checkAuthorization)
  					{
  						return 'Treść dostępna tylko dla użytkowników zalogowanych!';			
  					}
  				}
  				
  			}
  			else
  			{
  				//$actionName
  				$privilegeError = new dialog('Uprawnienia', "Brak uprawnień do wykonania akcji!!!", 'alert', 250, 100);
  				//$privilegeError->setOkAction(-1);
  				//$privilegeError->setOkCaption('Ok');
  				$privilegeError->setAlign('center');
  				return $privilegeError->show(1);
  			}
  			
			//  unset($this->objModule);
  		}
  	}
  	
  	//  instalacja modulu - moduleName - nazwa katalogu w /Modules
  	public function checkPrivilege($actionName)
  	{
  		
  		$moduleName = $this->moduleName;
  		$actionId = $this->getModuleActionIdByName($actionName);
  		
  		if (isset($_SESSION['adminId']))
  			$userId = $_SESSION['adminId'];
  		else
  			$userId = - 1;
		
		//FIXME Tu trzbea przemyslec jak z uprawnieniami dla zwyklych uzytkownikow...Moze wprowadzic tryb admin - a w tabeli dodac adminAction - admin ma do wszystkich a user tylko do nieAdmin  		  		
  		
		$query = "Select id from cmsPrivileges where ModulesActionFk=$actionId and UsersFk=$userId";
					
		$result = $this->dbInt->ExecQuery($query);
		$i=0;
		while ($data = $result->fetchRow(DB_FETCHMODE_ASSOC))
		{
			$i++;
		}
		
		//sprawdzam czy nie jest to akcja uzytkoniwka zewnetrznego
		
		$query = "SELECT Admin, Authorization FROM cmsModulesActions WHERE id=$actionId";
		$result2 = $this->dbInt->ExecQuery($query);
		$data2 = $result2->fetchRow(DB_FETCHMODE_ASSOC);	
		
		
		if ($i>0)
		{
			return true;
		}
		else if ($data2['Admin']=='N')
		{
			/*if ($data2['Authorization'] == 'N')
				return true;
			else if (($data2['Authorization'] == 'T')&&($_SESSION['klient'] > 0))
				return true;
			else 
				return false;*/
			return true;		
		}
		else
		{
			return false;
		}
		
  	}
  	public function installModule($moduleName)
  	{
  		//parsuje xml i na tej podstawie dodaje rekordy
  		//po instlacji modyfikuje installedModules 
  	}
  	
  	public function getActions($mode)
  	{
  		//dla modulu wczytanego przez loadModule generuje tablice asocjacyjna -> actions[actionName] = $idAction
  		if ($this->loadedModule == 0) 
  		{
  			throw new Exception('modulesMgr::getModulePath');
  		}
  		else
  		{
  			
  		} 
  	}
  	
  	public function getModuleIdByName($moduleName)
  	{
  		try
  		{
  			//$DBInt = DBSingleton::getInstance();
			$query = "Select id from cmsModules Where ModuleShortName = '$moduleName'";
			$result = $this->dbInt->ExecQuery($query);
			$data = $result->fetchRow(DB_FETCHMODE_ASSOC);
			$wynik = $data['id'];
			return $wynik;
  		}
  		Catch(Exception $e)
		{
			$exc = new ExceptionClass($e, 'moduleMgr.getModuleIdByName');
   			$exc->writeException();   	   	
		}
  	}

  	public function getModuleNameById($moduleId)
  	{
  		Try
  		{
  		//	$DBInt = DBSingleton::getInstance();
			$query = "Select ModuleShortName from cmsModules Where id = $moduleId";
			
			$result = $this->dbInt->ExecQuery($query);
			$data = $result->fetchRow(DB_FETCHMODE_ASSOC);
			return $data['ModuleShortName'];
  		}
  		Catch(Exception $e)
		{
			$exc = new ExceptionClass($e, 'moduleMgr.getModuleNameById');
   			$exc->writeException();   	   	
		}
  		
  	}
  	
  	public function getModuleActionNameById($actionId)
  	{
  		Try
  		{
  		//	$DBInt = DBSingleton::getInstance();
			$query = 'Select ActionShortName from cmsModulesActions Where id = '.$actionId;
			$result = $this->dbInt->ExecQuery($query);
			$data = $result->fetchRow(DB_FETCHMODE_ASSOC);
			return $data['ActionShortName'];
  		}
  		Catch(Exception $e)
		{
			$exc = new ExceptionClass($e, 'moduleMgr.getModuleActionNameById');
   			$exc->writeException();   	   	
		}
 	}
	
 	public function getModuleActionIdByName($actionName)
  	{
		Try
		{
			$query = "Select id from cmsModulesActions Where ActionShortName = '$actionName'";
			$result = $this->dbInt->ExecQuery($query);
			$data = $result->fetchRow(DB_FETCHMODE_ASSOC);
			return $data['id'];
		}
  		Catch(Exception $e)
		{
			$exc = new ExceptionClass($e, 'moduleMgr.getModuleActionIdByName');
   			$exc->writeException();   	   	
		}
  	}
	public function IsActionSecured($actionId)
	{
		Try
  		{
			$query = "Select secured from cmsModulesActions Where id = $actionId";
			$result = $this->dbInt->ExecQuery($query);
			$data = $result->fetchRow(DB_FETCHMODE_ASSOC);
			return $data['secured']=='T';
  		}
  		Catch(Exception $e)
		{
			$exc = new ExceptionClass($e, 'moduleMgr.IsActionSecured');
   			$exc->writeException();   	   	
		}
  	}	
  	public function IsAdmin($actionId)
  	{
  	Try
  		{
			$query = "Select Admin from cmsModulesActions Where id = $actionId";
			$result = $this->dbInt->ExecQuery($query);
			$data = $result->fetchRow(DB_FETCHMODE_ASSOC);
			return $data['Admin']=='T';
  		}
  		Catch(Exception $e)
		{
			$exc = new ExceptionClass($e, 'moduleMgr.IsAdmin');
   			$exc->writeException();   	   	
		}
  	}
  	public function getModuleNameByActionId($actionId)
  	{
  		Try
  		{
			$query = "SELECT m.ModuleShortName 
					  FROM cmsModules m inner join cmsModulesActions a on m.id = a.FK_ModuleId and a.id=$actionId";
			$result = $this->dbInt->ExecQuery($query);
			$data = $result->fetchRow(DB_FETCHMODE_ASSOC);
			return $data['ModuleShortName'];
  		}
  		Catch(Exception $e)
		{
			$exc = new ExceptionClass($e, 'moduleMgr.getModuleNameByActionId');
   			$exc->writeException();   	   	
		}
  	}
}
?>
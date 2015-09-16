<?php
//zarzadza sekcjami
class sectionsMgr
{
	private $dbInt = null;
	
	//zwraca p jezeli strona, m jezeli modul
	private function getSectionContentType($sectionId)
	{
		//$DBInt = DBSingleton::getInstance();
		$query = 'Select ContentType from cmsSections where id = '.$sectionId;
		
		$result = $this->dbInt->ExecQuery($query);
		$data = $result->fetchRow(DB_FETCHMODE_ASSOC);
		
		if ($data['ContentType'] == 0) 
		{
			return 'p'; 
		}
		else
		{
			return 'm';
		}
	}
	public function getSectionIdByName($sectionShortName)
	{
		Try
		{
			$query = "Select Id from cmsSections where ShortName = '$sectionShortName'";
			$result = $this->dbInt->ExecQuery($query);
			$data = $result->fetchRow(DB_FETCHMODE_ASSOC);
			$wynik = $data['Id'];
			return $wynik;
		}
		Catch(Exception $e)
		{	
			$exc = new ExceptionClass($e, 'SectionsMgr.getSectionIdByName');
   			$exc->writeException();   	   	
		}
	}
	
	public function getSectionKind($sectionId)
	{
		//zwraca html, module....
		Try
		{
			$result = '';
			$query = "SELECT ContentType FROM cmsSections Where id =$sectionId";
			$result = $this->dbInt->ExecQuery($query);
			$data = $result->fetchRow(DB_FETCHMODE_ASSOC);
			$wynik = $data['ContentType'];
			switch ($wynik)
			{
				case 0:
				{
					$result = 'html';
					break;
				}
				case 1:
				{
					$result = 'module';
					break;
				}
			}
			return $result;
		}
		Catch(Exception $e)
		{	
			$exc = new ExceptionClass($e, 'SectionsMgr.getSectionKind');
   			$exc->writeException();   	   	
		}
		
	}
	public function __construct()
	{
		try
		{
			$this->dbInt = DBSingleton::getInstance();
		}
		Catch(Exception $e)
		{
			$exc = new ExceptionClass($e, 'sectionsMgr.construct');
   			$exc->writeException();   	   	
		}
	}
	
	public function addPageSection($name, $shortName, $priority, $pageName, $content='')
	{
		Try
		{
			$pageMgr = new pagesMgr();
			
			$pageId = $pageMgr->getPageIdByName($pageName);
						
			$ddlSectionAdd = "Insert Into cmsSections (`Name`, `ShortName`, `Priority`, `ContentType`, Content) Values
						('$name', '$shortName', $priority, 0, '$content')";
			
			$this->dbInt->ExecQuery($ddlSectionAdd);
		}
		Catch(Exception $e)
		{	
			$exc = new ExceptionClass($e, 'SectionsMgr.addPageSection');
   			$exc->writeException();   	   	
		}
	}
	public function addModuleSection($name, $shortName, $priority,$moduleName, $moduleActionName)
	{
		Try
		{
			$moduleMgr = new modulesMgr();
			$moduleActionId = $moduleMgr->getModuleActionIdByName($moduleActionName);
			$moduleId = $moduleMgr->getModuleIdByName($moduleName);
			$ddlSectionAdd = "Insert Into cmsSections (`Name`, `ShortName`, `Priority`, `ContentType`, `FK_ModuleId`,`FK_ModuleAction`) Values
						('$name', '$shortName', $priority, 1, $moduleId, $moduleActionId)";
			$this->dbInt->ExecQuery($ddlSectionAdd);
		}
		Catch(Exception $e)
		{	
			$exc = new ExceptionClass($e, 'SectionsMgr.addModuleSection');
   			$exc->writeException();   	   	
		}
	}
	
	//przypisuje sekcje do strony
	public function assignSectionToPage($sectionShortName, $pageShortName)
	{
		Try
		{
			
			$sectionId = $this->getSectionIdByName($sectionShortName);
			$pageMgr = new pagesMgr();
			$pageId = $pageMgr->getPageIdByName($pageShortName);
			$ddlSectionsToPagesAdd = "Insert Into cmsSectionsToPages (`PK_PageId`, `PK_SectionId`)
										Values ($pageId, $sectionId)";
			$this->dbInt->ExecQuery($ddlSectionsToPagesAdd);
			
		}
		Catch(Exception $e)
		{	
			$exc = new ExceptionClass($e, 'SectionsMgr.assignSectionToPage');
   			$exc->writeException();   	   	
		}
		
	}
	
	public function getSectionsCount($pageId)
	{
		if ($pageId == 0)
		{
			return 0;
		}
		else
		{
			//$DBInt = DBSingleton::getInstance();
			$lang = $_SESSION['lang'];
			$query = "Select count(s.id) as ilosc from cmsSections s inner join cmsSectionsToPages sp on
				 (s.id = sp.PK_SectionId) and (sp.PK_PageId =  $pageId)
				 where sp.Language = '$lang' or sp.Language is null";
			$result = $this->dbInt->ExecQuery($query);
			$userData = $result->fetchRow(DB_FETCHMODE_ASSOC);
			return $userData['ilosc'];
		}

	}
	//dodaje sekcje
	public function getPageSections($pageId)
	{
		$wyn = array();
		if (isset($pageId))
		{
		$query = "
			SELECT 
				PK_SectionId 
			FROM
				cmsSectionsToPages
			WHERE
				PK_PageId = $pageId
				";
		$result = $this->dbInt->ExecQuery($query);
		$i = 0;
		while ($dane = $result->fetchRow(DB_FETCHMODE_ASSOC))
		{
			$wyn[$i] = $dane['PK_SectionId'];
			$i++;
		}
		}		
		return $wyn;		
		
	}
	public function getSectionAction($sectionId)
	{
		$wyn = 0;
		$query = "
			SELECT
				FK_ModuleAction
			FROM
				cmsSections
			WHERE
				id=$sectionId
				";
		$result = $this->dbInt->ExecQuery($query);
		$userData = $result->fetchRow(DB_FETCHMODE_ASSOC);
		$wyn =  $userData['FK_ModuleAction'];
		if ($wyn != 'null')
		{
			return $wyn;
		}
		else
		{
			return 0;
		}
	}
	public function getSectionContent($sectionId)
	{
		try
		{
			/*
			jezeli zawartosc sekcji to strona statyczna to zwracam zawartosc strony
			jezeli zawartosc to modul - pobieram DefaultAction i wykonuje modulesMgrmoduleExecuteAction()
			*/
			if (($this->getSectionContentType($sectionId)) == 'p')
			{
			
			//	select Content from Sections where sectionid=x
			//	return Content;
			//	$DBInt = DBSingleton::getInstance();
			
				$query = 'Select Content from cmsSections where id = '.$sectionId;
				
				//'SELECT Content FROM '
							
				$result = $this->dbInt->ExecQuery($query);
				$data = $result->fetchRow(DB_FETCHMODE_ASSOC);
				$content = $data['Content'];
				
				
			}
			else //jezeli sekcja zawiera modul
			{
				
			//	ActionId = select ActionId form sections where sectionid=x 
			//	select ma.ActionName from cmsModulesActions where ma.id=ActionId
			//	module = modulesMgr->LoadModule(mouleName);
			//	content = $module->moduleExecuteAction($actionName);
				//$DBInt = DBSingleton::getInstance();
				$query = 'Select FK_ModuleId, FK_ModuleAction, Content From cmsSections where id = '.$sectionId;
				$result = $this->dbInt->ExecQuery($query);
				$data = $result->fetchRow(DB_FETCHMODE_ASSOC);
				$moduleId = $data['FK_ModuleId'];
				$moduleActionId = $data['FK_ModuleAction'];
				$module = new modulesMgr();
				$mName = $module->getModuleNameById($moduleId);
				$module->loadModule($mName);
				$acnName = $module->getModuleActionNameById($moduleActionId);
				$params = array();
				$params[] = $data['Content'];
				$content = $module->moduleExecuteAction($acnName, $params);
					
			//	$content = ''; 
			}
		
			return $content;
		 
		}
		Catch(Exception $e)
		{
			$exc = new ExceptionClass($e, 'getSectionContent');
	   		$exc->writeException();   	   	
		}
		
}
}


<?php

class moduleClass
{
	private $dbInt = null;
	private $adminLog = null;
	private $id = 0; 
	 
	public function __construct()
	{
		$this->dbInt = DBSingleton::GetInstance();
		
		if (isset($_SESSION['adminId']))
			$this->adminLog = new adminLog($_SESSION['adminId']);
	}
	public function showModulesList()
	{
		
		$query = '
			SELECT 
				id, ModuleName, ModuleShortName, ModuleVersion, ModulePath
			FROM 
				cmsModules
			';
		$html = '';
		$html .= '<table class="Grid" align="center" cellspacing=0>';
 	   	$html .= '<tr>';
 	   	$html .= '<td width=50><img src="../Cms/Files/Img/about-48x48.png" /></td>';
 	   	$html .= '<td><br/></td>';
 	   	$html .= '</tr>';
 	   	$html .= '<tr><td align="right" colspan="2"><hr/>';
		
		$grid = new gridRenderer();
		$grid->setTitle('Moduły');
		$grid->setGridAlign('center');
		$grid->setGridWidth(780);
		$grid->addColumn("ModuleName", 'Nazwa', 100, false, 'left');
		$grid->addColumn("ModuleShortName", 'Nazwa techniczna', 100, false, 'left');
		$grid->addColumn("ModuleVersion", 'Wersja', 75, false, 'center');
		$grid->addColumn('ModulePath', 'Ścieżka', 200, false, 'center');
		
		$grid->addColumn('id', '', 200, true, 'right');
		
 		//$grid->enabledDelAction($delAction);
 		$moduleTmp = new ModulesMgr();
 		$moduleTmp->loadModule('cmsModules');
 		$editModule = $moduleTmp->getModuleActionIdByName('editModule');
 		$deleteModule = $moduleTmp->getModuleActionIdByName('deleteModule');
		$installModule = $moduleTmp->getModuleActionIdByName('installModule');
		$addModule = $moduleTmp->getModuleActionIdByName('addModule');
		 		
	 	$grid->enabledEditAction($editModule);
	 	$grid->enabledDelAction($deleteModule);
		$grid->setDataQuery($query);
		
		$html .= $grid->renderHtmlGrid(1);
		
		$html .= '</td></tr>';
		$html .= '<tr><td align="right" colspan="2">';
		
		$addButton = new button('../Cms/Files/Img/add-16x16.png', 'Dodaj moduł', $addModule, -1);
		$html .= $addButton->show(1);
		
		$installButton = new button('../Cms/Files/Img/add-16x16.png', 'Zainstaluj moduł', $installModule, -1);
		$html .= $installButton->show(1);
		
			
		/*echo "<button onClick=\"document.location.href='?a=".$addAction."';\">".
			 "<table><tr><td><img src=\"../Cms/Files/Img/stock_edit-16.png\" height=16 border=\"0\"></td><td>Dodaj język</td></tr></table>".
			 "</button>";*/
		$html .= '</td></tr>';
		$html .= '</table>';
		
		
		return $html;
			
	}
	
	public function showModulesAndActionsList()
	{
		$result = '';
		$query = '
			SELECT 
				id, ModuleName as Col1, ModuleShortName as Col2, ModuleVersion as Col3, ModulePath as Col4, ModuleDirPath as Col5 
			FROM 
				cmsModules
			';
		$subQuery = '
			SELECT 
				id, ActionName as Col1, ActionShortName as Col2, Admin as Col3, Authorization as Col4, Active as Col5, Fk_ModuleId
			FROM
				cmsModulesActions
			Where
				1 = 1 
			';
				
		$grid = new gridRenderer();
		
		$grid->setDataQuery($query);
		$grid->setRecurseQuery($subQuery, 'Fk_ModuleId', 'ORDER BY `ActionName`');
		
		$grid->setTitle('Moduły');
		$grid->setGridAlign('center');
		$grid->setGridWidth(700);
		$grid->addColumn("Col1", 'Nazwa', 150, false, 'left');
		$grid->addColumn("Col2", 'Nazwa techniczna', 150, false, 'left');
		$grid->addColumn("Col3", 'Wersja/Admin', 25, false, 'center');
		$grid->addColumn('Col4', 'Ścieżka/Auth', 250, false, 'center');
		$grid->addColumn('Col5', 'Główny plik/Active', 150, false, 'center');
		$grid->addColumn('id', '', 200, true, 'right');
		
 		//$grid->enabledDelAction($delAction);
 		//$moduleTmp = new ModulesMgr();
 		//$moduleTmp->loadModule('cmsModules');
 		//$editModule = $moduleTmp->getModuleActionIdByName('editModule');
 		//$deleteModule = $moduleTmp->getModuleActionIdByName('deleteModule');
		//$installModule = $moduleTmp->getModuleActionIdByName('installModule');
		
		 		
	 	//$grid->enabledEditAction($editModule);
	 	//$grid->enabledDelAction($deleteModule);
				
		$result .= $grid->renderHtmlGrid(1, false);		
		
		
		return $result;
	}
	
	private function saveModuleData($name, $shortName, $version, $path, $dirPath)
	{
		$html = '';
		try
		{
			if ($this->id != 0)
			{
				$query = "
					UPDATE
						cmsModules
					SET
						ModuleName = '$name', ModuleShortName = '$shortName', ModuleVersion = $version, ModulePath = '$path', ModuleDirPath = '$dirPath'
					WHERE
						id = $this->id
					";
			}
			else
			{
				$query = "
						INSERT INTO cmsModules
							(ModuleName, ModuleShortName, ModuleVersion, ModulePath, ModuleDirPath)
						VALUES
							('$name', '$shortName', $version, '$path', '$dirPath')
						"; 
			}
			$this->dbInt->ExecQuery($query);
			
			$module = new ModulesMgr();
			$module->loadModule('Modules');
			$okAction = $module->getModuleActionIdByName('ShowModulesList');	
			$dialog = new dialog('Zapis danych' , 'Dane zapisane prawidłowo', 'Info', 300, 150);
			$dialog->setAlign('center');
			$dialog->setOkCaption('Ok');
			$dialog->setOkAction($okAction);
			$html .= $dialog->show(1);
			return $html;
		}
		Catch (exception $e)
		{
			$exc = new ExceptionClass($e, 'editModuleDo');
   			$html .= $exc->writeException(1);
   			   	  
		}
		
	}
	
	public function editModule($id)
	{
		
		$html = '';
		
		$this->id = $id;
		$html .= '<table border="0" width="700" align="center" cellspaceing=0 cellpadding=0>
		<tr><td>';
		$myForm = null;
		$myForm = new Form('dFORM', 'POST');
		$moduleForm = $myForm->getFormInstance();
		$moduleForm->addElement('header', ' hdrTest', 'Edycja danych modułu');
		$nazwaElement = $moduleForm->addElement('text', 'txtNazwa', 'Nazwa', array('size' => 50, 'maxlength'=> 25));
		$nazwaTechElement = $moduleForm->addElement('text', 'txtNazwaTech', 'Nazwa tech.', array('size' => 50, 'maxlength'=> 25));
		$wersjaElement = $moduleForm->addElement('text', 'txtWersja', 'Wersja', array('size' => 5, 'maxlength'=> 10));
		$sciezkaElement = $moduleForm->addElement('text', 'txtPath', 'Ścieżka modułu', array('size' => 50, 'maxlength'=> 256));
		$sciezkaSzczegElement = $moduleForm->addElement('text', 'txtDirPath', 'Ścieżka pliku gł.', array('size' => 50, 'maxlength'=> 256));
		$idElement = $moduleForm->addElement('hidden', 'id', 'id');
		//$config_form->addRule('txtTitle', 'Proszę wypełnić pole tytuł!', 'required', null, 'server');
		$moduleForm->addElement('reset', 'btnReset', 'Wyczyść');
      	$moduleForm->addElement('submit', 'btnSubmit', 'Zapisz');
		
      	$moduleForm->addRule('txtNazwa', 'Pole "Nazwa" musi być wypełnione', 'required', null, 'server');
      	$moduleForm->addRule('txtNazwaTech', 'Pole "Nazwa techniczna" musi być wypełnione', 'required', null, 'server');
      	$moduleForm->addRule('txtWersja', 'Pole "Wersja" musi być wypełnione', 'required', null, 'server');
      	$moduleForm->addRule('txtWersja', 'Zła wartośc w polu "Wersja"', 'numeric', null, 'server');
      	$moduleForm->addRule('txtPath', 'Pole "Ścieżka modułu" musi być wypełnione', 'required', null, 'server');
      	$moduleForm->addRule('txtDirPath', 'Pole "Ścieżka pliku gł." musi być wypełnione', 'required', null, 'server');
      	$moduleForm->applyFilter('__ALL__', 'trim');
		
      	$myForm->setStyle(2);
				
		//$titleElement->setValue($pageTitle);
	//
		if ($moduleForm->validate())
		{
		
			$moduleForm->freeze();
			
			//$pageTitle = $titleElement -> getValue();
			$this->saveModuleData($nazwaElement->getValue(), 
								$nazwaTechElement->getValue(),
								$wersjaElement->getValue(),
								$sciezkaElement->getValue(),
								$sciezkaSzczegElement->getValue()
								);
					
		}	
		else
		{
			/*$defaults = array();
			
			$defaults['txtName'] = '';
			$config_form->setDefaults($defaults);*/
			// wpisuje dane z bazy danych
			if ($id <> 0) //jezeli edycja
			{
				$query = "
					SELECT 
						ModuleName, ModuleShortName,ModuleVersion, ModulePath, ModuleDirPath
					FROM
						cmsModules
					WHERE
						id = $id  
				";
				
				$data = $this->dbInt->ExecQuery($query);
				$moduleRec = $data->fetchRow(DB_FETCHMODE_ASSOC);
				$nazwaElement->SetValue($moduleRec['ModuleName']);
				$nazwaTechElement->SetValue($moduleRec['ModuleShortName']);
				$wersjaElement->SetValue($moduleRec['ModuleVersion']);
				$sciezkaElement->SetValue($moduleRec['ModulePath']);
				$sciezkaSzczegElement->SetValue($moduleRec['ModulePath']);
				$idElement->SetValue($id);
			}
			else
			{
				$sciezkaElement->setValue('../Modules/<Enter ModuleName>');
				$sciezkaSzczegElement->setValue('../Modules/<Enter ModuleName>/<Enter FileName>');
			}
						
			$html .=$moduleForm->toHtml();

			$html .= '</td></tr></table>';
		if ($id != 0)
		{
			$html .= '<table class="Grid" align ="center"><tr><td>';
			
		//	grid z akcjami
			$funcResult = '';
			
			$query = "	Select id, ActionName, ActionShortName, Admin, Authorization, Active 
					From cmsModulesActions
					Where Fk_ModuleId = $id  
					Order By ActionName";
		
			$module = new modulesMgr();
 			$module->loadModule('Modules');
 			$editAction = $module->getModuleActionIdByName('editAction');
 			$delAction = $module->getModuleActionIdByName('delAction');
 		//	to samo co edycja ale bez id - wiec dodawanie
 			$addAction = $module->getModuleActionIdByName('addAction');
 			$cancelAction = $module->getModuleActionIdByName('showModulesList');
 		
 			$grid = new gridRenderer();
			$grid->setTitle('Akcje modułu');
			$grid->setGridAlign('center');
			$grid->setGridWidth(680);
			$grid->addColumn('ActionName', 'Nazwa', 200, false, 'left');
			$grid->addColumn('ActionShortName', 'Nazwa techn', 50, false, 'left');
			$grid->addColumn('Admin', 'Admin', 75, false, 'center');
			$grid->addColumn('Authorization', 'Autoryzacja', 55, false, 'center');
			$grid->addColumn('Active', 'Aktywny', 55, false, 'center');
			$grid->addColumn('id', '', 200, true, 'right');
 			$grid->enabledDelAction($delAction);
 			$grid->enabledEditAction($editAction);
 			$grid->addOtherArgs('moduleid', $id);
 				 		
			$grid->setDataQuery($query);
			$html .= $grid->renderHtmlGrid(1);
		
			$html .= '</td></tr>';
			$html .= '<tr><td align="right">';
			
			$addButton = new button('../Cms/Files/Img/add-16x16.png', 'Dodaj akcę', $addAction, $id);
			$html .= $addButton->show(1);
				
			$html .= '</td></tr>';
			$html .= '</table>';
			$html .= '<table width = "688" class="Grid" align="center" cellspacing=0>';
			$html .= '<tr><td align="right">';
			
			$buttonChgPass = new button('../Cms/Files/Img/delete-16x16.png', 'Anuluj edycję modułu', $cancelAction, 0);
			$html .= $buttonChgPass->show(1);
			$html .= '</td></tr>';
			$html .= '</table>';		
		}	
		}
		return $html;
	}
	public function deletemodule($id)
	{
		$html = '';
		$module = new ModulesMgr();
		$module->loadModule('Modules');
		$cancelAction = $module->getModuleActionIdByName('ShowModulesList');
		$okAction = $module->getModuleActionIdByName('deleteModuleDo');	
		$dialog = new dialog('Usuwanie modułu' , 'Czy usunąć moduł?', 'Query', 300, 150);
		$dialog->setAlign('center');
		$dialog->setOkCaption('Tak');
		$dialog->setOkAction($okAction);
		
		$dialog->setCancelCaption('Nie');
		$dialog->setCancelAction($cancelAction);
		
		$dialog->setId($id);
		$html .= $dialog->show(1);
		return $html;			
	}
	public function deleteModuleDo($moduleId)
	{
		$this->dbInt->ExecQuery("DELETE FROM cmsModules where id=$moduleId");
		
		$module = new ModulesMgr();
		$module->loadModule('Modules');
		$okAction = $module->getModuleActionIdByName('ShowModulesList');
		$dialog = new dialog('Usuwanie' , 'Moduł usunięty', 'Info', 300, 150);
		$dialog->setAlign('center');
		$dialog->setOkCaption('Ok');
		$dialog->setOkAction($okAction);
		return $dialog->show(1);
	}
	
	public function delAction($actionId)
	{
		$module = new ModulesMgr();
		$module->loadModule('Modules');
		$cancelAction = $module->getModuleActionIdByName('ShowModulesList');
		$okAction = $module->getModuleActionIdByName('delActionDo');	
		$dialog = new dialog('Usuwanie modułu' , 'Czy usunąć moduł?', 'Query', 300, 150);
		$dialog->setAlign('center');
		$dialog->setOkCaption('Tak');
		$dialog->setOkAction($okAction);
		
		$dialog->setCancelCaption('Nie');
		$dialog->setCancelAction($cancelAction);
		
		$dialog->setId($actionId);
		return $dialog->show(1);
	}
	public function delActionDo($actionId)
	{
		$this->dbInt->ExecQuery("DELETE FROM cmsModulesActions where id=$actionId");
		
		$module = new ModulesMgr();
		$module->loadModule('Modules');
		$okAction = $module->getModuleActionIdByName('ShowModulesList');
		$dialog = new dialog('Usuwanie' , 'Akcja usunięta', 'Info', 300, 150);
		$dialog->setAlign('center');
		$dialog->setOkCaption('Ok');
		$dialog->setOkAction($okAction);
		return $dialog->show(1);
	}
	
	public function AddAction($moduleId, $actionId = 0)
	{
		$html = '';
		$this->id = $moduleId;
		$html .= '<table border="0" width="400" align="center" cellspaceing=0 cellpadding=0>
		<tr><td>';
		$myForm = null;
		$myForm = new Form('dFORM', 'POST');
		$actionForm = $myForm->getFormInstance();
		$actionForm->addElement('header', ' hdrTest', 'Edycja danych modułu');
		$nazwaElement = $actionForm->addElement('text', 'txtNazwa', 'Nazwa', array('size' => 50, 'maxlength'=> 25));
		$nazwaTechElement = $actionForm->addElement('text', 'txtNazwaTech', 'Nazwa techniczna', array('size' => 50, 'maxlength'=> 25));
		$adminList['T'] = 'Tak';
		$adminList['N'] = 'Nie';
		$elementAdmin = $actionForm->addElement('select', 'cbAdmin', 'Admin', $adminList);
		$authList['T'] = 'Tak';
		$authList['N'] = 'Nie';
		$elementAuth = $actionForm->addElement('select', 'cbAuth', 'Autoryzacja', $authList);
		$activeList['T'] = 'Tak';
		$activeList['N'] = 'Nie';
		$elementActive = $actionForm->addElement('select', 'cbActive', 'Aktywna', $activeList);
		
		$idElement = $actionForm->addElement('hidden', 'moduleid', 'moduleid');
		$idActionElement = $actionForm->addElement('hidden', 'actionid', 'actionid');
		
		$actionForm->addElement('reset', 'btnReset', 'Wyczyść');
      	$actionForm->addElement('submit', 'btnSubmit', 'Zapisz');
		
      	$actionForm->addRule('txtNazwa', 'Proszę wypełnić pole nazwa!', 'required', null, 'server');
		$actionForm->addRule('txtNazwaTech', 'Proszę wypełnić pole nazwa techniczna!', 'required', null, 'server');
		
      	
      	$actionForm->applyFilter('__ALL__', 'trim');
		
		$myForm->setStyle(2);

		if ($actionForm->validate())
		{
			$actionForm->freeze();
			
			
			$adminArray = $elementAdmin -> getValue();
			$authArray = $elementAuth -> getValue();
			$activeArray = $elementActive -> getValue();
			
			$html .= $this->saveActionData(
					$idActionElement->getValue(),
					$idElement->getValue(),
					$nazwaElement -> getValue(),
					$nazwaTechElement -> getValue(),
					$adminArray[0],
					$authArray[0],
					$activeArray[0]													
								);
					
		}
		else
		{
			$idElement->SetValue($moduleId);
			$idActionElement->SetValue($actionId);
			if ($actionId != 0) //edycja
			{
				$query = "
						SELECT 
							id, ActionName, ActionShortName, Admin, Authorization, Active
						FROM
							cmsModulesActions
						WHERE
							id = $actionId
						ORDER BY
							ActionShortName ASC
					";
				
				$data = $this->dbInt->ExecQuery($query);
				$actionRec = $data->fetchRow(DB_FETCHMODE_ASSOC);
				$nazwaElement->setValue($actionRec['ActionName']);
				$nazwaTechElement->setValue($actionRec['ActionShortName']);
				$elementAdmin->setValue($actionRec['Admin']);
				$elementAuth->setValue($actionRec['Authorization']);
				$elementActive->setValue($actionRec['Active']);
				$idActionElement->setValue($actionId);
				
			}
			$html .=$actionForm->toHtml();
		}
		return $html;
	}

	private function saveActionData($actionId, $moduleId, $actionName, $actionShortName, $admin, $auth, $active)
	{
		try
		{
			$ddlPrivilege = '';
			if ($actionId != 0)
			{
				$query = "
					UPDATE
						cmsModulesActions
					SET
						ActionName = '$actionName', ActionShortName = '$actionShortName', Admin= '$admin', 
						Authorization = '$auth', Active = '$active'
					WHERE
						id = $actionId
					";
			}
			else
			{
				
				$query = "
						INSERT INTO cmsModulesActions
							(ActionName, ActionShortName, Admin, Authorization, Active, FK_ModuleId)
						VALUES
							('$actionName', '$actionShortName', '$admin', '$auth', '$active', $moduleId)
						";
				$ddlPrivilege = "INSERT INTO `cmsPrivileges`(`ModulesActionFk`, `UsersFk`) VALUES ($actionId, 1)";
						 
			}
			$this->dbInt->ExecQuery($query);
			IF ($ddlPrivilege != '')
				$this->dbInt->ExecQuery($ddlPrivilege);
			
			$module = new ModulesMgr();
			$module->loadModule('Modules');
			$okAction = $module->getModuleActionIdByName('editModule');
			$dialog = new dialog('Zapis danych' , 'Dane zapisane prawidłowo', 'Info', 300, 150);
			$dialog->setAlign('center');
			$dialog->setOkCaption('Ok');
			$dialog->setOkAction($okAction);
			$dialog->setId($moduleId);
			return $dialog->show(1);
			
		}
		Catch (exception $e)
		{
			$exc = new ExceptionClass($e, 'saveAction');
   			return $exc->writeException();   	  
		}
	}
	public function showModulesActionsChoose()
	{	
		$query = "
				SELECT	
					a.id, m.ModuleShortName, m.ModuleName, a.ActionShortName, a.ActionName, a.Active, a.ActionShortName as Value
				FROM
					cmsModules m INNER JOIN cmsModulesActions a	ON m.id = a.FK_ModuleId
				WHERE
					a.Admin = 'N'
				ORDER BY
					m.ModuleName, a.ActionName
			 	";
		
		$result = '';
		
		$result .= '<table class="Grid" align="center" cellspacing=0>';
 	   	$result .= '<tr><td colspan="2">';
 	   	
 	   	$menuListGrid = new gridRenderer();
 	   	$menuListGrid->setDataQuery($query);
 	   	$menuListGrid -> setTitle('Lista akcji użytkownika');
    	$menuListGrid->setGridAlign('center');
    	$menuListGrid->setGridWidth(560);
    	
    	$menuListGrid->addColumn('ModuleName', 'Nazwa modułu', 200, false, false, 'left');
    	$menuListGrid->addColumn('ModuleShortName', 'Nazwa techn. modułu', 200, false, false, 'left');
    	$menuListGrid->addColumn('ActionName', 'Nazwa techn. modułu', 100, false, false, 'left');
    	$menuListGrid->addColumn('ActionShortName', 'Nazwa techn. akcji', 100, false, false, 'left');
    	$menuListGrid->addColumn('Active', 'Aktywne', 20, false, false, 'center');
    	$menuListGrid->addColumn('id', '', 1, true, false, 'left');
    	$menuListGrid->addColumn('Value', '', 1, false, true, 'left');
    	$menuListGrid->callBackAction('window.opener.document.sectionContentForm.txtModule.value');
    	$result .= $menuListGrid->renderHtmlGrid(1);
    	$result .= '</td></tr>';
    	$result .= '</table>';
		
		restoreActionValue();
		return $result;
		restoreActionValue();
	}
}
?>
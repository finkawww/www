<?php

/**
 * Moduł CmsInfo wyświetla informacje ogólne o CMS:
 * krótkie instrukcje, informacje o aktualizacjach i poprawkach
 * @access public
 * @author Piotr Brodziński
 */
class CmsInfoClass
{
	private $userId;
	private function showCmsMessages()
	{
		
	}
	public function delBug($id)
	{
		$html = '';
		
		return $html;
	}
	
	public function addBug($id)
	{
		$statusList = array();
		$html = '';
		
		$html .= '<table width="500" align="center" cellpadding=0 cellspacing=0 border=0><tr><td>';
		
		$myForm = null;
		$myForm = new Form('dFORM', 'POST');
		$bugForm = $myForm->getFormInstance();
		$bugForm->addElement('header', ' hdrTest', 'Edycja/dodawanie zgłoszenia');
		$elementWersja = $bugForm->addElement('text', 'txtVersion', 'Wersja', array('size' => 20, 'maxlength'=> 10));
		$elementOpis = $bugForm->addElement('textarea', 'txtDesc', 'Opis', array('cols'=>25, 'rows'=>10));
		
		
		$statusList[0] = 'Uwaga/życzenie';
		$statusList[1] = 'Błąd';
		$statusList[2] = 'Błąd krytyczny';
		
		$elementStatus = $bugForm->addElement('select', 'cbStatus', 'Waga', $statusList);
		$valId = $bugForm->addElement('hidden', 'id', 'id buga');
						
		$bugForm->addElement('reset', 'btnReset', 'Wyczyść');
		$bugForm->addElement('submit', 'btnSubmit', 'Zapisz');
		
		$bugForm->addRule('txtVersion', 'Pole musi być wypełnione', 'required', null, 'server');
		$bugForm->addRule('txtDesc', 'Pole musi być wypełnione', 'required', null, 'server');
				
		$bugForm->applyFilter('__ALL__', 'trim');
		
		$myForm->setStyle(2);
		
		if ($bugForm->validate())
		{
			$activeArray = array();
			//$_SESSION['m'] = -1;
			$bugForm->freeze();
			
			$version = $elementWersja->getValue();
			$opis = $elementOpis->getValue();
			$statusArr = $elementStatus->getValue();
			
			$status = $statusArr[0];
			$id = $valId->getValue();
			$userIdT = $_SESSION['adminId'];
			$moduleMgr = new ModulesMgr();
			$moduleMgr->loadModule('AdminUsr');
			$params = array();
			$userId = $moduleMgr->moduleExecuteAction('getLogin', $params);
			unset($moduleMgr);
					
			$html .= $this->editBugDo($id, $version, $opis, $status, $userId);
			
		//	$pageTitle = $titleElement -> getValue();
		//	$this->DBInt->ExecQuery("Update cmsConfig Set Title = '$pageTitle'");
					
			
		}	
		else
		{
			if ($id > 0)
			{
				$dbInt = DBSingleton::getInstance();
				$data = $dbInt->ExecQuery("SELECT `Version`, `Description`, `Status` FROM cmsBugs WHERE id=".$id);
				$bugRec = $data->fetchRow(DB_FETCHMODE_ASSOC);
				$version = $bugRec['Version'];
				$opis = $bugRec['Description'];
				$status = $bugRec['Status'];
				
				$elementWersja->setValue($version);
				$elementOpis->setValue($opis);
				$valId->setValue($id);
				$elementStatus->setValue($status);
			}
			else
			{
				$valId->setValue(0);
			}
			
			$html .= $bugForm->toHtml();
			$moduleTmp = new ModulesMgr();
			$moduleTmp->loadModule('CmsInfo');
			$cancelAction = $moduleTmp->getModuleActionIdByName('showCmsInfo');
			unset($moduleTmp);
			
			$html .= '</td></tr><tr><td>
					  <table width = "100%" class="Grid" >';
			$html .= '<tr><td align="right">';
				$buttonChgPass = new button('../Cms/Files/Img/delete-16x16.png', 'Anuluj', $cancelAction, -1);
			$html .= $buttonChgPass->show(1);
			$html .= '</td></tr>';
			$html .= '</table>';
		}
				
		$html .= '</tr></td></table>';
		
		return $html;
	}
	public function editBugDo($id, $version, $opis, $status, $userId)
	{
	
	$html = '';
		$data = date("Y-m-d, g:i");
		
		if ($id > 0)
		{
		 	//tu update
		 	$query = 
		 			"
		 			UPDATE 
		 				cmsBugs 
		 			SET 
		 				Version = '$version',
		 				`Date` = '$data',
		 				`Description` = '$opis',
		 				`Status` = $status,
		 				User = '$userId'
					WHERE
						id = $id		 			
		 			";
		}
		else
		{
		 	//tu insert
	 	 
			$query = 
					"
					INSERT INTO 
						cmsBugs(Version, `Date`, `Description`, `Status`, `User`)
					VALUES
						('$version','$data', '$opis', $status, '$userId')
					";
		}
		$dbInt = DBSingleton::getInstance();
		//echo $query;
		$dbInt->ExecQuery($query);
		
		$module = new ModulesMgr();
		$module->loadModule('CmsInfo');
		$okAction = $module->getModuleActionIdByName('showCmsInfo');
		$dialog = new dialog('Zapis danych', 'Dane zapisane prawidłowo', 'Info', 300, 150);
		$dialog->setAlign('center');
		$dialog->setOkCaption('Ok');
		$dialog->setOkAction($okAction);
		$html .= $dialog->show(1);
		return $html;
	}
		 
	public function showCmsInfo($userId)
	{
		$html = '';
		
		$html = '';
		$module = new modulesMgr();
 		$module->loadModule('CmsInfo');
 		$addAction = $module->getModuleActionIdByName('addBug');
 		$editAction = $module->getModuleActionIdByName('editBug');
 		$delAction =  $module->getModuleActionIdByName('delBug');
 		
 		$addButton = new button(buttonAddIcon, 'Dodaj zgłoszenie', $addAction, -1);
 		 		
 		'Uwaga/życzenie';
		$statusList[1] = 'Błąd';
		$statusList[2] = 'Błąd krytyczny';
 		$queryBugs = "
 				Select 
 					id, `Version`, `Date`, `Description`, 
 					CASE
 						WHEN `Status`=0 THEN 'Uwaga/życzenie'
 						WHEN `Status`=1 THEN 'Błąd'
 						WHEN `Status`=2 THEN '<font color=\"red\">Błąd krytyczny</font>'
 					END AS Stat,  
 					`User` 
				From 
					cmsBugs 
				Order By 
					`Status` DESC, `Date` DESC, `Version`";
 				
		$html .= '<table class="Grid" align="center" cellspacing=0>';
 	   	$html .= '<tr>';
 	   	$html .= '<td width=50><img src="../Cms/Files/Img/about-48x48.png" /></td>';
 	   	$html .= '<td><br/></td>';
 	   	$html .= '</tr>';
		$html .= '<tr><td><hr/>';
			$grid = new gridRenderer();
 			$grid->setTitle('Lista błędów otwartych');
			$grid->setGridAlign('center');
			$grid->setGridWidth(780);
			$grid->addColumn("Version", 'Wersja', 80, false, false, 'center');
			$grid->addColumn("Date", 'Data', 80, false, false,  'center');
			$grid->addColumn('User', 'Zgłosił', 120, false, false, 'center');
			$grid->addColumn('Stat', 'Priorytet', 120, false, false, 'center');
			$grid->addColumn('Description', 'Opis', 420, false, false, 'center');
			$grid->addColumn("id", "", 200, true, false, 'right');
 			$grid->enabledDelAction($delAction);
	 		$grid->enabledEditAction($editAction);
			$grid->setDataQuery($queryBugs);
			
			
		$html .=$grid->renderHtmlGrid(1);
		$html .= '</td></tr>';
		$html .= '<tr><td align="right" colspan="2">';
			
		$html .=$addButton->show(1);
		$html .= '</td></tr>';
				
		/*$html .= '<tr><td align="right" colspan="2"><hr/><br/>';
		
		$queryUpdates = "
 				Select 
 					id, `Version`, `Date`, `Description`  
				From 
					`www`.`cmsUpdates` 
				Order By 
					`Version`";
		
		
		 	   	
		$html .= '<tr><td>';
		$grid = new gridRenderer();
 			$grid->setTitle('Lista zmian w wersjach');
			$grid->setGridAlign('center');
			$grid->setGridWidth(780);
			$grid->addColumn("Version", 'Wersja', 80, false, false, 'center');
			$grid->addColumn("Date", 'Data', 80, false, false,  'center');
			$grid->addColumn('Description', 'Opis', 420, false, false, 'center');
			$grid->addColumn("id", "", 200, true, false, 'center');
 			
			$grid->setDataQuery($queryUpdates);
		$html .=$grid->renderHtmlGrid(1);
		$html .= '</td></tr>';*/
		
		//$html .= '<tr><td align="right" colspan="2"><hr/><br/>';
		//$html .= '<table width="100%">';
		
		//$html .= '<tr><td width="50" align="center"><img src="../Cms/Files/Img/php-logo.gif" /></td><td width="*">System wymaga motoru PHP (5.x)</td></tr>';
		//$html .= '<tr><td width="50" align="center"><img src="http://www.smarty.net/gifs/smarty_icon.gif" /></td><td width="*">System bazuje na silniku SMARTY (2.6.17)</td></tr>';
		//$html .= '<tr><td width="50" align="center"><img src="../Cms/Files/Img/pear-power.png" /></td><td width="*">System wymaga PEAR (x.x)</td></tr>';
		//$html .= '</table>';
		//$html .= '</td></tr>';
		
		$html .= '</table>';
		
		
 	 
		
		return $html;
	}
	public function addCmsMessage($usersIds)
	{
		$html = '';
		
		
		
		return $html;
	
	}
	
	public function User()
	{
		$ret = "Witaj świecie  - tu moduł php";
		
		$ret .= '<table class="Grid" align="center">';
		$ret .= '<tr><td>';
			
		$funcResult = '';
		$translatorObj = new translator('../Modules/Config/Config.Translation.xml');
		$translatorObj->setLanguage($_SESSION['lang']);
		
		$query = "	SELECT id, Name, ShortName, Icon, Active 
					FROM cmsLang 
					ORDER BY ShortName";
		
		$module = new modulesMgr();
 		$module->loadModule('Config');
 		$editAction = $module->getModuleActionIdByName('editLang');
 		$delAction = $module->getModuleActionIdByName('delLang');
 		$addAction = $module->getModuleActionIdByName('editLang');
 		
 		$grid = new gridRenderer();
		$grid->setTitle($translatorObj->translate('langGridTitle'));
		$grid->setGridAlign('center');
		$grid->setGridWidth(580);
		$grid->addColumn("Name", $translatorObj->translate('langGridColName'), 200, false, 'left');
		$grid->addColumn("ShortName", $translatorObj->translate('langGridColShortName'), 50, false, 'left');
		$grid->addColumn("Icon", $translatorObj->translate('langGridColIcon'), 75, false, 'center');
		$grid->addColumn('Active', $translatorObj->translate('langGridColActive'), 55, false, 'center');
		$grid->addColumn("id", "", 200, true, 'right');
 		$grid->enabledDelAction($delAction);
	 	$grid->enabledEditAction($editAction);
		$grid->setDataQuery($query);
		$ret .= $grid->renderHtmlGrid(1);
		
		$ret .= '</td></tr>';
		$ret .= '<tr><td align="right">';
		
		$addButton = new button('../Cms/Files/Img/add-16x16.png', 'Dodaj język', $addAction, -1);
		$ret .= $addButton->show(1);
				
		$ret .= '</td></tr>';
		$ret .= '</table>';
		
		return $ret; 
	}
}
?>
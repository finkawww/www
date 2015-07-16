<?php

class PagesClass
{
	private $dbInt = null;

	private function getDefaultTemplate()
	{
		return 1;
	}
	
	public function __construct()
	{
		$this->dbInt = DBSingleton::getInstance();
	}
	public function cssEdit()
	{
		$html = '';
		$html .= '<table width="750" align="center"><tr><td>';
		$myForm = null;
		$myForm = new Form('dFORM', 'POST');
		$cssForm = $myForm->getFormInstance();
		$cssForm->addElement('header', ' hdrTest', 'Edycja CSS');
		$elementCssContent = $cssForm->addElement('textarea', 'Content', 'Źródło CSS', array('cols'=>70, 'rows'=>25));
		$cssForm->addElement('reset', 'btnReset', 'Wyczyść');
		$cssForm->addElement('submit', 'btnSubmit', 'Zapisz');
		$myForm->setStyle(2);
		
		if ($cssForm->validate())
		{
			$cssForm->freeze();
			$content = $elementCssContent->getValue();
						
			if ($this->saveCssData($content))
			{
				$tmpModule = new ModulesMgr();
				$tmpModule->loadModule('Pages');
 				$okAction = $tmpModule->getModuleActionIdByName('showPages');
				
				$dialog = new dialog('Zapis danych' , 'Szablon zapisany', 'info', 300, 150);
				$dialog->setAlign('center');
				$dialog->setOkCaption('Ok');
				$dialog->setOkAction($okAction);
				$html .=$dialog->show(1);		
			}
		}
		else
		{
			$elementCssContent->setValue($this->readCssContent());
			$html .= $cssForm->toHtml();
		}
		return $html;
	}
	
	private function saveCssData($content)
	{
		try
		{
			$nazwaPliku = cssFile;//'./FrontPage/Style/style.css';
			
			$plik = fopen ($nazwaPliku, 'w+');
			
			if (fwrite($plik, $content) === FALSE)
   			{
       			throw new exception("Nie mogę zapisać do pliku ($nazwaPliku)");
       			exit;
    		}
    		fclose($plik);
    		return true;
		}
		catch (exception $e)
		{
			fclose($plik);
			return false;
		} 
	}
	private function readCssContent()
	{
		try
		{
			$content = '';
			$file = rootPath.'/FrontPage/Style/style.css';
			$plik = fopen ($file, 'r');
			if (filesize($file)>0)
			{
				$content = fread($plik, filesize($file));
				fclose($plik);
			}
			return $content;
		}
		catch (exception $e)
		{
			fclose($plik);
		}
	}
	
	public function showPagesChoose()
	{
 			
 		$query = "
 				Select 
 					id, PageName, ShortName, ShortName as Value, Active, AuthorizedOnly, `Desc` 
				From 
					cmsPages 
				Where 
					Admin = 'N' 
				Order By 
					PageName";
 		$result = '';
 		$result.= '<table class="Grid" align="center">';
		
		$result .= '<tr><td>';
		$grid = new gridRenderer();
 		$grid->setTitle('Lista stron użytkownika');
		$grid->setGridAlign('center');
		$grid->setGridWidth(580);
		$grid->addColumn("PageName", 'Nazwa strony', 200, false, 'left');
		$grid->addColumn("ShortName", 'Nazwa techn.', 100, false, 'left');
		$grid->addColumn('Active', 'Aktywna', 55, false, 'center');
		$grid->addColumn('AuthorizedOnly', 'Autoryzacja', 55, false, 'center');
		$grid->addColumn('Desc', 'Opis', 100, false, 'left');
		$grid->addColumn("id", "", 200, true, 'right');
		$grid->addColumn('Value', '', 1, false, true, 'left');
    	$grid->callBackAction('window.opener.document.dFORM.txtNazwa.value');
    	 			
		$grid->setDataQuery($query);
		$result .= $grid->renderHtmlGrid(1);
		$result .= '</td></tr>';
		$result .= '</table>';
		
		return $result;
		
	}
	public function showPages()
	{
		$html = '';
		$module = new modulesMgr();
 		$module->loadModule('Pages');
 		$addAction = $module->getModuleActionIdByName('showAddPage');
 		$editAction = $module->getModuleActionIdByName('showEditPage');
 		$delAction =  $module->getModuleActionIdByName('delPage');
 		
 		$addButton = new button(buttonAddIcon, 'Dodaj stronę', $addAction, -1);
 		 		
 		$query = "
 				Select 
 					id, PageName, ShortName, Active, AuthorizedOnly, `Desc` 
				From 
					cmsPages 
				Where 
					Admin = 'N' 
				Order By 
					PageName";
 		
 		$html .= '<table class="Grid" align="center" cellspacing=0>';
 	   	$html .= '<tr>';
 	   	$html .= '<td width=50><img src="./Cms/Files/Img/about-48x48.png" /></td>';
 	   	$html .= '<td><br/></td>';
 	   	$html .= '</tr>';
 	   	$html .= '<tr><td align="right" colspan="2"><hr/>';
		$html .= $addButton->show(1);
		$html .= '</td></tr>';
		$html .= '<tr><td>';
			$grid = new gridRenderer();
 			$grid->setTitle('Lista stron użytkownika');
			$grid->setGridAlign('center');
			$grid->setGridWidth(780);
			$grid->addColumn("PageName", 'Nazwa strony', 100, false, false, 'left');
			$grid->addColumn("ShortName", 'Nazwa techn.', 100, false, false,  'left');
			$grid->addColumn('Active', '<center>Aktywna</center>', 20, false, false, 'center');
			$grid->addColumn('AuthorizedOnly', '<center>Autoryzacja</center>', 20, false, false, 'center');
			$grid->addColumn('Desc', 'Opis', 180, false, false,  'left');
			$grid->addColumn("id", "", 200, true, false, 'right');
 			$grid->enabledDelAction($delAction);
	 		$grid->enabledEditAction($editAction);
			$grid->setDataQuery($query);
		$html .=$grid->renderHtmlGrid(1);
		$html .= '</td></tr>';
		$html .= '<tr><td align="right" colspan="2">';
		$html .= $addButton->show(1);			
		$html .= '</td></tr>';
		$html .= '</table>';
			
		return $html;
	}
	public function showEditPage($pageId)
	{
		return $this->showAddPage($pageId);
	}
	public function editPageSave()
	{
		
	}
	public function showAddPage($id = 0)
	{
		saveActionValue();
		$html = '';
		$myForm = null;
		$myForm = new Form('pageFORM', 'POST') ;
		$pageAdd_form = null;
		$pageAdd_form = $myForm->getFormInstance();
		$pageAdd_form->addElement('header', ' hdrTest', 'Nowa strona - ustawienia główne');
		$elementName = $pageAdd_form->addElement('text', 'txtName', 'Nazwa strony', array('size' => 25, 'maxlength'=> 25));
		$elementShortName = $pageAdd_form->addElement('text', 'txtTechName', 'Nazwa techniczna(unikalna)', array('size' => 25, 'maxlength'=> 25));
		//--szablon
		$moduleTmp = new ModulesMgr();
     	$moduleTmp->loadModule('Pages');
     	$actionPage = $moduleTmp->getModuleActionIdByName('chooseTemplate');
     	unset($moduleTmp);
     			
		$template = $pageAdd_form->addElement('text', 'txtTemplate', 'Szablon', 'readonly="readonly"');
     	$buttonTemplate = $pageAdd_form->addElement('button', 'btnTemplate', 'wybierz...', '');
     	$buttonTemplateAttr = array('title'=>'Szablon', 'onclick'=>"return window.open('?a=$actionPage&onlycontent=1&idcol=hidden&namecol=txtTemplate', 'Wybór', 'menubar=0,location=0,directories=0,toolbar=0,resizable,dependent,width=730,height=400');");
   	    $buttonTemplate->updateAttributes($buttonTemplateAttr);
		//--
		$option_list = array();
		$option_list['']= '--Wybierz z listy--';
		$option_list['T'] = 'Tak';
		$option_list['N'] = 'Nie';
		$elementActive = $pageAdd_form->addElement('select', 'selActive', 'Aktywna', $option_list);
		$option_list1 = array();
		$option_list1['']= '--Wybierz z listy--';
		$option_list1['T'] = 'Tak';
		$option_list1['N'] = 'Nie';
		$elementAuth = $pageAdd_form->addElement('select', 'selAuth', 'Autoryzacja', $option_list1);
		$option_list1 = array();
		/*$option_list1['']= '--Wybierz z listy--';
		$option_list1['T'] = 'Tak';
		$option_list1['N'] = 'Nie';
		$elementAdmin = $pageAdd_form->addElement('select', 'selAdmin', 'Administracyjnq', $option_list1);*/
		
		$elementMT = $pageAdd_form->addElement('checkbox', 'cbTopMenu', 'Menu górne', null, null);
		$elementML = $pageAdd_form->addElement('checkbox', 'cbLeftMenu', 'Menu lewe', null, null);
		$elementMR = $pageAdd_form->addElement('checkbox', 'cbRightMenu', 'Menu prawe', null, null);
		$elementMB = $pageAdd_form->addElement('checkbox', 'cbBottomMenu', 'Menu dolne', null, null);
		
		$elementDesc = $pageAdd_form->addElement('textarea', 'Opis', 'Opis', array('cols'=>30, 'rows'=>3));
		
		$elementPageTitle = $pageAdd_form->addElement('text', 'txtPageTitle', 'Tytuł do Meta', array('size' => 25, 'maxlength'=> 255));		
		$elementPageDescription = $pageAdd_form->addElement('textarea', 'txtPageDescription', 'Opis do Meta', array('cols'=>30, 'rows'=>3));
		
		$elementId = $pageAdd_form->addElement('hidden', 'id', 'id');
								 		
	//  $adminAdd_form->addElement('hidden', 'a', $action, null);
		$pageAdd_form->addElement('reset', 'btnReset', 'Wyczyść');
		$pageAdd_form->addElement('submit', 'btnSubmit', 'Zapisz');
		$action1=1;
		//$pageAdd_form->addElement('hidden', 'a', $action1, null);
		
		$pageAdd_form->addRule('txtName', 'Wartośc pola nie może być pusta', 'required', null, 'server');
		$pageAdd_form->addRule('txtTechName', 'Wartośc pola nie może być pusta', 'required', null, 'server');
		
		$pageAdd_form->addRule('txtTemplate', 'Wartośc pola nie może być pusta', 'required', null, 'server');
		
		$pageAdd_form->applyFilter('__ALL__', 'trim');
		
		$myForm->setStyle(2);
		$elementId->setValue($id);
		if ($pageAdd_form->validate())
		{
			$pageAdd_form->freeze();
			
			$templateId = 0;
			$templateName = $template->getValue();
			
			$queryTemplate = "SELECT id from cmsTemplates Where ShortName='$templateName'";
			
			$data = $this->dbInt->ExecQuery($queryTemplate);
			$moduleRec = $data->fetchRow(DB_FETCHMODE_ASSOC);
			$templateId = $moduleRec['id'];
						
			$activeArray = $elementActive->getValue();
			//$adminArray = $elementAdmin->getValue();
			$authArray = $elementAuth->getValue();
			
			if ($elementMT->getValue() == 1)
				$mt = 'T';
			else
				$mt = 'N';
			
			if ($elementML->getValue() == 1)
				$ml = 'T';
			else
				$ml = 'N';
			if ($elementMR->getValue() == 1)
				$mr = 'T';
			else
				$mr = 'N';
			if ($elementMB->getValue() == 1)
				$mb = 'T';
			else
				$mb = 'N';
				
			$this->addPageSave($elementId->getValue(), $elementName->getValue(), $elementShortName->getValue(),
								$activeArray[0], 'N', $authArray[0],$elementDesc->getValue(), $templateId, $mt, $ml, $mr, $mb, $elementPageTitle->getValue(), $elementPageDescription->getValue());
			
			$module = new ModulesMgr();
			$module->loadModule('Pages');
			
			if ($elementId->getValue() == 0)
			{
				$okAction = $module->getModuleActionIdByName('showPages');	
			}
			else
			{
				$okAction = $module->getModuleActionIdByName('showPages');
			}
			$menuMgr = MenuMgr::getInstance();
			
			if ($_SESSION['m'] == $menuMgr->getMenuIdByName('Menu'))
				$okAction = $module->getModuleActionIdByName('showMenuList');
			
			$dialog = new dialog('Zapis danych' , 'Dane zapisane', 'info', 300, 150);
			$dialog->setAlign('center');
			$dialog->setOkCaption('Ok');
			$dialog->setOkAction($okAction);
			$html .= $dialog->show(1);		
			
		}
		else
		{
			if ($id > 0)
			{
				$query = "
					SELECT
						t.ShortName 
					FROM
						cmsTemplates t INNER JOIN cmsPages p
							ON t.id = p.TemplateId 
					WHERE
						p.id = $id;
					";
				
				$data = $this->dbInt->ExecQuery($query);
				$moduleRec = $data->fetchRow(DB_FETCHMODE_ASSOC);
				$template->setValue($moduleRec['ShortName']);
				
				$queryEdit = "
					SELECT
						`PageName`, `ShortName`, `Active`, `Admin`, `AuthorizedOnly`, `Desc`,
						`MenuTop`, `MenuLeft`,`MenuRight`,`MenuBottom`, `PageDescription`, `PageTitle`
					FROM
						cmsPages
					WHERE
						id = $id;
					";
				
				$data = $this->dbInt->ExecQuery($queryEdit);
				$moduleRec = $data->fetchRow(DB_FETCHMODE_ASSOC);
								 
				$elementName->setValue($moduleRec['PageName']);
				$elementShortName->setValue($moduleRec['ShortName']);
				$elementActive->setValue($moduleRec['Active']);
				$elementAuth->setValue($moduleRec['AuthorizedOnly']);
				$elementDesc->setValue($moduleRec['Desc']);
							 
				$elementMT->setValue(($moduleRec['MenuTop']=='T'));
				$elementML->setValue(($moduleRec['MenuLeft']=='T'));
				$elementMR->setValue(($moduleRec['MenuRight']=='T'));
				$elementMB->setValue(($moduleRec['MenuBottom']=='T'));
				
				$elementPageTitle->setValue($moduleRec['PageTitle']); 
				$elementPageDescription->setValue($moduleRec['PageDesciption']);
			}
			else
			{
				$query = "
					SELECT
						ShortName 
					FROM
						cmsTemplates
					WHERE
						Main = 'T';
					";
				
				$data = $this->dbInt->ExecQuery($query);
				$moduleRec = $data->fetchRow(DB_FETCHMODE_ASSOC);
								 
				$template->setValue($moduleRec['ShortName']);
				
				$elementMT->setValue(1);
				$elementML->setValue(1);
				$elementMR->setValue(0);
				$elementMB->setValue(1);
				
			}
			$html .= '<table width="700" align="center"><tr><td>';
			$html .= $pageAdd_form->toHtml();
			
				
			
			if ($id > 0)
			{
				$moduleTmp = new ModulesMgr();
				$moduleTmp->loadModule('Sections');
				$addSectionAction = $moduleTmp->getModuleActionIdByName('addSection');
				$params = array();
				$html .= '</td></tr><tr><td>
					  <table width = "100%" class="Grid" >';
				$html .= '<tr><td align="right">';
				$html .= $moduleTmp->moduleExecuteAction('showPageSections', $params);
				
				
				$moduleTmp = new ModulesMgr();
				$moduleTmp->loadModule('FrontendModules');
				$cancelAction = $moduleTmp->getModuleActionIdByName('showMenuList');
				$cancelAction1 = $moduleTmp->getModuleActionIdByName('showPages');
				unset($moduleTmp);
			
			$html .= '</td></tr><tr><td>
					  <table width = "100%" class="Grid" >';
			$html .= '<tr><td align="right">';
				$buttonChgPass = new button('./Cms/Files/Img/delete-16x16.png', 'Powrót do menu', $cancelAction, -1);
			$html .= $buttonChgPass->show(1);
				$buttonChgPass = new button('./Cms/Files/Img/delete-16x16.png', 'Powrót do listy stron', $cancelAction1, -1);
			$html .= $buttonChgPass->show(1);
			
			$html .= '</td></tr>';
			$html .= '</table>';				
							
			}
			$html .= '</td></tr></table>';
			
		//	$pageAdd_form->Display();
		}
		return $html;
	}
	
	public function addPageSave($id, $pageName, $shortName, $active, $admin, $authorizedOnly, $desc, $template, $mt, $ml, $mr, $mb, $pageTitle, $pageDecription)
	{
		$tmpMenuMgr = new PagesMgr();
				
		if ($id == 0)
		{
			return $tmpMenuMgr->addPage($pageName, $shortName, $active, $admin , $authorizedOnly, $desc, $template, $mt, $ml, $mr, $mb, $pageTitle, $pageDescription);
		}
		else
		{
			return $tmpMenuMgr->modifyPage($id, $pageName, $shortName, $active, $admin , $authorizedOnly, $desc, $template, $mt, $ml, $mr, $mb,$pageTitle, $pageDescription);			
		}
		unset($tmpMenuMgr);
	}
	
	public function delPage($pageId)
	{
		$html = '';
 		$module = new ModulesMgr();
		$module->loadModule('Pages');
		$cancelAction = $module->getModuleActionIdByName('ShowPages');
		$okAction = $module->getModuleActionIdByName('delPageDo');
		$dialog = new dialog('Usuwanie' , 'Czy usunąć stronę?', 'Query', 300, 150);
		$dialog->setAlign('center');
		$dialog->setOkCaption('Tak');
		$dialog->setOkAction($okAction);
		$dialog->setCancelAction($cancelAction);
		$dialog->setCancelCaption('Nie');
		$dialog->setId($pageId);
		$html .= $dialog->show(1);
 			
		return $html;		
	}
	public function delPageDo($pageId)
	{
		$html = '';
 		$delQuery = "DELETE FROM cmsPages WHERE id=$pageId";
 		$dbInt = DBSingleton::getInstance();
 		$dbInt->ExecQuery($delQuery);
		
 		$module = new ModulesMgr();
		$module->loadModule('Pages');
		$okAction = $module->getModuleActionIdByName('ShowPages');
		$dialog = new dialog('Usuwanie' , 'Usunięto stronę i przypisane do niej sekcje', 'Info', 300, 150);
		$dialog->setAlign('center');
		$dialog->setOkCaption('Ok');
		$dialog->setOkAction($okAction);
		$html .= $dialog->show(1);
 			
		return $html;		 
	}
	public function genPages()
	{
		$tmpPageMgr = new PagesMgr();
		$menuMgr = MenuMgr::getInstance();
		$sectionsMgr = new SectionsMGR();
		
		$sqlMenu = "
			SELECT
				id, Name, ShortName, FK_PageId
			FROM
				cmsMenu
			WHERE
				FK_PageId is null
			
			";
		
		$dbResult = $this->dbInt->ExecQuery($sqlMenu);
		$i=0;
		while ($data = $dbResult->fetchRow(DB_FETCHMODE_ASSOC))
		{
			$tmpPageMgr->addPage(
							$data['Name'],
							$data['ShortName'],
							'T',
							'N',
							'N',
							'',
							1);
			$menuMgr->setMenuItemPage($data['ShortName'], $data['ShortName']);
			$sectionsMgr->addPageSection($data['Name'].' Sect', $data['ShortName'].'Sect', 1, $data['ShortName'], $data['Name']);
			$sectionsMgr->assignSectionToPage($data['ShortName'].'Sect', $data['ShortName']);
			$i++;
			
		}
		$tmpModule = new ModulesMgr();
		$tmpModule->loadModule('FrontendMenu');
 		$okAction = $tmpModule->getModuleActionIdByName('showMenuList');
			
		$dialog = new dialog('Zapis danych' , "Wygenerowano $i stron", 'info', 300, 150);
		$dialog->setAlign('center');
		$dialog->setOkCaption('Ok');
		$dialog->setOkAction($okAction);
		$html =$dialog->show(1);
		return $html;
	}
	
	/**
	 * Pokazuje listę szablonów
	 * 
	 * @author Piotr Brodziński 
	 * @access public
	 *  
	 */
	public function pagesTemplates()
	{
		
		$result = '';
		
		$tmpModule = new modulesMgr();
 		$tmpModule->loadModule('Pages');
 		$editAction = $tmpModule->getModuleActionIdByName('pagesTemplatesEdit');
 		$delAction = $tmpModule->getModuleActionIdByName('pagesTemplatesDelete');
 		$addAction = $tmpModule->getModuleActionIdByName('pagesTemplatesAdd');
 		unset($tmpModule);
		
		$query = "
			SELECT 
				id, Name, ShortName, Icon, Path, FileName, Main
			FROM
				cmsTemplates				
				";
		
		$result .=  '<table class="Grid" align="center" cellspacing="0">';
		$result .=   '<tr><td>';
		$grid = new gridRenderer();
 		$grid->setTitle('Lista szablonów');
		$grid->setGridAlign('center');
		$grid->setGridWidth(750);
		$grid->addColumn('Main', 'Szablon główny', 10, false, false,  'center');
		$grid->addColumn("Name", 'Nazwa szablonu', 100, false, false, 'left');
		$grid->addColumn("ShortName", 'Nazwa techn.', 100, false, false,  'left');
		  	    
		$grid->addColumn('Path', 'Ściezka', 150, false, false, 'left');
		$grid->addColumn('FileName', 'Plik szablonu', 120, false, false,  'left');
		$grid->addColumn("id", "", 200, true, false, 'right');
 		$grid->enabledDelAction($delAction);
	 	$grid->enabledEditAction($editAction);
		$grid->setDataQuery($query);
		
		$result .= $grid->renderHtmlGrid(1);
		$result .= '</td></tr>';
		$result .= '<tr><td align="right">';
		$addButton = new button(buttonAddIcon, 'Dodaj szablon', $addAction, -1);
		$result .= $addButton->show(1);
		$result .= '</td><tr>';
		$result .='</table>';
			
		
		return $result;
		
	}
	
	public function addTemplate($id = 0)
	{
		$html = '';
		$html .= '<table width="750" align="center"><tr><td>';
		$myForm = null;
		$myForm = new Form('dFORM', 'POST');
		$templateForm = $myForm->getFormInstance();
		$templateForm->addElement('header', ' hdrTest', 'Edycja/dodawnie eszablonu');
		
		$glownyList['T'] = 'Tak';
		$glownyList['N'] = 'Nie';
		$elementGlowny = $templateForm->addElement('select', 'selGlowny' ,'Szablon główny', $glownyList);
		
		$elementNazwa = $templateForm->addElement('text', 'txtNazwa', 'Nazwa szablonu', array('size' => 20, 'maxlength'=> 25));
		$elementNazwaTechn = $templateForm->addElement('text', 'txtShortNazwa', 'Nazwa techniczna', array('size' => 20, 'maxlength'=> 25));
		$elementPath = $templateForm->addElement('text', 'txtPath', 'Ścieżka do pliku', array('size' => 93, 'maxlength'=> 100));
		$elementFileName = $templateForm->addElement('text', 'txtFileName', 'Plik szablonu TPL', array('size' => 93, 'maxlength'=> 100));
		$elementTemplateContent = $templateForm->addElement('textarea', 'Content', 'Kod szbalonu', array('cols'=>70, 'rows'=>25));
		$elementId = $templateForm->addElement('hidden', 'id', 'elementId'); 
		$templateForm->addElement('reset', 'btnReset', 'Wyczyść');
		$templateForm->addElement('submit', 'btnSubmit', 'Zapisz');
		
		$templateForm->addRule('txtNazwa', 'Pole "Nazwa" musi być wypełnione', 'required', null, 'server');
      	$templateForm->addRule('txtShortNazwa', 'Pole "Nazwa techniczna" musi być wypełnione', 'required', null, 'server');
      	$templateForm->addRule('txtFileName', 'Pole "Plik szablonu" musi być wypełnione', 'required', null, 'server');
      	   	
		
    	$myForm->setStyle(2);
		$elementId->setValue($id);
				
		if ($templateForm->validate())
		{
			$templateForm->freeze();
			$id = $elementId->getValue();
			$glownyArray = $elementGlowny->getValue();
			$glowny = $glownyArray[0];
			$name = $elementNazwa->getValue();
			$shortName = $elementNazwaTechn->getValue();
			$path = $elementPath->getValue();
			$fileName = $elementFileName->getValue();
			$content = $elementTemplateContent->getValue();
						
			if ($this->saveTemplateData($id, $name, $shortName, $path, $fileName, $glowny, $content))
			{
				$tmpModule = new ModulesMgr();
				$tmpModule->loadModule('Pages');
 				$okAction = $tmpModule->getModuleActionIdByName('pagesTemplates');
				
				$dialog = new dialog('Zapis danych' , 'Szablon zapisany', 'info', 300, 150);
				$dialog->setAlign('center');
				$dialog->setOkCaption('Ok');
				$dialog->setOkAction($okAction);
				$html .=$dialog->show(1);		
			}
		}
		else
		{
			if ($id != 0)
			{
				$query = "
					SELECT 
						id, Name, ShortName, Icon, Path, FileName, Main
					FROM
						cmsTemplates
					WHERE
						id=$id				
					";			
				
				$result = $this->dbInt->ExecQuery($query);
				$data = $result->fetchRow(DB_FETCHMODE_ASSOC);
				$elementGlowny->setValue($data['Main']);
				$elementNazwa->setValue($data['Name']);
				$elementNazwaTechn->setValue($data['ShortName']);
				$elementPath->setValue($data['Path']);
				$elementFileName->setValue($data['FileName']); 
				$elementTemplateContent->setValue($this->readTemplateContent($data['Path'].$data['FileName'])); 		
			}
			$constants = array();
			$constants['txtPath'] = SMARTY_TEMPLATE_DIR;
			$templateForm->setConstants($constants);
			$html .= $templateForm->toHtml();
		}
		return $html;
				
	}
	private function readTemplateContent($file)
	{
		try
		{
			$content = '';
			$plik = fopen ($file, 'r');
			if (filesize($file)>0)
			{
				$content = fread($plik, filesize($file));
				fclose($plik);
			}
			return $content;
	
		}
		catch (exception $e)
		{
			fclose($plik);
		}
				
	}
	private function saveTemplateData($id, $name, $shortName, $path, $fileName, $glowny, $content)
	{
		try
		{
		//1. Nadpisuję plik *tpl
		//2. Tworzę rekord bazy danych
			$nazwaPliku = $path.$fileName;
			
			$plik = fopen ($nazwaPliku, 'w+');
			
			if (fwrite($plik, $content) === FALSE)
   			{
       			throw new exception("Nie mogę zapisać do pliku ($nazwaPliku)");
       			exit;
    		}
    		fclose($plik);
    		
    		//zapis do bazy
    		
    		if ($id == 0)
    		{
    			$query = "
    				INSERT INTO cmsTemplates (Main, Name, ShortName, Path, FileName)
    				VALUES('$glowny','$name', '$shortName', '$path', '$fileName');
    				";	
    		}
    		else
    		{
    			$query = "
    				UPDATE cmsTemplates SET 
    					Main = '$glowny', Name='$name', ShortName = '$shortName', Path = '$path', FileName='$fileName'
    				WHERE
    					id = $id
    				"; 
    				
    		}
    		$this->dbInt->ExecQuery($query);
			return true;
		}
		catch (exception $e)
		{
			
		}
				
	}
	
	public function delTemplate($templateId)
	{
		$html = '';
 		$delQuery = "DELETE FROM cmsTemplates WHERE id=$templateId";
 		$dbInt = DBSingleton::getInstance();
 		$dbInt->ExecQuery($delQuery);
		
 		$module = new ModulesMgr();
		$module->loadModule('Pages');
		$okAction = $module->getModuleActionIdByName('PagesTemplates');
		$dialog = new dialog('Usuwanie' , 'Usunięto szablon', 'Info', 300, 150);
		$dialog->setAlign('center');
		$dialog->setOkCaption('Ok');
		$dialog->setOkAction($okAction);
		$html .= $dialog->show(1);
 			
		return $html;		 
	}
	
	public function editTemplate($templateId)
	{
		
	}
	
	public function chooseTemplate()
	{
		$query = "
			SELECT 
				id, Name, ShortName, ShortName as Value, FileName
			FROM
				cmsTemplates				
				";
 		
 		
 		$result = '';
 		$result .= '<table class="Grid" align="center" cellspacing=0>';
 	   	 	   	
 	   	$result .= '<tr><td colspan="2">';
 	   	
 	   	$templateListGrid=new gridRenderer();
 	   	$templateListGrid->setTitle('Lista szablonów SMARTY');
    	$templateListGrid->setGridAlign('center');
    	$templateListGrid->setGridWidth(680);
    	
    	$templateListGrid->addColumn('Name', 'Pełna nazwa', 200, false, false, 'left');
    	$templateListGrid->addColumn('ShortName', 'Nazwa techn.', 100, false, false, 'left');
    	$templateListGrid->addColumn('FileName', 'Nazwa pliku', 100, false, false, 'left');
    	$templateListGrid->addColumn('Value', 'aaa', 100, false, true, 'left');
    	$templateListGrid->addColumn('id', 'aaa', 100, true, false, 'left');
    	$templateListGrid->callBackAction('window.opener.document.pageFORM.txtTemplate.value');
    	//$menuListGrid->enabledEditAction(13);
    	$templateListGrid->setDataQuery($query);
    	$result .= $templateListGrid->renderHtmlGrid(1);
    	
    	$result .= '</td></tr>';
    	$result .= '</table>';
    			
    	restoreActionValue();
    	return $result;
    	
	}
	
	
}
?>
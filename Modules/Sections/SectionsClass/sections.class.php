<?php
/**
 * Moduł zarządzania sekcjami stron Frontend
 *
 */

class sectionsClass
{
	private function saveHtmlContent($sectionId,$pageId, $content)
	{
		//sectionId nie może być < 1
		try
		{
			//$content = stripslashes($_POST['FCKeditor1']);
			//$content =$content;
			$content = $content;
			$query = "
				UPDATE cmsSections SET Content = '$content'
				WHERE id=$sectionId";
			
			$dbInt = DBSingleton::getInstance();

			$dbInt->ExecQuery($query);
			
			return true;
		}
		catch (exception $e)
		{
			//tu obsługa EXC
			return false;
		}
	}
	private function saveModuleContent($pageId, $sectionId, $moduleId, $moduleAction, $param)
	{
		try
		{
			
			$query = "
				UPDATE cmsSections Set
					FK_ModuleId = $moduleId, FK_ModuleAction = $moduleAction, Content='$param'
				WHERE
					id = $sectionId
				";
				
			$dbInt = DBSingleton::getInstance();
			$dbInt->ExecQuery($query);	
			
			$moduleTmp = new ModulesMgr();
			$moduleTmp->loadModule('Pages');
			$okAction = $moduleTmp->getModuleActionIdByName('showEditPage');
			unset($moduleTmp);
			
			$dialog = new dialog('Zapis sekcji', 'Sekcja została zapisana', 'info', 300, 150);
        	$dialog->setAlign('center');
        	$dialog->setOkCaption('Ok');
        	$dialog->setOkAction($okAction);
        	$dialog->setId($pageId);
        	return $dialog->show(1);
			
		}
		catch (exception $e)
		{
			//tu obsługa EXC
			return false;
		}
	
	}
	
	private function editHtmlSectionContent($sectionId)
	{
		echo 'HTML';
		$html = '';
		include './fckeditor/fckeditor_php5.php';
		
		if (isset($_POST['sectionId']))
		{
			echo "1";
			$sectionId = $_POST['sectionId'];
			$pageId = $_POST['pageId'];
			$content = $_POST['content'];
			
			if ($this->saveHtmlContent($sectionId,$pageId, $content))
			{
				$moduleTmp = new ModulesMgr();
				$moduleTmp->loadModule('Pages');
				$okAction = $moduleTmp->getModuleActionIdByName('showEditPage');
				unset($moduleTmp);
        		        		
        		$dialog = new dialog('Zapis sekcji', 'Sekcja została zapisana', 'info', 300, 150);
        		$dialog->setAlign('center');
        		$dialog->setOkCaption('Ok');
        		$dialog->setOkAction($okAction);
        		$dialog->setId($pageId);
        		$html .= $dialog->show(1);
			}
			else
			{
				//tu dialofg nie ok
				echo "2";
			}
			
		
		}
		else
		{
			$pageId = $_GET['pageId'];
			 
			$moduleTmp = new ModulesMgr();
			$moduleTmp->loadModule('Sections');
			$saveHtmlAction = $moduleTmp->getModuleActionIdByName('editSectionContent');
			
			//$objFCKeditor = new FCKEditor('content');
			//$objFCKeditor->BasePath = '../fckeditor/';
							
			$html .= '	<form name="htmlEdit" action ="?a='.$saveHtmlAction.'" method="post" >
					<table class="Grid" align="center" width="800">
					<tr>
						<td width="40">
							<img src="../Cms/Files/Img/about-48x48.png" />			
						</td>
						<td>
							Uwaga!!!Nie jest zalecane korzystanie z edytora WYSIWYG!
						</td>
					</tr>
					<tr><td colspan="2"><hr/>';
			$html .= 		"<div class=\"loginInfoBold\">Strona: ; Sekcja: ;</div>";
			$html .=	'</td><tr>
					<tr valign="top"><td colspan="2" height="450"><hr/>';
						
						$objFCKeditor->Height = 450;
						
						if ($sectionId != 0)
						{
							$query = "
								SELECT 
									Content
								FROM
									cmsSections
								WHERE
									id = $sectionId
									";
									
							$dbInt = DBSingleton::getInstance();
							$result = $dbInt->ExecQuery($query);
							$contentData = $result->fetchRow(DB_FETCHMODE_ASSOC);
							
							$content = htmlspecialchars($contentData['Content']);
							//$objFCKeditor->Value = $content; 
						}
			$html .= "<TEXTAREA name=\"content\" rows=\"100\" cols=\"100\" scrollbars=\"1\">$content</TEXTAREA>";
		
			//$objFCKeditor->CreateHtml();
			$html .= 	'</td><tr>
					<tr><td colspan="2"><input type="hidden" name="sectionId" value="'.$sectionId.'" />
							<input type="hidden" name="pageId" value="'.$pageId.'" />								
							<input type="submit" value="Zapisz" /></td></tr>
				</table>
				</form>';
			$html .= '<table class="Grid" align="center" cellspacing=0 width="800">';
 	   		$html .= '<tr>';
 	   		$html .= '<td align="right">';
 	   		$module = new modulesMgr();
 			$module -> loadModule('Pages');
 			$action = $module->getModuleActionIdByName('showEditPage');
 	   		$addButton = new button(buttonAddIcon, 'Anuluj', $action, $pageId);
 	   		$html .=$addButton->show(1);
 	   		$html .= '</td></tr></table>';
		}
				
		return $html;
	}

	private function editModuleSectionContent($sectionId)
	{
		//1. Wczytuje akcje modułów - tylko Admin = N
		//2.  	
		echo 'sdss';	
		$html = '';
		if (isset($_POST['sectionId']))
		{
			$sectionId = $_POST['sectionId'];
			$pageId = $_POST['pageId'];
		}
		else
		{
			$pageId = $_GET['pageId'];
		}
			
		$moduleTmp = new ModulesMgr();
     	$moduleTmp->loadModule('CmsModules');
     	$actionPage = $moduleTmp->getModuleActionIdByName('showModulesActionsChoose');
		unset($moduleTmp);
     	
		saveActionValue();
		
		$myForm = null;
		$myForm = new Form('sectionContentForm', 'POST') ;
		$sectionContentForm = null;
		$sectionContentForm = $myForm->getFormInstance();
		$sectionContentForm->addElement('header', ' hdrTest', 'Zawartość sekcji');
		
		$moduleA = $sectionContentForm->addElement('text', 'txtModule', 'Akcja', 'readonly="readonly"');
		$buttonPage = $sectionContentForm->addElement('button', 'btnShortNazwa', 'wybierz...', '');
		$module = $sectionContentForm->addElement('text', 'txtModuleOfAction', 'Moduł', 'readonly="readonly"');
     	$buttonPageAttributes = array('title'=>'asdasd', 'onclick'=>"return window.open('?a=$actionPage&onlycontent=1&idcol=hidden&namecol=txtStrona', 'Wybór', 'menubar=0,location=0,directories=0,toolbar=0,resizable,dependent,width=600,height=400');");
   	    $buttonPage->updateAttributes($buttonPageAttributes);
   	    $paramVal = $sectionContentForm->addElement('text', 'txtModuleOfParam', 'Parametr');
   	    $sectionIdElement = $sectionContentForm->addElement('hidden', 'sectionId');
   	    $pageIdElement = $sectionContentForm->addElement('hidden', 'pageId');
   	    
   	    $sectionContentForm->addElement('reset', 'btnReset', 'Wyczyść');
      	$sectionContentForm->addElement('submit', 'btnSubmit', 'Zapisz');
   	    
		$myForm->setStyle(2);
		
		if ($sectionContentForm->validate())
        {
        	//$_SESSION['m'] = -1;
        	$sectionContentForm->freeze();
        	$moduleTmp = new ModulesMgr();
        	
        	$actionId = $moduleTmp->getModuleActionIdByName($moduleA->GetValue());
        	
        	$moduleId = $moduleTmp->getModuleIdByName($moduleTmp->getModuleNameByActionId($actionId));
        	$param = $paramVal->GetValue();        	
        	$html = $this->saveModuleContent($pageId, $sectionId,$moduleId, $actionId, $param);
        }
        else
        {
        	
        	$sectionIdElement->setValue($sectionId);
        	$pageIdElement->setValue($pageId);
        	 
        	//$moduleA->SetValue()
        	$html .= '<table width = "490" align="center"><tr><td>';
        	$html .= $sectionContentForm->toHtml();
        	$html .= '</td></tr>';
        	$html .= '</table>';
        }
		
        return $html;
	}
	
	public function editSectionContent($sectionId)
	{
		echo $sectionId;
		$sectionMgr = new SectionsMgr();
		$sectionKind = $sectionMgr->getSectionKind($sectionId);
		 
		if ($sectionKind == 'html')
		{
			return $this->editHtmlSectionContent($sectionId);			
		}
		else
		{
			return $this->editModuleSectionContent($sectionId);
		}
	}
	
	public function showPageSections($pageId)
	{ 
		$query = "
					SELECT
						s.id as sectionId, p.id as pageId, s.Name, s.ShortName, s.Priority, 
						CASE
						  WHEN s.ContentType = 0 THEN 'HTML'
						  WHEN s.ContentType = 1 THEN 'PHP'
						END as Content, 
						sp.Language, 
						CASE
							WHEN p.ShortName IS NULL THEN '<font color=\"red\">Brak</font>'
							ELSE p.ShortName
						END AS Page												  
					FROM
						cmsSections s 
							INNER JOIN cmsSectionsToPages sp ON (s.id = sp.PK_SectionId)
							INNER JOIN cmsPages p ON (p.id = sp.PK_PageId)
					WHERE
						p.id = $pageId
					ORDER BY
						s.Priority
						";
				
				$result = '';
				$result .= '<table class="Grid" align ="center"><tr><td>';
				$tmpModuleMgr = new ModulesMgr();
				$tmpModuleMgr->loadModule('Sections');
				$delAction = $tmpModuleMgr->getModuleActionIdByName('delSection');
				$editAction = $tmpModuleMgr->getModuleActionIdByName('editSection');
				$addSectionAction = $tmpModuleMgr->getModuleActionIdByName('addSection');
				$editContent =  $tmpModuleMgr->getModuleActionIdByName('editSectionContent');
				
				$grid = new gridRenderer();
				$grid->setTitle('Sekcje strony');
				$grid->setGridAlign('center');
				$grid->setGridWidth(680);
				$grid->addColumn('Name', 'Nazwa', 150, false,false,  'left');
				$grid->addColumn('ShortName', 'Nazwa techn', 150, false, false, 'left');
				$grid->addColumn('Priority', 'Priorytet', 15, false, false, 'center');
				$grid->addColumn('Content', 'Zawartość', 50, false, false, 'center');
				$grid->addColumn('Language', 'Język ', 25, false, false, 'center');
				$grid->addColumn('sectionId', '', 200, true, false, 'right');
				$grid->addOtherArgs('pageId', $pageId);
 				$grid->enabledDelAction($delAction);
 				$grid->enabledEditAction($editAction);
 				$grid->enabledChooseAction($editContent);
 				//$grid->addOtherArgs('moduleid', $id);
 				 		
				$grid->setDataQuery($query);
				$result .= $grid->renderHtmlGrid(1);
				$result.= '</td></tr>';
				$result .= '<tr><td align="right">';
				$addSectionButton = new button(buttonAddIcon, 'Dodaj sekcję', $addSectionAction, $pageId);
    			$result .= $addSectionButton->show(1);
    			$result .= '</td></tr></table>';
    			return $result;			
	}
	
	public function delSection($sectionId)
	{
		echo 'del';
	}
	
	public function addSection($pageId, $sectionId = 0)
	{
		$html = '';
		$myForm = null;
		$myForm = new Form('sectionForm', 'POST') ;
		$sectionAddForm = null;
		$sectionAddForm = $myForm->getFormInstance();
		$sectionAddForm->addElement('header', ' hdrTest', 'Nowa strona - ustawienia główne');
		$elementName = $sectionAddForm->addElement('text', 'txtName', 'Nazwa sekcji', array('size' => 25, 'maxlength'=> 25));
		$elementShortName = $sectionAddForm->addElement('text', 'txtShortName', 'Nazwa techn. sekcji', array('size' => 25, 'maxlength'=> 25));
		$elementPriority = $sectionAddForm->addElement('text', 'txtPriority', 'Kolejność', array('size' => 10, 'maxlength'=> 10));
		
		$optContentTypeList = array('0'=>'Strona HTML', '1'=>'Moduł PHP'); 
     	$elementContentType = $sectionAddForm->addElement('select', 'selContentType' ,'Zawartość sekcji', $optContentTypeList);
		
     	$option_list = array();
		//$option_list[''] = '--Wybierz z listy--';
		
		$query = "
				SELECT 
					Name, ShortName  
				FROM 
				  	cmsLang 
				ORDER BY 
				  	ShortName";
		
		$dbInt = DBSingleton::getInstance();
		$result = $dbInt->ExecQuery($query);
		
		while ($userData = $result->fetchRow(DB_FETCHMODE_ASSOC)) 
		{
			$option_list[$userData['ShortName']] = $userData['Name'];
		}
		
		$elementLang = $sectionAddForm->addElement('select', 'selLang' ,'Język sekcji', $option_list);	
		    	
     	$elementSectionId = $sectionAddForm->addElement('hidden', 'id', 'id');
		$elementPageId = $sectionAddForm->addElement('hidden', 'pageId', 'pageId');
				
		$sectionAddForm->addElement('reset', 'btnReset', 'Wyczyść');
		$sectionAddForm->addElement('submit', 'btnSubmit', 'Zapisz');
		$myForm->setStyle(2);
		
		$elementSectionId->setValue($sectionId);
		$elementPageId->setValue($pageId);
		
		$sectionAddForm->addRule('txtName', 'Proszę wypełnić pole nazwa!', 'required', null, 'server');
		$sectionAddForm->addRule('txtShortName', 'Proszę wypełnić pole nazwa techniczna!', 'required', null, 'server');
		$sectionAddForm->addRule('txtPriority', 'Proszę wypełnić pole Kolejonść!', 'required', null, 'server');
		$sectionAddForm->addRule('txtPriority', 'Zła wartość w polu Kolejność!', 'numeric', null, 'server');
		if ($sectionAddForm->validate())
        {
        	$sectionAddForm->freeze();
        	
        	$contentTypeArray = $elementContentType->getValue();
        	$langArray = $elementLang->getValue();
        	
        	$pageId = $elementPageId->getValue();
        	$sectionId = $elementSectionId->getValue();
        	
        	$name = $elementName->getValue();
        	$shortName = $elementShortName->getValue();
        	$priority = $elementPriority->getValue();
        	$contentType = $contentTypeArray[0];
        	$lang = $langArray[0];
        	
        	if ($this->saveSectionData($pageId, $sectionId, $name, $shortName, $priority, $contentType, $lang))
        	{
        		$moduleTmp = new ModulesMgr();
				$moduleTmp->loadModule('Pages');
				$okAction = $moduleTmp->getModuleActionIdByName('showEditPage');
				unset($moduleTmp);
        		        		
        		$dialog = new dialog('Zapis sekcji', 'Sekcja została zapisana', 'info', 300, 150);
        		$dialog->setAlign('center');
        		$dialog->setOkCaption('Ok');
        		$dialog->setOkAction($okAction);
        		$dialog->setId($pageId);
        		$html .=$dialog->show(1);
        	}
        }
        else
        {
        	if ($sectionId != 0)
        	{
        		$sectionQuery = "
        			SELECT
						s.id, s.Name, s.ShortName, s.Priority, s.ContentType, sp.Language									  
					FROM
						cmsSections s 
							INNER JOIN cmsSectionsToPages sp ON (s.id = sp.PK_SectionId)
							INNER JOIN cmsPages p ON (p.id = sp.PK_PageId)
					WHERE
						s.id = $sectionId				
						";
        		$result = $dbInt->ExecQuery($sectionQuery);
				$sectionData = $result->fetchRow(DB_FETCHMODE_ASSOC);
				$elementName->setValue($sectionData['Name']);
				$elementShortName->setValue($sectionData['ShortName']);
				$elementPriority->setValue($sectionData['Priority']);
				$elementContentType->setValue($sectionData['ContentType']);
				$elementLang->setValue($sectionData['Language']);
        	}
        	
        	$html .= '<table align="center" width="590" cellpadding=0 cellspacing=0 border=0><tr><td>';
        	$html .= $sectionAddForm->toHtml();
        	        	
        	$moduleTmp = new ModulesMgr();
			$moduleTmp->loadModule('Pages');
			$cancelAction = $moduleTmp->getModuleActionIdByName('showEditPage');
			unset($moduleTmp);
		
			$html .= '</td></tr><tr><td>
					  <table width = "100%" class="Grid" >';
			$html .= '<tr><td align="right">';
			$buttonCancel = new button('../Cms/Files/Img/delete-16x16.png', 'Anuluj', $cancelAction, $pageId);
			$html .= $buttonCancel->show(1);
			
			$html .= '</td></tr>';
			$html .= '</table>';
        }
        return $html;
	}
	
	private function saveSectionData($pageId, $sectionId, $name, $shortName, $priority, $contentType, $lang)
	{
		try
		{
			$dbInt = DBSingleton::getInstance();
			if ($sectionId == 0)//nowa sekcja - insert
			{
				$query1 = "
					INSERT INTO 
						cmsSections(Name, ShortName, Priority, ContentType)
					VALUES
						('$name', '$shortName', $priority, $contentType)
						";
				
				$query2 = "
					INSERT INTO 
						cmsSectionsToPages(Pk_PageId, PK_SectionId, Language)
					VALUES
						($pageId, (SELECT id FROM cmsSections WHERE ShortName='$shortName'), '$lang')
						";
				
	 			$dbInt->ExecQuery($query1);
	 			$dbInt->ExecQuery($query2);
			}
			else //update
			{
				$query1 = "
					UPDATE cmsSections SET
						Name = '$name', ShortName='$shortName', Priority=$priority, ContentType=$contentType
					WHERE
						id = $sectionId						
						";
						
				$query2 = "
					UPDATE cmsSectionsToPages SET
						Language = '$lang'
					WHERE
						PK_SectionId = $sectionId
					";
				
				$dbInt->ExecQuery($query1);
				$dbInt->ExecQuery($query2);
				
			}
			return true;
		}
		catch (exception $e)
		{
			$exc = new ExceptionClass($e, 'saveSectionData');
   			$exc->writeException();   
			return false;
		}
	}
}

?>
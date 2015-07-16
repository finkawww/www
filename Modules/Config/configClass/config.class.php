<?php
/**
 *
 * Klasa config realizuje funcjonalność ustawień konfiguacyjnych strony.
 * Umożliwia okreslenie znaczników <meta> oraz <title>, ustawić język 
 * domyślny. 
 * @access public
 * @author Piotr Brodziński
 * 
 */

class configClass
{
	private $DBInt = null;
		
	public function __construct()
	{
		$this->DBInt = DBSingleton::GetInstance();
	}
	
	public function testUniqueShortName($val)
 	{
 		$res = true;
 		
 		$DBInt = DBSingleton::getInstance();
 		$sql = "SELECT COUNT(id) as ile FROM cmsLang WHERE ShortName='$val'";
 		$dbResult = $DBInt->ExecQuery($sql);
 	    $recData = $dbResult->fetchRow(DB_FETCHMODE_ASSOC);
		
 	    $ile = $recData['ile'];

		if ($ile == 0)
			$res  = true;
		else
			$res = false;
 		
 		return $res;
 	}
	public function testUniqueName($val)
 	{
 		$res = true;
 		
 		$DBInt = DBSingleton::getInstance();
 		$sql = "SELECT COUNT(id) as ile FROM cmsMenu WHERE Name='$val'";
 		$dbResult = $DBInt->ExecQuery($sql);
 	    $recData = $dbResult->fetchRow(DB_FETCHMODE_ASSOC);
		
 	    $ile = $recData['ile'];

		if ($ile == 0)
			$res  = true;
		else
			$res = false;
 		
 		return $res;
 	}
	
	public function printLangGrid()
	{
		$html = '';
		$html .= '<table class="Grid" align="center" cellspacing=0>';
 	   	$html .= '<tr>';
 	   	$html .= '<td width=50><img src='.dnsPath.'"/Cms/Files/Img/about-48x48.png" /></td>';
 	   	$html .= '<td><br/></td>';
 	   	$html .= '</tr>';
 	   	$html .= '<tr><td align="right" colspan="2"><hr/>';
			
		$funcResult = '';
		$translatorObj = new translator(rootPath.'/Modules/Config/Config.Translation.xml');
		//echo $_SESSION['lang'];
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
		$grid->setGridWidth(780);
		$grid->addColumn("Name", $translatorObj->translate('langGridColName'), 200, false, 'left');
		$grid->addColumn("ShortName", $translatorObj->translate('langGridColShortName'), 50, false, 'left');
		$grid->addColumn("Icon", $translatorObj->translate('langGridColIcon'), 75, false, 'center');
		$grid->addColumn('Active', $translatorObj->translate('langGridColActive'), 55, false, 'center');
		$grid->addColumn("id", "", 200, true, 'right');
 		$grid->enabledDelAction($delAction);
	 	$grid->enabledEditAction($editAction);
		$grid->setDataQuery($query);
		$html .= $grid->renderHtmlGrid(1);
		
		$html .= '</td></tr>';
		$html .= '<tr><td align="right" colspan="2">';
		
		$addButton = new button(dnsPath.'/Cms/Files/Img/add-16x16.png', 'Dodaj język', $addAction, -1);
		$html .= $addButton->show(1);
				
		$html .= '</td></tr>';
		$html .= '</table>';
		
		return $html;
		 		
	}
	
	public function editLang($id)
	{
		$ret = '';
		$ret .= '<table width="600" align="center" cellpadding=0 cellspacing=0 border=0><tr><td>';
		$myForm = null;
		$myForm = new Form('dFORM', 'POST');
		$langForm = $myForm->getFormInstance();
		$langForm->addElement('header', ' hdrTest', 'Edycja/dodawanie języka tłumaczenia strony');
		$elementNazwa = $langForm->addElement('text', 'txtNazwa', 'Nazwa języka', array('size' => 20, 'maxlength'=> 25));
		$elementKod = $langForm->addElement('text', 'txtShortNazwa', 'Kod języka języka', array('size' => 20, 'maxlength'=> 3));
		
		$activeList['T'] = 'Tak';
		$activeList['N'] = 'Nie';
				
		$elementActive = $langForm->addElement('select', 'cbActive', 'Aktywny', $activeList);
		$valId = $langForm->addElement('hidden', 'id', 'Kod języka języka');
				
		$langForm->addElement('reset', 'btnReset', 'Wyczyść');
		$langForm->addElement('submit', 'btnSubmit', 'Zapisz');
		
		$langForm->addRule('txtNazwa', 'Pole musi być wypełnione', 'required', null, 'server');
		$langForm->addRule('txtShortNazwa', 'Pole musi być wypełnione', 'required', null, 'server');

		$langForm->registerRule('testUniqueShortName', 'callback', 'testUniqueShortName', 'configClass');
		$langForm->registerRule('testUniqueName', 'callback', 'testUniqueShortName', 'configClass');
      	$langForm->addRule('txtShortNazwa', 'Nazwa techniczna nie jest unikalna', 'testUniqueShortName');
		$langForm->addRule('txtNazwa', 'Nazwa nie jest unikalna', 'testUniqueName');
		
		$langForm->addRule('txtNazwa', 'Użyto niedozowlonych znaków', 'nopunctuation', null, 'server');
		$langForm->addRule('txtShortNazwa', 'Użyto niedozowlonych znaków', 'nopunctuation', null, 'server');
				
		$langForm->applyFilter('__ALL__', 'trim');
		
		$myForm->setStyle(2);
		
		if ($langForm->validate())
		{
			$activeArray = array();
			//$_SESSION['m'] = -1;
			$langForm->freeze();
			$name = $elementNazwa->getValue();
			//$kod = 
			$kod = $elementKod->getValue();
			$id = $valId->getValue();
			$activeArray = $elementActive->getValue();
			
			$ret .= $this->editLangDo($id, $name, $kod, $activeArray[0]);
		//	$pageTitle = $titleElement -> getValue();
		//	$this->DBInt->ExecQuery("Update cmsConfig Set Title = '$pageTitle'");
					
			
		}	
		else
		{
			if ($id > -1)
			{
				$data = $this->DBInt->ExecQuery("SELECT Name, ShortName, Active FROM cmsLang where id=".$id);
				$langRec = $data->fetchRow(DB_FETCHMODE_ASSOC);
				$name = $langRec['Name'];
				$kod = $langRec['ShortName'];
				$active = $langRec['Active'];
				
				$elementNazwa->setValue($name);
				$elementKod->setValue($kod);
				$valId->setValue($id);
				$elementActive->setValue($active);
			}
			else
			{
				$valId->setValue(-1);
			}
			
			$ret .= $langForm->toHtml();
			$moduleTmp = new ModulesMgr();
			$moduleTmp->loadModule('Config');
			$cancelAction = $moduleTmp->getModuleActionIdByName('printLangGrid');
			unset($moduleTmp);
			$ret .= '</td></tr><tr><td>
					 <table width = "100%" class="Grid" >';
			$ret .= '<tr><td align="right">';
				$buttonChgPass = new button(dnsPath.'/Cms/Files/Img/delete-16x16.png', 'Anuluj', $cancelAction, -1);
			$ret .= $buttonChgPass->show(1);
			$ret .= '</td></tr>';
			$ret .= '</table>';
		}
				
		$ret .= '</td></tr></table>';
		return $ret;
	}
	
	public function editLangDo($id, $name, $shortName, $active)
	{
		$ret = '';
		if ($id > -1)
		{
		 	//tu update
		 	$query = 
		 			"
		 			UPDATE 
		 				cmsLang 
		 			SET 
		 				Name = '$name',
		 				ShortName = '$shortName',
		 				Active = '$active'
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
						cmsLang(Name, ShortName, Active)
					VALUES
						('$name', '$shortName', '$active')
					";
		}
		$this->DBInt->ExecQuery($query);
		
		$module = new ModulesMgr();
		$module->loadModule('Config');
		$okAction = $module->getModuleActionIdByName('printLangGrid');
		$dialog = new dialog('Zapis danych języka tłumaczenia strony', 'Dane języka tłumaczenia strony zapisane prawidłowo', 'Info', 300, 150);
		$dialog->setAlign('center');
		$dialog->setOkCaption('Ok');
		$dialog->setOkAction($okAction);
		$ret .= $dialog->show(1);
		return $ret;
	}
	
	public function delLang()
	{
		$ret = '';
		if (!isset($_GET["id"]))
		{
			$module = new ModulesMgr();
			$module->loadModule('Config');
			$okAction = $module->getModuleActionIdByName('printLangGrid');
	
			$errDialog = new dialog('Usuwanie języka tłumaczenia strony', 'Nie wybrano języka na liście', 'alert', 300, 150);
			$errDialog->setAlign('center');
			$errDialog->setOkCaption('Ok');
			$errDialog->setOkAction($okAction);
			$ret .= $errDialog->show(1); 
		}
		else
		{
			$module = new ModulesMgr();
			$module->loadModule('Config');
			$okAction = $module->getModuleActionIdByName('delLangDo');
			$cancelAction = $module->getModuleActionIdByName('printLangGrid');
	
			$dialog = new dialog('Usuwanie języka tłumaczenia strony', 'Czy chcesz usunąć język tłumaczenia?', 'query', 300, 150);
			$dialog->setAlign('center');
			$dialog->setOkCaption('Tak');
			$dialog->setCancelCaption('Nie');
			$dialog->setId($_GET["id"]);
			$dialog->setOkAction($okAction);
			$dialog->setCancelAction($cancelAction);
			$ret .= $dialog->show(1);
		}
		return $ret;
	}
	
	public function delLangDo()
	{
		$id = $_GET["id"];
		$this->DBInt->ExecQuery("DELETE FROM cmsLang WHERE id=".$id);
		
		$module = new ModulesMgr();
		$module->loadModule('Config');
		$okAction = $module->getModuleActionIdByName('printLangGrid');
			
		$dialog = new dialog('Usuwanie języka tłumaczenia strony', 'Język usunięty', 'Info', 300, 150);
		$dialog->setAlign('center');
		$dialog->setOkCaption('Ok');
		$dialog->setOkAction($okAction);
		$ret = $dialog->show(1);
		return $ret;
	}
	
	public function printConfig()
	{
		saveActionValue();
		$pageTitle = '';
		$ret = '';
		$ret .= '<table width="780" align="center">
				<tr><td>';
		$myForm = null;
		$myForm = new Form('dFORM', 'POST');
		$config_form = $myForm->getFormInstance();
		$config_form->addElement('header', ' hdrTest', 'Panel konfiguracyjny');
		$titleElement = $config_form->addElement('text', 'txtTitle', 'Tytuł strony', array('size' => 40, 'maxlength'=> 1024));
		$option_list = array();
		//$option_list[''] = '--Wybierz z listy--';
		$query = "
				SELECT 
					id, Name, ShortName, Icon, Active 
				FROM 
				  	cmsLang 
				ORDER BY 
				  	ShortName";
		
		$result = $this->DBInt->ExecQuery($query);
		while ($userData = $result->fetchRow(DB_FETCHMODE_ASSOC)) 
		{
			$option_list[$userData['id']] = $userData['Name'];
		}
		
		$elementLang = $config_form->addElement('select', 'selLang' ,'Język domyślny strony', $option_list);
		
		$moduleTmp = new ModulesMgr();
     	$moduleTmp->loadModule('Config');
     	$actionPage = $moduleTmp->getModuleActionIdByName('choosePage');
     	unset($moduleTmp);
     			
		$page = $config_form->addElement('text', 'txtStrona', 'Strona startowa', 'readonly="readonly"');
     	$buttonPage = $config_form->addElement('button', 'btnShortNazwa', 'wybierz...', '');
     	$buttonPageAttributes = array('title'=>'asdasd', 'onclick'=>"return window.open('?a=$actionPage&onlycontent=1&idcol=hidden&namecol=txtNazwa', 'Wybór', 'menubar=0,location=0,directories=0,toolbar=0,resizable,dependent,width=740,height=400');");
   	    $buttonPage->updateAttributes($buttonPageAttributes);
		
		$elementKeywords = $config_form->addElement('textarea', 'Keywords', 'Słowa kluczowe', array('cols'=>30, 'rows'=>6));
		$elementDescription = $config_form->addElement('textarea', 'Description', 'Opis (wyszukiwarki)', array('cols'=>30, 'rows'=>6));
		$elementAuthor = $config_form->addElement('text', 'txtAuthor', 'Autor strony');
		//<meta name="copyright" content="wwww" />
		$elementCopyrights = $config_form->addElement('text', 'txtCopyright', 'Prawa autorskie');
		
		$cache_list['nocache'] = 'no-cache';
		$cache_list['cache'] = 'cache';
		$elementCache = $config_form->addElement('select', 'selCache' ,'Cache', $cache_list);
		/*
		# index,follow" - indeksuj strone, podazaj za odsyłaczami (max 2 poziomy)
		# content="index,nofollow" - indeksuj strone, nie odwiedzaj linków
		# content="noindex,follow" - nie indeksuj strony, odwiedz tylko dalsze linki
		# content="noindex,nofollow" - nie indeksuj strony, nie odwiedzaj linków
		# content="all" - pozwala na analizowanie kodu naszej strony, zamiennie z index,follow
		# content="noimageindex" - nie indeksuje grafiki na stronie HTML - tekst indeksuje
		*/
		$robot_list['indexfollow'] = 'Index, Follow';
		$robot_list['indexnofollow'] = 'Index, NoFollow';
		$robot_list['noindexnofollow'] = 'NoIndex, NoFollow';
		$robot_list['All'] = 'All';
		
		$elementRobots = $config_form->addElement('select', 'selRobot' ,'Robots', $robot_list);
		$config_form->addElement('reset', 'btnReset', 'Wyczyść');
		$config_form->addElement('submit', 'btnSubmit', 'Dalej');
		
		$config_form->addRule('txtTitle', 'Pole musi być wypełnione', 'required', null, 'server');
		$config_form->applyFilter('__ALL__', 'trim');
		
		$myForm->setStyle(2);
				
		//$titleElement->setValue($pageTitle);
	//
		if ($config_form->validate())
		{
			$_SESSION['m'] = -1;
			$config_form->freeze();
			
			$pageTitle = $titleElement -> getValue();
			
			$tmpPageMgr = new PagesMgr();
			$stronaNazwa =  $page->getValue();
			
			$pageDefaultPageId = $tmpPageMgr->getPageIdByName($stronaNazwa);
			
			unset($tmpPageMgr);
			
			//if ($pageDefaultPageId == '')
		//	{
		//		$pageDefaultPageId = 'null';
		//	}
			$arg1 = $titleElement->getValue();
			$arg3 = $pageDefaultPageId;
			$arg4arr = $elementLang->getValue();
			$arg5 =$elementKeywords->getValue();
			$arg6 =$elementDescription->getValue();
			$arg7 =$elementAuthor->getValue();
			$arg8 =$elementCopyrights->getValue();
			
			$arg9arr =$elementCache->getValue();
			$arg10arr =$elementRobots->getValue();

			// kod jezyka
			$arg4code = $arg4arr[0];
			echo $arg4code;
			$arg4 = /*$this->getLangIdByCode(*/$arg4code;//);
						
			$arg9 = $arg9arr[0];
			$arg10 = $arg10arr[0];
						
			$updateQuery = "
				UPDATE
					cmsConfig				
				SET
					Title = '$arg1',
					DefaultPageFk = $arg3,
					DefaultLanguageFk = $arg4,
					KeyWords = '$arg5',
					PageDescription = '$arg6',
					PageAuthor = '$arg7',
					Copyrights = '$arg8',
					`Cache` = '$arg9',
					Robots = '$arg10'															
					";
			
			//echo $updateQuery;
			$this->DBInt->ExecQuery($updateQuery);
					
			$module = new ModulesMgr();
			$module->loadModule('Config');
			$okAction = $module->getModuleActionIdByName('printConfig');	
			$dialog = new dialog('Zapis danych konfiguracyjnych strony', 'Dane strony zapisane prawidłowo', 'Info', 300, 150);
			$dialog->setAlign('center');
			$dialog->setOkCaption('Ok');
			$dialog->setOkAction($okAction);
			$ret .= $dialog->show(1);
			//echo $tmpPageMgr->getPageIdByName($stronaNazwa);
		}	
		else
		{
			/*$defaults = array();
			
			$defaults['txtName'] = '';
			$config_form->setDefaults($defaults);*/
			// wpisuje dane z bazy danych
			
			$query = "
				SELECT 
					Title, DefaultPageFk, DefaultLanguageFk, KeyWords, PageDescription, PageAuthor, 
					Copyrights, Cache, Robots
				FROM
					cmsConfig
					";
			 
			$data = $this->DBInt->ExecQuery($query);
			$pageTitleRec = $data->fetchRow(DB_FETCHMODE_ASSOC);
			$pageTitle = $pageTitleRec['Title'];
			//pobieram nazwe techn strony domyslnej
			$tmpPageMgr = new PagesMgr();
			
			if ($pageTitleRec['DefaultPageFk'] != null) 
				$pageIndex = $pageTitleRec['DefaultPageFk'];
			else
				$pageIndex = 0;
			
			$pageDefaultPage = $tmpPageMgr->getPageNameById($pageIndex);
			unset($tmpPageMgr);
			
			// pobieram id jezyka
			$pageDefaultLang =  $pageTitleRec['DefaultLanguageFk'];
			$pageKeyWords = $pageTitleRec['KeyWords'];
			$pageDesc = $pageTitleRec['PageDescription'];
			$pageAuthor = $pageTitleRec['PageAuthor'];
			$pageCopyrights = $pageTitleRec['Copyrights'];
			$pageCache = $pageTitleRec['Cache'];
			$pageRobots = $pageTitleRec['Robots'];

			//ustawiam wartosci pol
			$titleElement->setValue($pageTitle);
			$page->setValue($pageDefaultPage);
			$elementLang->setValue($pageDefaultLang);
			$elementKeywords->setValue($pageKeyWords);
			$elementDescription->setValue($pageDesc);
			$elementAuthor->setValue($pageAuthor);
			$elementCopyrights->setValue($pageCopyrights);
			$elementCache->setValue($pageCache);
			$elementRobots->setValue($pageRobots);
			
			$ret .= $config_form->toHtml();
		}
				
		$ret .= '</td></tr></table>';
		return $ret;

	}
	private function getLangIdByCode($Code)
	{
		$data = $this->DBInt->ExecQuery("SELECT id FROM cmsLang WHERE ShortName = '$Code'");
		$langData = $data->fetchRow(DB_FETCHMODE_ASSOC);
		$result = $langData['id'];
		return $result;
	}
	
	
	public function getMainPageTitle()
	{
		$data = $this->DBInt->ExecQuery("SELECT Title FROM cmsConfig");
		$configData = $data->fetchRow(DB_FETCHMODE_ASSOC);
		$result = $configData['Title'];
		return $result;		
	}
	
	public function choosePage()
	{
		$query = 
				"
 			SELECT 
 				`id`, `PageName`, `ShortName` as Value, `ShortName`,`Active`, `AuthorizedOnly`, `Desc`
 			FROM
 				`cmsPages`
 			WHERE
 				`Admin` = 'N'
 			ORDER BY
 				`PageName`, `ShortName` ASC
 				" ;
 		
 		
 		$result = '';
 		$result .= '<table class="Grid" align="center" cellspacing=0>';
 	   	 	   	
 	   	$result .= '<tr><td colspan="2">';
 	   	
 	   	$pagesListGrid = new gridRenderer();
 	   	$pagesListGrid->setDataQuery($query);
 	   	$pagesListGrid -> setTitle('Lista pozycji menu');
    	$pagesListGrid->setGridAlign('center');
    	$pagesListGrid->setGridWidth(680);
    	
    	$pagesListGrid->addColumn('PageName', 'Pełna nazwa', 200, false, false, 'left');
    	$pagesListGrid->addColumn('ShortName', 'Nazwa techn.', 100, false, false, 'left');
    	$pagesListGrid->addColumn('Active', 'Aktywne', 20, false, false, 'center');
    	$pagesListGrid->addColumn('AuthorizedOnly', 'Autoryzacja', 20, false, false, 'center');
    	$pagesListGrid->addColumn('Desc', 'Opis',350, false, false, 'left');
    	$pagesListGrid->addColumn('id', '', 200, true, false, 'right');
    	$pagesListGrid->addColumn('Value', 'aaa', 100, false, true, 'left');
    	$pagesListGrid->callBackAction('window.opener.document.dFORM.txtStrona.value');
    	//$menuListGrid->enabledEditAction(13);
    	$result .= $pagesListGrid->renderHtmlGrid(1);
    	$result .= '</td></tr>';
    	$result .= '</table>';
    			
    	restoreActionValue();
    	return $result;
	}
}
?>
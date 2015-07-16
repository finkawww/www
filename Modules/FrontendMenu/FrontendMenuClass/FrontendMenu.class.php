<?php
/**
 * Klasa obsługi FrontMenu
 *
 *
 */

 class FrontendMenuClass
 {
 	/**
 	 * @var $objMenu Referencja do obiektu klasy menuMgr
 	 * @access private
 	 */
 	private $objMenu = null;
 	
 	/**
 	 * @var $objMenuRenderer Referencja do obiektu klasu menuRenderer
 	 * @access private
 	 */
 	 
 	private $objMenuRenderer = null;
  	
 	private $id = 0;
 	
 	//metody validacyjne
 	

 	
	public function testUniqueMenuRenderName($val)
 	{
 		$res = true;
 		
 		$DBInt = DBSingleton::getInstance();
 		$sql = "SELECT COUNT(id) as ile FROM cmsMenu WHERE MenuLinkText='$val'";
 		$dbResult = $DBInt->ExecQuery($sql);
 	    $recData = $dbResult->fetchRow(DB_FETCHMODE_ASSOC);
		
 	    $ile = $recData['ile'];
 	    
		if ($ile == 0)
			$res  = true;
		else
			$res = false;
 		
 		return $res;
 	}
	
 	public function testUniqueShortName($val)
 	{
 		$res = true;
 		
 		$DBInt = DBSingleton::getInstance();
 		$sql = "SELECT COUNT(id) as ile FROM cmsMenu WHERE ShortName='$val'";
 		$dbResult = $DBInt->ExecQuery($sql);
 	    $recData = $dbResult->fetchRow(DB_FETCHMODE_ASSOC);
		
 	    $ile = $recData['ile'];
 	    
		if ($ile == 0)
			$res  = true;
		else
			$res = false;
 		
 		return $res;
 	}
 	
 	public function testParent($val)
 	{
  		$pos = $_POST['selPosition'];
		$res = true;
 		if (($pos == 'L')||($pos == 'R'))
 		{
 			if ($val == 'Brak')
 				$res = false;
 		}
 		return $res; 
 		 
 	}
 	
 	public function moveUp($id)
 	{
 		
 		$html = '';
 		$dbInt = null;
        $dbInt = DBSingleton::getInstance();
         		
        $sqlCurrentNode = 
 		"
 				SELECT id, `index` FROM cmsMenu WHERE AdminMenu='N' AND id=$id
 		";
 		 		
 		$dataCurrentNode = $dbInt->ExecQuery($sqlCurrentNode);
        $recCurrentNode = $dataCurrentNode->fetchRow(DB_FETCHMODE_ASSOC);
        
        $currentId = $recCurrentNode['id'];
        $currentIndex = $recCurrentNode['index'];
     	$menuMgr = MenuMgr::getInstance();
        
 		$position = $menuMgr->getMenuLocation($id);
 		   
 		if ($position == 'T')
 		{
        $sqlUpperNode =
 			"
 			SELECT 
 				Id, `Index` FROM cmsMenu m
 			WHERE 
 				AdminMenu='N' AND Fk_ParentMenuItem is null
 				AND
 				`Index`=(SELECT max(`Index`) 
 			FROM 
 				cmsMenu 
 			WHERE 
 				`Index`<(SELECT `index` from cmsMenu where id=$id)
 				And Fk_ParentMenuItem is null)
 			
 			";
 		}
 		else
 		{
        $sqlUpperNode =
 			"
 				SELECT Id, `Index` FROM cmsMenu m
 				WHERE AdminMenu='N' AND
 					m.FK_ParentMenuItem = (SELECT FK_ParentMenuItem From cmsMenu Where id = $id)
 					AND
 					`Index`=(SELECT max(`Index`) From cmsMenu Where `Index`<(SELECT `index` from cmsMenu where id=$id)
 							AND FK_ParentMenuItem = (SELECT FK_ParentMenuItem From cmsMenu Where id = $id))
 			 
 			";
 		}
        
 		//echo $sqlUpperNode;
 		$dataUpperNode = $dbInt->ExecQuery($sqlUpperNode);
        $recUpperNode = $dataUpperNode->fetchRow(DB_FETCHMODE_ASSOC);
        
        $upperId = $recUpperNode['Id'];
        $upperIndex = $recUpperNode['Index'];
 		
 		//jezelijest jakis node
 		$updateUpperSql = 
 			"
 				UPDATE cmsMenu SET `index`=$currentIndex WHERE id = $upperId
 			";
 		
 		$updateCurrentSql = 
 			"
 				UPDATE cmsMenu SET `index`=$upperIndex WHERE id = $currentId
 			";
		
 		$module = new ModulesMgr();
        $module -> loadModule('FrontendMenu');
        $okAction = $module->getModuleActionIdByName('showMenuList');
        $dbInt->ExecQuery($updateUpperSql);
 		$dbInt->ExecQuery($updateCurrentSql);
 		header("Location: ?a=".$okAction);
 		
 		/* 			
 		
 		
        $dialog = new dialog('Zmiana klejności menu', 'Kolejność menu zmieniona', 'Info', 300, 150);
        $dialog->setAlign('center');
        $dialog->setOkCaption('Ok');
        $dialog->setOkAction($okAction);
        $html .=$dialog->show(1);
        return $html;*/
 	}
 	
 	public function moveDown($id)
 	{
 		$html = '';
 		$dbInt = null;
        $dbInt = DBSingleton::getInstance();
         		
        $sqlCurrentNode = 
 		"
 				SELECT Id, `Index` FROM cmsMenu WHERE AdminMenu='N' AND id=$id
 		";
 		 		
 		$dataCurrentNode = $dbInt->ExecQuery($sqlCurrentNode);
        $recCurrentNode = $dataCurrentNode->fetchRow(DB_FETCHMODE_ASSOC);
        
        $currentId = $recCurrentNode['Id'];
        $currentIndex = $recCurrentNode['Index'];
        $menuMgr = MenuMgr::getInstance();
        
 		$position = $menuMgr->getMenuLocation($id);
 		
 		if ($position == 'T')
 		{
        $sqlDownNode =
 			"
 			SELECT Id, `Index` FROM cmsMenu m
 				WHERE AdminMenu='N' AND Fk_ParentMenuItem is null
 				and
 				`Index`=(SELECT min(`Index`) From cmsMenu Where `Index`>(SELECT `index` from cmsMenu where id=$id)
 				And Fk_ParentMenuItem is null)
 			";
 		}
 		else
 		{
        $sqlDownNode =
 			"
 				SELECT 
 					Id, `Index` 
 				FROM 
 					cmsMenu m
 				WHERE 
 					AdminMenu='N' AND
 					m.FK_ParentMenuItem = (SELECT FK_ParentMenuItem From cmsMenu Where id = $id)
 					AND
 					`Index`=(SELECT min(`Index`) From cmsMenu Where `Index`>(SELECT `index` from cmsMenu where id=$id)
 					AND FK_ParentMenuItem = (SELECT FK_ParentMenuItem From cmsMenu Where id = $id))
 			";
 		}
 		 
 		$dataDownNode = $dbInt->ExecQuery($sqlDownNode);
        $recDownNode = $dataDownNode->fetchRow(DB_FETCHMODE_ASSOC);
        
        $downId = $recDownNode['Id'];
        $downIndex = $recDownNode['Index'];
 		
 		//jezelijest jakis node
 		$updateDownSql = 
 			"
 				UPDATE cmsMenu SET `index`=$currentIndex WHERE id = $downId
 			";
 		
 		$updateCurrentSql = 
 			"
 				UPDATE cmsMenu SET `index`=$downIndex WHERE id = $currentId
 			";
		
 		$module = new ModulesMgr();
        $module->loadModule('FrontendMenu');
        $okAction = $module->getModuleActionIdByName('showMenuList');
        $dbInt->ExecQuery($updateDownSql);
 		$dbInt->ExecQuery($updateCurrentSql);
 		header("Location: ?a=".$okAction);
		
 		/* 			
 		
 		
        $dialog = new dialog('Zmiana klejności menu', 'Kolejność menu zmieniona', 'Info', 300, 150);
        $dialog->setAlign('center');
        $dialog->setOkCaption('Ok');
        $dialog->setOkAction($okAction);
        $html .=$dialog->show(1);
        return $html;*/
 	}
 	
 	public function __construct()
 	{
 		$this->objMenu = menuMgr::getInstance();
 	   	//$this->objMenuRenderer = new menuRenderer('public');
 	}

 	public function __destruct()
 	{
 	  	unset($this->objMenu);
 	   	//unset($this->objMenuRenderer);
 	}

 	/**
 	 * Wyświetlenie listy wszystkich pozycji menu
 	 * @param $menuPosition Pozycja menu, dla ktorej wyswitlamy liste (l, t, b, r)
 	 * @param $mode Tryb wyswietlnaia - (o - lista;1 - lista z aktywenym wyborem)
 	 * @access public
 	 * @author Pitr Brodziński
 	*/
 	public function showMenuList($menuPosition, $mode = 0)
 	{
 	   	//grid wypelniany rekursywnie
 	   	$html = '';
 	   	
 	   	if ($menuPosition == '')
 	   	$menuPosition = 'l';
 	   		
 	   	//----------------------------------------------------------
 	   	$query = "
					SELECT 
						m.id, m.Name, m.ShortName, m.`Index`, m.Active,
						CASE
            				WHEN m.`Position` = 'T' THEN '<b>Górne<b>'
							WHEN m.`Position` = 'B' THEN '<b>Dolne</b>'
							WHEN m.`Position` = 'L' THEN 'Lewe'
							WHEN m.`Position` = 'R' THEN '<i>Prawe</i>'
						END AS MenuPosition,
						CASE
							WHEN p.PageName IS NULL THEN '<font color=\"red\">Brak</font>'
							WHEN p.PageName IS NOT NULL THEN p.PageName 
						END AS AssignedPageName,
						mp.ShortName as ParentMenuName
					FROM
						cmsMenuView AS m 
						 LEFT OUTER JOIN cmsPages AS p
							ON m.FK_PageId = p.id
						 LEFT OUTER JOIN cmsMenu AS mp
						 	ON m.FK_ParentMenuItem = mp.id
					WHERE
						m.AdminMenu = 'N' AND
						m.FK_ParentMenuItem = 0
					ORDER BY
						m.`Index`											
				";
 	    	//----------------------------------------------------------
 	   	
 	    $subQuery = "
					SELECT 
						m.id,m.FK_ParentMenuItem, m.Name, m.ShortName, m.`Index`, m.Active,  
						CASE
							WHEN m.`Position` = 'T' THEN '<b>Górne<b>'
							WHEN m.`Position` = 'B' THEN '<b>Dolne</b>'
            				WHEN m.`Position` = 'L' then 'Lewe'
							WHEN m.`Position` = 'R' then '<i>Prawe</i>'
						end as MenuPosition,
						CASE
							WHEN p.PageName IS NULL THEN '<font color=\"red\">Brak</font>'
							WHEN p.PageName IS NOT NULL THEN p.PageName 
						END AS AssignedPageName,	
						mp.ShortName as ParentMenuName
					FROM
						cmsMenuView AS m 
						 LEFT OUTER JOIN cmsPages AS p
							ON m.FK_PageId = p.id
						 LEFT OUTER JOIN cmsMenu AS mp
						 	ON m.FK_ParentMenuItem = mp.id
					WHERE
						m.AdminMenu = 'N'
					";  

 	   	$html .= '<table class="Grid" align="center" cellspacing=0>';
 	   	$html .= '<tr>';
 	   	$html .= '<td width=130><img src="../Cms/Files/Img/about-48x48.png" /></td>';
 	   	$html .= '<td><br/></td>';
 	   	$html .= '</tr>';
 	   	$html .= '<tr><td align="right" colspan="2"><hr/>';

 	   	$modules = new ModulesMgr();
 	   	$modules -> loadModule('FrontendMenu');
 	   	$action = $modules -> getModuleActionIdByName('showMenuItemAdd');
 	   	$editAction = $modules -> getModuleActionIdByName('showMenuItemEdit');
 	   	$delAction = $modules->getModuleActionIdByName('delMenuItem');
 	   	
 	   	$upAction = $modules->getModuleActionIdByName('menuUp');
 	   	$downAction = $modules->getModuleActionIdByName('menuDown');
 	   	unset($modules);
 	   	$modules = new ModulesMgr();
 	   	$modules -> loadModule('Pages');
 	   	$genPages = $modules -> getModuleActionIdByName('genPages');
		$rebuildHta = $modules -> getModuleActionIdByName('RebuildHtaccess');
 	   	$editPage = $modules -> getModuleActionIdByName('showEditPage');
 	   	unset($modules);

 	   	$addTopButton = new button(buttonAddIcon, 'Dodaj menu', $action, -1);
 	   	$genPagesButton = new button(buttonAddIcon, 'Generuj strony', $genPages, -1);
		
		$RebuildHtaccess = new button(buttonAddIcon, 'Zamontuj nazwy menu', $rebuildHta, -1);
 	   	$html .=$addTopButton->show(1);
 	    		
 	   	$html .= '</td></tr>';
 	   	$html .= '<tr><td colspan="2">';
 	   	$menuListGrid = new gridRenderer();
 	   	$menuListGrid->setDataQuery($query);
 	   	$menuListGrid->setRecurseQuery($subQuery, 'm.FK_ParentMenuItem', 'ORDER BY m.`Index`');
    	$menuListGrid->setTitle('Lista pozycji menu');
    	$menuListGrid->setGridAlign('center');
    	$menuListGrid->setGridWidth(790);
    	
    	$menuListGrid->addColumn("Name", 'Pełna nazwa', 200, false, false, 'left');
    	$menuListGrid->addColumn("ShortName", 'Nazwa techn.', 100, false, false, 'left');
    	$menuListGrid->addColumn('MenuPosition', 'Pozycja', 40, false, false,  'center');
    	$menuListGrid->addColumn('Index', 'Kolejność', 20, false, false, 'right');
    	$menuListGrid->addColumn('Active', 'Aktywne', 20, false, false, 'center');
    	$menuListGrid->addColumn('AssignedPageName', 'Przypisana strona', 100, false, false, 'left');
    	$menuListGrid->addColumn("id", "", 200, true, false, 'right');
    	
    	
    	$menuListGrid->enabledDelAction($delAction);
    	$menuListGrid->enabledEditAction($editAction);
    	$menuListGrid->addAction($upAction, '../Cms/Files/Img/up.gif');
    	$menuListGrid->addAction($downAction, '../Cms/Files/Img/down.gif');
    	//$menuListGrid->addAction($editPage, '../Cms/Files/Img/pages_small.gif');
    	$html .= $menuListGrid->renderHtmlGrid(1);
    	$html .= '</td></tr>';
    	$html .= '<tr><td align="left">'.$RebuildHtaccess->show(1).$genPagesButton->show(1).'</td><td align="right">';
    	$addTopButton = new button(buttonAddIcon, 'Dodaj menu', $action, -1);
    	$html .=$addTopButton->show(1);
    		
    	$html .= '</td></tr>';
    	
    	$html .= '</table>';
    	
    	return $html;
    }

    
    /**
     * Ekran dodawnia nowego menuItem
     * @access public
     * @author Piotr Brodziński
     */
    public function showAddMenuForm($id = 0)
    {
    	$html = '';
    	$captions = array();
    	$langs = array();
    	//pola formularza budowane dynamicznie, referencje w tablicy langFields
    	$langFields = array();
    	
    	//odczytuje liste jezykow i wypelniam tablice $langs
    	$langQuery = "
    			SELECT DISTINCT
    			  ShortName
    			FROM
    			  cmsLang
    				";
    	
    	$DBInt = DBSIngleton::getInstance();
    	$qResult = $DBInt->ExecQuery($langQuery);
		$i = 0;
		while ($data = $qResult->fetchRow(DB_FETCHMODE_ASSOC))
		{
			$langs[$i] = $data['ShortName'];
			$i++;
		}
    	
     	//QuickForm
     	$this->id = $id;
     	saveActionValue();
     	$moduleTmp = new ModulesMgr();
     	$moduleTmp->loadModule('FrontendMenu');
     	$action = $moduleTmp->getModuleActionIdByName('showMenuListChoose');
     	$actionPage = $moduleTmp->getModuleActionIdByName('showMenuPagesChoose');
     	$html .= '<table width="600" align="center" cellpadding=0 cellspacing=0 border=0><tr><td>';
     	$myForm = null;
     	$myForm = new Form('dFORM', 'POST');
     	$menuForm = $myForm->getFormInstance();
     	
     	$menuForm->addElement('header', ' hdrTest', 'Edycja/dodawanie elementu menu');
     	$name = $menuForm->addElement('text', 'txtName', 'Nazwa');
     	$shortName = $menuForm->addElement('text', 'txtShortName', 'Nazwa techniczna');
		$menuRenderName = $menuForm->addElement('text', 'txtmenuRenderName', 'Nazwa w querystring');
     	
     	//połączenie z językiem - w polu hidden
     	// TODO Zrobic menu wielozjezyczne
     	
     	for($i = 0; $i < count($langs); $i++)
     	{
     		$langFields[$i] = $menuForm->addElement('text', 'caption'.$langs[$i], 'Tekst '.$langs[$i], array('size' => 50, 'maxlength'=> 250));
     	}
     	
     	//--
     	$page = $menuForm->addElement('text', 'txtStrona', 'Strona', 'readonly="readonly"');
     	$buttonPage = $menuForm->addElement('button', 'btnShortNazwa', 'wybierz...', '');
     	$buttonPageAttributes = array('title'=>'asdasd', 'onclick'=>"return window.open('?a=$actionPage&onlycontent=1&idcol=hidden&namecol=txtStrona', 'Wybór', 'menubar=0,location=0,directories=0,toolbar=0,resizable,dependent,width=720,height=500,scrollbars=1');");
   	    $buttonPage->updateAttributes($buttonPageAttributes);
   	    
     	$parentMenu = $menuForm->addElement('text', 'txtNazwa', 'Menu nadrzędne', 'readonly="readonly"');
     	$button = $menuForm->addElement('button', 'btnShortNazwa', 'wybierz...', '');
     	$buttonattributes = array('title'=>'asdasd', 'onclick'=>"return window.open('?a=$action&onlycontent=1&idcol=hidden&namecol=txtNazwa', 'Wybór', 'menubar=0,location=0,directories=0,toolbar=0,resizable,dependent,width=720,height=500, scrollbars=1');");
   	    $button->updateAttributes($buttonattributes);
   	    
     	$index = $menuForm->addElement('text', 'txtIndex', 'Kolejnosc');
     	$optPositionList = array('L'=>'Menu lewe', 'R'=>'Menu prawe', 'T'=>'Menu górne', 'B'=>'Menu dolne'); 
     	$position = $menuForm->addElement('select', 'selPosition' ,'Pozycja menu', $optPositionList);
     	$optActiveList = array('T' => 'Tak', 'N' => 'Nie');
     	$active = $menuForm->addElement('select', 'selActive' ,'Aktywne', $optActiveList);
     	
     	$grupa = $menuForm->addElement('text', 'txtGrupa', 'Grupa');
     	$idElement = $menuForm->addElement('hidden', 'id' ,'id');
     	
     	//daje onclick -> wyswietlam okno z wyborem -> a tam w onEnter wpisuje na Parent->txtXx
     	$menuForm->addElement('reset', 'btnReset', 'Wyczyść');
      	$menuForm->addElement('submit', 'btnSubmit', 'Zapisz');
      	
      	$menuForm->registerRule('testParent', 'callback', 'testParent', 'FrontendMenuClass');
      	$menuForm->registerRule('testUniqueShortName', 'callback', 'testUniqueShortName', 'FrontendMenuClass');
      	      	
      	$menuForm->addRule('txtNazwa', 'Menu musi posiadać menu nadrzędne', 'testParent');
      	$menuForm->addRule('txtName', 'Pole "Nazwa" musi być wypełnione', 'required', null, 'server');
     	$menuForm->addRule('txtShortName', 'Pole "Nazwa techniczna" musi być wypełnione', 'required', null, 'server');

     	if ($id == 0)
		{
     		$menuForm->addRule('txtShortName', 'Nazwa techniczna nie jest unikalna', 'testUniqueShortName');
			$menuForm->addRule('txtmenuRenderName', 'Nazwa querystring nie jest unikalna', 'testUniqueMenuRenderName');
     	}
     	$menuForm->addRule('txtIndex', 'Pole "Kolejność" musi być wypełnione', 'required', null, 'server');
      	$menuForm->addRule('txtIndex', 'Zła wartośc w polu "Kolejność" - musi być liczba', 'numeric', null, 'server');
  		
      	$menuForm->applyFilter('__ALL__', 'trim');
     	
      	//menu nadrzedne
      	
      	$menuPos = $position->getValue();
      	$menuPosValue = $menuPos[0];
      	$myForm->setStyle(2);
		$idElement->setValue($id);
        
		if ($menuForm->validate())
        {
        	//$_SESSION['m'] = -1;
        	$menuForm->freeze();
        	try
        	{	
        	//pobieram wartosci rgumentow metody addMenuItem
        		$tmpMenuMgr = MenuMgr::getInstance();
        		$menuName = $name->getValue();
        		$menuShortName = $shortName->getValue();
				$renderName = $menuRenderName->getValue();
        		$grupaVal = $grupa->getValue();
        	
	        	if ($page->getValue() == 'Brak')
        		{
        			//echo 'PAGE 0';
        			$menuPage = 0;
        		}
        		else
        		{
        			//echo 'IN!!!!';
	        		$objPagesMgr = new PagesMgr();
	        		$menuPage = $objPagesMgr->getPageIdByName($page->getValue());
        			unset($objPagesMgr);
        		}
        		
	        	  
        		if ($parentMenu->getValue() == 'Brak')
        		{
        			$menuParentItem = 0; //w tabeli bedzie null
        		}
        		else
        		{
	        		
        			$parentMenuName = $parentMenu->getValue();
        			//if ($parentMenuName != 'Brak') 
	        		  $menuParentItem = $tmpMenuMgr->getMenuIdByName($parentMenuName);
	        	}
	        	
        			
	        		
        		$menuIndex = $index->getValue();
        		$menuPositionArray = ($position->getValue());
        		$menuPosition = $menuPositionArray[0];
        		$activeArray = $active->getValue();
        		$menuActive = $activeArray[0]; 
	        	
        		$this->addMenuItem($menuName, $menuShortName, $menuPage, $menuParentItem, $menuIndex, $menuPosition, $menuActive, $grupaVal, $renderName);
        		
        		$menuId = 0;
        		$menuIdVal = $tmpMenuMgr->getMenuIdByName($shortName->getValue());
        		
        		//$menuId1 = $menuId;
        		for($i = 0;$i<count($langs); $i++)
     			{
     				//$langFields[$i]->getValue
     				//if ($menuId)
     			
     				$tmpMenuMgr->setMenuCaption($menuIdVal, $langs[$i], $langFields[$i]->getValue());
     			}        			
        		
	        	
        		$module = new ModulesMgr();
        		$module->loadModule('Config');
        		$okAction = $module->getModuleActionIdByName('showMenuList');
        		$dialog = new dialog('Zapis elementu menu', 'Element menu zapisana prawidłowo', 'Info', 300, 150);
        		$dialog->setAlign('center');
        		$dialog->setOkCaption('Ok');
        		$dialog->setOkAction($okAction);
        		$html .=$dialog->show(1);
        	}
        	Catch (exception $e)
        	{
        		$module = new ModulesMgr();
        		$module->loadModule('Config');
        		
        		$okAction = $module->getModuleActionIdByName('showMenuList');
        		$dialog = new dialog('Zapis elementu menu', 'Element menu nie został zapisany!<br/>'.$e->GetMessage(), 'Alert', 300, 150);
        		$dialog->setAlign('center');
        		$dialog->setOkCaption('Ok');
        		$dialog->setOkAction($okAction);
        		$html .= $dialog->show(1);
        		return $html;
        		
        	}
        		
        }
        else
        {
        	$page->setValue('Brak');
      		$parentMenu->setValue('Brak');
        	
      		if ($this->id != 0)
        	{
        		
        		$query = "
        			SELECT 
        				`Name`, `ShortName`, `FK_PageId`, `FK_ParentMenuItem`, `Index`, grupa,
        				`Position`, `Active`, `MenuLinkText` 
        			FROM
        				`cmsMenu`
        			WHERE
        				`AdminMenu` = 'N' AND `id` = $this->id
        				"; 
				
        				
        		$dbInt = null;
        		$dbInt = DBSingleton::getInstance();
        		$data = $dbInt->ExecQuery($query);
        		$rec = $data->fetchRow(DB_FETCHMODE_ASSOC);
        		
        		$nameArray = $rec['Name'];
        		
        		$name->setValue($nameArray);
        		
        		$shortName->setValue($rec['ShortName']);
        		$pageId = $rec['FK_PageId'];
        		$parentMenuItem = $rec['FK_ParentMenuItem'];
        		$index->setValue($rec['Index']);
        		$position->setValue($rec['Position']);
        		$active->setValue($rec['Active']);
				$menuRenderName->setValue($rec['MenuLinkText']);
        		$grupa->SetValue($rec['grupa']);
        		$tmpMenuMgr = MenuMgr::getInstance();
        		
        		for($i = 0; $i < count($langFields); $i++)
        		{
        			
        			$langFields[$i]->setValue($tmpMenuMgr->getMenuCaption($id, $langs[$i]));
        			
        		}
        		
        		
        		
        		if ($pageId <> '')
        		{
        			$tmpPagesMgr = new PagesMgr();
        			$pageName = $tmpPagesMgr->getPageNameById($pageId);
        			$page->setValue($pageName);
        			unset($tmpPagesMgr);
        		}
        		if ($parentMenuItem <> '')
        		{
        			$tmpMenuMgr = MenuMgr::getInstance();
        			$parentMenuName = $tmpMenuMgr->getMenuNameById($parentMenuItem);
        			$parentMenu->setValue($parentMenuName);
        		}
        		
        		
        	}
        	/*	$data = $this->DBInt->ExecQuery("SELECT Title FROM cmsConfig");
        	 $pageTitleRec = $data->fetchRow(DB_FETCHMODE_ASSOC);
        	 $pageTitle = $pageTitleRec['Title'];
        	 $titleElement->setValue($pageTitle);*/
        	$html .= $menuForm->toHtml();
        	
        	$moduleTmp = new ModulesMgr();
			$moduleTmp->loadModule('AdminUsr');
			$cancelAction = $moduleTmp->getModuleActionIdByName('showMenuList');
			unset($moduleTmp);
			$moduleTmp = new ModulesMgr();
			$moduleTmp->loadModule('Pages');
			$editPageAction = $moduleTmp->getModuleActionIdByName('showEditPage');
			unset($moduleTmp);
		
			$html .= '</td></tr><tr><td>
					  <table width = "100%" class="Grid" >';
			$html .= '<tr><td align="right">';
			if (($this->id != 0) && ($pageId>0))
        	{
        		$buttonPage = new button('../Cms/Files/Img/delete-16x16.png', 'Edytuj stronę', $editPageAction, $pageId);
				$html .=$buttonPage->show(1);
        	}
        	
				$buttonChgPass = new button('../Cms/Files/Img/delete-16x16.png', 'Anuluj', $cancelAction, 0);
				$html .=$buttonChgPass->show(1);
			$html .= '</td></tr>';
			$html .= '</table>';
        }

        $html .= '</td></tr></table>';

        return $html;
     }
 	     
 	/**
 	 * Dodanie menuItem do menu
 	 * @param $name Nazwa opisowa menuItem
 	 * @param $shortName Nazwa techniczna (unikalna) menuItem
 	 * @param $menuPage Odniesienie do strony
 	 * @param $parentMenuId Referencja do menu nadrzednego
 	 * @param $index Kolejnosc (oddzielna kolejnosc dla każdego poziomu)
 	 * @param $position Przynaleznosc do menu: lewego, prawego, gornego lub dolnego
 	 * @param $active Definiuje aktywność menu
 	 * @access public
 	 * @author Piotr Brodziński
 	 */
	public function addMenuItem($name, $shortName, $menuPage = 0, $parentMenuId = 0, $index, $position, $active, $grupa='', $renderName)
 	{
 		
 		if ($menuPage == 0)
 			$menuPageTxt = 'null';
 		else
 		 	$menuPageTxt = $menuPage;
 				
 		if (($position == 'T') || ($position == 'B'))
 		{
 			//$parentMenuId = 0;
 		}
 		 	
 		 if ($parentMenuId == 0)
 			$parentMenuIdTxt = 'null';
 		else
 			$parentMenuIdTxt = $parentMenuId;

 	
 			
 		if ($this->id == 0)
 		{
 			$parentMenuName = '';
 			
 			if ($parentMenuIdTxt != 'null')
 				$parentMenuName = $this->objMenu->getMenuNameById($parentMenuId);
 			 			
 			$pagesMgr = new PagesMgr();
 			
 			$pageName = '';
 			if ($menuPageTxt != 'null')
 				$pageName = $pagesMgr->getPageNameById($menuPage);
 				//echo 'Page:'.$pageName;
 			unset($pagesMgr);
 				
 			$this->objMenu->addMenuItem($parentMenuName, $name, $shortName, $pageName, $index, 'N', $position, $active, $grupa, $renderName);
 		 
		}
 		else
 		{
			$query = "
				UPDATE `cmsMenu`
				SET `Name`='$name', `ShortName`='$shortName', `FK_PageId`=$menuPageTxt, 
					`FK_ParentMenuItem`=$parentMenuIdTxt, `Index` = $index, `Position` = '$position', grupa = '$grupa',
					`AdminMenu`='N', `Active`='$active', `MenuLinkText`='$renderName'
				WHERE
					id = $this->id;
					";
			
			//TODO To przeniesc do moduleMgr
			$dbInt = DBSingleton::getInstance();
 			$dbInt->ExecQuery($query); 		
 		}
 		return true;
 		
    }

    public function delMenuItemDo($menuId)
    {
 		$html = '';
 		$delQuery = "DELETE FROM cmsMenu WHERE id=$menuId";
 		$dbInt = DBSingleton::getInstance();
 		$dbInt->ExecQuery($delQuery);
		
 		$module = new ModulesMgr();
		$module->loadModule('Menu');
		$okAction = $module->getModuleActionIdByName('ShowMenuList');
		$dialog = new dialog('Usuwanie' , 'Usunięto pozycję menu', 'Info', 300, 150);
		$dialog->setAlign('center');
		$dialog->setOkCaption('Ok');
		$dialog->setOkAction($okAction);
		$html .= $dialog->show(1);
		return $html;		
    	
    }
    /**
     * 
	 * Kasowanie elementu menuItem
     * @param $menuId Identyfikator pozycji do usunięcia
 	 * @access public
 	 * @author Piotr Brodziński
 	 * 
 	 */
 	public function delMenuItem($menuId)
 	{
 		
 		$html = '';
 		$module = new ModulesMgr();
		$module->loadModule('Menu');
		$cancelAction = $module->getModuleActionIdByName('ShowMenuList');
		$okAction = $module->getModuleActionIdByName('delMenuItemDo');
		$dialog = new dialog('Usuwanie' , 'Czy usunąć pozyche menu?', 'Query', 300, 150);
		$dialog->setAlign('center');
		$dialog->setOkCaption('Tak');
		$dialog->setOkAction($okAction);
		$dialog->setCancelAction($cancelAction);
		$dialog->setCancelCaption('Nie');
		$dialog->setId($menuId);
		$html .= $dialog->show(1);
 			
		return $html;		
 	}

    /**
 	 * Przyporządkowanie pozycji menu do strony
 	 * @param $menuId Identyfikator pozycji menu
 	 * @param $pageId Identyfikator strony
 	 * @access public
 	 * @author Piotr Brodziński
 	 */
 	public function assignMenuToPage()
 	{
 		$query = "
 			SELECT 
 				`id`, `PageName`, `ShortName` as Value, `ShortName`,`Active`, `AuthorizedOnly`, `Desc`
 			FROM
 				`cmsPages`
 			WHERE
 				`Admin` = 'N'
 			ORDER BY
 				`PageName`, `ShortName` ASC
 				";
 		
 		
 		$result = '';
 		$result .= '<table class="Grid" align="center" cellspacing=0>';
 	   	 	   	
 	   	$result .= '<tr><td colspan="2">';
 	   	
 	   	$pagesListGrid = new gridRenderer();
 	   	$pagesListGrid->setDataQuery($query);
 	   	$pagesListGrid->setTitle('Lista pozycji menu');
    	$pagesListGrid->setGridAlign('center');
    	$pagesListGrid->setGridWidth(680);
    	
    	$pagesListGrid->addColumn('PageName', 'Pełna nazwa', 200, false, false, 'left');
    	$pagesListGrid->addColumn('ShortName', 'Nazwa techn.', 100, false, false, 'left');
    	$pagesListGrid->addColumn('Active', 'Aktywne', 20, false, false, 'center');
    	$pagesListGrid->addColumn('AuthorizedOnly', 'Autoryzacja', 20, false, false, 'center');
    	$pagesListGrid->addColumn('Desc', 'Opis',350, false, false, 'left');
    	$pagesListGrid->addColumn("id", "", 200, true, false, 'right');
    	$pagesListGrid->addColumn('Value', '', 1, false, true, 'left');
    	$pagesListGrid->callBackAction('window.opener.document.dFORM.txtStrona.value');
    	
    	//$menuListGrid->enabledEditAction(13);
    	$result .= $pagesListGrid->renderHtmlGrid(1);
    	$result .= '</td></tr>';
    	$result .= '</table>';
		
    	restoreActionValue();		
		return $result;
 		
 		
 		restoreActionValue();
    }

    public function showMenuChooseList()
    {
		//TODO BEDZIE TRZEBA DODAC W GRIDZIE TEXTACTION dla kazdego CLICK
		$query = "
					SELECT 
						m.id, m.Name, m.ShortName ,m.ShortName as Value, m.`Index`, m.Active,
						CASE
            				WHEN m.`Position` = 'T' THEN '<b>Górne<b>'
							WHEN m.`Position` = 'B' THEN 'Dolne'
						END AS MenuPosition,
						CASE
							WHEN p.PageName IS NULL THEN '<font color=\"red\">Brak</font>'
							WHEN p.PageName IS NOT NULL THEN p.PageName 
						END AS AssignedPageName,
						mp.ShortName as ParentMenuName
					FROM
						cmsMenuView AS m LEFT OUTER JOIN cmsPages AS p
							ON m.FK_PageId = p.id
						 LEFT OUTER JOIN cmsMenu AS mp
						 	ON m.FK_ParentMenuItem = mp.id
					WHERE
						m.AdminMenu = 'N' AND
						m.FK_ParentMenuItem = 0
					ORDER BY
						m.`Index`											
				";
 	    	//----------------------------------------------------------
 	   	$subQuery = "
					SELECT 
						m.id,m.FK_ParentMenuItem, m.Name, m.ShortName, m.ShortName as Value, m.`Index`, m.Active,  
						CASE
            				when m.`Position` = 'L' then 'Lewe'
							when m.`Position` = 'R' then '<i>Prawe</i>'
						end as MenuPosition,
						CASE
							WHEN p.PageName IS NULL THEN '<font color=\"red\">Brak</font>'
							WHEN p.PageName IS NOT NULL THEN p.PageName 
						END AS AssignedPageName,	
						mp.ShortName as ParentMenuName
					FROM
						cmsMenu AS m LEFT OUTER JOIN cmsPages AS p
							ON m.FK_PageId = p.id
						 LEFT OUTER JOIN cmsMenu AS mp
						 	ON m.FK_ParentMenuItem = mp.id
					WHERE
						m.AdminMenu = 'N'
					";  
		$result = '';
 	   	$result .= '<table class="Grid" align="center" cellspacing=0>';
 	   	 	   	
 	   	$result .= '<tr><td colspan="2">';
 	   	
 	   	$menuListGrid = new gridRenderer();
 	   	$menuListGrid->setDataQuery($query);
 	   	$menuListGrid->setRecurseQuery($subQuery, 'm.FK_ParentMenuItem', 'ORDER BY m.`Index`');
    	$menuListGrid -> setTitle('Lista pozycji menu');
    	$menuListGrid->setGridAlign('center');
    	$menuListGrid->setGridWidth(680);
    	
    	$menuListGrid->addColumn("Name", 'Pełna nazwa', 200, false, false, 'left');
    	$menuListGrid->addColumn("ShortName", 'Nazwa techn.', 100, false, false, 'left');
    	$menuListGrid->addColumn('MenuPosition', 'Pozycja', 40, false, false, 'center');
    	$menuListGrid->addColumn("Index", 'Kolejność', 20, false, false, 'right');
    	$menuListGrid->addColumn('Active', 'Aktywne', 20, false, false, 'center');
    	$menuListGrid->addColumn('AssignedPageName', 'Przypisana strona', 100, false, false, 'left');
    	$menuListGrid->addColumn("id", "", 200, true, false, 'right');
    	$menuListGrid->addColumn('Value', '', 1, false, true, 'left');
    	$menuListGrid->callBackAction('window.opener.document.dFORM.txtNazwa.value');
    	//$menuListGrid->enabledEditAction(13);
    	$result .= $menuListGrid->renderHtmlGrid(1);
    	$result .= '</td></tr>';
    	$result .= '</table>';
		restoreActionValue();		
		return $result;
 	}
	public function RebuildHtaccess()
	{
		$file = fopen(rootPath.'/Modules/FrontendMenu/FrontendMenuClass/htHeader.txt', "r") or exit("Unable to open file!");
		//Output a line of the file until the end is reached
		$htHeader='';$htDynamic='';$htFooter='';
		
		while(!feof($file))
		{
			$htHeader .= fgets($file);
		}
		fclose($file);
		$sql= "SELECT id, MenuLinkText FROM cmsMenu WHERE AdminMenu='N' and not MenuLinkText=''";
		$dbInt = null;
        $dbInt = DBSingleton::getInstance();
        $data = $dbInt->ExecQuery($sql);
        while($rec = $data->fetchRow(DB_FETCHMODE_ASSOC))
		{
			$htDynamic .= 'RewriteRule ^'.$rec['MenuLinkText'].'$ index.php?mp='.$rec['id'].' [L,QSA] '."\n";			
		}
		$file = fopen(rootPath.'/.htaccess', "w") or exit("Unable to open file!");
		fwrite($file,$htHeader."\n".$htDynamic);
		fclose($file);
		$module = new ModulesMgr();
        $module -> loadModule('FrontendMenu');	
		$okAction = $module->getModuleActionIdByName('showMenuList');        
 		header("Location: ?a=".$okAction);
	}
 	
 }
 ?>
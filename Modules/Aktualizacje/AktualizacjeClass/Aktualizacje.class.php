<?php

//klaa kontener na potrzeby wyswieltnia Frontend
final class AktualizacjaItem
{
	public $wersja;
	public $opis;
	public $data;
	public $grupa;
	public $program;
}

class AktualizacjeClass
{
	private $dbInt = null;
	private $translator;

	private function SaveAktualizacje($id, $progName, $dataVal, $wersja, $opisPL)
	{
		$queryProg = "SELECT id FROM AktualizacjeProgramy WHERE nazwa='$progName'";
		$qResult = $this->dbInt->ExecQuery($queryProg);
		$dataQ = $qResult->fetchRow(DB_FETCHMODE_ASSOC);
		$progId = $dataQ['id'];

		$resId = 0;
		if ($id == 0)
		{
			//insert
			$query = "
			INSERT INTO AktualizacjeOpisy (dataWydania, wersja, opis, fkProgram)
			VALUES ('$dataVal', '$wersja', '$opisPL', $progId)
			";
		}
		else
		{
			$resId = $id;
			//updatew
			$query = "
			UPDATE AktualizacjeOpisy
			SET
			dataWydania = '$dataVal',
			wersja = '$wersja',
			opis = '$opisPL',
			fkProgram = $progId
			WHERE
			id=$id
			";
				
		}

		$this->dbInt->ExecQuery($query);

		if ($id = 0)
		{
			$queryChk = "
			SELECT id FROM ProgramyAktualizacje WHERE FkProgram=$progId AND dataWydania='$data' and wersja='$wersja'
			";
				
			$qResult = $this->dbInt->ExecQuery($queryChk);
			$data = $qResult->fetchRow(DB_FETCHMODE_ASSOC);
			$resId = $data['id'];
		}

		return $resId;
	}
	private function UpdateAktualizacjeLang($id, $arrOpisy)
	{
		$langQuery = "
    			SELECT DISTINCT
    			  ShortName
    			FROM
    			  cmsLang WHERE ShortName<>'PL' ORDER BY id
    				";
		 
		$DBInt = DBSIngleton::getInstance();
		$qResult = $this->dbInt->ExecQuery($langQuery);
		 
		while ($data = $qResult->fetchRow(DB_FETCHMODE_ASSOC))
		{
			$lang = $data['ShortName'];
			$opis = $arrOpisy[$lang];
			$query = "
			UPDATE
			AktualizacjeOpisyLang
			SET
			Opis = '$opis'
			WHERE
			FkAktualOpisy = $id and lang = '$lang'
			";
				
			$this->dbInt->ExecQuery($query);
		}
	}

	private function ShowDialog()
	{
		$module = new ModulesMgr();
		$module->loadModule('Aktualizacje');
		$okAction = $module->getModuleActionIdByName('ShowAdmin');
			
		$dialog = new dialog('Info', 'Operacja wykonana prawidłowo', 'Info', 300, 150);
		$dialog->setAlign('center');
		$dialog->setOkCaption('Ok');
		$dialog->setOkAction($okAction);
		$ret = $dialog->show(1);
		return $ret;
	}

	//mode: short / full
	private function Show($mode, $idProgr, $page)
	{
		if ($mode == 'short')
		{
			$ile = 3;

		}
		else
		{
			$ile = 5;
		}
		if ($page>0)
		{
			$page -= 1;
		}
		$odStr = $page*$ile;
			

		$html = '';
		if ($_SESSION['lang']=='PL')
		{
			if ($mode == 'short')
			{
				$query = "
				SELECT
					G.nazwa AS nazwaGrupy, P.nazwa AS nazwaProgramu,
					DATE_FORMAT(A.dataWydania, '%d-%m-%Y') as dataWydania, A.wersja, A.opis
				FROM
					AktualizacjeOpisy A
					INNER JOIN AktualizacjeProgramy P ON A.fkProgram = P.id
					INNER JOIN AktualizacjeGrupy G ON G.id = P.fkGrupa
				WHERE
					P.active = 'T' and A.fkProgram = $idProgr
				ORDER BY
					A.dataWydania DESC
				LIMIT $odStr, $ile
				";
			}
			else
			{
				$query = "
				SELECT
				  	G.nazwa AS nazwaGrupy, P.nazwa AS nazwaProgramu, 
				  	DATE_FORMAT(A.dataWydania, '%d-%m-%Y') as dataWydania, A.wersja, A.opis 
				FROM
					AktualizacjeOpisy A
					INNER JOIN AktualizacjeProgramy P ON A.fkProgram = P.id
					INNER JOIN AktualizacjeGrupy G ON G.id = P.fkGrupa
				WHERE
					P.active = 'T' and A.fkProgram = $idProgr
				ORDER BY
					A.dataWydania DESC
				LIMIT $odStr, $ile
				";
			}
		}
		else
		{
			$langSess = $_SESSION['lang']; 
			if ($mode == 'short')
			{
				$query = "
				SELECT
					G.nazwa AS nazwaGrupy, P.nazwa AS nazwaProgramu,
					DATE_FORMAT(A.dataWydania, '%d-%m-%Y') as dataWydania, A.wersja, AL.opis
				FROM
					AktualizacjeOpisy A
					INNER JOIN AktualizacjeOpisyLang AL ON A.id = AL.FkAktualOpisy 
					INNER JOIN AktualizacjeProgramy P ON A.fkProgram = P.id
					INNER JOIN AktualizacjeGrupy G ON G.id = P.fkGrupa
				WHERE
					P.active = 'T' AND AL.lang='$langSess' and A.fkProgram = $idProgr
				ORDER BY
					A.dataWydania DESC
				LIMIT $odStr, $ile
				";
			}
			else
			{
				$query = "
				SELECT
					G.nazwa AS nazwaGrupy, P.nazwa AS nazwaProgramu,
					DATE_FORMAT(A.dataWydania, '%d-%m-%Y') as dataWydania, A.wersja, AL.opis
				FROM
					AktualizacjeOpisy A
					INNER JOIN AktualizacjeOpisyLang AL ON A.id = AL.FkAktualOpisy 
					INNER JOIN AktualizacjeProgramy P ON A.fkProgram = P.id
					INNER JOIN AktualizacjeGrupy G ON G.id = P.fkGrupa
				WHERE
					P.active = 'T' AND AL.lang='$langSess' and A.fkProgram = $idProgr
				ORDER BY
					A.dataWydania DESC
				LIMIT $odStr, $ile
				";
			}

		}
		
		$DBInt = DBSIngleton::getInstance();
		$qResult = $this->dbInt->ExecQuery($query);
		$i = 0;
		
		// translator
		
		$aktItems = array();
		//$sectTitleTx = $this->translator->translate('textTitle');
		while ($data = $qResult->fetchRow(DB_FETCHMODE_ASSOC))
		{
			$aktItem = new AktualizacjaItem();
			$aktItem->data = $data['dataWydania'];
			$aktItem->wersja = htmlspecialchars_decode($data['wersja'], ENT_QUOTES);
			$aktItem->opis = htmlspecialchars_decode($data['opis'], ENT_QUOTES);
			$aktItem->grupa = $data['nazwaGrupy'];
			$aktItem->program = $data['nazwaProgramu'];
			$aktItems[] = $aktItem;
		}
		
		$queryIle = "SELECT COUNT(1) as ileRek
				FROM
					AktualizacjeOpisy A
					INNER JOIN AktualizacjeProgramy P ON A.fkProgram = P.id
					INNER JOIN AktualizacjeGrupy G ON G.id = P.fkGrupa
				WHERE
					P.active = 'T' and A.fkProgram = $idProgr";
		
		$qResult = $this->dbInt->ExecQuery($queryIle);
		$dataIle = $qResult->fetchRow(DB_FETCHMODE_ASSOC);
		
		$ileRek = $dataIle['ileRek'];
		$arrViewPages = array();
		for($i=1; $i <= (ceil($ileRek/$ile)); $i++)
		{
			$arrViewPages[]=$i;
		}	
		//$actualPage = $nrStrony;
		
		$nextPageAct = $_GET['mp'];
				
		$smarty = new mySmarty();
		
		$smarty->assign('pages', $arrViewPages);
		$smarty->assign('nextPageAct', $nextPageAct);
		$smarty->assign('actualPage', $page+1);
		
		$smarty->assign('sectTitleTx', '');
		$smarty->assign('aktItems', $aktItems);

		if ($mode == 'short')
		{
			$html = $smarty->fetch('modules/AktualizacjeShort.tpl');
		}
		else
		{
			$html = $smarty->fetch('modules/AktualizacjeFull.tpl');
		}
		
		return $html;

	}

	public function __construct()
	{
		$this->dbInt = DBSingleton::getInstance();
		$this->translator = new translator(rootPath.'/Modules/Aktualizacje/Aktualizacje.Translation.xml');
		$this->translator->setLanguage($_SESSION['lang']);
	}
	public function Add($id)
	{
	
		saveActionValue();
		$moduleTmp = new ModulesMgr();
		$moduleTmp->loadModule('Aktualizacje');
		$action=0;
		if ($id == 0)
		{
			$action = $moduleTmp->getModuleActionIdByName('Add');
		}
		else
		{
			$action = $moduleTmp->getModuleActionIdByName('Edit');
		}
		unset($moduleTmp);

		$langQuery = "
    			SELECT DISTINCT
    			  ShortName
    			FROM
    			  cmsLang ORDER BY id
    				";
		 
		$DBInt = DBSIngleton::getInstance();
		$qResult = $this->dbInt->ExecQuery($langQuery);
		$i = 0;

		while ($data = $qResult->fetchRow(DB_FETCHMODE_ASSOC))
		{
			$langs[] = $data['ShortName'];
		}

		 
		$html = '';
			
		$html .= '<table width="600" align="center" cellpadding=0 cellspacing=0 border=0><tr><td>';
		$myForm = null;
		$myForm = new Form('dFORM', 'post');
		$aktForm = $myForm->getFormInstance();
		$aktForm->addElement('header', ' hdrTest', 'Aktualizacje');

		$aktForm->addElement('hidden', 'a', $action, null);
		$valId = $aktForm->addElement('hidden', 'id', $id);

		$moduleTmp = new ModulesMgr();
		$moduleTmp->loadModule('Aktualizacje');
		$actionProgram = $moduleTmp->getModuleActionIdByName('chooseProgram');
		unset($moduleTmp);

		$program = $aktForm->addElement('text', 'txtProgram', 'Program', 'readonly="readonly"');
		$buttonProgram = $aktForm->addElement('button', 'btnProgram', 'wybierz...', '');
		$buttonProgramAttributes = array('title'=>'asdasd', 'onclick'=>"return window.open('?a=$actionProgram&onlycontent=1&idcol=hidden&namecol=txtProgram', 'Wybór', 'menubar=0,location=0,directories=0,toolbar=0,resizable,dependent,width=740,height=400', scrollbars=1);");
		$buttonProgram->updateAttributes($buttonProgramAttributes);

		$date_options = array('language' => 'pl', 'format' => 'dMY', 'minYear' => 2005, 'maxYear' => 2050);

		$elementdata = $aktForm->addElement('date', 'data', 'Data', $date_options);
		$wersja = $aktForm->addElement('text', 'txtWersja', 'Wersja', array('size' => 20, 'maxlength'=> 25));

		for($i = 0; $i < count($langs); $i++)
		{
			$langOpisy[$langs[$i]] = $aktForm->addElement('textarea', 'opis'.$langs[$i], 'Opis ('.$langs[$i].')', array('cols'=>50, 'rows'=>5, 'maxlength'=>32000));
		}

		$aktForm->addElement('reset', 'btnReset', 'Wyczyść');
		$aktForm->addElement('submit', 'btnSubmit', 'Zapisz');

		$aktForm->addRule('txtProgram', 'Pole musi być wypełnione', 'required', null, 'server');
		$aktForm->addRule('txtWersja', 'Pole musi być wypełnione', 'required', null, 'server');
		 
		$aktForm->applyFilter('__ALL__', 'trim');
		$myForm->setStyle(2);
		if ($aktForm->validate())
		{
			$arrOpisy = array();

			$dataTmp = $elementdata->getValue();
			 
			$dataVal = $dataTmp['Y'][0].'-'.$dataTmp['M'][0].'-'.$dataTmp['d'][0];
			 
			$opisPL =htmlspecialchars($langOpisy['PL']->GetValue(), ENT_QUOTES|ENT_IGNORE, 'UTF-8');
			$wersjaVal = $wersja->GetValue();
			$progName = $program->GetValue();
				
			 
			/*for ($i=0; $i<count($langs); $i++)
			{
				if ($langs[$i] != 'PL')
				{
					$arrOpisy[$langs[$i]] =htmlspecialchars(addslashes($langOpisy[$langs[$i]]->getValue()));
				}
			}*/

			//zapis do tabeli podstawowej (insert lub update w zaleznosci od id)
			$fkId = $this->SaveAktualizacje($id, $progName, $dataVal, $wersjaVal, $opisPL);
			//update tabeli lang
			//$this->UpdateAktualizacjeLang($id, $arrOpisy);
			$html .= $this->ShowDialog();
		}
		else
		{
			if ($id != 0)
			{
				$query = "
				SELECT
				opis, dataWydania, wersja, fkProgram
				FROM
				AktualizacjeOpisy
				WHERE id = $id";

				$qResult = $this->dbInt->ExecQuery($query);
				$dataQ = $qResult->fetchRow(DB_FETCHMODE_ASSOC);
				$dataW = '';
				$dataW = $dataQ['dataWydania'];
				$opisTmp = htmlspecialchars_decode($dataQ['opis'], ENT_QUOTES);
				$wersjaTmp = $dataQ['wersja'];
				$programTmp = $dataQ['fkProgram'];
				$query = 'SELECT nazwa FROM AktualizacjeProgramy WHERE id='.$programTmp;
				$dbRes = $this->dbInt->ExecQuery($query);
				$dataRec = $dbRes->fetchRow(DB_FETCHMODE_ASSOC);
				$program->setValue($dataRec['nazwa']);

				$dataArr = explode('-', $dataW);
				$dataArrFinal = array('Y'=>$dataArr[0], 'M'=>$dataArr[1], 'd'=>$dataArr[2]);
				$elementdata->SetValue($dataArrFinal);

				$wersja->SetValue($wersjaTmp);

				$langOpisy['PL']->SetValue($opisTmp);

				//wypelniam dla pozostalych jezykow
				$langQuery = "
    			SELECT DISTINCT
    			  ShortName
    			FROM
    			  cmsLang
    			WHERE ShortName <> 'PL'  ORDER BY id";
				 
				$DBInt = DBSIngleton::getInstance();
				$qResult = $this->dbInt->ExecQuery($langQuery);

				/*while ($data = $qResult->fetchRow(DB_FETCHMODE_ASSOC))
				{
					$lang = $data['ShortName'];
					$queryAktLang = "
					SELECT
					opis
					FROM
					AktualizacjeOpisyLang
					WHERE
					lang='$lang' AND FkAktualOpisy=$id
					";
						
					$qResult = $this->dbInt->ExecQuery($queryAktLang);
					$d = $qResult->fetchRow(DB_FETCHMODE_ASSOC);
					$langOpisy[$lang]->SetValue(htmlspecialchars_decode($d['opis']));
				}*/

			}
			 
			$html .= $aktForm->toHtml();
		}

		$html .= '</td></tr></table>';

		return $html;



	}
	public function Del($id)
	{
		$html = '';
		$module = new ModulesMgr();
		$module->loadModule('Aktualizacje');
		$okAction = $module->getModuleActionIdByName('ShowAdmin');

		try
		{
			$sql = "DELETE FROM AktualizacjeOpisy WHERE id = $id";
			$this->dbInt->ExecQuery($sql);
				
			$dialog = new dialog('Usuwanie', 'Usunięto wpis!<br/>', 'Info', 300, 150);
			$dialog->setAlign('center');
			$dialog->setOkCaption('Ok');
			$dialog->setOkAction($okAction);
			$html .= $dialog->show(1);
			return $html;
		}
		catch(exception $e)
		{
			$dialog = new dialog('Usuwanie', 'Usuwanie nie powiodło się!<br/>'.$e->GetMessage(), 'Alert', 300, 150);
			$dialog->setAlign('center');
			$dialog->setOkCaption('Ok');
			$dialog->setOkAction($okAction);
			$html .= $dialog->show(1);
			return $html;
		}

	}
	public function ShowAdmin()
	{
		
		$html = '';
		$module = new modulesMgr();
		$module->loadModule('Aktualizacje');
		$showAction = $module->getModuleActionIdByName('ShowAdmin');
		$addAction = $module->getModuleActionIdByName('Add');
		$editAction = $module->getModuleActionIdByName('Edit');
		$delAction =  $module->getModuleActionIdByName('Del');
		unset($module);
		$addButton = new button(buttonAddIcon, 'Dodaj aktualizację', $addAction, -1);

		//wyopelneinie tablicy buttonow 
		$arrButtons = array();
		
                
		$queryButtons = 'SELECT id, nazwa FROM AktualizacjeProgramy Order By sortkey';
		$DBInt = DBSIngleton::getInstance();
		$qResult = $this->dbInt->ExecQuery($queryButtons);
				
		while ($data = $qResult->fetchRow(DB_FETCHMODE_ASSOC))
		{
			$tmpButton = new button('', $data['nazwa'], $showAction, -1);
			//$tmpButton->addOtherArgs('a', $showAction);
			$tmpButton->addOtherActionArgs('s', $data['id']);
			$arrButtons[]=$tmpButton; 
		}
	
		//--
		$whereClause = '';
		if ($_SESSION['s']>-1)
		{
			$s = $_SESSION['s'];
			$whereClause = " WHERE p.id=$s";
		}
			  
		$query = "
 				SELECT 
 					a.dataWydania, a.wersja, SUBSTRING(a.opis, 1, 500) as opisSh, a.id, p.nazwa as nazwaProgramu, g.nazwa as nazwaGrupy
 				FROM
 					AktualizacjeOpisy a 
 						INNER JOIN AktualizacjeProgramy p ON a.fkProgram = p.id
 						INNER JOIN AktualizacjeGrupy g ON p.fkGrupa = g.id
				$whereClause 				
 				ORDER BY
 					dataWydania desc, g.sortkey asc, p.sortkey asc
 				";
		
		$html .= '<table class="Grid" align="center" cellspacing=0>';
		$html .= '<tr>';
		$html .= '<td width=50><img src="./Cms/Files/Img/about-48x48.png" /></td>';
		$html .= '<td><br/></td>';
		$html .= '</tr>';
		$html .= '<tr><td align="center" colspan="2"><hr/>';
		foreach($arrButtons as $btn)
		{
			$html .= $btn->show(1);
		}
		$html .= '</td></tr>';
		$html .= '<tr><td align="right" colspan="2"><hr/>';
		$html .= $addButton->show(1);
		$html .= '</td></tr>';
		$html .= '<tr><td>';
		$grid = new gridRenderer();
		$grid->setTitle('Aktualizacje');
		$grid->setGridAlign('center');
		$grid->setGridWidth(780);
		$grid->addColumn("nazwaGrupy", 'Grupa programów', 80, false, false, 'center');
		$grid->addColumn("wersja", 'Wersja', 50, false, false, 'center');
		$grid->addColumn("nazwaProgramu", 'Nazwa programu', 80, false, false, 'center');
		$grid->addColumn("dataWydania", 'Data', 50, false, false, 'center');
		$grid->addColumn("opisSh", 'Opis', 300, false, false,  'left');
		$grid->addColumn("id", "", 10, true, false, 'right');
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
	public function ShowShort()
	{
		//ile wyswietlic rekordow
		return $this->Show('short');
			
	}
	public function ShowFull($idProgr, $page)
	{
		return $this->Show('full', $idProgr, $page);
	}

	public function chooseProgram()
	{
		$query =
		"
 			SELECT 
 				p.`id`, p.`nazwa` as Value, p.`nazwa` as program, g.`nazwa` as grupa
 			FROM
 				`AktualizacjeProgramy` p INNER JOIN `AktualizacjeGrupy` g ON p.fkGrupa=g.id
 			WHERE
 				p.`active` = 'T'
 			ORDER BY
 				g.`sortkey`, p.`sortkey`
 				" ;
			
			
		$result = '';
		$result .= '<table class="Grid" align="center" cellspacing=0>';

		$result .= '<tr><td colspan="2">';

		$pagesListGrid = new gridRenderer();
		$pagesListGrid->setDataQuery($query);
		$pagesListGrid -> setTitle('Lista pozycji menu');
		$pagesListGrid->setGridAlign('center');
		$pagesListGrid->setGridWidth(680);
		 
		$pagesListGrid->addColumn('grupa', 'Pełna nazwa', 200, false, false, 'left');
		$pagesListGrid->addColumn('program', 'Nazwa techn.', 200, false, false, 'left');
		$pagesListGrid->addColumn('id', '', 200, true, false, 'right');
		$pagesListGrid->addColumn('Value', 'aaa', 100, false, true, 'left');
		$pagesListGrid->callBackAction('window.opener.document.dFORM.txtProgram.value');
		//$menuListGrid->enabledEditAction(13);
		$result .= $pagesListGrid->renderHtmlGrid(1);
		$result .= '</td></tr>';
		$result .= '</table>';
		 
		restoreActionValue();
		return $result;
	}

}
?>
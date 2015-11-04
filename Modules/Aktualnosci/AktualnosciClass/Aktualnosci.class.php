<?php

//klaa kontener na potrzeby wyswieltnia Frontend
final class AktualnosciItem
{
	public $data;
	public $tytul;
	public $tresc;
}

class AktualnosciClass
{
	private $dbInt = null;
	private $translator;

	private function SaveAktualnosci($id, $data, $tytul, $tresc)
	{
		$resId = 0;
		if ($id == 0)
		{
			$query = "
			INSERT INTO Aktualnosci(Data, Tytul, Tresc)
			VALUES ('$data', '$tytul', '$tresc')
			";
		}
		else
		{
			$resId = $id;
			$query = "
			UPDATE Aktualnosci SET
			Data = '$data',
			Tytul = '$tytul',
			Tresc = '$tresc'
			WHERE
			id = $id
			";
		}

		$this->dbInt->ExecQuery($query);

		if ($id = 0)
		{
			$queryChk = "
			SELECT id FROM Aktualnosci
			WHERE Data='$data', Tytul='$tytul', Tresc='$tresc'
			";
				
			$qResult = $this->dbInt->ExecQuery($queryChk);
			$data = $qResult->fetchRow(DB_FETCHMODE_ASSOC);
			$resId = $data['id'];
		}

		return $resId;
		}
		private function UpdateAktualnosciLang($id, $arrTytuly, $arrTresci)
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
				$tytul = $arrTytuly[$lang];
				$tresc = $arrTresci[$lang];
				$query = "
				UPDATE AktualnosciLang
				SET tytul='$tytul', tresc='$tresc'
				WHERE FkAktualnosci = $id and lang= '$lang'
				";
					
				$this->dbInt->ExecQuery($query);
			}
		}

		private function ShowDialog()
		{
			$module = new ModulesMgr();
			$module->loadModule('Aktualnosci');
			$okAction = $module->getModuleActionIdByName('AktualnosciShowAdmin');
				
			$dialog = new dialog('Info', 'Operacja wykonana prawidłowo', 'Info', 300, 150);
			$dialog->setAlign('center');
			$dialog->setOkCaption('Ok');
			$dialog->setOkAction($okAction);
			$ret = $dialog->show(1);
			return $ret;
		}
		
		private function Show($mode)
		{
			//ile wyswietlic rekordow
			$page=0;
                        $ile = 0;
                        
			if ($mode == 'short')
			{
				$ile = 3;
			}
			else
			{
				$ile = 10;
			}
			if (isset($_GET['page']))
  			{
  				$page=$_GET['page'];
  			}
  			else
  			{
  				$page=0;
  			}
			
			if ($page>0)
			{
				$page -= 1;
			}
			$odStr = $page*$ile;



			$html = '';
			
				if ($_SESSION['lang']=='PL')
				{
					$query = "
					SELECT
						Data as data, Tytul as tytul, Tresc as tresc
					FROM
			  			Aktualnosci
			  		ORDER BY
			  			data DESC
			  		LIMIT $odStr, $ile
			  		";
				}
				else
				{
					$query = "
					SELECT
						a.data, al.tytul, al.tresc
					FROM
						Aktualnosci a INNER JOIN AktualnosciLang al ON a.id=al.FkAktualnosci
					ORDER BY
						a.data DESC
					LIMIT $odStr, $ile

					";
						
				}
			
			$DBInt = DBSIngleton::getInstance();
			$qResult = $this->dbInt->ExecQuery($query);
			$i = 0;

			// translator
			//$tanslator = new Translator();
			$aktItems = array();
			//$sectTitleTx = $this->translator->translate('textTitle');
			while ($data = $qResult->fetchRow(DB_FETCHMODE_ASSOC))
			{
			 $aktItem = new AktualnosciItem();
			 $aktItem->data = $data['data'];
			 $aktItem->tytul = $data['tytul'];
			 $aktItem->tresc = $data['tresc'];
			 $aktItems[] = $aktItem;
			}

			$queryIle = "SELECT COUNT(1) as ileRek
				FROM
					Aktualnosci A";
		
			$qResult = $this->dbInt->ExecQuery($queryIle);
			$dataIle = $qResult->fetchRow(DB_FETCHMODE_ASSOC);
		
			$ileRek = $dataIle['ileRek'];
			$arrViewPages = array();
			
		for($i=1; $i <= ceil($ileRek / $ile); $i++)
		{
			$arrViewPages[]=$i;                        
		}	
		//$actualPage = $nrStrony;
		
		$nextPageAct = $_GET['mp'];
				
		$smarty = new mySmarty();
		
		$smarty->assign('pages', $arrViewPages);
		$smarty->assign('nextPageAct', $nextPageAct);
		$smarty->assign('actualPage', $page+1);
       
                $smarty->assign('aktItems', $aktItems);

                if ($mode == 'short')
                {
                        $html = $smarty->fetch('modules/AktualnosciShort.tpl');
                }
                else
                {
                        $html = $smarty->fetch('modules/AktualnosciFull.tpl');
                }

                return $html;
			
		}
		
		public function __construct()
		{
			$this->dbInt = DBSingleton::getInstance();
			$this->translator = new translator(rootPath.'/Modules/Aktualnosci/Aktualnosci.Translation.xml');
			$this->translator->setLanguage($_SESSION['lang']);
		}
		public function Add($id)
		{

			$moduleTmp = new ModulesMgr();
			$moduleTmp->loadModule('Aktualnosci');
			if ($id == 0)
			{
				$action = $moduleTmp->getModuleActionIdByName('AktualnosciAdd');
			}
			else
			{
				$action = $moduleTmp->getModuleActionIdByName('AktualnosciEdit');
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
				
			$html .= '<table width="700" align="center" cellpadding=0 cellspacing=0 border=0><tr><td>';
			$myForm = null;
			$myForm = new Form('dFORM', 'POST');
			$aktForm = $myForm->getFormInstance();
			$aktForm->addElement('header', ' hdrTest', 'Aktualności');

			$aktForm->addElement('hidden', 'a', $action, null);
			$valId = $aktForm->addElement('hidden', 'id', $id);

			$dateOptions = array('language' => 'pl', 'format' => 'dMY', 'minYear' => 2005, 'maxYear' => 2050);
			$data = $aktForm->addElement('date', 'data', 'Data', $dateOptions);

			for($i = 0; $i < count($langs); $i++)
			{
				$langTytuly[$langs[$i]] = $aktForm->addElement('text', 'tytul'.$langs[$i], 'Tytuł ('.$langs[$i].')', array('size' => 50, 'maxlength'=> 90));
				$langTresci[$langs[$i]] = $aktForm->addElement('textarea', 'tresc'.$langs[$i], 'Treść ('.$langs[$i].')', array('cols'=>80, 'rows'=>15, 'maxlength'=>16000));
			}
			$aktForm->addElement('reset', 'btnReset', 'Wyczyść');
			$aktForm->addElement('submit', 'btnSubmit', 'Zapisz');

			$aktForm->applyFilter('__ALL__', 'trim');
			$myForm->setStyle(2);
			if ($aktForm->validate())
			{
				$arrTresci = array();
				$arrTytuly = array();
				 
				$dataTmp = $data->getValue();
				$dataVal = $dataTmp['Y'][0].'-'.$dataTmp['M'][0].'-'.$dataTmp['d'][0];
				 
				$tytulPL = $langTytuly['PL']->GetValue();
				$trescPL = $langTresci['PL']->GetValue();
					
				 
				for ($i=0; $i<count($langs); $i++)
				{
					if ($langs[$i] != 'PL')
					{
						$arrTresci[$langs[$i]] = $langTresci[$langs[$i]]->getValue();
						$arrTytuly[$langs[$i]] = $langTytuly[$langs[$i]]->getValue();
					}
				}

				//zapis do tabeli podstawowej (insert lub update w zaleznosci od id)
				$fkId = $this->SaveAktualnosci($id, $dataVal, $tytulPL, $trescPL);
				//update tabeli lang
				$this->UpdateAktualnosciLang($id, $arrTytuly, $arrTresci);
				$html .= $this->ShowDialog();
			}
			else
			{
				if ($id != 0)
				{

					//wypaleniam dane PL
					$query = "SELECT
					Data, Tytul, Tresc
					FROM
					Aktualnosci
					WHERE id = $id";
					$qResult = $this->dbInt->ExecQuery($query);                                        
					$dataQ = $qResult->fetchRow(DB_FETCHMODE_ASSOC);
					$dataAkt = $dataQ['Data'];
					$tytul = $dataQ['Tytul'];
                                    	$tresc = $dataQ['Tresc'];

					$dataArr = explode('-', $dataAkt);
					$dataArrFinal = array('Y'=>$dataArr[0], 'M'=>$dataArr[1], 'd'=>$dataArr[2]);
					$data->SetValue($dataArrFinal);

					$langTytuly['PL']->SetValue($tytul);
					$langTresci['PL']->SetValue($tresc);

					//wypelniam dla pozostalych jezykow
					$langQuery = "
    			SELECT DISTINCT
    			  ShortName
    			FROM
    			  cmsLang WHERE ShortName <> 'PL' ORDER BY id
    				";
					 
					$DBInt = DBSIngleton::getInstance();
					$qResult = $this->dbInt->ExecQuery($langQuery);

					while ($data = $qResult->fetchRow(DB_FETCHMODE_ASSOC))
					{
						$lang = $data['ShortName'];
						$queryAktLang = "
						SELECT
						tytul, tresc
						FROM
						AktualnosciLang
						WHERE
						lang='$lang' AND FkAktualnosci=$id
						";
						$qResult = $this->dbInt->ExecQuery($queryAktLang);
						$d = $qResult->fetchRow(DB_FETCHMODE_ASSOC);
						$langTytuly[$lang]->SetValue($d['tytul']);
						$langTresci[$lang]->SetValue($d['tresc']);
					}
						
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
			$module->loadModule('Aktualnosci');
			$okAction = $module->getModuleActionIdByName('AktualnosciShowAdmin');

			try
			{
				$sql = "DELETE FROM Aktualnosci WHERE id = $id";
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
			$module->loadModule('Aktualnosci');
			$addAction = $module->getModuleActionIdByName('AktualnosciAdd');
			$editAction = $module->getModuleActionIdByName('AktualnosciEdit');
			$delAction =  $module->getModuleActionIdByName('AktualnosciDel');
			unset($module);
			$addButton = new button(buttonAddIcon, 'Dodaj post', $addAction, -1);
				
			$query = '
 				SELECT 
 					id, data, tytul, CONCAT(SUBSTR(tresc, 1, 100), "...") AS tresc
 				FROM 
 					Aktualnosci 
 				ORDER BY 
 					data DESC
 					';

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
			$grid->setTitle('Aktualności');
			$grid->setGridAlign('center');
			$grid->setGridWidth(780);
			$grid->addColumn("data", 'Data', 60, false, false, 'center');
			$grid->addColumn("tytul", 'Tytuł', 200, false, false,  'left');
			$grid->addColumn("tresc", 'Treść', 400, false, false,  'left');
			$grid->addColumn("id", "", 10, true, false, 'right');
			$grid->enabledDelAction($delAction);
			$grid->enabledEditAction($editAction);
			$grid->setDataQuery($query);
			$html .=$grid->renderHtmlGrid(1,false, true);
			$html .= '</td></tr>';
			$html .= '<tr><td align="right" colspan="2">';
			$html .= $addButton->show(1);
			$html .= '</td></tr>';
			$html .= '</table>';
				
			return $html;
		}
		
		
		
		public function ShowShort()
		{
			return $this->Show('short');
		}
		public function ShowFull()
		{
			return $this->Show('full');
		}
}
?>
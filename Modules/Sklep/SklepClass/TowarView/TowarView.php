<?php
class TowarView
{
	private $towar = null;
	private $towarId;

	private function ShowAfterTowarAdd($id)
	{
		$html = '';
		//$delQuery = "DELETE FROM cmsMenu WHERE id=$menuId";
		//$dbInt = DBSingleton::getInstance();
		//$dbInt->ExecQuery($delQuery);

		$module = new ModulesMgr();
		$module->loadModule('Sklep');
		$okAction = $module->getModuleActionIdByName('ShowTowaryAdmin');
		if ($id == 0)
		{
			$dialog = new dialog('Dodano towar' , 'Dodano towar', 'Info', 300, 150);
		}
		else
		{
			$dialog = new dialog('Zmieniono towar' , 'Zmieniono towar', 'Info', 300, 150);
		}
		$dialog->setAlign('center');
		$dialog->setOkCaption('Ok');
		$dialog->setOkAction($okAction);
		$html .= $dialog->show(1);

		return $html;
	}

	public function __construct()
	{
		$this->towar = new Towar();

	}

	
	public function testUniqueNazwa($val)
	{
		$id = $_SESSION['tmpTowarId'];
		$sql = "SELECT COUNT(1) as ile FROM Towary WHERE nazwa='$val' AND id<>$id";

		$DBInt = DBSingleton::getInstance();
		$dbResult = $DBInt->ExecQuery($sql);
		$recData = $dbResult->fetchRow(DB_FETCHMODE_ASSOC);
		$ile = $recData['ile'];

		return $ile==0;
	}

	public function ShowTowaryAdmin()
	{
		//echo 'in ShowTowary';
		$html = '';
		$module = new modulesMgr();
		$module->loadModule('Sklep');
		$addAction = $module->getModuleActionIdByName('AddTowarAdmin');
		$editAction = $module->getModuleActionIdByName('EditTowarAdmin');
		$delAction =  $module->getModuleActionIdByName('DelTowar');
		unset($module);
		$addButton = new button(buttonAddIcon, 'Dodaj towar', $addAction, -1);
		$path = '/FrontPage/Files/ImgShop/';
		$rezerwacja = new Konfiguracja();
		$rezerwacje = $rezerwacja->Rezerwacje();
		unset($rezerwacja);

		if ($rezerwacje)
		{
			$query = "
 				Select 
 					id, nazwa, cena, ilosc, CONCAT('$path',obrazMin) as obrazMin, zarezerwowany, 
 					wersja, rabat  
				From 
					Towary 
				WHERE
					ilosc>0
				Order By 
					nazwa";
		}
		else
		{
			$query = "
 				Select 
 					id, nazwa, cena, ilosc, CONCAT('$path',obrazMin) as obrazMin, zarezerwowany, 
 					wersja, rabat  
				From 
					Towary 
				Order By 
					nazwa";
		}
			
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
		$grid->setTitle('Towary');
		$grid->setGridAlign('center');
		$grid->setGridWidth(780);
		$grid->addColumn("nazwa", 'Nazwa', 200, false, false, 'left');
		$grid->addColumn("cena", 'Cena', 60, false, false,  'left');
		$grid->addColumn('ilosc', '<center>Ilość</center>', 20, false, false, 'center');
		$grid->addColumn('zarezerwowany', '<center>Rez.</center>', 20, false, false, 'center');
		$grid->addColumn("wersja", 'Wersja', 100, false, false, 'left');
		$grid->addColumn("rabat", 'Rabat', 100, false, false, 'left');
		$grid->addColumn("obrazMin", 'Miniatura', 250, false, false, 'center', true);
			
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
	public function ShowAddTowar($id)
	{
		$_SESSION['tmpTowarId'] = $id;
		//echo 'addTowar';
		$this->towarId = $id;
		$html = '';
		$langs = array();
		$langNazwy = array();
		$langOpisy = array();
		$langAutorzy = array();
		$langTechniki = array();
		$langRozmiary = array();
		$langRok = array();
		$html = '';

		$rezerwacja = new Konfiguracja();
		$rezerwacje = $rezerwacja->Rezerwacje();
		unset($rezerwacja);

		$langQuery = "
    			SELECT DISTINCT
    			  ShortName
    			FROM
    			  cmsLang ORDER BY id
    				";
			
		$DBInt = DBSIngleton::getInstance();
		$qResult = $DBInt->ExecQuery($langQuery);
		$i = 0;
		while ($data = $qResult->fetchRow(DB_FETCHMODE_ASSOC))
		{
			$langs[] = $data['ShortName'];
		}

		if ($id == 0)
		{
			$hdrText = 'Dodawanie towaru';
		}
		else
		{
			$hdrText = 'Edycja towaru';
		}


		$html .= '<center><table width="580" align="center" cellpadding=0 cellspacing=0 border=0><tr><td>';

		$myForm = null;
		$myForm = new Form('TowarForm', 'POST') ;
		$TowarForm = null;
		$TowarForm = $myForm->getFormInstance();
		$TowarForm -> addElement('header', ' hdrTest', $hdrText);

		$moduleTmp = new ModulesMgr();
		$moduleTmp->loadModule('Sklep');
		if ($id == 0)
		{
			$action = $moduleTmp->getModuleActionIdByName('AddTowarAdmin');
		}
		else
		{
			$action = $moduleTmp->getModuleActionIdByName('EditTowarAdmin');
		}

		$TowarForm->addElement('hidden', 'a', $action, null);
		$valId = $TowarForm->addElement('hidden', 'id', $id);

		$elementUID = $TowarForm->addElement('text', 'uid', 'UnikalneID(nazwa)', array('size' => 25, 'maxlength'=> 20));

		for($i = 0; $i < count($langs); $i++)
		{

			$langNazwy[$langs[$i]] = $TowarForm->addElement('text', 'nazwa'.$langs[$i], 'Nazwa ('.$langs[$i].')', array('size' => 50, 'maxlength'=> 200));

		}
		for($i = 0; $i < count($langs); $i++)
		{
			$langOpisy[$langs[$i]] = $TowarForm->addElement('textarea', 'opis'.$langs[$i], 'Opis ('.$langs[$i].')', array('cols'=>50, 'rows'=>5, 'maxlength'=>300));
		}
		
		$elementRabat = $TowarForm->addElement('text', 'rabat', 'Rabat(%)', array('size' => 30, 'maxlength'=> 45));
		
		$algList[0] = 'Algorytm liczenia cen egz/il dla wersji zwykłych';
		$algList[1] = 'Algorytm liczenia cen egz/il dla wersji sieciowych';
		$elementAlg = $TowarForm->addElement('select', 'selAlg' ,'Algorytm liczenia ceny', $algList);
		
		for($i = 0; $i < count($langs); $i++)
		{
			$langWersja[$langs[$i]] = $TowarForm->addElement('text', 'wersja'.$langs[$i], 'Wersja ('.$langs[$i].')', array('size' => 20, 'maxlength'=> 20));
		}

		$cena = $TowarForm->addElement('text', 'cena', 'Cena (bazowa)', array('size' => 20, 'maxlength'=> 10));
		if ($rezerwacje)
		{
			$ilosc = $TowarForm->addElement('text', 'ilosc', 'Ilość', array('size' => 20, 'maxlength'=> 10));
		}

		if (($id != 0)&&($rezerwacje))
		{
			$zarezerwowany = $TowarForm->addElement('text', 'zarezerwowany', 'Rezerwacja', array('size' => 5, 'maxlength'=> 1));
		}
		$obrazMin = $TowarForm->addElement('file', "obrazMin", "Miniatura");
		
		$TowarForm->addElement('reset', 'btnReset', 'Wyczyść');
		$TowarForm->addElement('submit', 'btnSubmit', 'Zapisz');
			
		//reguly
		
		$TowarForm->registerRule('testUniqueNazwa', 'callback', 'testUniqueNazwa', 'TowarView');
			
		$TowarForm->addRule('cena', 'Wartość w polu "Cena" musi być liczbą', 'numeric', null, 'server');
		$TowarForm->addRule('ilosc', 'Wartość w polu "Ilość" musi być liczbą', 'numeric', null, 'server');
				
		$TowarForm->addRule('nazwa', 'Nazwa towaru nie jest unikalna', 'testUniqueNazwa');
		$TowarForm->addRule('obrazMin', 'Maksymalny rozmiar pliku to 1 MB', 'maxfilesize', 1024000);
					
		$TowarForm->addRule('nazwaPL', 'Pole "Nazwa" musi być wypełnione', 'required', null, 'server');
		$TowarForm->addRule('nazwaPL', 'Istnieje już towar o takiej nazwie', 'testUniqueNazwa');
		$TowarForm->addRule('cena', 'Pole "Cena" musi być wypełnione', 'required', null, 'server');
		if ($rezerwacje)
		{
			$TowarForm->addRule('ilosc', 'Pole "Ilość" musi być wypełnione', 'required', null, 'server');
		}
		if (($rezerwacje)&&($id !=0))
		$TowarForm->addRule('zarezerwowany', 'Pole "Rezerwacja" musi być wypełnione', 'required', null, 'server');
			
		$TowarForm->applyFilter('__ALL__', 'trim');
		$myForm->setStyle(2);
		if ($TowarForm->validate())
		{
			$fileInfMin = $obrazMin->GetValue();
			
			if ($id !=0)
			{
				if (!isset($this->towar))
				$this->towar = new Towar();
					
				$this->towar->Load($_SESSION['tmpTowarId'], 'PL');

			}
			$this->towar = new Towar();

			$this->towar->Load($_SESSION['tmpTowarId'], 'PL');
			if (($fileInfMin['name'] <> ''))
			if ($obrazMin->isUploadedFile()) 
			{
					
				$nazwaMin = $fileInfMin['name'];	
				$obrazMin->moveUploadedFile('./FrontPage/Files/ImgShop/');
				$this->towar->SetObrazMin($nazwaMin);
				
			}




			//settery
			$this->towar->SetCena($cena->GetValue());
			if ($rezerwacje)
			{
				$this->towar->SetIlosc($ilosc->GetValue());

			}
				

			if (($id != 0 )&& ($rezerwacje))
			$this->towar->SetZarezerwowany($zarezerwowany->GetValue());

			$this->towar->SetNazwa($langNazwy['PL']->GetValue());

			$this->towar->SetOpis($langOpisy['PL']->GetValue());
			
			$this->towar->SetWersja($langWersja['PL']->GetValue());
			$this->towar->SetRabat($elementRabat->GetValue());
			$alg = $elementAlg->GetValue();
			$this->towar->SetAlgCeny($alg[0]);
			$this->towar->SetUID($elementUID->GetValue());

			$this->towar->Save($id);

			//update jezykow
			$queryLang = "SELECT ShortName FROM cmsLang WHERE ShortName <>'PL'";
			$DBInt = DBSIngleton::getInstance();
			$qResult = $DBInt->ExecQuery($queryLang);

			$nazwaTmp = $langNazwy['PL']->GetValue();


			while ($data = $qResult->fetchRow(DB_FETCHMODE_ASSOC))
			{
				$updateQuery = 'UPDATE TowaryLang SET ';
				$lang = $data['ShortName'];
				$coma = false;
				if ((isset($langNazwy[$lang]))&&($langNazwy[$lang]->GetValue() <> ''))
				{


					$updateQuery .= ' nazwa="'.$langNazwy[$lang]->GetValue().'"';
					$coma = true;
				}
				if ((isset($langOpisy[$lang]))&&($langOpisy[$lang]->GetValue() <> ''))
				{
					if ($coma) $updateQuery.=',';
					$updateQuery .= ' opis="'.$langOpisy[$lang]->GetValue().'"';
					$coma=true;
				}
				
				if ((isset($langWersja[$lang]))&&($langWersja[$lang]->GetValue() <> ''))
				{
					if ($coma) $updateQuery.=',';
					$updateQuery .= ' wersja="'.$langWersja[$lang]->GetValue().'"';
					$coma=true;
				}
				
				$updateQuery .= " WHERE FKTow=$id and lang='$lang'";
					
				$DBInt = DBSIngleton::getInstance();
				$DBInt->ExecQuery($updateQuery);
			}

			//komunikat ze dodano
			$html .= $this->ShowAfterTowarAdd($id);
		}
		else
		{
			if ($id != 0)
			{
				$this->towar->Load($_SESSION['tmpTowarId'], 'PL');
				//wypelniam dane
				$cena->setValue($this->towar->GetCena(1,3));
				if ($rezerwacje)
				$ilosc->setValue($this->towar->GetIlosc());
				if ($rezerwacje)
				{
					$zarezerwowany->setValue($this->towar->GetZarezerwowany());
				}
				$obrazMin->setValue($this->towar->GetObrazMin());
				
				$langNazwy["PL"]->setValue($this->towar->GetNazwa());
				$langOpisy["PL"]->setValue($this->towar->GetOpis());
			
				$langWersja["PL"]->setValue($this->towar->GetWersja());
				$elementRabat->setValue($this->towar->GetRabat());
				$elementUID->SetValue($this->towar->GetUID());
				$elementAlg->SetValue($this->towar->GetAlgCeny());
				//jezyki
				$queryLang = "SELECT ShortName FROM cmsLang WHERE ShortName <>'PL'";
				$DBInt = DBSIngleton::getInstance();
				$qResult = $DBInt->ExecQuery($queryLang);
				while ($data = $qResult->fetchRow(DB_FETCHMODE_ASSOC))
				{
					$lang = $data['ShortName'];

					$query = "
						SELECT nazwa, opis, wersja
						FROM TowaryLang
						WHERE FKTow=$id AND lang='$lang'		
								";
					$qResult2 = $DBInt->ExecQuery($query);
					$data2 = $qResult2->fetchRow(DB_FETCHMODE_ASSOC);

					$langNazwy["$lang"]->setValue($data2['nazwa']);
					$langOpisy["$lang"]->setValue($data2['opis']);
					
					$langWersja["$lang"]->setValue($data2['wersja']);
					
				}
			}


			$html .= $TowarForm->toHtml();
		}

		$html .= '</td></tr></table>';

		return $html;

	}

	public function DelTowar($id)
	{
		$html = '';

		$dbInt = DBSingleton::getInstance();
		$chkQuery = "SELECT COUNT(1) AS ile FROM ZamowieniaTowary WHERE FkTow=$id";
		$res = $dbInt->ExecQuery($chkQuery);
		$data = $res->fetchRow(DB_FETCHMODE_ASSOC);
		if ($data['ile'] > 0)
		{
			$module = new ModulesMgr();
			$module->loadModule('Sklep');
			$okAction = $module->getModuleActionIdByName('ShowTowaryAdmin');
			$dialog = new dialog('Usuwanie towatu' , 'Towar nie może być usunięty, gdyż zostało wystawione zamówienie', 'Info', 300, 150);
			$dialog->setAlign('center');
			$dialog->setOkCaption('Ok');
			$dialog->setOkAction($okAction);
			$html .= $dialog->show(1);
		}
		else
		{
			$delQuery = "DELETE FROM Towary WHERE id=$id";

			$dbInt->ExecQuery($delQuery);

			$module = new ModulesMgr();
			$module->loadModule('Sklep');
			$okAction = $module->getModuleActionIdByName('ShowTowaryAdmin');
			$dialog = new dialog('Usunięto towar' , 'Usunięto towar', 'Info', 300, 150);
			$dialog->setAlign('center');
			$dialog->setOkCaption('Ok');
			$dialog->setOkAction($okAction);
			$html .= $dialog->show(1);
		}
		return $html;
	}
	public function CannotDel()
	{
		$html = '';
		$module = new ModulesMgr();
		$module->loadModule('Sklep');
		$okAction = $module->getModuleActionIdByName('ShowTowaryAdmin');
		$dialog = new dialog('Uwaga' , 'Usuwanie towarów przypisdanych do oferty lub zarezerwowanych jest niedozwolone', 'Info', 300, 150);
		$dialog->setAlign('center');
		$dialog->setOkCaption('Ok');
		$dialog->setOkAction($okAction);
		$html .= $dialog->show(1);
	}


}

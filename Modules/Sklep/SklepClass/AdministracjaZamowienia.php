<?php

//FIXME: Klasa do refaktiryzacji - formularze przenisc do widoku

class AdministracjaZamowienia
{
	private $dbInt = null;

	private function GetMasterQuery($status, $order)
	{


		$sql = "
			SELECT
				Z.id, CONCAT('ZAM', Z.id) AS nrZam, Z.oplacone, 
				Z.dataStatusu, D.nazwa AS nazwaDostawy, P.nazwa AS nazwaPlatnosci,
				K.imie, K.nazwisko, K.nrTel, K.email, K.miasto, 
				CONCAT(K.ulica ,' ', K.nrDomu, '/', K.nrMieszkania) as Adres,
				CASE
					WHEN P.typ=3 THEN PM.mesg
					ELSE 'n.d.'  
				END AS mess,
				CASE
					WHEN Z.statusRabatu=-1 THEN 'wyłączony'
					WHEN Z.statusRabatu=0 THEN 'nienaliczony'
					WHEN Z.statusRabatu=1 THEN '<font color=red>do naliczenia</font>'
					WHEN Z.statusRabatu=2 THEN 'naliczony'
					WHEN Z.statusRabatu=3 THEN 'zrealizowany'
				END AS rabat,    
				CASE 
					WHEN K.dostNazwaFirmy<>'' THEN K.dostNazwaFirmy
					ELSE CONCAT(K.dostImie, ' ', K.dostNazwisko)
				END AS DaneZFV
			FROM 
				Zamowienia Z 
				INNER JOIN Dostawy D 
					ON D.id = Z.FKDostawa
				INNER JOIN Platnosci P 
					ON P.id = Z.FkPlatnosci
				INNER JOIN Klienci K 
					ON K.id = Z.FKKlient
				LEFT JOIN PlatnosciMesg PM 
					ON PM.FK_Zamowienia = Z.id
			WHERE
				Z.status = $status 
			ORDER BY
				Z.dataStatusu $order
		";

		return $sql;
	}
	//towrzy detailquery dla rekordow z master
	private function GetDetQuery($status)
	{
		$sql = "
				SELECT 
				  ZT.FKZam, T.nazwa, T.opis, ZT.ilosc 	
				FROM
				  Zamowienia Z
				  INNER JOIN ZamowieniaTowary ZT on Z.id = ZT.FKZam
				  INNER JOIN Towary T ON T.id = ZT.FKTow
				WHERE
				  Z.status = $status
			";
	}
	private function ShowSendDialog($id)
	{
		$html = '';
		$module = new ModulesMgr();
		$module->loadModule('Sklep');
		$cancelAction = $module->getModuleActionIdByName('ShowZamowieniaAdmin');
		$okAction = $module->getModuleActionIdByName('SendZamowienieStatus');
		$dialog = new dialog('Status zamówienia' , 'Zmienił się status zamówienia. Czy wysłać maila do klienta?', 'Query', 300, 150);
		$dialog->setAlign('center');
		$dialog->setOkCaption('Tak');
		$dialog->setOkAction($okAction);
		$dialog->setCancelAction($cancelAction);
		$dialog->setCancelCaption('Nie');
		$dialog->setId($id);
		$html .= $dialog->show(1);

		return $html;
	}
	public function ShowErrStatDialog($id)
	{
		$html = '';
		$module = new ModulesMgr();
		$module->loadModule('Sklep');
		
		$okAction = $module->getModuleActionIdByName('EditZamowienieAdmin');
		$dialog = new dialog('Błąd' , 'Stauts można tylko zwiększać o 1 "stopień"', 'Query', 300, 150);
		$dialog->setAlign('center');
		$dialog->setOkCaption('OK');
		$dialog->setOkAction($okAction);
		$dialog->setId($id);
		$html .= $dialog->show(1);

		return $html;
	}
	public function __construct()
	{
		$this->dbInt = DBSingleton::GetInstance();
	}
	public function __destruct()
	{

	}

	//wyświetla listę zwykłą lub master-detail z mozliwością sortowania (asc, desc)
	public function ShowZamowienia($status, $order)
	{
		$html = '';
		//przyciski filtrujace status - wsztystkei statusy
		//sortowania - wszystkie widoczne kolumny
		$modules = new ModulesMgr();
		$modules -> loadModule('Sklep');
		$filterAction = $modules -> getModuleActionIdByName('ShowZamowieniaAdmin');
		$sortAction = $modules -> getModuleActionIdByName('ShowZamowieniaAdmin');
		$stat = 1;
		$ord = 'desc';
		$stat = $status;

		if (($order != '') && (($order=='asc')||($order=='desc')))
		{
			$ord = $order;

		}
		if ($status == 0)
		{
			$txt = '<b>Pokaż niepotwierdzone</b>';
		}
		else
		{
			$txt = 'Pokaż niepotwierdzone';
		}
		$statusNoweButton = new button('', $txt, $filterAction, -1);
		$statusNoweButton->addOtherActionArgs('status', 0);
		$statusNoweButton->addOtherActionArgs('order', $ord);
		
		if ($status == 1)
		{
			$txt = '<b>Pokaż potwierdzone</b>';
		}
		else
		{
			$txt = 'Pokaż potwierdzone';
		}
		
		$statusPotwierdzoneButton = new button('', $txt, $filterAction, -1);
		$statusPotwierdzoneButton->addOtherActionArgs('status', 1);
		$statusPotwierdzoneButton->addOtherActionArgs('order', $ord);
		
		if ($status == 2)
		{
			$txt = '<b>Pokaż przyjęte</b>';
		}
		else
		{
			$txt = 'Pokaż przyjęte';
		}
		$statusPrzyjeteButton = new button('', $txt, $filterAction, -1);
		$statusPrzyjeteButton->addOtherActionArgs('status', 2);
		$statusPrzyjeteButton->addOtherActionArgs('order', $ord);

		if ($status == 3)
		{
			$txt = '<b>Pokaż wysłane</b>';
		}
		else
		{
			$txt = 'Pokaż wysłane';
		}
		
		$statusWyslaneButton = new button('', $txt, $filterAction, -1);
		$statusWyslaneButton->addOtherActionArgs('status', 3);
		$statusWyslaneButton->addOtherActionArgs('order', $ord);
		
		if ($status == 4)
		{
			$txt = '<b>Pokaż zrealizowane</b>';
		}
		else
		{
			$txt = 'Pokaż zrealizowane';
		}
		$statusZrealizowaneButton = new button('', $txt, $filterAction, -1);
		$statusZrealizowaneButton->addOtherActionArgs('status', 4);
		$statusZrealizowaneButton->addOtherActionArgs('order', $ord);

		
		$sortAscButton = new button('', 'Sortuj od najnowszego', $sortAction, -1);
		$sortAscButton->addOtherActionArgs('order', 'asc');
		$sortAscButton->addOtherActionArgs('status', $stat);

		$sortDescButton = new button('', 'Sortuj od najstarszego', $sortAction, -1);
		$sortDescButton->addOtherActionArgs('order', 'desc');
		$sortDescButton->addOtherActionArgs('status', $stat);

		$editAction = $modules -> getModuleActionIdByName('EditZamowienieAdmin');
		$delAction = $modules->getModuleActionIdByName('AnulujZamowienieAdmin');

		$html .= '<table class="Grid" align="center" cellspacing=0>';
		$html .= '<tr>';
		$html .= '<td width=130><img src="../Cms/Files/Img/about-48x48.png" /></td>';
		$html .= '<td><br/></td>';
		$html .= '</tr>';
		$html .= '<tr><td align="center" colspan="2"><hr/>';
		$html .=$statusNoweButton->show(1);
		$html .=$statusPotwierdzoneButton->show(1);
		$html .=$statusPrzyjeteButton->show(1);
		$html .=$statusWyslaneButton->show(1);
		$html .=$statusZrealizowaneButton->show(1);
		$html .= '</td></tr>';
		$html .= '<tr><td align="center" colspan="2"><hr/>';
		$html .=$sortAscButton->show(1);
		$html .=$sortDescButton->show(1);
		$html .= '<tr><td align="right" colspan="2"><hr/>';

		


		$query = $this->GetMasterQuery($stat, $ord);
		// 	$subQuery = $this->GetDetQuery($stat, $ord);

		$zamListGrid = new gridRenderer();
		$zamListGrid->setDataQuery($query);
		//	$zamListGrid->setRecurseQuery($subQuery, 'ZT.FKZam', $ordSubTxt);
		$zamListGrid->setTitle('Lista zamówień');
		$zamListGrid->setGridAlign('center');
		$zamListGrid->setGridWidth(790);
			
		$zamListGrid->addColumn('nrZam', 'Zamówienie', 80, false, false, 'left');
		$zamListGrid->addColumn('dataStatusu', 'Data ost. zm.', 80, false, false, 'left');		
		$zamListGrid->addColumn('nazwaDostawy', 'Dostawa', 80, false, false, 'left');
		$zamListGrid->addColumn('nazwaPlatnosci', 'Platnosc', 80, false, false, 'left');
		$zamListGrid->addColumn('DaneZFV', 'Dane z faktury', 160, false, false, 'left');		
		$zamListGrid->addColumn('imie', 'Imie zam', 80, false, false, 'left');
		$zamListGrid->addColumn('nazwisko', 'Nazwisko zam', 80, false, false, 'left');
		$zamListGrid->addColumn('Adres', 'Adres', 200, false, false, 'left');
		$zamListGrid->addColumn('oplacone', 'Zapl.', 30, false, false, 'center');
		$zamListGrid->addColumn('mess', 'Platnosci.pl', 250, false, false, 'left');
		//$zamListGrid->addColumn('rabat', 'Status rabatu', 100, false, false, 'left');
			
		$zamListGrid->addColumn("id", "", 200, true, false, 'right');
			
		$zamListGrid->enabledDelAction($delAction);
		$zamListGrid->enabledEditAction($editAction);
		//$zamListGrid->addAction($upAction, '../Cms/Files/Img/up.gif');
		//$zamListGrid->addAction($downAction, '../Cms/Files/Img/down.gif');
			
		$html .= $zamListGrid->renderHtmlGrid(1);
		$html .= '</td></tr>';
		$html .= '</table>';
			
		return $html;
			
			

	}
	public function DelZamowienie($id)
	{
		$tmpZam = new Zamowienie();
		$tmpZam->Load($id);
		$tmpZam->Delete();
		$modules = new ModulesMgr();
		$modules -> loadModule('Sklep');
		$action = $modules->getModuleActionIdByName('ShowZamowieniaAdmin');
		header("Location:?a=$action");
		
	}
	public function DelZamowienieDo($id)
	{

	}
	public function EditZamowienie($id)
	{
		/*
		 * Edytowac mozna czesc adresową oraz pozycje (dostępne pod )
		 */
		$html = '';
		$ZamowienieObj = new Zamowienie();
		$ZamowienieObj->Load($id);

		$dostawaId = $ZamowienieObj->GetDostawa();

		$KlientObj = new Klient();
		$KlientObj->LoadById($ZamowienieObj->klient->GetId());

		$modules = new ModulesMgr();
		$modules -> loadModule('Sklep');
		$action = $modules->getModuleActionIdByName('EditZamowienieAdmin');


		$platnosciId = $ZamowienieObj->GetPlatnosc();
		$uwagi = $ZamowienieObj->GetUwagi();
		$status = $ZamowienieObj->GetStatus();
		$dataStatus = $ZamowienieObj->GetDataStatusu();

		//formularz - poszczxgone czesci oddzielone headerami

		$module = new modulesMgr();
 		$module->loadModule('Sklep');
 		$editAction = $module->getModuleActionIdByName('EditPozZam');
 		
		$html .= '<center><table width="580" align="center" cellpadding=2 cellspacing=2 border=1><tr><td>';
		$zamListGrid = new gridRenderer();
		$towQuery = "
			SELECT 
				ZT.id, T.nazwa, T.opis, T.wersja, ZT.iloscFirm, ZT.iloscStanowisk, ZT.wartoscPozycji,
				ZT.wartoscPozycjiNetto, ZT.wartoscPozycjiNettoPrzedRabatem, ZT.procRabatu 
			FROM 
				Towary T 
				INNER JOIN ZamowieniaTowary ZT ON T.id=ZT.FkTow
				INNER JOIN Zamowienia Z ON Z.id=ZT.FkZam
			WHERE
				Z.ID = $id 
			";


		$zamListGrid->setDataQuery($towQuery);
		//	$zamListGrid->setRecurseQuery($subQuery, 'ZT.FKZam', $ordSubTxt);
		$zamListGrid->setTitle('Towary na zamówieniu');
		$zamListGrid->setGridAlign('center');
		$zamListGrid->setGridWidth(680);
			
		$zamListGrid->addColumn('nazwa', 'Nazwa', 80, false, false, 'left');
		$zamListGrid->addColumn('opis', 'Opis', 180, false, false, 'left');
		$zamListGrid->addColumn('wersja', 'Wersja', 50, false, false, 'left');
		$zamListGrid->addColumn('iloscFirm', 'Ilość firm', 50, false, false, 'left');
		$zamListGrid->addColumn('iloscStanowisk', 'Ilość egzemplarzy', 50, false, false, 'left');
		$zamListGrid->addColumn('wartoscPozycjiNettoPrzedRabatem', 'Wartość (netto)', 80, false, false, 'left');
		$zamListGrid->addColumn('procRabatu', 'Rabat(%)', 80, false, false, 'left');
		$zamListGrid->addColumn('wartoscPozycjiNetto', 'Wartość po rabacie(netto)', 80, false, false, 'left');
		$zamListGrid->addColumn('wartoscPozycji', 'Wartość po rabacie(brutto)', 80, false, false, 'left');
		
		$zamListGrid->addColumn("id", "", 200, true, false, 'right');
		
		$zamListGrid->enabledEditAction($editAction);
		$zamListGrid->addOtherArgs('zamId', $id);	
		
		$myForm = null;
		$myForm = new Form('ZamowienieAdminForm', 'POST') ;
		$ZamForm = null;
		$ZamForm = $myForm->getFormInstance();
		$ZamForm -> addElement('header', 'hdrWartosc', 'Wartość zamówienia');
		$elementWartoscNetto = $ZamForm->addElement('text', 'txtWartosc', 'Wartość zamówienia (netto)', array('size' => 30, 'maxlength'=> 80, 'readonly'=>1));
		$elementWartosc = $ZamForm->addElement('text', 'txtWartosc', 'Wartość zamówienia (brutto)', array('size' => 30, 'maxlength'=> 80, 'readonly'=>1));
		$elementWartoscDost = $ZamForm->addElement('text', 'txtWartosc', 'Cena dostawy(brutto)', array('size' => 30, 'maxlength'=> 80, 'readonly'=>1));
		$elementWartoscRazem = $ZamForm->addElement('text', 'txtWartosc', 'Razem(brutto)', array('size' => 30, 'maxlength'=> 80, 'readonly'=>1));
		
		$ZamForm -> addElement('header', 'hdrZam', 'Edycja zamówienia');
		$ZamForm->addElement('hidden', 'a', $action, null);
		$valId = $ZamForm->addElement('hidden', 'id', $id);

		//dane zamowienia - status, dataSatusu, dostawa, platnosc
		$statusValues = array(0=>'Nowe', 1=>'Potwierdzone', 2=>'Przyjęte', 3=>'Wysłane', 4=>'Zrealizowane');
		$elementStatus = $ZamForm->addElement('select', 'selStatus' ,'Status', $statusValues);
		$elementDataStatusu = $ZamForm->addElement('text', 'txtDataStatusu', 'Data zmiany statusu', array('size' => 20, 'maxlength'=> 80, 'readonly'=>1));
		
		$oplValues = array('T'=>'Tak', 'N'=>'Nie');
		$elementOplacone = $ZamForm->addElement('select', 'selOplacone' ,'Oplacone', $oplValues);
		
		$dostawaValues = array();
		$query = 'SELECT id, nazwa FROM Dostawy ORDER BY sortkey';
		$qResult = $this->dbInt->ExecQuery($query);
		while($data = $qResult->fetchRow(DB_FETCHMODE_ASSOC))
		{
			$dostawaValues[$data['id']] = $data['nazwa'];
		}
		$elementDostawa = $ZamForm->addElement('select', 'selDostawa' ,'Dostawa', $dostawaValues);


		$platnoscValues = array();
		$query = 'SELECT id, nazwa FROM Platnosci ORDER BY sortkey';
		$qResult = $this->dbInt->ExecQuery($query);
		while($data = $qResult->fetchRow(DB_FETCHMODE_ASSOC))
		{
			$platnoscValues[$data['id']] = $data['nazwa'];
		}
		$elementPlatnosc = $ZamForm->addElement('select', 'selPlatnosc' ,'Platność', $platnoscValues);

		//informacyjne - wartosc zamowienia
		$elementUwagi = $ZamForm->addElement('textarea', 'Uwagi', 'Uwagi', array('cols'=>30, 'rows'=>6, 'maxlength'=>1024));
		

		//dane osobowe i do faktury
		$ZamForm -> addElement('header', 'hdrDaneOsob', 'Dane korespondencyjne');
		$elementImie = $ZamForm->addElement('text', 'txtImie', 'Imię', array('size' => 45, 'maxlength'=> 45));

		$elementNazwisko = $ZamForm->addElement('text', 'txtNazwisko', 'Nazwisko', array('size' => 25, 'maxlength'=> 25));


		$option_list = array();

		$query = "
					SELECT k.id, k.nazwa 
					FROM 
						`Kraje` k   
					WHERE k.Active = 'T'
					ORDER BY k.sortkey";

		$db = DBSingleton::GetInstance();
		$result = $db->ExecQuery($query);

		while ($userData = $result->fetchRow(DB_FETCHMODE_ASSOC))
		{
			$option_list[$userData['id']] = $userData['nazwa'];
		}
		$elementKraj = $ZamForm->addElement('select', 'selKraj' ,'Kraj', $option_list);

		$elementKodPocztowy = $ZamForm->addElement('text', 'txtKodPocztowy', 'KodPocztowy' , array('size' => 20, 'maxlength'=> 50));
		$elementMiasto = $ZamForm->addElement('text', 'txtMiasto', 'Miasto' , array('size' => 20, 'maxlength'=> 80));
		$elementUlica = $ZamForm->addElement('text', 'txtUlica', 'Ulica' , array('size' => 20, 'maxlength'=> 150));

		$elementNrDomu = $ZamForm->addElement('text', 'txtNrDomu', 'NrDomu', array('size' => 20, 'maxlength'=> 50));
		$elementNrLok = $ZamForm->addElement('text', 'txtNrMieszkania', 'NrMieszkania' , array('size' => 20, 'maxlength'=> 50));

		$elementEmail = $ZamForm->addElement('text', 'txtEmail', 'txtEmail' , array('size' => 50, 'maxlength'=> 50));

		$elementNrTel = $ZamForm->addElement('text', 'txtNrTel', 'txtNrTel' , array('size' => 20, 'maxlength'=> 50));
		//
		//Faktura
		//
		$ZamForm -> addElement('header', 'hdrDaneFakt', 'Dane do faktury');
		$elementFaktImie = $ZamForm->addElement('text', 'txtFaktImie', 'Imię', array('size' => 45, 'maxlength'=> 45));

		$elementFaktNazwisko = $ZamForm->addElement('text', 'txtFaktNazwisko', 'Nazwisko', array('size' => 25, 'maxlength'=> 25));
		$elementFaktNazwa = $ZamForm->addElement('text', 'txtFaktNazwa', 'Nazwa firmy', array('size' => 45, 'maxlength'=> 45));
		$elementFaktNIP = $ZamForm->addElement('text', 'txtFaktNIP', 'NIP', array('size' => 25, 'maxlength'=> 25));
		//kraj,

		$option_list = array();

		$query = "
					SELECT k.id, k.nazwa 
					FROM 
						`Kraje` k   
					WHERE k.Active = 'T'
					ORDER BY k.sortkey";

		$db = DBSingleton::GetInstance();
		$result = $db->ExecQuery($query);

		while ($userData = $result->fetchRow(DB_FETCHMODE_ASSOC))
		{
			$option_list[$userData['id']] = $userData['nazwa'];
		}
		$elementFaktKraj = $ZamForm->addElement('select', 'selFaktKraj' ,'Kraj', $option_list);

		$elementFaktKodPocztowy = $ZamForm->addElement('text', 'txtFaktKodPocztowy', 'KodPocztowy' , array('size' => 20, 'maxlength'=> 50));
		$elementFaktMiasto = $ZamForm->addElement('text', 'txtFaktMiasto', 'Miasto' , array('size' => 20, 'maxlength'=> 80));
		$elementFaktUlica = $ZamForm->addElement('text', 'txtFaktUlica', 'Ulica' , array('size' => 20, 'maxlength'=> 150));

		$elementFaktNrDomu = $ZamForm->addElement('text', 'txtFaktNrDomu', 'NrDomu', array('size' => 20, 'maxlength'=> 50));
		$elementFaktNrLok = $ZamForm->addElement('text', 'txtFaktNrMieszkania', 'NrMieszkania' , array('size' => 20, 'maxlength'=> 50));



		$ZamForm->addElement('reset', 'btnReset', "Wyczyść");
		$ZamForm->addElement('submit', 'btnSubmit', 'Zapisz');


		$ZamForm->applyFilter('__ALL__', 'trim');
		$myForm->setStyle(2);
		if ($ZamForm->validate())
		{
			//jezeli wybrano save i zmie3nil sie status - to nastepuje pytanie czy wyslac info do usera e zmiana statusu
			
			//dane zamowienia
			$origStatus = $ZamowienieObj->GetStatus();
			$id = $valId->GetValue();
			$statusVal = $elementStatus->GetValue();
			$oplVal = $elementOplacone->GetValue();
			$platnoscVal = $elementPlatnosc->GetValue();
			$dostawaVal = $elementDostawa->GetValue();

			$uwagi = $elementUwagi->GetValue();
			$status = $statusVal[0];
			$oplacone = $oplVal[0];
			$platnosc = $platnoscVal[0];
			$dostawa = $dostawaVal[0];

			//dane osobowe

			$imie = mysql_real_escape_string($elementImie->GetValue());
			$nazwisko = mysql_real_escape_string($elementNazwisko->GetValue());
			$krajArr = $elementKraj->getValue();
			$kraj = $krajArr[0];
			$miasto = mysql_real_escape_string($elementMiasto->GetValue());
			$ulica = mysql_real_escape_string($elementUlica->GetValue());
			$nrDomu = mysql_real_escape_string($elementNrDomu->GetValue());
			$nrMieszkania = mysql_real_escape_string($elementNrLok->GetValue());
			$email = mysql_real_escape_string($elementEmail->GetValue());
			$kodPocztowy = mysql_real_escape_string($elementKodPocztowy->GetValue());
			$nrTel = mysql_real_escape_string($elementNrTel->GetValue());

			$faktImie = mysql_real_escape_string($elementFaktImie->GetValue());
			$faktNazwisko = mysql_real_escape_string($elementFaktNazwisko->GetValue());
			$faktNazwa = mysql_real_escape_string($elementFaktNazwa->GetValue());
			$faktNIP = mysql_real_escape_string($elementFaktNIP->GetValue());
			$faktKrajArr = $elementFaktKraj->getValue();
			$faktKraj = $faktKrajArr[0];
			$faktMiasto = mysql_real_escape_string($elementFaktMiasto->GetValue());
			$faktUlica = mysql_real_escape_string($elementFaktUlica->GetValue());
			$faktNrDomu = mysql_real_escape_string($elementFaktNrDomu->GetValue());
			$faktNrMieszkania = mysql_real_escape_string($elementFaktNrLok->GetValue());
			$faktKodPocztowy = mysql_real_escape_string($elementFaktKodPocztowy->GetValue());

			//Zapisuje zamowienie
			$czyMail = false;
			$errStat = false;
			if ($origStatus != $status)
			{
				if ($origStatus == $status-1)
				{
					$ZamowienieObj->ZmienStatus($status);
					if ($status == 3)
					{
						//petla po towarach i odjecie po 1 kazdego
						$towArr = $ZamowienieObj->GetTowar();
						foreach($towArr as $tow)
						{
							$towTmp = new Towar();
							$towTmp->Load($tow->towarId, 'PL');
							$towTmp->SetIlosc($towTmp->GetIlosc()-1);
							$towTmp->Save($tow->towarId);
						}
											
					}
					$czyMail = true;
				}
				else
				{
					$errStat = true;
				}
			}

			$ZamowienieObj->SetDostawa($dostawa);
			$ZamowienieObj->SetPlatnosc($platnosc);
			$ZamowienieObj->SetUwagi($uwagi);
			$ZamowienieObj->SetOplacone($oplacone);
			$kliObj = $ZamowienieObj->klient;
			$idKli = $kliObj->GetId();

			$kliObj->SetImie($imie);
			$kliObj->SetNazwisko($nazwisko);
			$kliObj->SetKrajId($kraj);
			$kliObj->SetMiasto($miasto);
			$kliObj->SetUlica($ulica);
			$kliObj->SetNrDomu($nrDomu);
			$kliObj->SetNrMieszkania($nrMieszkania);
			$kliObj->SetEmail($email);
			$kliObj->SetKodPocztowy($kodPocztowy);
			$kliObj->SetNrTel($nrTel);

			$kliObj->SetFakturaImie($faktImie);
			$kliObj->SetFakturaNazwisko($faktNazwisko);
			$kliObj->SetFakturaNazwa($faktNazwa);
			$kliObj->SetFakturaNIP($faktNIP);

			$kliObj->SetFakturaKrajId($faktKraj);
			$kliObj->SetFakturaMiasto($faktMiasto);
			$kliObj->SetFakturaUlica($faktUlica);
			$kliObj->SetFakturaNrDomu($faktNrDomu);
			$kliObj->SetFakturaNrMieszkania($faktNrMieszkania);
			$kliObj->SetFakturaKodPocztowy($faktKodPocztowy);
			if (!$errStat)
			{
				$kliObj->Save($idKli, false);

				$ZamowienieObj->Save(false);
				if ($czyMail)
				{
					$html = $this->ShowSendDialog($id);
				}
				else
				{
					$modules = new ModulesMgr();
					$modules -> loadModule('Sklep');
					$action = $modules->getModuleActionIdByName('ShowZamowieniaAdmin');
					header("Location: ?a=$action");
				}
			}
			else
			{
				$html = $this->ShowErrStatDialog($id);
			}
				
		}
		else
		{
			//dane osobowe
			$klientTmp = $ZamowienieObj->klient;
			$elementImie->SetValue($klientTmp->GetImie());
			$elementNazwisko->setValue($klientTmp->GetNazwisko());
			$elementKraj->SetValue($klientTmp->GetKraj());
			$elementMiasto->SetValue($klientTmp->GetMiasto());
			$elementUlica->SetValue($klientTmp->GetUlica());
			$elementNrDomu->SetValue($klientTmp->GetNrDomu());
			$elementNrLok->SetValue($klientTmp->GetNrMieszkania());
			$elementEmail->SetValue($klientTmp->GetEmail());
			$elementKodPocztowy->SetValue($klientTmp->GetKodPocztowy());
			$elementNrTel->SetValue($klientTmp->GetNrTel());

			//dane faktura

			$elementFaktImie->SetValue($klientTmp->GetFakturaImie());
			$elementFaktNazwisko->setValue($klientTmp->GetFakturaNazwisko());
			$elementFaktNazwa->SetValue($klientTmp->GetFakturaNazwa());
			$elementFaktNIP->setValue($klientTmp->GetFakturaNip());
			$elementFaktKraj->SetValue($klientTmp->GetFakturaKraj());
			$elementFaktMiasto->SetValue($klientTmp->GetFakturaMiasto());
			$elementFaktUlica->SetValue($klientTmp->GetFakturaUlica());
			$elementFaktNrDomu->SetValue($klientTmp->GetFakturaNrDomu());
			$elementFaktNrLok->SetValue($klientTmp->GetFakturaNrMieszkania());
			$elementFaktKodPocztowy->SetValue($klientTmp->GetFakturaKodPocztowy());
			$valId->SetValue($id);

			//dane zamowienia

			$elementUwagi->SetValue($ZamowienieObj->GetUwagi());
			$elementDostawa->SetValue($ZamowienieObj->GetDostawa());
			$elementPlatnosc->SetValue($ZamowienieObj->GetPlatnosc());
			$elementStatus->SetValue($ZamowienieObj->GetStatus());
			$elementOplacone->SetValue($ZamowienieObj->GetOplacone());
			$elementWartoscNetto->SetValue($ZamowienieObj->GetWartosc(true));
			$elementWartosc->SetValue($ZamowienieObj->GetWartosc());
			$elementWartoscDost->SetValue($ZamowienieObj->GetWartoscDostawy());
			$elementWartoscRazem->SetValue($ZamowienieObj->GetWartosc()+$ZamowienieObj->GetWartoscDostawy());
			$html .= $zamListGrid->renderHtmlGrid(1);
			$html .= $ZamForm->toHtml();
			$html .= '</td></tr>';
			$html .= '<tr><td align ="center">';
			//historia i anuluj zamowienie, wyjdz bez zapisu

			$modules = new ModulesMgr();
			$modules -> loadModule('Sklep');
			$actionHist = $modules->getModuleActionIdByName('ShowZamowienieHistoria');
			$actionAnulujZam = $modules->getModuleActionIdByName('AnulujZamowienieAdmin');
			$actionAnuluj = $modules->getModuleActionIdByName('ShowZamowieniaAdmin');
			$actionZapiszRabatyIWyslij = $modules->getModuleActionIdByName('ZapiszRabatIWyslij');

			$hist = new button('', 'Pokaż historię', $actionHist, $id);
			$anulujZam = new button('', 'Anuluj zamowienie', $actionAnulujZam, $id);
			$anuluj = new button('', 'Wyjdź bez zapamiętania', $actionAnuluj, -1);
			$zapiszRabat = new button('', 'Wyślij z rabatami', $actionZapiszRabatyIWyslij, $id);
			$html .=$hist->show(1);
			$html .=$anulujZam->show(1);
			$html .=$anuluj->show(1);
			
			if (($ZamowienieObj->GetStatusRabatu()=='nienaliczony')||($ZamowienieObj->GetStatusRabatu()=='do naliczenia'))
				$html .=$zapiszRabat->show(1);
			$html .= '</td></tr></table>';

		}


		return $html;
	}
	public function EditPozZam($idPoz, $idZam)
	{
		$zamObj = new Zamowienie();
		$zamObj->Load($idZam);
		$html .= '<center><table width="580" align="center" cellpadding=0 cellspacing=0 border=0><tr><td>';
		$myForm = null;
		$myForm = new Form('dForm', 'POST') ;
		$PozForm = null;
		$PozForm = $myForm->getFormInstance();
		$hdrText = 'Edycja pozycji zamówienia '.$zamObj->GetNumer();
		$PozForm -> addElement('header', ' hdrTest', $hdrText);
		$valId = $PozForm->addElement('hidden', 'id', $idPoz);
		$valId2 = $PozForm->addElement('hidden', 'zamId', $idZam);
			     	
     	$nazwaTow = $PozForm->addElement('text', 'nazwaTow', 'Nazwa towaru', array('size' => 20, 'maxlength'=> 200, 'readonly'=>'readonly'));
     	$opisTow = $PozForm->addElement('text', 'opisTow', 'Opis', array('size' => 40, 'maxlength'=> 200, 'readonly'=>'readonly'));
     	$ilFirm = $PozForm->addElement('text', 'ilFirm', 'Ilość firm', array('size' => 20, 'maxlength'=> 200, 'readonly'=>'readonly'));
     	$ilEgz = $PozForm->addElement('text', 'ilEgz', 'Ilość egz', array('size' => 20, 'maxlength'=> 200, 'readonly'=>'readonly'));
     	$nettoPrzedRabatem = $PozForm->addElement('text', 'nettoPrzedRabatem', 'Netto przed rabatem', array('size' => 20, 'maxlength'=> 200, 'readonly'=>'readonly'));
     	$rabat = $PozForm->addElement('text', 'rabat', 'Rabat', array('size' => 20, 'maxlength'=> 200));
     	$nettoPoRabacie = $PozForm->addElement('text', 'nettoPoRabacie', 'Netto po rabacie', array('size' => 20, 'maxlength'=> 200, 'readonly'=>'readonly'));
     	$bruttoPoRabacie = $PozForm->addElement('text', 'bruttoPoRabacie', 'Brutto po rabacie', array('size' => 20, 'maxlength'=> 200, 'readonly'=>'readonly'));
		
     	$PozForm->addElement('reset', 'btnReset', 'Wyczyść');
      	$PozForm->addElement('submit', 'btnSubmit', 'Zapisz');
      	
      	$myForm->setStyle(2);
      	if ($PozForm->validate())
        {
        	$rab = $rabat->GetValue();
        	$zamObj->ZastosujRabat($idPoz, $rab);
        	$zamObj->Save(false);
			
        	$module = new ModulesMgr();
			$module->loadModule('Sklep');
			$okAction = $module->getModuleActionIdByName('EditZamowienieAdmin');
			header("Location: ?a=$okAction&id=$idZam");
        }
        else
        {
        	$towarTmp = new Towar();
        	if ($idPoz!=0)
        	{
        		
        		foreach ($zamObj->towary as $towPoz)
        		{
        			
        			if ($towPoz->idPozycji == $idPoz)
        			{
        				
        				$towarTmp->Load($towPoz->towarId, 'PL');
        				$nazwaTow->setValue($towarTmp->GetNazwa());
        				$opisTow->setValue($towarTmp->GetOpis());
        				$ilFirm->setValue($towPoz->iloscFirm);
        				$ilEgz->setValue($towPoz->iloscStanowisk);
        				$nettoPrzedRabatem->setValue($towPoz->wartoscPozycjiNettoPrzedRabatem);
        				$rabat->setValue($towPoz->procRabatu);
        				$nettoPoRabacie->setValue($towPoz->wartoscPozycjiNetto);
        				$bruttoPoRabacie->setValue($towPoz->wartoscPozycji);
        				
        				break;
        			}
        		}
        		
        	}
        	$html .= $PozForm->toHtml();
        }
    	$html .= '</td></tr></table>';

        return $html;    
	}
	public function ShowZamowienieHistoria($id)
	{
		$modules = new ModulesMgr();
		$modules -> loadModule('Sklep');
		$actionBack = $modules->getModuleActionIdByName('EditZamowienieAdmin');
		$back = new button('', 'Wróć', $actionBack, $id);

		$html = '';
		$query = "
			SELECT DISTINCT 
			  0 as id, ZH.mod, K.imie, K.nazwisko, K.nazwaFirmy, K.nip,
			  ZH.bDeleted, D.nazwa as nazwaDostawy,
			  CASE 
			  	WHEN ZH.status=0 THEN 'Nowe, niepotw.'
			  	WHEN ZH.status=1 THEN 'Potwierdzone'
			  	WHEN ZH.status=2 THEN 'Przyjęte'
			  	WHEN ZH.status=3 THEN 'Zrealizowane'
			  	WHEN ZH.status=-1 THEN 'Anulowane'
			  END as status,
			  ZH.oplacone,
			  P.nazwa AS nazwaPlatnosci,
			  ZH.Uwagi,
			  ZH.dataStatusu,
			  ZH.adminId,
			  U.Login			  	   
			FROM
			  ZamowieniaHistoria ZH
			  INNER JOIN Klienci K ON ZH.FKKlientId = K.id
			  LEFT JOIN Dostawy D ON ZH.FKDostawa=D.id
			  LEFT JOIN Platnosci P ON ZH.FKPlatnosci=P.id
			  LEFT JOIN cmsUsers U ON ZH.adminId = U.id  
			WHERE
			  ZH.idTow = $id
			ORDER BY 
				ZH.mod ASC
			";

		
		
 			
		$zamHistGrid = new gridRenderer();
		$zamHistGrid->setDataQuery($query);
		//	$zamListGrid->setRecurseQuery($subQuery, 'ZT.FKZam', $ordSubTxt);
		$zamHistGrid->setTitle('Towary na zamówieniu');
		$zamHistGrid->setGridAlign('center');
		$zamHistGrid->setGridWidth(780);
			
		$zamHistGrid->addColumn('mod', 'Data modyfikacji', 80, false, false, 'left');
		$zamHistGrid->addColumn('imie', 'Imie klienta', 80, false, false, 'left');
		$zamHistGrid->addColumn('nazwisko', 'Nazwisko klienta', 80, false, false, 'left');
		$zamHistGrid->addColumn('nazwaFirmy', 'Nazwa firmy', 80, false, false, 'left');
		$zamHistGrid->addColumn('nip', 'NIP', 80, false, false, 'left');
		$zamHistGrid->addColumn('bDeleted', 'Skasowany', 80, false, false, 'left');
		$zamHistGrid->addColumn('nazwaDostawy', 'Forma dostawy', 80, false, false, 'left');
		$zamHistGrid->addColumn('status', 'Status zam.', 80, false, false, 'left');
		$zamHistGrid->addColumn('oplacone', 'Zapł.', 80, false, false, 'center');
		$zamHistGrid->addColumn('dataStatusu', 'Data zmiany stat.', 80, false, false, 'left');
		$zamHistGrid->addColumn('adminId', 'ID operatora', 80, false, false, 'left');
		$zamHistGrid->addColumn('Login', 'Login operastora', 80, false, false, 'left');
		$zamHistGrid->addColumn('Uwagi', 'Uwagi', 120, false, false, 'left');
		$zamHistGrid->addColumn("id", "", 200, true, false, 'right');
		$html .= $back->show(1);
		$html .= $zamHistGrid->renderHtmlGrid(1);
		$html .= $back->show(1);

		return $html;

	}

	public function AnulujZamowienieAdmin($id)
	{
		$html = '';
		$module = new ModulesMgr();
		$module->loadModule('Sklep');
		$cancelAction = $module->getModuleActionIdByName('ShowZamowieniaAdmin');
		$okAction = $module->getModuleActionIdByName('DelZamowienieAdmin');
		$dialog = new dialog('Zamówienie' , 'Czy chcesz anulować(usunąć) to zamówienie?', 'Query', 300, 150);
		$dialog->setAlign('center');
		$dialog->setOkCaption('Tak');
		$dialog->setOkAction($okAction);
		$dialog->setCancelAction($cancelAction);
		$dialog->setCancelCaption('Nie');
		$dialog->setId($id);
		$html .= $dialog->show(1);

		return $html;
	}
	public function SendZamowienieStatus($idZam)
	{
		$kontaktFact = new KontaktKreator();
		$kontakt = $kontaktFact->FactoryMethod('zmianaStat', $idZam);
		$kontakt->Send();
		$modules = new ModulesMgr();
		$modules -> loadModule('Sklep');
		$action = $modules->getModuleActionIdByName('ShowZamowieniaAdmin');
		header("Location: ?a=$action");
	}



}
?>

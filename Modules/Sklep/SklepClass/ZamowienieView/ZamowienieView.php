<?php

/*require_once 'HTML/QuickForm/Controller.php';
 class ActionProcess extends HTML_QuickForm_Action
 {
 function perform(&$page, $actionName)
 {
 echo "Submit successful!<br>\n<pre>\n";
 var_dump($page->controller->exportValues());
 echo "\n</pre>\n";
 }
 }*/

final class ZamPrintItem
{
	public $nazwaTowaru;
	public $id;
	public $cenaNetto;
	public $ilosc;
	public $iloscFirm;
	public $zdjecieMin;
	public $rabat;

}

class ZamowienieView
{
	private $Global = null;
	private $KlientModel = null;
	private $DostawaModel = null;
	private $PlatnosciModel = null;
	private $translator = null;


	/*public function testChkZgoda($val)
	 {
		//echo 'AAAA:'.$val;
		return false;
		}*/

	private function Translate($field)
	{
		return $this->translator->translate($field);
	}

	private function TranslateCaptionsPodsumowanie($smarty)
	{
		$txtImie = $this->Translate('txtImie');
		$txtNazwisko = $this->Translate('txtNazwisko');
		$txtKraj = $this->Translate('txtKraj');
		$txtMiasto =$this->Translate('txtMiasto');
		$txtUlica = $this->Translate('txtUlica');
		$txtNrDomu = $this->Translate('txtNrDomu');
		$txtNrMieszkania = $this->Translate('txtNrMieszkania');
		$txtEmail = $this->Translate('txtEmail');
		$txtKodPocztowy = $this->Translate('txtKodPocztowy');
		$txtNrTel =  $this->Translate('txtNrTel');

		$txtNazwaFaktura = $this->Translate('txtNazwa');
		$txtNipFaktura = $this->Translate('txtNIP');
		$txtImieFaktura = $this->Translate('txtImie');
		$txtNazwiskoFaktura = $this->Translate('txtNazwisko');
		$txtKrajFaktura = $this->Translate('txtKraj');
		$txtMiastoFaktura = $this->Translate('txtMiasto');
		$txtUlicaFaktura = $this->Translate('txtUlica');
		$txtNrDomuFaktura = $this->Translate('txtNrDomu');
		$txtNrMieszkaniaFaktura = $this->Translate('txtNrMieszkania');
		$txtKodPocztowyFaktura = $this->Translate('txtKodPocztowy');

		$txtNazwaTow = $this->Translate('txtNazwaTow');
		$txtCenaTow = $this->Translate('txtCenaTow');
		$txtIloscTow = $this->Translate('txtIloscTow');
		$txtIloscFirm = $this->Translate('txtIloscFirm');
		$txtZdjecieTow = $this->Translate('txtZdjecieTow');

		$txtRazem = $this->Translate('txtRazem');
		$txtRazemBrutto = $this->Translate('txtRazemBrutto');
		$txtFormaDostawy = $this->Translate('txtFormaDostawy');
		$txtCena = $this->Translate('txtCena');
		$txtWartoscZam = $this->Translate('txtWartoscZam');

		$txtZatwierdz = $this->Translate('txtZatwierdz');
		$txtAnuluj = $this->Translate('txtAnuluj');
		$txtPopraw = $this->Translate('txtPopraw');
		$txtUwagi = $this->Translate('txtUwagi');
		$smarty->assign('txtNazwaTow', $txtNazwaTow);
		$smarty->assign('txtCenaTow', $txtCenaTow);
		$smarty->assign('txtIloscTow', $txtIloscTow);
		$smarty->assign('txtIloscFirm', $txtIloscFirm);
		$smarty->assign('txtZdjecieTow', $txtZdjecieTow);

		$smarty->assign('txtRazem', $txtRazem);
		$smarty->assign('txtRazemBrutto', $txtRazemBrutto);
		$smarty->assign('txtFormaDostawy', $txtFormaDostawy);
		$smarty->assign('txtCena', $txtCena);
		$smarty->assign('txtWartoscZam', $txtWartoscZam);
		$smarty->assign('txtUwagi', $txtUwagi);
		$smarty->assign('txtImie', $txtImie);
		$smarty->assign('txtNazwisko', $txtNazwisko);
		$smarty->assign('txtKraj', $txtKraj);
		$smarty->assign('txtMiasto', $txtMiasto);
		$smarty->assign('txtUlica', $txtUlica);
		$smarty->assign('txtNrDomu', $txtNrDomu);
		$smarty->assign('txtNrMieszkania', $txtNrMieszkania);
		$smarty->assign('txtEmail', $txtEmail);
		$smarty->assign('txtKodPocztowy', $txtKodPocztowy);
		$smarty->assign('txtNrTel', $txtNrTel);
		$smarty->assign('txtNazwaFaktura', $txtNazwaFaktura);
		$smarty->assign('txtNipFaktura', $txtNipFaktura);
		$smarty->assign('txtImieFaktura', $txtImieFaktura);
		$smarty->assign('txtNazwiskoFaktura', $txtNazwiskoFaktura);
		$smarty->assign('txtKrajFaktura', $txtKrajFaktura);
		$smarty->assign('txtMiastoFaktura', $txtMiastoFaktura);
		$smarty->assign('txtUlicaFaktura', $txtUlicaFaktura);
		$smarty->assign('txtNrDomuFaktura', $txtNrDomuFaktura);
		$smarty->assign('txtNrMiszkaniaFaktura', $txtNrMieszkaniaFaktura);
		$smarty->assign('txtKodPocztowyFaktura', $txtKodPocztowyFaktura);



		$smarty->assign('txtZatwierdz', $txtZatwierdz);
		$smarty->assign('txtAnuluj', $txtAnuluj);
		$smarty->assign('txtPopraw', $txtPopraw);

	}

	private function ZamowienieDaneOsobowe()
	{
		try
		{

			$moduleTmp = new ModulesMgr();
			$moduleTmp->loadModule('Sklep');
			$action = $moduleTmp->getModuleActionIdByName('ZlozZamowienie');

			$myForm = null;
			$myForm = new Form('ZamowienieForm', 'POST') ;
			$ZamowienieForm = null;
			$ZamowienieForm = $myForm->getFormInstance();
			$ZamowienieForm->addElement('header', 'hdr', $this->Translate('txtHdr'));
			$ZamowienieForm->addElement('hidden', 'a', $action);
			$ZamowienieForm->addElement('hidden', 'strona', 'daneOsobowe');

			//imie,
			$elementImie = $ZamowienieForm->addElement('text', 'txtImie', $this->Translate('txtImie'), array('size' => 45, 'maxlength'=> 45));
			//nazwisko
			$elementNazwisko = $ZamowienieForm->addElement('text', 'txtNazwisko', $this->Translate('txtNazwisko'), array('size' => 45, 'maxlength'=> 45));
			//kraj,

			$option_list = array();
			if ($_SESSION['lang'] == 'PL')
			{
				$query = "
					SELECT k.id, k.nazwa 
					FROM 
						`Kraje` k   
					WHERE k.Active = 'T'
					ORDER BY k.sortkey";
			}
			else
			{
				$query = "
					SELECT k.id, kl.name AS nazwa 
					FROM 
						`Kraje` k INNER JOIN 'KrajeLang' kl ON kl.FkKraj = k.id  
					WHERE k.Active = 'T'
					ORDER BY k.sortkey";

			}
			$db = DBSingleton::GetInstance();
			$result = $db->ExecQuery($query);

			while ($userData = $result->fetchRow(DB_FETCHMODE_ASSOC))
			{
				$option_list[$userData['id']] = $userData['nazwa'];
			}
			$elementKraj = $ZamowienieForm->addElement('select', 'selKraj' ,'Kraj', $option_list);
			$elementNIP = $ZamowienieForm->addElement('text', 'txtNIP', $this->Translate('txtNIP'), array('size' => 25, 'maxlength'=> 20));
			//kod,
			$elementKodPocztowy = $ZamowienieForm->addElement('text', 'txtKodPocztowy', $this->Translate('txtKodPocztowy') , array('size' => 35, 'maxlength'=> 50));
			$elementMiasto = $ZamowienieForm->addElement('text', 'txtMiasto', $this->Translate('txtMiasto') , array('size' => 35, 'maxlength'=> 80));
			$elementUlica = $ZamowienieForm->addElement('text', 'txtUlica', $this->Translate('txtUlica') , array('size' => 35, 'maxlength'=> 150));
			
			$elementNrDomu = $ZamowienieForm->addElement('text', 'txtNrDomu', $this->Translate('txtNrDomu') , array('size' => 35, 'maxlength'=> 10));
			$elementNrLok = $ZamowienieForm->addElement('text', 'txtNrMieszkania', $this->Translate('txtNrMieszkania') , array('size' => 35, 'maxlength'=> 10));

			//email,
			$elementEmail = $ZamowienieForm->addElement('text', 'txtEmail', $this->Translate('txtEmail') , array('size' => 35, 'maxlength'=> 50));
			$elementEmail2 = $ZamowienieForm->addElement('text', 'txtEmail2', $this->Translate('txtEmail2') , array('size' => 35, 'maxlength'=> 50));
			//tel,
			$elementNrTel = $ZamowienieForm->addElement('text', 'txtNrTel', $this->Translate('txtNrTel') , array('size' => 35, 'maxlength'=> 20));
			//czyfirma
			$optionListFaktura = array();
			$optionListFaktura['osoba'] = $this->Translate('txtFakturaVal1');
			$optionListFaktura['innaOsoba'] = $this->Translate('txtFakturaVal2');
			$optionListFaktura['innaFirma'] = $this->Translate('txtFakturaVal3');
			$elementDaneFaktura = $ZamowienieForm->addElement('select', 'selFaktura' ,$this->Translate('txtFakturaTyt'), $optionListFaktura);

			$elementChkZgoda = $ZamowienieForm->addElement('checkbox', 'chkZgoda', $this->Translate('txtChkZgoda'), null, null);

			$ZamowienieForm->addElement('reset', 'btnReset', $this->Translate('txtWyczysc'));
			$ZamowienieForm->addElement('submit', 'btnSubmit', $this->Translate('txtDalej'));

			//$ZamowienieForm->registerRule('testChkZgoda', 'callback', 'testChkZgoda', 'ZamowienieView');

			$ZamowienieForm->addRule('txtImie', $this->Translate('txtRuleImie'), 'required', null, 'server');
			$ZamowienieForm->addRule('txtNrTel', $this->Translate('txtRuleTel'), 'required', null, 'server');
			
			$ZamowienieForm->addRule('txtNrDomu', $this->Translate('txtRuleNrDomu'), 'required', null, 'server');
			$ZamowienieForm->addRule('txtKodPocztowy', $this->Translate('txtRuleKodPocztowy'), 'required', null, 'server');
			
			$ZamowienieForm->addRule('txtNazwisko', $this->Translate('txtRuleNazwisko'), 'required', null, 'server');
			$ZamowienieForm->addRule('txtLogin', $this->Translate('txtRuleLogin'), 'required', null, 'server');
			$ZamowienieForm->addRule('txtMiasto', $this->Translate('txtRuleMiasto'), 'required', null, 'server');
			$ZamowienieForm->addRule('txtUlica', $this->Translate('txtRuleUlica'), 'required', null, 'server');
			$ZamowienieForm->addRule('txtEmail', $this->Translate('txtRuleEmail'), 'required', null, 'server');
			$ZamowienieForm->addRule('txtEmail2', $this->Translate('txtRuleEmail'), 'required', null, 'server');
			$ZamowienieForm->addRule('txtEmail', $this->Translate('txtRuleEmail2'), 'email', null, 'server');
			$ZamowienieForm->addRule(array('txtEmail', 'txtEmail2'), $this->Translate('txtRuleEmail3'), 'compare', null, 'server');
			//$ZamowienieForm->addRule('chkZgoda', 'dfdf'/*$this->Translate('txtRuleZgoda')*/, 'testChkZgoda');
			$ZamowienieForm->addRule('chkZgoda', $this->Translate('txtRuleZgoda'), 'required', null, 'server');
			//$ZamowienieForm->addRule('txtNIP', $this->Translate('txtRuleNIP'), 'required', null, 'server');
			$ZamowienieForm->applyFilter('__ALL__', 'trim');


			if ($ZamowienieForm->validate())
			{
				$ZamowienieForm->freeze();
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
				$czyFirmaArr = $elementDaneFaktura->GetValue();
				$nip = mysql_real_escape_string($elementNIP->GetValue());
				if (($czyFirmaArr[0] == 'osoba'))
				{
					$czyFirma = 'N';
				}
				else if ($czyFirmaArr[0] == 'innaOsoba')
				{
					$czyFirma = 'NI';
				}
				else
				{
					$czyFirma = 'T';
				}
				$wypelnijFaktura = false;
				if ($czyFirmaArr[0] == 'osoba')
				{
					$nextPage = 'pozostale';
					$wypelnijFaktura = true;
				}
				else
				{
					$nextPage = 'daneFaktura';
				}

				if (!isset($_SESSION['Zamowienie']->klient))
				$_SESSION['Zamowienie']->klient = new Klient();
					
				$_SESSION['Zamowienie']->klient->SetImie($imie);
				$_SESSION['Zamowienie']->klient->SetNazwisko($nazwisko);
				$_SESSION['Zamowienie']->klient->SetKrajId($kraj);
				$_SESSION['Zamowienie']->klient->SetMiasto($miasto);
				$_SESSION['Zamowienie']->klient->SetUlica($ulica);
				$_SESSION['Zamowienie']->klient->SetNrDomu($nrDomu);
				$_SESSION['Zamowienie']->klient->SetNrMieszkania($nrMieszkania);
				$_SESSION['Zamowienie']->klient->SetEmail($email);
				$_SESSION['Zamowienie']->klient->SetKodPocztowy($kodPocztowy);
				$_SESSION['Zamowienie']->klient->SetNrTel($nrTel);
				$_SESSION['Zamowienie']->klient->SetFakturaNip($nip);
				
				$_SESSION['Zamowienie']->klient->SetCzyFirma($czyFirma);

				if ($wypelnijFaktura)
				{
					$_SESSION['Zamowienie']->klient->SetFakturaImie($imie);
					$_SESSION['Zamowienie']->klient->SetFakturaNazwisko($nazwisko);
					$_SESSION['Zamowienie']->klient->SetFakturaKrajId($kraj);
					$_SESSION['Zamowienie']->klient->SetFakturaMiasto($miasto);
					$_SESSION['Zamowienie']->klient->SetFakturaUlica($ulica);
					$_SESSION['Zamowienie']->klient->SetFakturaNrDomu($nrDomu);
					$_SESSION['Zamowienie']->klient->SetFakturaNrMieszkania($nrMieszkania);
					$_SESSION['Zamowienie']->klient->SetFakturaEmail($email);
					$_SESSION['Zamowienie']->klient->SetFakturaKodPocztowy($kodPocztowy);
					$_SESSION['Zamowienie']->klient->SetFakturaNrTel($nrTel);
					$_SESSION['Zamowienie']->klient->SetFakturaCzyFirma($czyFirma);
					$_SESSION['Zamowienie']->klient->SetFakturaNazwa('');
					//$_SESSION['Zamowienie']->klient->SetFakturaNip('');
				}
					
				$moduleTmp = new ModulesMgr();
				$moduleTmp->loadModule('Sklep');
				$action = $moduleTmp->getModuleActionIdByName('ZlozZamowienie');
				header("Location: ?a=$action&strona=$nextPage");
			}
			else
			{
				//Wypelniam dane

				if (isset($_SESSION['Zamowienie']->klient))
				{
					//nie robie nic, przepisze dane z klienta z sesji
				}
				else if ($_SESSION['klient'] > 0)
				{
					$_SESSION['Zamowienie']->klient = new Klient();
					$_SESSION['Zamowienie']->klient->LoadById($_SESSION['klient']);
				}


				if (isset($_SESSION['Zamowienie']->klient))
				{
					$klientTmp = $_SESSION['Zamowienie']->klient;
					$elementImie->SetValue($klientTmp->GetImie());
					$elementNazwisko->setValue($klientTmp->GetNazwisko());
					$elementKraj->SetValue($klientTmp->GetKraj());
					$elementMiasto->SetValue($klientTmp->GetMiasto());
					$elementUlica->SetValue($klientTmp->GetUlica());
					$elementNrDomu->SetValue($klientTmp->GetNrDomu());
					$elementNrLok->SetValue($klientTmp->GetNrMieszkania());
					$elementEmail->SetValue($klientTmp->GetEmail());
					$elementEmail2->SetValue($klientTmp->GetEmail());
					$elementKodPocztowy->SetValue($klientTmp->GetKodPocztowy());
					$elementNrTel->SetValue($klientTmp->GetNrTel());
					$elCzyFirma = $klientTmp->GetCzyFirma();
					if ($elCzyFirma =='N')
					{
						$elementDaneFaktura->SetValue('osoba');
					}
					else if ($elCzyFirma =='NI')
					{
						$elementDaneFaktura->SetValue('innaOsoba');
					}
					else
					{
						$elementDaneFaktura->SetValue('innaFirma');
					}
				}


				//Wyswietlam formularz
				//$elementChkZgoda->SetValue(true);
				$smarty = new mySmarty();
				$renderer = &new HTML_QuickForm_Renderer_ArraySmarty($smarty);
				$ZamowienieForm->accept($renderer);
				$smarty->assign('form', $renderer->toArray());
				$html = $smarty->fetch('modules/ZamowienieOsoboweForm.tpl');
			}
			return $html;
		}
		catch (exception $e)
		{
			$exc = new ExceptionClass($e, 'ZamowienieDaneOsoboweForm');
			$exc->writeException();
			return $this->Translate('txtError');
		}
	}
	private function ZamowienieDaneFakturaOsoba()
	{
		try
		{
			$moduleTmp = new ModulesMgr();
			$moduleTmp->loadModule('Sklep');
			$action = $moduleTmp->getModuleActionIdByName('ZlozZamowienie');

			$myForm = null;
			$myForm = new Form('ZamowienieForm', 'POST') ;
			$ZamowienieForm = null;
			$ZamowienieForm = $myForm->getFormInstance();
			$ZamowienieForm->addElement('header', 'hdr', $this->Translate('txtHdr'));
			$ZamowienieForm->addElement('hidden', 'a', $action, null);
			$ZamowienieForm->addElement('hidden', 'strona', 'daneFaktura', null);

			//imie,
			$elementImie = $ZamowienieForm->addElement('text', 'txtImie', $this->Translate('txtImie'), array('size' => 45, 'maxlength'=> 45));
			//nazwisko
			$elementNazwisko = $ZamowienieForm->addElement('text', 'txtNazwisko', $this->Translate('txtNazwisko'), array('size' => 45, 'maxlength'=> 45));
			//kraj,

			$option_list = array();
			if ($_SESSION['lang'] == 'PL')
			{
				$query = "
					SELECT k.id, k.nazwa 
					FROM 
						`Kraje` k   
					WHERE k.Active = 'T'
					ORDER BY k.sortkey";
			}
			else
			{
				$query = "
					SELECT k.id, kl.name AS nazwa 
					FROM 
						`Kraje` k INNER JOIN 'KrajeLang' kl ON kl.FkKraj = k.id  
					WHERE k.Active = 'T'
					ORDER BY k.sortkey";

			}
			$db = DBSingleton::GetInstance();
			$result = $db->ExecQuery($query);

			while ($userData = $result->fetchRow(DB_FETCHMODE_ASSOC))
			{
				$option_list[$userData['id']] = $userData['nazwa'];
			}
			$elementKraj = $ZamowienieForm->addElement('select', 'selKraj' ,'Kraj', $option_list);

			//kod,
			$elementKodPocztowy = $ZamowienieForm->addElement('text', 'txtKodPocztowy', $this->Translate('txtKodPocztowy') , array('size' => 20, 'maxlength'=> 50));
			$elementMiasto = $ZamowienieForm->addElement('text', 'txtMiasto', $this->Translate('txtMiasto') , array('size' => 20, 'maxlength'=> 80));
			$elementUlica = $ZamowienieForm->addElement('text', 'txtUlica', $this->Translate('txtUlica') , array('size' => 20, 'maxlength'=> 150));

			$elementNrDomu = $ZamowienieForm->addElement('text', 'txtNrDomu', $this->Translate('txtNrDomu') , array('size' => 20, 'maxlength'=> 10));
			$elementNrLok = $ZamowienieForm->addElement('text', 'txtNrMieszkania', $this->Translate('txtNrMieszkania') , array('size' => 20, 'maxlength'=> 10));
			$ZamowienieForm->addElement('reset', 'btnReset', $this->Translate('txtWyczysc'));
			$ZamowienieForm->addElement('submit', 'btnSubmit', $this->Translate('txtDalej'));

			$ZamowienieForm->addRule('txtImie', $this->Translate('txtRuleImie'), 'required', null, 'server');
			$ZamowienieForm->addRule('txtNazwisko', $this->Translate('txtRuleNazwisko'), 'required', null, 'server');
			$ZamowienieForm->addRule('txtLogin', $this->Translate('txtRuleLogin'), 'required', null, 'server');
			$ZamowienieForm->addRule('txtMiasto', $this->Translate('txtRuleMiasto'), 'required', null, 'server');
			$ZamowienieForm->addRule('txtUlica', $this->Translate('txtRuleUlica'), 'required', null, 'server');
			$ZamowienieForm->addRule('txtNrDomu', $this->Translate('txtRuleNrDomu'), 'required', null, 'server');
			$ZamowienieForm->addRule('txtKodPocztowy', $this->Translate('txtRuleKodPocztowy'), 'required', null, 'server');
			


			$ZamowienieForm->applyFilter('__ALL__', 'trim');
			if ($ZamowienieForm->validate())
			{
				$ZamowienieForm->freeze();
				$imie = mysql_real_escape_string($elementImie->GetValue());
				$nazwisko = mysql_real_escape_string($elementNazwisko->GetValue());
				$krajArr = $elementKraj->getValue();
				$kraj = $krajArr[0];
				$miasto = mysql_real_escape_string($elementMiasto->GetValue());
				$ulica = mysql_real_escape_string($elementUlica->GetValue());
				$nrDomu = mysql_real_escape_string($elementNrDomu->GetValue());
				$nrMieszkania = mysql_real_escape_string($elementNrLok->GetValue());
				//$email = mysql_real_escape_string($elementEmail->GetValue());
				$kodPocztowy = mysql_real_escape_string($elementKodPocztowy->GetValue());
				//$nrTel = mysql_real_escape_string($elementNrTel->GetValue());
				$_SESSION['Zamowienie']->klient->SetFakturaImie($imie);
				$_SESSION['Zamowienie']->klient->SetFakturaNazwisko($nazwisko);
				$_SESSION['Zamowienie']->klient->SetFakturaKrajId($kraj);
				$_SESSION['Zamowienie']->klient->SetFakturaMiasto($miasto);
				$_SESSION['Zamowienie']->klient->SetFakturaUlica($ulica);
				$_SESSION['Zamowienie']->klient->SetFakturaNrDomu($nrDomu);
				$_SESSION['Zamowienie']->klient->SetFakturaNrMieszkania($nrMieszkania);
				$_SESSION['Zamowienie']->klient->SetFakturaKodPocztowy($kodPocztowy);
				$_SESSION['Zamowienie']->klient->SetFakturaCzyFirma('N');
				$_SESSION['Zamowienie']->klient->SetFakturaNazwa('');
				//$_SESSION['Zamowienie']->klient->SetFakturaNip('');

				$nextPage = 'pozostale';
				$moduleTmp = new ModulesMgr();
				$moduleTmp->loadModule('Sklep');
				$action = $moduleTmp->getModuleActionIdByName('ZlozZamowienie');
				header("Location: ?a=$action&strona=$nextPage");

			}
			else
			{
				//Wypelniam dane
				if (isset($_SESSION['Zamowienie']->klient))
				{
					//nie robie nic, przepisze dane z klienta z sesji
				}
				else if ($_SESSION['klient'] > 0)
				{
					$_SESSION['Zamowienie']->klient = new Klient();
					$_SESSION['Zamowienie']->klient->LoadById($_SESSION['klient']);
				}

				if (isset($_SESSION['Zamowienie']->klient))
				{
					$klientTmp = &$_SESSION['Zamowienie']->klient;
					$elementImie->SetValue($klientTmp->GetFakturaImie());
					$elementNazwisko->setValue($klientTmp->GetFakturaNazwisko());
					$elementKraj->SetValue($klientTmp->GetFakturaKraj());
					$elementMiasto->SetValue($klientTmp->GetFakturaMiasto());
					$elementUlica->SetValue($klientTmp->GetFakturaUlica());
					$elementNrDomu->SetValue($klientTmp->GetFakturaNrDomu());
					$elementNrLok->SetValue($klientTmp->GetFakturaNrMieszkania());
					$elementKodPocztowy->SetValue($klientTmp->GetFakturaKodPocztowy());

				}


				//Wyswietlam formularz
				$smarty = new mySmarty();
				$renderer = &new HTML_QuickForm_Renderer_ArraySmarty($smarty);
				$ZamowienieForm->accept($renderer);
				$smarty->assign('form', $renderer->toArray());
				$html = $smarty->fetch('modules/ZamowienieFakturaOsForm.tpl');
			}
			return $html;
		}
		catch (exception $e)
		{
			$exc = new ExceptionClass($e, 'ZamowienieDaneFakturaOsobaForm');
			$exc->writeException();
			return $this->Translate('txtError');
		}
	}

	private function ZamowienieDaneFakturaFirma()
	{
		try
		{
			$moduleTmp = new ModulesMgr();
			$moduleTmp->loadModule('Sklep');
			$action = $moduleTmp->getModuleActionIdByName('ZlozZamowienie');

			$myForm = null;
			$myForm = new Form('ZamowienieForm', 'POST') ;
			$ZamowienieForm = null;
			$ZamowienieForm = $myForm->getFormInstance();
			$ZamowienieForm->addElement('header', 'hdr', $this->Translate('txtHdr'));
			$ZamowienieForm->addElement('hidden', 'a', $action, null);
			$ZamowienieForm->addElement('hidden', 'strona', 'daneFaktura', null);

			//imie,
			$elementNazwa = $ZamowienieForm->addElement('text', 'txtNazwa', $this->Translate('txtNazwa'), array('size' => 65, 'maxlength'=> 200));
			//nazwisko
			//$elementNIP = $ZamowienieForm->addElement('text', 'txtNIP', $this->Translate('txtNIP'), array('size' => 25, 'maxlength'=> 20));
			//kraj,

			$option_list = array();
			if ($_SESSION['lang'] == 'PL')
			{
				$query = "
					SELECT k.id, k.nazwa 
					FROM 
						`Kraje` k   
					WHERE k.Active = 'T'
					ORDER BY k.sortkey";
			}
			else
			{
				$query = "
					SELECT k.id, kl.name AS nazwa 
					FROM 
						`Kraje` k INNER JOIN 'KrajeLang' kl ON kl.FkKraj = k.id  
					WHERE k.Active = 'T'
					ORDER BY k.sortkey";

			}
			$db = DBSingleton::GetInstance();
			$result = $db->ExecQuery($query);

			while ($userData = $result->fetchRow(DB_FETCHMODE_ASSOC))
			{
				$option_list[$userData['id']] = $userData['nazwa'];
			}
			$elementKraj = $ZamowienieForm->addElement('select', 'selKraj' ,'Kraj', $option_list);

			//kod,
			$elementKodPocztowy = $ZamowienieForm->addElement('text', 'txtKodPocztowy', $this->Translate('txtKodPocztowy') , array('size' => 20, 'maxlength'=> 50));
			$elementMiasto = $ZamowienieForm->addElement('text', 'txtMiasto', $this->Translate('txtMiasto') , array('size' => 20, 'maxlength'=> 80));
			$elementUlica = $ZamowienieForm->addElement('text', 'txtUlica', $this->Translate('txtUlica') , array('size' => 20, 'maxlength'=> 150));

			$elementNrDomu = $ZamowienieForm->addElement('text', 'txtNrDomu', $this->Translate('txtNrDomu') , array('size' => 20, 'maxlength'=> 10));
			$elementNrLok = $ZamowienieForm->addElement('text', 'txtNrMieszkania', $this->Translate('txtNrMieszkania') , array('size' => 20, 'maxlength'=> 10));
			$ZamowienieForm->addElement('reset', 'btnReset', $this->Translate('txtWyczysc'));
			$ZamowienieForm->addElement('submit', 'btnSubmit', $this->Translate('txtDalej'));

			$ZamowienieForm->addRule('txtNazwa', $this->Translate('txtRuleNazwa'), 'required', null, 'server');
			//$ZamowienieForm->addRule('txtNIP', $this->Translate('txtRuleNIP'), 'required', null, 'server');

			$ZamowienieForm->addRule('txtMiasto', $this->Translate('txtRuleMiasto'), 'required', null, 'server');
			$ZamowienieForm->addRule('txtUlica', $this->Translate('txtRuleUlica'), 'required', null, 'server');
			$ZamowienieForm->addRule('txtNrDomu', $this->Translate('txtRuleNrDomu'), 'required', null, 'server');
			$ZamowienieForm->addRule('txtKodPocztowy', $this->Translate('txtRuleKodPocztowy'), 'required', null, 'server');
			


			$ZamowienieForm->applyFilter('__ALL__', 'trim');
			if ($ZamowienieForm->validate())
			{
				$ZamowienieForm->freeze();
				$nazwa = mysql_real_escape_string($elementNazwa->GetValue());
				//$nip = mysql_real_escape_string($elementNIP->GetValue());
				$krajArr = $elementKraj->getValue();
				$kraj = $krajArr[0];
				$miasto = mysql_real_escape_string($elementMiasto->GetValue());
				$ulica = mysql_real_escape_string($elementUlica->GetValue());
				$nrDomu = mysql_real_escape_string($elementNrDomu->GetValue());
				$nrMieszkania = mysql_real_escape_string($elementNrLok->GetValue());
				//$email = mysql_real_escape_string($elementEmail->GetValue());
				$kodPocztowy = mysql_real_escape_string($elementKodPocztowy->GetValue());
				//$nrTel = mysql_real_escape_string($elementNrTel->GetValue());
				$_SESSION['Zamowienie']->klient->SetFakturaNazwa($nazwa);
				//$_SESSION['Zamowienie']->klient->SetFakturaNIP($nip);
				$_SESSION['Zamowienie']->klient->SetFakturaKrajId($kraj);
				$_SESSION['Zamowienie']->klient->SetFakturaMiasto($miasto);
				$_SESSION['Zamowienie']->klient->SetFakturaUlica($ulica);
				$_SESSION['Zamowienie']->klient->SetFakturaNrDomu($nrDomu);
				$_SESSION['Zamowienie']->klient->SetFakturaNrMieszkania($nrMieszkania);
				$_SESSION['Zamowienie']->klient->SetFakturaKodPocztowy($kodPocztowy);
				$_SESSION['Zamowienie']->klient->SetFakturaCzyFirma('T');
				$_SESSION['Zamowienie']->klient->SetFakturaImie('');
				$_SESSION['Zamowienie']->klient->SetFakturaNazwisko('');

				$nextPage = 'pozostale';
				$moduleTmp = new ModulesMgr();
				$moduleTmp->loadModule('Sklep');
				$action = $moduleTmp->getModuleActionIdByName('ZlozZamowienie');
				header("Location: ?a=$action&strona=$nextPage");

			}
			else
			{
				//Wypelniam dane
				if (isset($_SESSION['Zamowienie']->klient))
				{
					//nie robie nic, przepisze dane z klienta z sesji
				}
				else if ($_SESSION['klient'] > 0)
				{
					$_SESSION['Zamowienie']->klient = new Klient();
					$_SESSION['Zamowienie']->klient->LoadById($_SESSION['klient']);
				}

				if (isset($_SESSION['Zamowienie']->klient))
				{
					$klientTmp = &$_SESSION['Zamowienie']->klient;
					$elementNazwa->SetValue($klientTmp->GetFakturaNazwa());
					//$elementNIP->setValue($klientTmp->GetFakturaNIP());
					$elementKraj->SetValue($klientTmp->GetFakturaKraj());
					$elementMiasto->SetValue($klientTmp->GetFakturaMiasto());
					$elementUlica->SetValue($klientTmp->GetFakturaUlica());
					$elementNrDomu->SetValue($klientTmp->GetFakturaNrDomu());
					$elementNrLok->SetValue($klientTmp->GetFakturaNrMieszkania());
					$elementKodPocztowy->SetValue($klientTmp->GetFakturaKodPocztowy());

				}


				//Wyswietlam formularz
				$smarty = new mySmarty();
				$renderer = &new HTML_QuickForm_Renderer_ArraySmarty($smarty);
				$ZamowienieForm->accept($renderer);
				$smarty->assign('form', $renderer->toArray());
				$html = $smarty->fetch('modules/ZamowienieFakturaFirmaForm.tpl');


				//var_dump($renderer->toArray());
			}
			return $html;
		}
		catch (exception $e)
		{
			$exc = new ExceptionClass($e, 'ZamowienieDaneFakturaFirma');
			$exc->writeException();
			return $this->Translate('txtError');
		}
	}
	private function ZamowieniePozostale()
	{
		$moduleTmp = new ModulesMgr();
		$moduleTmp->loadModule('Sklep');
		$action = $moduleTmp->getModuleActionIdByName('ZlozZamowienie');

		$myForm = null;
		$myForm = new Form('ZamowienieForm', 'POST') ;
		$ZamowienieForm = null;
		$ZamowienieForm = $myForm->getFormInstance();
		$ZamowienieForm->addElement('header', 'hdr', 'Składanie zamówienia - pozostałe dane');
		$ZamowienieForm->addElement('hidden', 'a', $action, null);
		$ZamowienieForm->addElement('hidden', 'strona', 'pozostale', null);

		$option_list = array();
		if ($_SESSION['lang'] == 'PL')
		{
			$query = "
					SELECT 
						id, nazwa
					FROM 
						`Platnosci`    
					WHERE 
						active = 'T'
					ORDER BY 
						sortkey";
		}
		else
		{
			$query = "
					SELECT
						p.id, pl.nazwa  
					FROM 
						PlatnosciLang pl INNER JOIN Platnosci p ON pl.FKPlatnosci = p.id  	  
					WHERE 
						p.active = 'T'
					ORDER BY 
						p.sortkey";

		}
		$db = DBSingleton::GetInstance();
		$result = $db->ExecQuery($query);

		while ($userData = $result->fetchRow(DB_FETCHMODE_ASSOC))
		{
			$optionPlatnosci[$userData['id']] = $userData['nazwa'];
		}
		$elementPlatnosc = $ZamowienieForm->addElement('select', 'selPlatnosc' ,'Płatność', $optionPlatnosci);

		$ZamowienieForm->addElement('html', 'opisDostawy' ,'Dostawa kurierem: 100<br>dostawa czymś innym 200');

		if ($_SESSION['lang'] == 'PL')
		{
			$query = "
				SELECT 
					id, nazwa 
				FROM
					Dostawy
				WHERE
					active = 'T'
				ORDER BY
					sortkey
				";

		}
		else
		{
			$query = "
				SELECT 
					d.id, dl.nazwa 
				FROM
					Dostawy d INNER JOIN DostawyLang dl ON d.id = FKDostawy
				WHERE
					d.active = 'T'
				ORDER BY
					d.sortkey
				";
		}

		$db = DBSingleton::GetInstance();
		$result2 = $db->ExecQuery($query);

		$opitonDostawy = array();
		while ($userData2 = $result2->fetchRow(DB_FETCHMODE_ASSOC))
		{
			$optionDostawy[$userData2['id']] = $userData2['nazwa'];
		}

		$elementDostawa = $ZamowienieForm->addElement('select', 'selDostawa' ,'Forma dostawy', $optionDostawy);
		$elementUwagi = $ZamowienieForm->addElement('textarea', 'Uwagi', 'Uwagi', array('cols'=>30, 'rows'=>6, 'maxlength'=>1024));


		$ZamowienieForm->addElement('reset', 'btnReset', 'Wyczyść');
		$ZamowienieForm->addElement('submit', 'btnSubmit', 'Dalej');
		$ZamowienieForm->applyFilter('__ALL__', 'trim');

		$ZamowienieForm->addRule('Uwagi', 'Przekroczono maksymalną liczbę znaków dla pola Uwagi (1024)', 'maxlength', 1024, 'server');
		//$ZamowienieForm->addRule('Przykladowe', 'Pole "Nazwa" musi być wypełnione', 'required', null, 'server');

		if ($ZamowienieForm->validate())
		{
			$platnoscVal = $elementPlatnosc->GetValue();
			$dostawaVal = $elementDostawa->GetValue();
			$uwagiVal = $elementUwagi->GetValue();

			$_SESSION['Zamowienie']->SetPlatnosc($platnoscVal[0]);
			$_SESSION['Zamowienie']->SetDostawa($dostawaVal[0]);
			$_SESSION['Zamowienie']->SetUwagi($uwagiVal);

			$moduleTmp = new ModulesMgr();
			$moduleTmp->loadModule('Sklep');
			$action = $moduleTmp->getModuleActionIdByName('ZlozZamowienie');
			$nextPage = 'potwierdzenie';
			header("Location: ?a=$action&strona=$nextPage");
		}
		else
		{
			if (isset($_SESSION['Zamowienie']))
			{
				echo $_SESSION['Zamowienie']->GetPlatnosc();
				if ($_SESSION['Zamowienie']->GetPlatnosc() != 0)
				$elementPlatnosc->setValue($_SESSION['Zamowienie']->GetPlatnosc());
				if ($_SESSION['Zamowienie']->GetDostawa() != 0)
				$elementDostawa->setValue($_SESSION['Zamowienie']->GetDostawa());

				$elementUwagi->setValue($_SESSION['Zamowienie']->GetUwagi());
			}

			$smarty = new mySmarty();
			$renderer = &new HTML_QuickForm_Renderer_ArraySmarty($smarty);
			$ZamowienieForm->accept($renderer);
			$smarty->assign('form', $renderer->toArray());
			$html = $smarty->fetch('modules/ZamowieniePozostaleForm.tpl');
			//var_dump($renderer->toArray());
		}
		return $html;
	}
	private function ZamowieniePotwierdzenie()
	{
		try
		{
			if (!isset($_SESSION['Zamowienie'])||(!isset($_SESSION['Zamowienie']->klient)))
			{
				throw new Exception('KlientView::ZamowieniePotwierdzenie(sess not assigned)');
			}
			//zatwierdzenie / anulowanie
			$smarty = new mySmarty();

			//1. Zamowienie

			$koszykTmp = GlobalObj()->Koszyk();
			//pozycje - towary
			$koszykItems = array();
			//tablica z pelnymi danymi do wyswietlenia
			$printItems = array();

			//pozycje
			//	nazwa ilosc cena brutto
			// podsumowanie - warto�� zam�wienia
			$konfiguracja = new Konfiguracja();
                        $rabat = new Rabat();
                        $rabat->Load();
			$vat = $konfiguracja->GetStawkaVat();
			if ((isset($_SESSION['Zamowienie']))&&(count($_SESSION['Zamowienie']->towary)>0))
			{


				$zam = $_SESSION['Zamowienie'];
				$wartoscPrn = 0;
				$towary = $zam->towary;
					echo 'a';
				for ($i=0;$i<count($towary); $i++)
				{
				
					$idTowaru = $towary[$i]->towarId;
					$ilosc = $towary[$i]->ilosc;
					$iloscFirm = $towary[$i]->iloscFirm;
					$towarTmp = new Towar();
					$towarTmp -> Load($idTowaru, $_SESSION['lang']);
					$printItemTmp = new ZamPrintItem();
					$printItemTmp -> nazwaTowaru = $towarTmp->GetNazwa();
					$printItemTmp -> cenaNetto = number_format($towary[$i]->wartoscPozycjiNetto, 2, ',', ' ');
					$printItemTmp -> ilosc = $towary[$i]->ilosc;
					$printItemTmp -> iloscFirm = $towary[$i]->iloscFirm;
					$printItemTmp -> zdjecieMin = $towarTmp->GetObrazMin();
					$printItemTmp -> id = $towarTmp->GetId();
					$printItemTmp->rabat = $towary[$i]->procRabatu; 
					$printItems[] = $printItemTmp;
					$wartoscPrn += $towary[$i]->wartoscPozycjiNetto;
				}


			}
			else
			{
				
				$count = $koszykTmp->ItemsCount();

			
				$wartoscPrn = 0;

				for ($i=0;$i<$count; $i++)
				{
					$idTowaru = $koszykTmp->GetTowarId($i);
					$ilosc = $koszykTmp->GetTowarIlosc($i);
					$iloscFirm = $koszykTmp->GetTowarIloscFirm($i);
					$towarTmp = new Towar();
					$towarTmp -> Load($idTowaru, $_SESSION['lang']);
                                        
                                        $cena;
                                        if (!$rabat->GetRabatEnabled())
                                        {
                                           $cena = $towarTmp->GetCena($ilosc, $iloscFirm);
                                        }
                                        else
                                        {
                                           $cena = $towarTmp->GetCenaParams($ilosc, $iloscFirm);
                                        }
                                        
					$printItemTmp = new ZamPrintItem();
					$printItemTmp -> nazwaTowaru = $towarTmp->GetNazwa();
					$printItemTmp -> cenaNetto = number_format($cena, 2, ',', ' ');
					$printItemTmp -> ilosc = $ilosc;
					$printItemTmp -> iloscFirm = $iloscFirm;
					$printItemTmp -> zdjecieMin = $towarTmp->GetObrazMin();
					$printItemTmp -> id = $towarTmp->GetId();
					$printItemTmp->rabat = 0;
					$printItems[] = $printItemTmp;
                                        
                                       
                                        if (!$rabat->GetRabatEnabled())
                                        {
                                           $wartoscPrn += $towarTmp->GetCena($ilosc, $iloscFirm);
                                        }
                                        else
                                        {
                                           $wartoscPrn += $towarTmp->GetCenaParams($ilosc, $iloscFirm);
                                        }
                                        
					//$wartoscPrn += $towarTmp->GetCena($ilosc, $iloscFirm);
				}
			}
			$smarty->assign('pozycje', $printItems);
			$prnRabat = $_SESSION['Zamowienie']->GetStatusRabatuInt()>=2;
			$smarty->assign('prnRabat', $prnRabat);
			$smarty->assign('razem', number_format($wartoscPrn, 2, ',', ' ') );
			$smarty->assign('razemBrutto', number_format($wartoscPrn*(1+$vat/100), 2, ',', ' '));
			$formaDostawyId = $_SESSION['Zamowienie']->GetDostawa();

			if ($_SESSION['lang'] == 'PL')
			{
				$queryDostawy = "
			SELECT
				nazwa, cena
			FROM 
				Dostawy
			WHERE 
				id=$formaDostawyId";
			}
			else
			{
				$queryDostawy = "
			SELECT
				dl.nazwa, d.cena
			FROM 
				Dostawy d INNER JOIN DostawyLang dl
			WHERE 
				d.id=$formaDostawyId";
			}
			//echo $queryDostawy;
			$DBInt = DBSingleton::GetInstance();
			$qResult2 = $DBInt->ExecQuery($queryDostawy);
			$dataDost = $qResult2->fetchRow(DB_FETCHMODE_ASSOC);
			$dostawaNazwa = $dataDost['nazwa'];
			$dostawaCena = $dataDost['cena'];

			$smarty->assign('dostawaNazwa', $dostawaNazwa);
			$smarty->assign('dostawaCena', $dostawaCena);


			$wartoscZam = $dostawaCena + ($wartoscPrn)*(1+$vat/100);
			//$wartoscZam *= (1+$vat/100);

			$smarty->assign('wartoscZam', number_format($wartoscZam, 2, ',', ' '));

			//--------------------------------------koniec koszyka i podsumowania zamowienia
			//2. Dane osoby zamawiającej
			$klientTmp = $_SESSION['Zamowienie']->klient;
			$imie = $klientTmp->GetImie();
			$nazwisko = $klientTmp->GetNazwisko();
			$kraj = $klientTmp->GetKraj();
			$miasto = $klientTmp->GetMiasto();
			$ulica = $klientTmp->GetUlica();
			$nrDomu = $klientTmp->GetNrDomu();
			$nrMieszkania = $klientTmp->GetNrMieszkania();
			$email = $klientTmp->GetEmail();
			$kodPocztowy = $klientTmp->GetKodPocztowy();
			$nrTel = $klientTmp->GetNrTel();

			$moduleTmp = new ModulesMgr();
			$moduleTmp->loadModule('Sklep');
			$poprawOsobActn = $moduleTmp->getModuleActionIdByName('ZlozZamowienie');
			$stronaOsobActn = 'daneOsobowe';

			$smarty->assign('imie', $imie);
			$smarty->assign('nazwisko', $nazwisko);
			$smarty->assign('kraj', $kraj) ;
			$smarty->assign('miasto', $miasto);
			$smarty->assign('ulica', $ulica);
			$smarty->assign('nrDomu', $nrDomu);
			$smarty->assign('nrMieszkania', $nrMieszkania);
			$smarty->assign('email', $email);
			$smarty->assign('kodPocztowy', $kodPocztowy);
			$smarty->assign('nrTel', $nrTel);
			$smarty->assign('poprawOsobActn', $poprawOsobActn);
			$smarty->assign('stronaOsobActn', $stronaOsobActn);

			//-------------------------------------------------------Koniec osobowych
			//3. Dane do faktury
			$czyFirmaFaktura = $klientTmp->GetCzyFirma();

			$nazwaFaktura = $klientTmp->GetFakturaNazwa();
			$NIPFaktura = $klientTmp->GetFakturaNIP();

			$imieFaktura = $klientTmp->GetFakturaImie();
			$nazwiskoFaktura = $klientTmp->GetFakturaNazwisko();
			$krajFaktura = $klientTmp->GetFakturaKraj();
			$miastoFaktura = $klientTmp->GetFakturaMiasto();
			$ulicaFaktura = $klientTmp->GetFakturaUlica();
			$nrDomuFaktura = $klientTmp->GetFakturaNrDomu();
			$nrMieszkaniaFaktura = $klientTmp->GetFakturaNrMieszkania();
			$emailFaktura = $klientTmp->GetFakturaEmail();
			$kodPocztowyFaktura = $klientTmp->GetFakturaKodPocztowy();
			$nrTelFaktura = $klientTmp->GetFakturaNrTel();

			$moduleTmp = new ModulesMgr();
			$moduleTmp->loadModule('Sklep');
			$poprawFaktActn = $moduleTmp->getModuleActionIdByName('ZlozZamowienie');
			$stronaFaktActn = 'daneFaktura';

			$smarty->assign('poprawOsobActn', $poprawOsobActn);
			$smarty->assign('stronaOsobActn', $stronaOsobActn);

			$smarty->assign('czyFirmaFaktura', $czyFirmaFaktura);
			$smarty->assign('nazwaFaktura', $nazwaFaktura);
			$smarty->assign('NIPFaktura', $NIPFaktura);
			$smarty->assign('imieFaktura', $imieFaktura);
			$smarty->assign('nazwiskoFaktura', $nazwiskoFaktura);
			$smarty->assign('krajFaktura', $krajFaktura) ;
			$smarty->assign('miastoFaktura', $miastoFaktura);
			$smarty->assign('ulicaFaktura', $ulicaFaktura);
			$smarty->assign('nrDomuFaktura', $nrDomuFaktura);
			$smarty->assign('nrMieszkaniaFaktura', $nrMieszkaniaFaktura);
			$smarty->assign('kodPocztowyFaktura', $kodPocztowyFaktura);


			$smarty->assign('poprawFaktActn', $poprawFaktActn);
			$smarty->assign('stronaFaktActn', $stronaFaktActn);
			//--------------------------------------------------------koniec danych osobowych
			//4. Pozostale
			$formaPlatnosciId = $_SESSION['Zamowienie']->GetPlatnosc();
			$formaDostawyId = $_SESSION['Zamowienie']->GetDostawa();
			$uwaga = $_SESSION['Zamowienie']->GetUwagi();

			if ($_SESSION['lang'] == 'PL')
			{
				$queryPlatnosci = "
			SELECT 
				nazwa
			FROM Platnosci
			WHERE id=$formaPlatnosciId";
			}
			else
			{
				$queryPlatnosci = "
			SELECT 
			  pl.nazwa	
			FROM 
				Platnosci p INNER JOIN PlatnosciLang pl ON p.id = pl.FKPlatnosci 
			WHERE 
				p.id=$formaPlatnosciId";
			}

			if ($_SESSION['lang'] == 'PL')
			{
				$queryDostawy = "
			SELECT
				nazwa, cena
			FROM 
				Dostawy
			WHERE 
				id=$formaDostawyId";
			}
			else
			{
				$queryDostawy = "
			SELECT
				dl.nazwa, d.cena
			FROM 
				Dostawy d INNER JOIN DostawyLang dl
			WHERE 
				d.id=$formaDostawyId";
			}


			$DBInt = DBSIngleton::getInstance();
			$qResult = $DBInt->ExecQuery($queryPlatnosci);
			$dataPlatn = $qResult->fetchRow(DB_FETCHMODE_ASSOC);
			$nazwaPlatnosci = $dataPlatn['nazwa'];

			$qResult2 = $DBInt->ExecQuery($queryDostawy);
			$dataDost = $qResult->fetchRow(DB_FETCHMODE_ASSOC);
			$nazwaDostawy = $dataDost['nazwa'];
			$cenaDostawy = $dataDost['cena'];

			$smarty->assign('nazwaPlatnosci', $nazwaPlatnosci);
			$smarty->assign('nazwaDostawy', $nazwaDostawy);
			$smarty->assign('cenaDostawy', $cenaDostawy);
			$smarty->assign('uwagi', $uwaga);
			$moduleTmp = new ModulesMgr();
			$moduleTmp->loadModule('Sklep');
			$poprawPozostaleActn = $moduleTmp->getModuleActionIdByName('ZlozZamowienie');
			$stronaPozostaleActn = 'pozostale';
			//echo 'trans';
			$this->TranslateCaptionsPodsumowanie(&$smarty);

			$smarty->assign('poprawPozostaleActn', $poprawPozostaleActn);
			$smarty->assign('stronaPozostaleActn', $stronaPozostaleActn);

			//---------------------------------------------------------koniec Pozostalych

			//Akcje - Anuluuj zakupy, zamow
			$moduleTmp = new ModulesMgr();
			$moduleTmp->loadModule('Sklep');

			$anulujActn = $moduleTmp->getModuleActionIdByName('AnulujUsr');
			$zamowActn = $moduleTmp->getModuleActionIdByName('ZatwierdzUsr');

			$smarty->assign('anulujActn', $anulujActn);
			$smarty->assign('zatwierdzActn', $zamowActn);



			$html = $smarty->fetch('modules/ZamowieniePotwierdzenieForm.tpl');
			return $html;
		}
		catch(Exception $e)
		{
			$exc = new ExceptionClass($e, 'Zamowienie::Potwierdzenie');
			$exc->writeException();
			return $exc->UserErrorForm('Wystąpił błąd przy wyświetlaniu strony "Potwierdzenie zamówienia".');
		}
	}

	public function __construct()
	{
		$this->translator = new translator(rootPath.'/Modules/Sklep/SklepClass/ZamowienieView/ZamowienieView.Translation.xml');
		$this->translator->setLanguage($_SESSION['lang']);
	}

	public function WyswietlFormularzZamowienia($strona)
	{
		if ($strona == 'daneOsobowe')
		{
			return $this->ZamowienieDaneOsobowe();
		}
		else if ($strona == 'daneFaktura')
		{

			if ($_SESSION['Zamowienie']->klient->GetCzyFirma() == 'T')
			{
				//echo 'firma';
				return $this->ZamowienieDaneFakturaFirma();
			}
			else
			{
				return $this->ZamowienieDaneFakturaOsoba();
			}
		}
		else if ($strona == 'pozostale')
		{
			return $this->ZamowieniePozostale();
		}
		else if ($strona == 'potwierdzenie')
		{
			return $this->ZamowieniePotwierdzenie();
		}

	}



}
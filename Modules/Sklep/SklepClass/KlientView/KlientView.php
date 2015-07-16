<?php
final class KlientZamowienieView
{

	public $numer;
	public $status;
	public $ilosc;
	public $nazwa;
	public $opis;
	public $autor;
	public $technika;
	public $rok;
	public $rozmiar;
	public $obrazMin;
	public $cena;

}

class KlientView
{
	private $DBInt = null;


	public function testUniqueEmail($val)
	{
		$res = true;
			
		$DBInt = DBSingleton::getInstance();
		$sql = "SELECT COUNT(1) as ile FROM Klienci WHERE email='$val' and login is not null and login <> ''";
		$dbResult = $DBInt->ExecQuery($sql);
		$recData = $dbResult->fetchRow(DB_FETCHMODE_ASSOC);

		$ile = $recData['ile'];

		if ($ile == 0)
		$res  = true;
		else
		$res = false;
			
		return $res;
	}
	public function testUniqueLogin($val)
	{
		$res = true;
			
		$DBInt = DBSingleton::getInstance();
		$sql = "SELECT COUNT(1) as ile FROM Klienci WHERE login='$val'";
		$dbResult = $DBInt->ExecQuery($sql);
		$recData = $dbResult->fetchRow(DB_FETCHMODE_ASSOC);

		$ile = $recData['ile'];

		if ($ile == 0)
		$res  = true;
		else
		$res = false;
			
		return $res;
	}
	public function __construct()
	{
		$this->DBInt = DBSingleton::GetInstance();
		$this->translator = new translator(rootPath.'/Modules/Sklep/SklepClass/KlientView/KlientView.Translation.xml');
		$this->translator->setLanguage($_SESSION['lang']);
	}
	public function __destruct()
	{
		unset($this->translator);
	}
	//sprawdzenie na ptrzeby formularza ile jest juz wartosci w bazie
	private function FormGetDBValueCount($fieldName, $fieldValue)
	{
		$query = "SELECT COUNT(*) AS ile FROM `Klienci` WHERE `$fieldName` = '$fieldValue'";
		$result = $this->DBInt->ExecQuery($query);
		$data = $result->fetchRow(DB_FETCHMODE_ASSOC);
		return $data["ile"];
	}

	public function ShowEkranLogowania()
	{
		$html = '';
		$html .= '<center><table width="300" align="center"><tr><td>';
		$myForm = null;
		$myForm = new Form('UserLoginFORM', 'POST') ;
		$userLoginForm = null;
		$userLoginForm = $myForm->getFormInstance();
		$userLoginForm->addElement('header', ' hdrTekst', 'Logowanie...	');
		$loginElement = $userLoginForm->addElement('text', 'txtLogin', 'Login' , array('size' => 25, 'maxlength'=> 15));
		$passElement = $userLoginForm->addElement('password', 'txtPass', 'Hasło', array('size' => 25, 'maxlength'=> 20));
		$action = 85;
		$userLoginForm->addElement('hidden', 'a', $action, null);
		//$adminAdd_form->addElement('reset', 'btnReset', 'Wyczyść');
		$userLoginForm->addElement('submit', 'btnSubmit', 'Zaloguj');


		$userLoginForm->addRule('txtLogin', 'Proszę wypełnić pole Login!', 'required', null, 'server');
		//$adminAdd_form->addRule('txtPass', 'Proszę wypełnić pole Hasło!', 'required', null, 'server');
		$userLoginForm->applyFilter('__ALL__', 'trim');

		$myForm->setStyle(2);

		if ($userLoginForm->validate())
		{
			$userLoginForm -> freeze();
			$valLogin = mysql_real_escape_string($loginElement -> getValue());
			$valPass = MD5($passElement -> getValue());
			//echo $valPass;
			$query = "Select id From Klienci Where login='$valLogin' and pass='$valPass'";
			//echo $query;
			$result = $this->DBInt->ExecQuery($query);
			$ile = 0;
			while ($data = $result->fetchRow(DB_FETCHMODE_ASSOC))
			{
				$userid = $data["id"];
				$ile++;
			}
			if ($ile == 1)
			{
				$_SESSION["klient"] = $userid;
				$html = $this->ShowAfterLoginWindow();
			}
			else
			{

				$html = $this->ShowAfterLoginWindow();
			}
				
		}
		else
		{
			$moduleTmp = new ModulesMgr();
			$moduleTmp->loadModule('Sklep');
			$addAction = $moduleTmp->getModuleActionIdByName('AddUser');
			$resetAction = $moduleTmp->getModuleActionIdByName('UserResetPass');
			unset($moduleTmp);

			$html .= $userLoginForm->toHtml();
			$html .= '</td></tr><tr><td>
					  <table width = "100%" class="Grid" >';
			$html .= '<tr><td align="right">';
			$html .= "<a href='?a=$addAction'>Zarejestruj się</a>";
			$html .= '</td></tr>';
			$html .= '<tr><td align="right">';
			$html .= "<a href='?a=$resetAction'>Wygeneruj nowe hasło</a>";
			$html .= '</td></tr>';
			$html .= '</table>';
		}
		$html .= '</td></tr></table></center>';
		return $html;
	}
	public function ShowAfterLoginWindow()
	{
		if ($_SESSION['klient'] >0)
		{
			header('Location: ?');
		}
		else
		{
			$moduleTmp = new ModulesMgr();
			$moduleTmp->loadModule('Sklep');
			$loginAction = $moduleTmp->getModuleActionIdByName('Zaloguj');
			unset($moduleTmp);
			$html = "<a href = '?a=$loginAction'>Błąd logowania! Spróbuj jeszcze raz!</a>";
		}
		//$html = 'Zalogowany!';
		//$_SESSION['klient']=1;
		return $html;
	}
	public function ShowFormWylogowany()
	{

	}
	public function PokazKlientStatus()
	{
		$klientId = $_SESSION['klient'];
		$smarty = new mySmarty();
		//echo 'Kliid:'.$klientId;
		$smarty->assign('id', $klientId);

		if ($klientId == 0)
		{
			//echo 'klient id =0';
			$clickTxt = $this->translator->translate('textZal');
			$moduleTmp = new ModulesMgr();
			$moduleTmp->loadModule('Sklep');
			$clickAct = $moduleTmp->getModuleActionIdByName('Zaloguj');
			unset($moduleTmp);
			$clickAction = $clickAct;//zaloguj
				
			$smarty->assign('clickTxt', $clickTxt);
			$smarty->assign('clickAct', $clickAction);
				
		}
		else
		{
			//echo 'klient id <> 0';
			$clickTxt = $this->translator->translate('textWyl');
			$moduleTmp = new ModulesMgr();
			$moduleTmp->loadModule('Sklep');
			$clickAction = $moduleTmp->getModuleActionIdByName('ShowUserPage');
			$wylogujAction =  $moduleTmp->getModuleActionIdByName('Wyloguj');
			unset($moduleTmp);
				
			$klientTmp = new Klient();
			$klientTmp->LoadById($klientId);
			$login = $klientTmp->GetLogin();
				
			$smarty->assign('clickTxt', $clickTxt);
			$smarty->assign('clickAct', $clickAction);
			$smarty->assign('wylogujAction', $wylogujAction);
			$smarty->assign('login', $login);
				
		}

		$html = $smarty->fetch('modules/KlientStatus.tpl');

		return $html;
	}
	public function ShowUserDataForm()
	{
		$html = '';
		$id = -1;
		$hdrText = "Dodawanie użytkownika";

		$html .= '<center><table width="400" align="center" cellpadding=0 cellspacing=0 border=0><tr><td>';

		$myForm = null;
		$myForm = new Form('UserDataForm', 'POST') ;
		$userAdd_form = null;
		$userAdd_form = $myForm->getFormInstance();
		$userAdd_form -> addElement('header', ' hdrTest', $hdrText);

		$moduleTmp = new ModulesMgr();
		$moduleTmp->loadModule('Sklep');
		$action = $moduleTmp->getModuleActionIdByName('AddUser');
		$userAdd_form->addElement('hidden', 'a', $action, null);

		$elementName = $userAdd_form->addElement('text', 'txtName', 'Imię', array('size' => 45, 'maxlength'=> 45));
		$elementSurName = $userAdd_form->addElement('text', 'txtSurName', 'Nazwisko', array('size' => 25, 'maxlength'=> 25));
		$elementEmail = $userAdd_form->addElement('text', 'txtEmail', 'Email' , array('size' => 20, 'maxlength'=> 50));
		$elementEmail2 = $userAdd_form->addElement('text', 'txtEmail2', 'Powtórz email' , array('size' => 20, 'maxlength'=> 50));
		//jezeli nowy
		if ($_SESSION['klient']==0)
		{
			$userAdd_form -> addElement('header', ' hdrLog', 'Dane logowania');
			$elementLogin = $userAdd_form->addElement('text', 'txtLogin', 'Login' , array('size' => 20, 'maxlength'=> 15));
			$elementPass = $userAdd_form->addElement('password', 'txtPass', 'Hasło', array('size' => 20, 'maxlength'=> 20));
			$elementPass2 = $userAdd_form->addElement('password', 'txtPass2', 'Powtórz hasło', array('size' => 20, 'maxlength'=> 20));
				
		}
		//miasto, ulica, email, krajId

		//kraj
		$option_list = array();
		$query = "SELECT * FROM `Kraje`	ORDER BY `id`";
		$db = DBSingleton::GetInstance();
		$result = $db->ExecQuery($query);

		while ($userData = $result->fetchRow(DB_FETCHMODE_ASSOC))
		{
			$option_list[$userData['id']] = $userData['nazwa'];
		}
		$userAdd_form -> addElement('header', ' hdrAdr', 'Dane adresowe');
		$elementKraj = $userAdd_form->addElement('select', 'selKraj' ,'Kraj', $option_list);


		$elementMiasto = $userAdd_form->addElement('text', 'txtMiasto', 'Miasto' , array('size' => 20, 'maxlength'=> 80));
		$elementUlica = $userAdd_form->addElement('text', 'txtUlica', 'Ulica' , array('size' => 20, 'maxlength'=> 150));

		$elementNrDomu = $userAdd_form->addElement('text', 'txtNrDomu', 'Nr domu' , array('size' => 20, 'maxlength'=> 50));
		$elementNrLok = $userAdd_form->addElement('text', 'txtNrMieszkania', 'Nr lok' , array('size' => 20, 'maxlength'=> 50));
		$elementKodPocztowy = $userAdd_form->addElement('text', 'txtKodPocztowy', 'Kod poczt.' , array('size' => 20, 'maxlength'=> 50));
		$elementNrTel = $userAdd_form->addElement('text', 'txtNrTel', 'Nr. tel.' , array('size' => 20, 'maxlength'=> 50));
		$elementNrTel2 = $userAdd_form->addElement('text', 'txtNrTel2', 'Nr. tel2.' , array('size' => 20, 'maxlength'=> 50));
		$userAdd_form -> addElement('header', ' hdrFirma', 'Dane firmowe');
		$elementNazwaFirmy = $userAdd_form->addElement('text', 'txtNazwaFirmy', 'Nazwa firmy' , array('size' => 20, 'maxlength'=> 50));
		$elementNIP = $userAdd_form->addElement('text', 'txtNIP', 'NIP' , array('size' => 20, 'maxlength'=> 50));



		//$adminAdd_form->addElement('hidden', 'a', $action, null);
		$userAdd_form->addElement('reset', 'btnReset', 'Wyczyść');
		$userAdd_form->addElement('submit', 'btnSubmit', 'Zapisz');

		$userAdd_form->registerRule('testUniqueEmail', 'callback', 'testUniqueEmail', 'KlientView');
		$userAdd_form->registerRule('testUniqueLogin', 'callback', 'testUniqueLogin', 'KlientView');

		$userAdd_form->addRule('txtName', 'Proszę wypełnić pole imię!', 'required', null, 'server');
		$userAdd_form->addRule('txtSurName', 'Proszę wypełnić pole nazwisko!', 'required', null, 'server');
		$userAdd_form->addRule('txtLogin', 'Proszę wypełnić pole Login!', 'required', null, 'server');
		$userAdd_form->addRule('txtMiasto', 'Proszę wypełnić pole Miasto', 'required', null, 'server');
		$userAdd_form->addRule('txtUlica', 'Proszę wypełnić pole Ulica!', 'required', null, 'server');
		$userAdd_form->addRule('txtEmail', 'Proszę wypełnić pole Email!', 'required', null, 'server');
		$userAdd_form->addRule('txtEmail', 'Wpisano nieprawidłowy adres e-mail', 'email', null, 'server');
		$userAdd_form->addRule(array('txtEmail', 'txtEmail2'), 'Wartość wpisana w pola "email" i "powtórz emial" musi być taka sama', 'compare', null, 'server');
		$userAdd_form->addRule('txtEmail', 'Adres email już istnieje', 'testUniqueEmail');



		//jezeli nowy
		if ($_SESSION['klient']==0)
		{

			$userAdd_form->addRule('txtPass', 'Proszę wypełnić pole hasło!', 'required', null, 'server');
			$userAdd_form->addRule('txtPass2', 'Proszę wypełnić pole Powtórz hasło!', 'required', null, 'server');
			$userAdd_form->addRule(array('txtPass', 'txtPass2'), 'Pola hasło oraz powtórzone haśło muszą mieć taką samą wartość', 'compare', null, 'server');
			$userAdd_form->addRule('txtLogin', 'Login już zajęty', 'testUniqueLogin');
		}
		//informacje o rejestrowaniu wlasnych regul w config.class.php
		//$form->registerRule('ileRekordow','callback', 'FormGetDBValueCount');
		//$form->addRule('user_name','The first and last letters must be the same', 'same_firstandlast');

		//$adminAdd_form->addRule(array('txtPass', 'txtPass2'), 'Pola hasło oraz powtórzone haśło muszą mieć taką samą wartość', 'compare', null, 'server');
		$userAdd_form->applyFilter('__ALL__', 'trim');
		$myForm->setStyle(2);
		//echo $_SESSION['klient'];
		if ($userAdd_form->validate())
		{
			$userAdd_form->freeze();
				
				
			$klient = new Klient();
				
			if ($_SESSION['klient']!=0)
			{
				$klient->LoadById($_SESSION['klient']);
			}

			$kraj = $elementKraj->getValue();
			$klient->SetImie($elementName -> getValue());
			$klient->SetNazwisko($elementSurName -> getValue());
			$klient->SetKrajId($kraj[0]);
			$klient->SetFakturaKrajId($kraj[0]);
			$klient->SetMiasto($elementMiasto->getValue());
			$klient->SetUlica($elementUlica->getValue());
			$klient->SetNrDomu($elementNrDomu->getValue());
			$klient->SetNrMieszkania($elementNrLok->getValue());
			$klient->SetKodPocztowy($elementKodPocztowy->getValue());
			$klient->SetNrTel($elementNrTel->getValue());
			$klient->SetNrTel2($elementNrTel2->getValue());
			$klient->SetNazwaFirmy($elementNazwaFirmy->getValue());
			$klient->SetNip($elementNIP->getValue());
			if ($_SESSION['klient']==0)
			{
				$klient->SetLogin($elementLogin->getValue());
				$klient->SetPass(MD5($elementPass->getValue()));
				$klient->SetTmpPass($elementPass->getValue());
			}
			$klient->SetEmail($elementEmail->getValue());
			$klientId = $klient->Save($_SESSION['klient'], true);
				
			if ($_SESSION['klient']==0)
			{
				$html = 'Rejestracja zakończona';
				$kontaktFact = new KontaktKreator();
				$kontakt = $kontaktFact->FactoryMethod('rejestracja', $klientId);
				$kontakt->Send();

				$klient->SetTmpPass('');
				$klient->Save($klientId, false);

			}
			else
			{
				$html = 'Dane zmienione';
			}
				
			return $html;

			/*$QueryString = "&txtName=$name&txtSurName=$surname&txtLogin=$login&txtPass=$pass";
			 echo "<tr class=\"header\"><td colspan=\"2\" align = \"right\"><a href=\"?a=$action".$QueryString."\" class=\"leftmenu\"><input type=\"button\" value=\"Zapisz\"></a>";
			 echo "<a href=\"index.php\"?a=$action2\" class=\"leftmenu\"><input type=\"button\" value=\"Anuluj\"></a></td></tr>";
			 //echo "<input type=\"button\" value=\"Anuluj\" onclick=\"document.location.href='index.php?a=$action2'\"></td></tr>";
			 echo "</table>";*/
				
		}
		else
		{
			if ($_SESSION['klient']>0)
			{
				$klient = new Klient();
				$klient->LoadById($_SESSION['klient']);
				$elementName->setValue($klient->GetImie());
				$elementSurName->setValue($klient->GetNazwisko());
				$elementKraj->setValue($klient->GetKraj());
				$elementMiasto->setValue($klient->GetMiasto());
				$elementUlica->setValue($klient->GetUlica());
				$elementNrDomu->setValue($klient->GetNrDomu());
				$elementNrLok->setValue($klient->GetNrMieszkania());
				$elementKodPocztowy->setValue($klient->GetKodPocztowy());
				$elementNrTel->setValue($klient->GetNrTel());
				$elementNrTel2->setValue($klient->GetNrTel2());
				$elementNazwaFirmy->setValue($klient->GetNazwaFirmy());
				$elementNIP->setValue($klient->GetNip());
				$elementEmail->setValue($klient->GetEmail());

				unset($klient);
			}
			$html .= $userAdd_form->toHtml();
		}

		$html .= '</td></tr></table></center>';
		return $html;
	}
	public function ShowUserPage()
	{
		$html = '';

		$moduleTmp = new ModulesMgr();
		$moduleTmp->loadModule('Sklep');


		$txtPowitanie = $this->translator->translate('textPowitanie');

		$txtZmianaDanych = $this->translator->translate('textZmianaDanych');
		$actnZmianaDanych = $moduleTmp->getModuleActionIdByName('AddUser');

		$txtZmianaHasla = $this->translator->translate('textZmianaHasla');
		$actnZmianaHasla = $moduleTmp->getModuleActionIdByName('UserChangePass');

		$txtZamowienia = $this->translator->translate('textZamowienia');


		$txtNumerZam = $this->translator->translate('textNumerZam');
		$txtStatus = $this->translator->translate('textStatus');
		$txtNazwa = $this->translator->translate('textNazwa');
		$txtOpis = $this->translator->translate('textOpis');
		$txtAutor = $this->translator->translate('textAutor');
		$txtTechnika = $this->translator->translate('textTechnika');
		$txtRok = $this->translator->translate('textRok');
		$txtRozmiar = $this->translator->translate('textRozmiar');
		$txtIlosc = $this->translator->translate('textIlosc');
		$txtCena = $this->translator->translate('textCena');


		//tu select do zamowien
		$idKlient = $_SESSION['klient'];

		$query = "SELECT
					Concat('ZAM',Z.id) AS numerZam,
		   			T.nazwa, T.opis, T.autor, T.technika, T.rok, T.rozmiar, 
		   			T.obrazMin,	T.cena, ZT.ilosc,
		   			CASE 
		   				WHEN Z.status=0 THEN 'Nowe'
		   				WHEN Z.status=1 THEN 'Potwierdzone'
		   				WHEN Z.status=2 THEN 'Przyjęte'
		   				WHEN Z.status=3 THEN 'Wysłane'
		   				WHEN Z.status=3 THEN 'Zrealizowane'
		   			END AS stat 
				  FROM 
				  	Zamowienia Z
				  	INNER JOIN ZamowieniaTowary ZT ON ZT.FkZam = Z.id
				  	INNER JOIN Towary T ON T.id = ZT.FkTow
				  WHERE
				  	 Z.FKKlient = $idKlient AND Z.status < 4 
				";


		$result = $this->DBInt->ExecQuery($query);

		$zamowienia = array();

		while ($data = $result->fetchRow(DB_FETCHMODE_ASSOC))
		{
			$tmpZamowienieView = new KlientZamowienieView();
			$tmpZamowienieView->numer = $data['numerZam'];
			$tmpZamowienieView->nazwa = $data['nazwa'];
			$tmpZamowienieView->opis = $data['opis'];
			$tmpZamowienieView->autor = $data['autor'];
			$tmpZamowienieView->technika = $data['technika'];
			$tmpZamowienieView->rok = $data['rok'];
			$tmpZamowienieView->rozmiar = $data['rozmiar'];
			$tmpZamowienieView->obrazMin = $data['obrazMin'];
			$tmpZamowienieView->ilosc = $data['ilosc'];
			$tmpZamowienieView->cena = $data['cena'];
			$tmpZamowienieView->status = $data['stat'];

				
				
			$zamowienia[] = $tmpZamowienieView;
		}

		$smarty = new mySmarty();

		$smarty->assign('txtZmianaDanych', $txtZmianaDanych);
		$smarty->assign('actnZmianaDanych', $actnZmianaDanych);
		$smarty->assign('txtZmianaHasla', $txtZmianaHasla);
		$smarty->assign('actnZmianaHasla', $actnZmianaHasla);
		$smarty->assign('txtZamowienia', $txtZamowienia);

		$smarty->assign('txtNumerZam', $txtNumerZam);
		$smarty->assign('txtNazwa', $txtNazwa);
		$smarty->assign('txtOpis', $txtOpis);
		$smarty->assign('txtAutor', $txtAutor);
		$smarty->assign('txtTechnika', $txtTechnika);
		$smarty->assign('txtRok', $txtRok);
		$smarty->assign('txtRozmiar', $txtRozmiar);
		$smarty->assign('txtIlosc', $txtIlosc);
		$smarty->assign('txtCena', $txtCena);

		$smarty->assign('zamowienia', $zamowienia);

		$html = $smarty->fetch('modules/KlientMainPage.tpl');

		return $html;
	}
	public function UserChangePass()
	{

		$klientTmp = new Klient();
		$klientTmp->LoadById($_SESSION['klient']);

		$html = '';
		$html .= '<table width="500" align="center" cellpadding=0 cellspacing=0 border=0><tr><td>';

		$myForm = null;
		$myForm = new Form('userEditForm', 'POST') ;
		$userPassEditForm = null;
		$userPassEditForm = $myForm ->getFormInstance();
		$hdrTxt = 'Edycja hasła dla '.$klientTmp->GetLogin();
		$userPassEditForm -> addElement('header', ' hdrTekst', $hdrTxt);

		//$elementOldPass = $userPassEditForm->addElement('password', 'txtOldPass', 'Stare hasło', array('size' => 25, 'maxlength'=> 100));
		$elementNewPass = $userPassEditForm->addElement('password', 'txtPass', 'Nowe hasło' , array('size' => 20, 'maxlength'=> 100));
		$elementNewPass2 = $userPassEditForm->addElement('password', 'txtPass2', 'Nowe hasło (powtórz)' , array('size' => 20, 'maxlength'=> 100));
		$valId = $userPassEditForm->addElement('hidden', 'id', '');


		$moduleTmp = new ModulesMgr();
		$moduleTmp->loadModule('Sklep');
		$action = $moduleTmp->getModuleActionIdByName('UserChangePass');


		$userPassEditForm->addElement('hidden', 'a', $action, null);
		$userPassEditForm->addElement('reset', 'btnReset', 'Wyczyść');
		$userPassEditForm->addElement('submit', 'btnSubmit', 'Dalej');

		//$adminPassEditForm->addRule('txtOldPass', 'Proszę wypełnić pole hasło!', 'required', null, 'server');
		$userPassEditForm->addRule('txtPass', 'Proszę wypełnić pole "nowe hasło"!', 'required', null, 'server');
		$userPassEditForm->addRule('txtPass2', 'Proszę wypełnić pole "nowe hasło (powtórz)"!', 'required', null, 'server');
		$userPassEditForm->addRule(array('txtPass', 'txtPass2'), 'Pola hasło oraz powtórzone haśło muszą mieć taką samą wartość', 'compare', null, 'server');
		$userPassEditForm->addRule(array('txtPass', 'txtPass2'), 'Pola hasło oraz powtórzone haśło muszą mieć taką samą wartość', 'compare', null, 'server');

		$userPassEditForm->applyFilter('__ALL__', 'trim');

		$myForm->setStyle(2);

		if ($userPassEditForm->validate())
		{
			$userPassEditForm->freeze();
				
			$newPass = mysql_real_escape_string($elementNewPass->getValue());
			//$newPass2 = mysql_real_escape_string($elementNewPass2->getValue());
			$valueId = $valId -> getValue();
			/*$valName = $elementName -> getValue();
			 $valSurname = $elementSurName -> getValue();
			 $valLogin = $elementLogin -> getValue();
			 $valueId = $valId -> getValue();
			 //$id, $name, $surname, $login*/
			$html .= $this->userPassEditDo($valueId, $newPass);

		}
		else
		{
			$valId -> setValue($_SESSION['klient']);
			$html .=$userPassEditForm->toHtml();

			$html .= '</td></tr>';
		}

		$html .= '</td></tr>';
		$html .= '</table>';
		return $html;
	}
	private function userPassEditDo($valueId, $newPass)
	{
		try
		{
			$klientTmp = new Klient();
			$klientTmp->LoadById($valueId);
			$klientTmp->SetPass(MD5($newPass));
			return $klientTmp->Save($valueId);
			//smarty

			$smarty = new mySmarty();
			return $smarty->fetch('modules/PassChgd.tpl');
		}
		catch(Exception $e)
		{
			$exc = new ExceptionClass($e, 'KlientView::UserPassEditDo');
			$exc->writeException();
			return $exc->UserErrorForm('Wystapił błąd podczas zmiany hasła.');
		}

	}
	public function UserResetPass()
	{
		$html = '';
		$html .= '<table width="500" align="center" cellpadding=0 cellspacing=0 border=0><tr><td>';

		$myForm = null;
		$myForm = new Form('userPassResetForm', 'POST') ;
		$userPassResetForm = null;
		$userPassResetForm = $myForm ->getFormInstance();
		$hdrTxt = 'Generowanie nowego hasła';
		$userPassResetForm -> addElement('header', ' hdrTekst', $hdrTxt);
		$elementLogin = $userPassResetForm->addElement('text', 'txtLogin', 'Login' , array('size' => 20, 'maxlength'=> 20));

		//$valId = $userPassResetForm->addElement('hidden', 'id', '');
		$moduleTmp = new ModulesMgr();
		$moduleTmp->loadModule('Sklep');
		$action = $moduleTmp->getModuleActionIdByName('UserResetPass');
		$userPassResetForm->addElement('hidden', 'a', $action, null);
		$userPassResetForm->addElement('submit', 'btnSubmit', 'Wyślij nowe hasło!');
		$userPassResetForm->addRule('txtLogin', 'Proszę wypełnić pole "login"!', 'required', null, 'server');

		$userPassResetForm->applyFilter('__ALL__', 'trim');

		$myForm->setStyle(2);

		if ($userPassResetForm->validate())
		{
			$userPassResetForm->freeze();
				
			$login = mysql_real_escape_string($elementLogin->getValue());
			//$newPass2 = mysql_real_escape_string($elementNewPass2->getValue());
				
			/*$valName = $elementName -> getValue();
			 $valSurname = $elementSurName -> getValue();
			 $valLogin = $elementLogin -> getValue();
			 $valueId = $valId -> getValue();
			 //$id, $name, $surname, $login*/
			$html = $this->UserPassResetDo($login);

		}
		else
		{
			//$valId -> setValue($_SESSION['klient']);
			$html .=$userPassResetForm->toHtml();
			$html .= '</td></tr>';
			$html .= '</table>';
		}


		return $html;
	}
	private function UserPassResetDo($login)
	{
		//1. Szukam id do klienta o loginie

		//2 Wysylam maila "reset hasla"
		$sql = "
			SELECT id FROM Klienci WHERE login='$login'
			";
		$result = $this->DBInt->ExecQuery($sql);
		$data = $result->fetchRow(DB_FETCHMODE_ASSOC);
		$id = $data['id'];

		$tmpKlient = new Klient();
		$tmpKlient->LoadById($id);
		$pass = $tmpKlient->GetPass();
		$tmpPass = substr(MD5($pass.$login), 0, 4);
		$tmpKlient->SetTmpPass($tmpPass);
		$tmpKlient->SetPass(MD5($tmpPass));
		$tmpKlient->Save($id, false);
		$kontakt = new KontaktKreator();
		$kontaktKli = $kontakt->FactoryMethod('resetHasla', $id);

		$kontaktKli->Send();

		return 'Hasło zostało wysłane na adres email';


	}
	public function ShowAdmin($kryt)
	{
		
		
		/*$query = "
			SELECT
				k.email, k.imie, k.nazwisko, k.login, kr.nazwa, k.miasto, k.ulica, k.numerDomu, k.numerMieszkania, k.kodPocztowy
			FROM
				Klienci k INNER JOIN Kraje kr ON k.krajId = kr.id
			WHERE
				$txKryt
			ORDER BY 
				k.email	
		"; 
		
		
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
		$grid -> setTitle('Grupy ofert');
		$grid -> setGridAlign('center');
		$grid -> setGridWidth(780);
		$grid -> addColumn('tytul', 'Nazwa', 200, false, false, 'left');
		$grid -> addColumn('opis', 'Opis', 400, false, false, 'left');
		$grid -> addColumn('caption', 'Menu', 200, false, false, 'left');
		$grid -> addColumn('id', '', 10, true, false, 'right');
		$grid -> enabledDelAction($delAction);
		$grid -> enabledEditAction($editAction);
		$grid -> setDataQuery($query);
		
		$html .= $grid->renderHtmlGrid(1);
		$html .= '</td></tr>';
		$html .= '<tr><td align="right" colspan="2">';
		$html .= $addButton->show(1);
		$html .= '</td></tr>';
		$html .= '</table>';*/
		$html = 'Czy to potrzebne?';
			
		return $html;
	}
	public function EditAdmin($id)
	{
		
	}
}
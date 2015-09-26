<?php

class adminUsrClass
{
	/**
	 * @var $userId Przechowuje id zalogowanego uzytkownika
	 * @access private
	 */
	private $userId = -1;
	private $DBInt = null;
	private $allElements = array();

	/**
	 * @var $chkdElements Przechowuje zaznaczone akcje - przy zmianie uprawnień
	 * @access private
	 */
	private $chkdElements = array();
	private $adminLog = null;

	/**
	 * Zwraca login użytkownika na podstawie id
	 * @param $id Identyfikator użytkownika
	 * @access private
	 * @author Piotr Brodziński
	 */
	private function getUserLogin($id)
	{
		$query = 'Select Login From cmsUsers Where id='.$id;
		$result = $this->DBInt->ExecQuery($query);
		$adminLogin = '';
		while ($data = $result->fetchRow(DB_FETCHMODE_ASSOC))
		{
			$adminLogin = $data["Login"];

		}
		return $adminLogin;
	}

	/**
	 * Zapis danych po edycji użytkownika
	 * @param $id Identyfikator użytkownika
	 * @param $name Imię użytkownika
	 * @param $surname Nazwisko użytkonwika
	 * @param login Login użytkownika
	 * @access private
	 * @author Piotr Brodziński
	 */
	private function adminEditDo($id, $name, $surname, $login, $email, $rola)
	{
		$html = '';
		$query = "
				UPDATE 
					cmsUsers 
				SET 
					`Name` = '$name', `LastName` = '$surname', `Login` = '$login', `email` = '$email', `rola` = '$rola' 
				WHERE 
					`id`=$id";
			
		$module = new modulesMgr();
		$module->loadModule('AdminUsr');
		$action = $module->getModuleActionIdByName('showAdmins');
			
		try
		{
			$this->DBInt->ExecQuery($query);
			$dialog = new dialog('Edycja użytkownika', 'Dane zostały zmienione', 'info', 390, 150);
			$dialog->setAlign('center');
			$dialog->setOkAction($action);
			$dialog->setOkCaption('Ok');
			$html .= $dialog->show(1);
			return $html;

		}
		catch(exception $e)
		{
			$dialog = new dialog('Edycja użytkownika', 'Wystąpiły problemy. Dane nie zostały zmienione!', 'info', 200, 100);
			$dialog->setAlign('alert');
			$dialog->setOkAction($action);
			$dialog->setOkCaption('Ok');
			$html .=$dialog->show(1);
			return $html;
		}
		//$_SESSION["a"] = $action;
		//echo "<script language=\"javascript\">location.href=\"?\";</script>";
	}

	private function adminAddDo($name, $surname, $login, $pass, $email, $rola)
	{
		//		$passMd5 = md5($pass);
		$query = "Insert Into cmsUsers (`Name`, `LastName`, `Login`, `Pass`, `Root`, `email`, `rola`) Values ('$name', '$surname', '$login', '$pass', 'T', '$email', '$rola')";
		$this->DBInt->ExecQuery($query);
			
		$module = new modulesMgr();
		$module->loadModule('AdminUsr');
		$action = $module->getModuleActionIdByName('showAdmins');
		$dialog = new dialog('Zapis danych', 'Dane zostały zapisane prawidłowo', 'Info', 300, 150);
		$dialog->setAlign('center');
		$dialog->setOkCaption('Ok');
		$dialog->setOkAction($action);
		$ret = $dialog->show(1);
		return $ret;
	}

	/**
	 * Konstruktor domyślny
	 * @param
	 * @author Piotr Brodziński
	 * @access public
	 */
	public function __construct()
	{
		$this->DBInt = DBSingleton::GetInstance();

		if (isset($_SESSION['adminId']))
		$this->adminLog = new adminLog($_SESSION['adminId']);
	}

	public function __destruct()
	{
		unset($this->adminLog);
	}

	public function showAdmins()
	{
		$html = '';
		$query = "Select id, LastName, Name, Login, Active, LastLogin from cmsUsers Order By Login";
		$module = new modulesMgr();
		$module -> loadModule('AdminUsr');
		$action = $module->getModuleActionIdByName('adminAdd');
		$editaction = $module->getModuleActionIdByName('adminEdit');
		$delaction = $module->getModuleActionIdByName('adminDelete');

		$html .= '<table class="Grid" align="center" cellspacing=0>';
		$html .= '<tr>';
		$html .= '<td width=50><img src="./Cms/Files/Img/about-48x48.png" /></td>';
		$html .= '<td><br/></td>';
		$html .= '</tr>';
		$html .= '<tr><td align="right" colspan="2"><hr/>';
		$grid = new gridRenderer();
		$grid->setTitle('Lista użytkowników systemu CMS (administratorzy)');
		$grid->addColumn('Login', 'Login',50, false, 'left');
		$grid->addColumn('Name', 'Imię', 130, false, 'left');
		$grid->addColumn('LastName', 'Nazwisko', 130, false, 'left');
		$grid->addColumn('Active', 'Aktywny',50, false, 'center');
		$grid->addColumn('LastLogin', 'Ostatnio zalogowany',100, false, 'center');
		$grid->addColumn('id', 'id', 10, true, 'left');
		$grid->setDataQuery($query);
		$grid->setGridWidth(780);
		$grid->enabledEditAction($editaction);
		$grid->enabledDelAction($delaction);
		$html .=$grid->renderHtmlGrid(1);
		$html .= '</td></tr>';
		$html .= '<tr><td align="right" colspan="2">';
		$addButton = new button(buttonAddIcon, 'Dodaj użytkownika', $action, -1);
		$html .=$addButton->show(1);
		$html .= '</td></tr>';
		$html .= '</table>';
		return $html;
		// 		$userData = $result->fetchRow(DB_FETCHMODE_ASSOC);
	}
	public function adminLogout()
	{

		$_SESSION["adminId"] = -1;
		// jak wylaczone javascript to bedize widac napis
		$html =
			'<b>Użytkownik wylogowany!!!</b>
			<script language="javascript">location.reload(true);</script>
			';
		return $html;
	}
	public function adminLogin()
	{
		//include rootPath.'/Includes/application.inc.php';
		//session_start();
		$html = '';
		$html .= '<table width="300" align="center"><tr><td>';
		$myForm = null;
		$myForm = new Form('adminAddFORM', 'POST') ;
		$adminAdd_form = null;
		$adminAdd_form = $myForm->getFormInstance();
		$adminAdd_form->addElement('header', ' hdrTest', 'Logowanie...	');
		$loginElement = $adminAdd_form->addElement('text', 'txtLogin', 'Login' , array('size' => 25, 'maxlength'=> 15));
		$passElement = $adminAdd_form->addElement('password', 'txtPass', 'Hasło', array('size' => 25, 'maxlength'=> 20));
			
		//$adminAdd_form->addElement('hidden', 'a', $action, null);
		//$adminAdd_form->addElement('reset', 'btnReset', 'Wyczyść');
		$adminAdd_form->addElement('submit', 'btnSubmit', 'Zaloguj');


		$adminAdd_form->addRule('txtLogin', 'Proszę wypełnić pole Login!', 'required', null, 'server');
		//$adminAdd_form->addRule('txtPass', 'Proszę wypełnić pole Hasło!', 'required', null, 'server');
		$adminAdd_form->applyFilter('__ALL__', 'trim');
		$myForm->setStyle(2);

		if ($adminAdd_form->validate())
		{
			$adminAdd_form -> freeze();
			$valLogin = $loginElement -> getValue();
			$valPass = MD5($passElement -> getValue());

			$query = "Select id, Name, LastName, LastLogin From cmsUsers Where Login='$valLogin' and Pass='$valPass'";
				
				
			$result = $this->DBInt->ExecQuery($query);
			$ile = 0;
			while ($data = $result->fetchRow(DB_FETCHMODE_ASSOC))
			{
				$adminid = $data["id"];
				$adminName = $data["Name"];
				$adminLastName = $data["LastName"];
				$adminLastLogin = $data["LastLogin"];
				$ile++;
			}
			if ($ile == 1)
			{
				$_SESSION["adminId"] = $adminid;

				if (isset($this->adminLog))
				{
					unset($this->adminLog);
				}
				$this->adminLog = new adminLog($_SESSION['adminId']);
					
					
				$html .= '<table class="Grid" align="center" width = "300">';
				$html .= '<tr class="header"><td colspan="2" align = \"center\">Informacje logowania:</td></tr>';
				$html .= '<tr><td>Imie:</td><td>' . $adminName.'</td></tr>';
				$html .= '<tr><td>Nazwisko:</td><td>' . $adminLastName.'</td></tr>';
				$html .= '<tr><td>Data logowania:</td><td>' . $adminLastLogin.'</td></tr>';
				$html .= "<tr class=\"header\"><td colspan=\"2\" align = \"right\"><a href=\"?a=-1 \" class=\"leftmenu\"><input type=\"button\" value=\"Ok\"></a>";
				$html .= "</table>";

				$loginDate = date("d-m-y, g:i");
				$query = "Update cmsUsers Set LastLogin='$loginDate' where id=$adminid";
				$result = $this->DBInt->ExecQuery($query);
				$this->adminLog->writeLog('adminLogin', $valLogin, 'Udane logowanie');
			}
			else
			{
				$html .='<table class="Grid" align="center" width = "300">';
				$html .='<tr class="header"><td colspan="2" align = \"center\">Błąd logowania</td></tr>';
				$html .='<tr class="content"><td colspan="2" align = \"center\">Błędne login i/lub hasło</td></tr>';
				$html .="<tr class=\"header\"><td colspan=\"2\" align = \"right\"><a href=\"?a=-1\" class=\"leftmenu\"><input type=\"button\" value=\"Loguj się ponownie\"></a>";
				$html .= "</table>";
				$this->adminLog->writeLog('adminLogin', $valLogin, 'Nieudane logowanie');
			}
				
		}
		else
		{
			$html .= $adminAdd_form->toHtml();
		}


		//$pass = md5($values['txtPass']);


		$html .='</td></tr></table>';
		return $html;
	}
	public function adminAdd()
	{
		$html = '';
		$id = -1;
		$hdrText = "Dodawanie użytkownika";

		$html .= '<table width="400" align="center" cellpadding=0 cellspacing=0 border=0><tr><td>';

		$myForm = null;
		$myForm = new Form('adminAddFORM', 'POST') ;
		$adminAdd_form = null;
		$adminAdd_form = $myForm->getFormInstance();
		$adminAdd_form -> addElement('header', ' hdrTest', $hdrText);
		$elementName = $adminAdd_form->addElement('text', 'txtName', 'Imię', array('size' => 25, 'maxlength'=> 25));
		//$config_form::setSize (int $size)

		$elementSurName = $adminAdd_form->addElement('text', 'txtSurName', 'Nazwisko', array('size' => 25, 'maxlength'=> 25));
		$elementEmail = $adminAdd_form->addElement('text', 'txtEmail', 'E-mail', array('size' => 50, 'maxlength'=> 25));
		$rolaList['A'] = 'Admin';
		$rolaList['O'] = 'Operator';
		$elementRola = $adminAdd_form->addElement('select', 'rola', 'Rola', $rolaList);

		$elementLogin = $adminAdd_form->addElement('text', 'txtLogin', 'Login' , array('size' => 20, 'maxlength'=> 15));
		//jezeli nowy

		$elementPass = $adminAdd_form->addElement('password', 'txtPass', 'Hasło', array('size' => 20, 'maxlength'=> 20));
		$elementPass2 = $adminAdd_form->addElement('password', 'txtPass2', 'Powtórz hasło', array('size' => 20, 'maxlength'=> 20));


		//$adminAdd_form->addElement('hidden', 'a', $action, null);
		$adminAdd_form->addElement('reset', 'btnReset', 'Wyczyść');
		$adminAdd_form->addElement('submit', 'btnSubmit', 'Dalej');

		$adminAdd_form->addRule('txtName', 'Proszę wypełnić pole imię!', 'required', null, 'server');
		$adminAdd_form->addRule('txtSurName', 'Proszę wypełnić pole nazwisko!', 'required', null, 'server');
		$adminAdd_form->addRule('txtLogin', 'Proszę wypełnić pole Login!', 'required', null, 'server');
		//jezeli nowy
		$adminAdd_form->addRule('txtPass', 'Proszę wypełnić pole hasło!', 'required', null, 'server');
		$adminAdd_form->addRule('txtPass2', 'Proszę wypełnić pole Powtórz hasło!', 'required', null, 'server');
		$adminAdd_form->addRule(array('txtPass', 'txtPass2'), 'Pola hasło oraz powtórzone haśło muszą mieć taką samą wartość', 'compare', null, 'server');


		//$adminAdd_form->addRule(array('txtPass', 'txtPass2'), 'Pola hasło oraz powtórzone haśło muszą mieć taką samą wartość', 'compare', null, 'server');
		$adminAdd_form->applyFilter('__ALL__', 'trim');
		$myForm->setStyle(2);

		if ($adminAdd_form->validate())
		{
			$adminAdd_form->freeze();
				
			$valName = $elementName -> getValue();
			$valSurname = $elementSurName -> getValue();
			$valLogin = $elementLogin -> getValue();
				
			$valPass = $elementPass -> getValue();
			$valEmail = $elementEmail->getValue();
			$valRolaArr = $elementRola->getValue();
			$html .= $this->adminAddDo($valName, $valSurname, $valLogin, MD5($valPass), $valEmail, $valRolaArr[0]);


			/*$QueryString = "&txtName=$name&txtSurName=$surname&txtLogin=$login&txtPass=$pass";
			 echo "<tr class=\"header\"><td colspan=\"2\" align = \"right\"><a href=\"?a=$action".$QueryString."\" class=\"leftmenu\"><input type=\"button\" value=\"Zapisz\"></a>";
			 echo "<a href=\"index.php\"?a=$action2\" class=\"leftmenu\"><input type=\"button\" value=\"Anuluj\"></a></td></tr>";
			 //echo "<input type=\"button\" value=\"Anuluj\" onclick=\"document.location.href='index.php?a=$action2'\"></td></tr>";
			 echo "</table>";*/
				
		}
		else
		{
			$html .= $adminAdd_form->toHtml();
				
			$moduleTmp = new ModulesMgr();
			$moduleTmp->loadModule('AdminUsr');
			$cancelAction = $moduleTmp->getModuleActionIdByName('showAdmins');
			unset($moduleTmp);
				
			$html .= '</td></tr><tr><td>
					  <table width = "100%" class="Grid" >';
			$html .= '<tr><td align="right">';
			$buttonChgPass = new button(dnsPath.'/Cms/Files/Img/delete-16x16.png', 'Anuluj', $cancelAction, $this->userId);
			$html .=$buttonChgPass->show(1);
			$html .= '</td></tr>';
			$html .= '</table>';
		}

		$html .= '</td></tr></table>';
		return $html;

	}

	public function adminEdit($id)
	{

		$this->userId = $id;
		$hdrText = "Edycja użytkownika";
		$html = '';
		$html .= '<table width="400" align="center" cellpadding=0 cellspacing=0 border=0><tr><td>';

		$html .= '<tr><td>';

		$myForm = null;
		$myForm = new Form('adminEditForm', 'POST') ;
		$adminEditForm = null;
		$adminEditForm = $myForm -> getFormInstance();
		$adminEditForm -> addElement('header', ' hdrTest', $hdrText);
		$elementName = $adminEditForm->addElement('text', 'txtName', 'Imię', array('size' => 25, 'maxlength'=> 25));
		//$config_form::setSize (int $size)

		$elementSurName = $adminEditForm->addElement('text', 'txtSurName', 'Nazwisko', array('size' => 25, 'maxlength'=> 25));

		$elementEmail = $adminEditForm->addElement('text', 'txtEmail', 'E-mail', array('size' => 50, 'maxlength'=> 25));
		$rolaList['A'] = 'Admin';
		$rolaList['O'] = 'Operator';
		$elementRola = $adminEditForm->addElement('select', 'rola', 'Rola', $rolaList);


		$elementLogin = $adminEditForm->addElement('text', 'txtLogin', 'Login' , array('size' => 20, 'maxlength'=> 15));
		$valId = $adminEditForm->addElement('hidden', 'id', '');

		//$adminAdd_form->addElement('hidden', 'a', $action, null);
		$adminEditForm->addElement('reset', 'btnReset', 'Wyczyść');
		$adminEditForm->addElement('submit', 'btnSubmit', 'Dalej');

		$adminEditForm->addRule('txtName', 'Proszę wypełnić pole imię!', 'required', null, 'server');
		$adminEditForm->addRule('txtSurName', 'Proszę wypełnić pole nazwisko!', 'required', null, 'server');
		$adminEditForm->addRule('txtLogin', 'Proszę wypełnić pole Login!', 'required', null, 'server');

		$adminEditForm->applyFilter('__ALL__', 'trim');

		$myForm->setStyle(2);

		if ($adminEditForm->validate())
		{
			$adminEditForm->freeze();
				
			$valName = $elementName -> getValue();
			$valSurname = $elementSurName -> getValue();
			$valLogin = $elementLogin -> getValue();
			$valueId = $valId -> getValue();
			$valEmail = $elementEmail->getValue();
			$valRolaArr = $elementRola->getValue();

			//$id, $name, $surname, $login
			$html .= $this->adminEditDo($valueId, $valName, $valSurname, $valLogin, $valEmail, $valRolaArr[0]);
		}
		else
		{
			$query = "Select Name, LastName, Login, email, rola From cmsUsers Where id=".$id;
			 
			//echo $query;
			$resultRec = $this->DBInt->ExecQuery($query);
			$data = $resultRec->fetchRow(DB_FETCHMODE_ASSOC);
				
			$elementName -> setValue($data["Name"]);
			$elementSurName -> setValue($data["LastName"]);
			$elementLogin -> setValue($data["Login"]);
			$elementEmail -> setValue($data['email']);
			$elementRola -> setValue($data['rola']);
			$valId -> setValue($this->userId);

			$html .=$adminEditForm->toHtml();

			$moduleChgPass = new ModulesMgr();
			$moduleChgPass->loadModule('AdminUsr');
			$chgPassAction = $moduleChgPass->getModuleActionIdByName('adminPassEdit');
			$cancelAction = $moduleChgPass->getModuleActionIdByName('showAdmins');
			$html .= '</td></tr><tr><td>
					  <table width = "100%" class="Grid" >';
			$html .= '<tr><td align="right">';
			$buttonChgPass = new button('', 'Zmień hasło', $chgPassAction, $this->userId);
			$html .= $buttonChgPass->show(1);
			$buttonCancel = new button('', 'Anuluj', $cancelAction, -1);
			$html .= $buttonCancel->show(1);
			$html .='</td></tr>';
			$html .='</table>';
		}
		$html .= '</td></tr></table>';
		//zmiana hasla
		return $html;


	}

	public function adminPassEdit($id)
	{
		$this->userId = $id;
		$html = '';
		$html .= '<table width="500" align="center" cellpadding=0 cellspacing=0 border=0><tr><td>';

		$myForm = null;
		$myForm = new Form('adminEditForm', 'POST') ;
		$adminPassEditForm = null;
		$adminPassEditForm = $myForm -> getFormInstance();
		$hdrTxt = 'Edycja hasła dla '.$this->getUserLogin($id);
		$adminPassEditForm -> addElement('header', ' hdrTekst', $hdrTxt);

		$elementOldPass = $adminPassEditForm->addElement('password', 'txtOldPass', 'Stare hasło', array('size' => 25, 'maxlength'=> 20));
		$elementNewPass = $adminPassEditForm->addElement('password', 'txtPass', 'Nowe hasło' , array('size' => 20, 'maxlength'=> 20));
		$elementNewPass2 = $adminPassEditForm->addElement('password', 'txtPass2', 'Nowe hasło (powtórz)' , array('size' => 20, 'maxlength'=> 20));
		$valId = $adminPassEditForm->addElement('hidden', 'id', '');

		//$adminAdd_form->addElement('hidden', 'a', $action, null);
		$adminPassEditForm->addElement('reset', 'btnReset', 'Wyczyść');
		$adminPassEditForm->addElement('submit', 'btnSubmit', 'Dalej');

		//$adminPassEditForm->addRule('txtOldPass', 'Proszę wypełnić pole hasło!', 'required', null, 'server');
		$adminPassEditForm->addRule('txtPass', 'Proszę wypełnić pole "nowe hasło"!', 'required', null, 'server');
		$adminPassEditForm->addRule('txtPass2', 'Proszę wypełnić pole "nowe hasło (powtórz)"!', 'required', null, 'server');
		$adminPassEditForm->addRule(array('txtPass', 'txtPass2'), 'Pola hasło oraz powtórzone haśło muszą mieć taką samą wartość', 'compare', null, 'server');
		$adminPassEditForm->addRule(array('txtPass', 'txtPass2'), 'Pola hasło oraz powtórzone haśło muszą mieć taką samą wartość', 'compare', null, 'server');
		$adminPassEditForm->applyFilter('__ALL__', 'trim');

		$myForm->setStyle(2);

		if ($adminPassEditForm->validate())
		{
			$adminPassEditForm->freeze();
			$oldPass = $elementOldPass->getValue();
			$newPass = $elementNewPass->getValue();
			$newPass2 = $elementNewPass2->getValue();
			$valueId = $valId -> getValue();
			/*$valName = $elementName -> getValue();
			 $valSurname = $elementSurName -> getValue();
			 $valLogin = $elementLogin -> getValue();
			 $valueId = $valId -> getValue();
			 //$id, $name, $surname, $login*/
			$html .= $this->adminPassEditDo($valueId, $oldPass, $newPass, $newPass2);
				
		}
		else
		{
			$valId -> setValue($this->userId);
			$html .=$adminPassEditForm->toHtml();
				
			$html .= '</td></tr><tr><td>
					  <table width = "100%" class="Grid" >';
			$html .= '<tr><td align="right">';
			$moduleTmp = new ModulesMgr();
			$moduleTmp->loadModule('AdminUsr');
			$cancelAction = $moduleTmp->getModuleActionIdByName('adminEdit');
			unset($moduleTmp);


			$buttonChgPass = new button(dnsPath.'/Cms/Files/Img/delete-16x16.png', 'Anuluj', $cancelAction, $this->userId);
			$html .= $buttonChgPass->show(1);
			$html .= '</td></tr>';
			$html .= '</table>';
		}

		$html .= '</td></tr>';
		$html .= '</table>';
		return $html;

	}

	private function adminPassEditDo($id, $oldPass, $newPass, $newPass2)
	{
		//jezeli stare haslo jest ok to zmieniam na nowe
		//jezeli nie to komunikat i przywracam ekran zmiany hasla
		$html = '';
		try
		{
			$queryTrans = "start transaction";
			$this->DBInt->ExecQuery($queryTrans);

			$query = "Select Pass, Login From cmsUsers Where id=".$id;
			$result = $this->DBInt->ExecQuery($query);
				
			$adminPass = '';
			while ($data = $result->fetchRow(DB_FETCHMODE_ASSOC))
			{
				$adminPass = $data["Pass"];
			}
			//--------zmiana hasla - lub odmowa
			if (md5($oldPass) == $adminPass)
			{
				$newPassMD5 = md5($newPass);

				$query = "Update cmsUsers set Pass='$newPassMD5' Where id=".$id;
				$result = $this->DBInt->ExecQuery($query);
				$queryTrans = 'commit';
				$this->DBInt->ExecQuery($queryTrans);

				$tmpModule = new ModulesMgr();
				$tmpModule->loadModule('AdminUsr');
				$backAction = $tmpModule->getModuleActionIdByName('showAdmins');
				unset($tmpModule);

				$dialog = new dialog('Zmiana hasła', 'Zmiana hasła wykonana', 'info', 390, 150);
				$dialog->setId($id);
				$dialog->setOkAction($backAction);
				$html .= $dialog->show(1);
				$this->adminLog->writeLog('adminPassEdit', $id, 'Udana zmiana hasła dla użytkownika'.$this->getUserLogin($id));
			}
			else
			{

				$queryTrans = 'rollback';
				$this->DBInt->ExecQuery($queryTrans);

				$tmpModule = new ModulesMgr();
				$tmpModule->loadModule('AdminUsr');
				$backAction = $tmpModule->getModuleActionIdByName('adminPassEdit');
				unset($tmpModule);
					
				$dialog = new dialog('Zmiana hasła', 'Hasło niezgodne z dotychczasowym!', 'alert', 390, 150);
				$dialog->setId($id);
				$dialog->setOkAction($backAction);
				$html .=$dialog->show(1);
				$this->adminLog->writeLog('adminPassEdit', $id, 'Nieudana zmiana hasła dla użytkownika'.$this->getUserLogin($id));
			}
			return $html;
		}
		catch (exception $e)
		{
			$queryTrans = 'rollback';
			$this->DBInt->ExecQuery($queryTrans);
				
			$tmpModule = new ModulesMgr();
			$tmpModule->loadModule('AdminUsr');
			$backAction = $tmpModule->getModuleActionIdByName('showAdmins');
			unset($tmpModule);
				
			$dialog = new dialog('Zmiana hasła', 'Zmiana hasła nie powiodła się!<br>Transakcja zostanie wycofana!', 'alert', 390, 150);
			$dialog->setId($id);
			$dialog->setOkAction($backAction);
			$html .= $dialog->show(1);
			$this->adminLog->writeLog('adminPassEdit', $id, 'Błąd podczas zmiany hasła dla użytkownika'.$this->getUserLogin($id));
			return $html;
		}

	}

	public function showPrivilegesUsers()
	{
		$html = '';

		$html .= '<table class="Grid" align="center" cellspacing=0>';
		$html .= '<tr>';
		$html .= '<td width=50><img src="./Cms/Files/Img/about-48x48.png" /></td>';
		$html .= '<td></td>';
		$html .= '</tr>';
		$html .= '<tr><td colspan=2>';
			
		$funcResult = '';
		$translatorObj = new translator(rootPath.'/Modules/AdminUsr/AdminUsr.Translation.xml');
		$translatorObj->setLanguage($_SESSION['lang']);

		$query = "
					SELECT 
						id, Name, LastName, Login, Active 
					FROM 
						cmsUsers
					WHERE 
						Root='T' 
					ORDER BY 
						LastName
				 ";

		$module = new modulesMgr();
		$module->loadModule('adminUsr');
		$editAction = $module->getModuleActionIdByName('showPrivilegesModules');
		$adminListActn = $module->getModuleActionIdByName('showAdmins');
		//$delAction = $module->getModuleActionIdByName('delLang');
		//to samo co edycja ale bez id - wiec dodawanie
		//$addAction = $module->getModuleActionIdByName('editLang');
			
		$grid = new gridRenderer();
		$grid->setTitle($translatorObj->translate('usrGridTitle'));
		$grid->setGridAlign('center');
		$grid->setGridWidth(780);
		$grid->addColumn("Name", $translatorObj->translate('usrGridColName'), 150, false, 'left');
		$grid->addColumn("LastName", $translatorObj->translate('usrGridColShortName'), 150, false, 'left');
		$grid->addColumn("Login", $translatorObj->translate('usrGridColLogin'), 75, false, 'center');
		$grid->addColumn('Active', $translatorObj->translate('usrGridColActive'), 55, false, 'center');

		$grid->addColumn('id', '', 200, true, 'right');

		//$grid->enabledDelAction($delAction);
		$grid->enabledChooseAction($editAction);
		$grid->setDataQuery($query);
		$html .= $grid->renderHtmlGrid(1);
		$html .= '</td></tr>';
		$html .= '<tr><td colspan="2" align="right">';

		unset($module);

		//$module = new modulesMgr();
		//$module->loadModule('info');
		//$editAction = $module->getModuleActionIdByName('showPrivilegesModules');
		$button = new button(dnsPath.'/Cms/Files/Img/delete-16x16.png', 'Anuluj zmianę uprawnień', $adminListActn, 0);
		$html .=$button->show(1);

		$html .= '</td><tr>';
		$html .= '</table>';

		return $html;
	}
	public function showPrivilegesModules()
	{
		$html = '';

		if ($_GET["id"] == 1)
		{
			$module = new ModulesMgr();
			$module->loadModule('AdminUsr');
			$okAction = $module->getModuleActionIdByName('ShowPrivilegesUsers');
			$dialog = new dialog('Zmiana uprawnień użytkoniwka', 'Zmiana uprawnień użytkownika głównego zabroniona!', 'alert', 300, 150);
			$dialog->setAlign('center');
			$dialog->setOkCaption('Ok');
			$dialog->setOkAction($okAction);
			$html .= $dialog->show(1);
		}
		else
		{

			$html .= '<table class="Grid" align="center" cellspacing=0>';
			$html .= '<tr>';
			$html .= '<td width=50><img src=dnsPath."/Cms/Files/Img/about-48x48.png" /></td>';
			$html .= '<td><br/></td>';
			$html .= '</tr>';
			$html .= '<tr><td align="right" colspan="2"><hr/>';

			$funcResult = '';
			$translatorObj = new translator(rootPath.'/Modules/AdminUsr/AdminUsr.Translation.xml');
			$translatorObj -> setLanguage($_SESSION['lang']);

			$query = "
					Select 
						id, ModuleName, ModuleShortName, ModulePath 
					From 
						cmsModules
					Order By 
						ModuleShortName
					";

			$module = new modulesMgr();
			$module->loadModule('adminUsr');
			$chooseAction = $module->getModuleActionIdByName('showPrivilegesActions');
			//$delAction = $module->getModuleActionIdByName('delLang');
			//to samo co edycja ale bez id - wiec dodawanie
			//$addAction = $module->getModuleActionIdByName('editLang');
				
			$queryUsr = 'Select login from cmsUsers where id='.$_GET["id"];

			$result = $this->DBInt->ExecQuery($queryUsr);

			while ($userData = $result->fetchRow(DB_FETCHMODE_ASSOC))
			{
				$user = $userData['login'];
			}
			$grid = new gridRenderer();
			$grid->setTitle('Wybór modułu do zmiany uprawnień dla użytkownika <B>'.$user.'</b>');
			$grid->setGridAlign('center');
			$grid->setGridWidth(780);
			$grid->addColumn("ModuleName", 'Opis modułu', 150, false, 'left');
			$grid->addColumn("ModuleShortName", 'Nazwa modułu', 150, false, 'left');
			$grid->addColumn("ModulePath", 'Ścieżka modułu', 75, false, 'center');
			$grid->addColumn("id", "", 200, true, 'right');
			//$grid->enabledDelAction($delAction);
			$grid->enabledChooseAction($chooseAction);
			$grid->addOtherArgs('userId', $_GET["id"]);
			$grid->setDataQuery($query);
			$html .=$grid->renderHtmlGrid(1);
			$html .= '</td></tr>';
			$html .= '<tr><td align="right" colspan="2">';
			$moduleBack = new modulesMgr();
			$moduleBack->loadModule('adminUsr');
			$backAction = $moduleBack->getModuleActionIdByName('showPrivilegesUsers');
			$button = new button(dnsPath.'/Cms/Files/Img/back-16x16.png', 'Wstecz', $backAction, 0);
			$html .=$button->show(1);
			$html .= '</td></tr>';
			$html .= '</table>';
		}
		return $html;
	}
	public function showPrivilegesActions()
	{
		$html = '';
		$html .= '<table width="400" align="center"><tr><td>';
		$html .= '<tr><td>';
		/*	echo 'Zmieniasz uprawnienia użytkownika: dla modułu:';
		 echo '</td></tr>';
		 echo '<tr><td>';*/
		//  gdy jest upranwienie to wysietlam 1, jak nie 0
		$moduleId = $_GET['id'];

		$userId = $_GET['userId'];

		$query = '
				SELECT 
					actions.id, actions.ActionName, actions.ActionShortName, 
					CASE WHEN priv.id IS NULL THEN 0 ELSE 1 END AS upr 
		    	FROM 
		     		cmsModulesActions actions 
		     	INNER JOIN 
		     		cmsModules modules ON modules.id = actions.FK_moduleid AND modules.id = ' . $_GET['id'].  
		     '	LEFT JOIN 
		     		cmsPrivileges priv ON actions.id = priv.ModulesActionFK AND priv.usersfk = ' . $_GET['userId'].
		     '  WHERE Admin="T"';

		//echo $query;
		$result = $this->DBInt->ExecQuery($query);
		$myForm = null;

		$moduleRes = new ModulesMgr();
		$moduleRes->loadModule('AdminUsr');
		$resAction = $moduleRes->getModuleActionIdByName('updatePrivileges');

		$myForm = new Form('Privileges', 'POST', "?a=$resAction&userId=$userId&moduleId=$moduleId");
		//$myForm = new Form('Privileges', 'GET');
		$privilegeForm = null;

		$moduleTmp = new ModulesMgr();
		$moduleTmp->loadModule('AdminUsr');
		$usrLogin = $moduleTmp->moduleExecuteAction('getUserLoginById', array($userId));
		$moduleName = $moduleTmp->getModuleNameById($moduleId);
		unset($moduleTmp);

		$privilegeForm = $myForm->getFormInstance();
		$privilegeForm->addElement('header', ' hdrTest', "Uprawnienia użytkownika $usrLogin dla modułu $moduleName");
		//$elementName = $privilegeForm->addElement('checkbox', 'txtName', null, 12);
		$i = 0;
		while ($data = $result->fetchRow(DB_FETCHMODE_ASSOC))
		{
			//echo "<form name=forma>";
			$actionId = $data["id"];
			$actionName = $data["ActionName"];
			$actionShortName = $data["ActionShortName"];
			if ($data["upr"] == 1)
			{
				$this->chkdElements[count($this->chkdElements)] = $actionId;
			}
			$this->allElements[$i] = $privilegeForm->addElement('checkbox', $actionId, null, $actionName.' - ('.$actionShortName.')');
			//tu robie formularz www (zwykly) i wyswietlam akcje zacheckowane. Przekauzje Postem (wszystko co z formularzxa) - akcja ma sie rozumiec idzie getem
			//echo $actionName.' '.$actionShortName.'<input type=chceckbox name='.$actionShortName
			$i++;
				
		}

		$privilegeForm->addElement('reset', 'btnReset', 'Wyczyść');
		$privilegeForm->addElement('submit', '', 'Zapisz');
		$myForm->setStyle(2);

		if ($privilegeForm->validate())
		{
			$privilegeForm->freeze();
			//echo 'validate';
			$chkdActionsIdForSave = array();
				
				
			for ($i=0;$i<count($this->allElements);$i++)
			{
				if ($this->allElements[$i]->getChecked())
				{
					//zapisuje do tablicy id pobierane z nazwy elemetu formularza
					$chkdActionsIdForSave[count($chkdActionsIdForSave)] = $this->allElements[$i]->getName();
						
				}
			}
			//$this->updatePrivileges($userId, $moduleId, $chkdActionsIdForSave);
		}
		else
		{
				
				
			if (count($this->chkdElements)>0)
			{
				for ($i=0;$i<count($this->chkdElements);$i++)
				{
					for ($j=0;$j<count($this->allElements);$j++)
					{
						if ($this->allElements[$j]->getName() == $this->chkdElements[$i])
							$this->allElements[$j]->setChecked(1);
					}
						
				}
			}

			$html .=$privilegeForm->toHtml();
		}

		$html .= '</td></tr>';
		$html .= '</table>';

		return $html;
	}

	public function updatePrivileges()
	{
		$html = '';
		$actionsIdArray = array();
		$keys = array_keys($_POST);
		$actionsIdArray = $keys;

		/*foreach ($keys as $key) {
			echo "\$_POST['$key'] == $_POST[$key]<BR>";}*/

		$userId = $_GET['userId'];
		$moduleId = $_GET['moduleId'];
		$tmpmodule = new ModulesMgr();
		$moduleName = $tmpmodule->getModuleNameById($moduleId);
		unset($tmpmodule);

		try
		{
			$this->DBInt->ExecQuery('start transaction');
			$deleteQuery =
						'DELETE FROM 
							cmsPrivileges 
						 WHERE 
							UsersFk=' . $userId. ' AND 
							ModulesActionFk in 
								(SELECT id FROM cmsModulesActions WHERE FK_ModuleID ='.$moduleId.')';

			$this->DBInt->ExecQuery($deleteQuery);
			for($i=0; $i<count($actionsIdArray); $i++)
			{
				$updateQuery = "insert into cmsPrivileges(`ModulesActionFk`, `UsersFk`) values ($actionsIdArray[$i], $userId)";
				$this->DBInt->ExecQuery($updateQuery);
			}
			$this->DBInt->ExecQuery('Commit');
				
			$moduleOk = new ModulesMgr();
			$moduleOk->loadModule('AdminUsr');
			$okAction = $moduleOk->getModuleActionIdByName('showPrivilegesModules');
			$dialog = new dialog('Zapis danych konfiguracyjnych strony', 'Dane strony zapisane prawidłowo', 'Info', 300, 150);
			$dialog->setAlign('center');
			$dialog->setOkCaption('Ok');
			$dialog->setOkAction($okAction);
			$dialog->setId($userId);
			$html .= $dialog->show(1);
			$this->adminLog->writeLog('updatePrivileges', 'none', 'Udana zmiana uprawnień dla użytkownika: '.$this->getUserLogin($userId).' w module: '.$moduleName) ;
			return $html;
		}
		catch(Exception $e)
		{
			$this->DBInt->ExecQuery('Rollback');
			$exc = new ExceptionClass($e, 'updatePrivileges');
			return $exc->writeException();
		}

	}

	public function chkPrivileges($args = array())
	{
		return true;
	}

	public function adminDelete($id)
	{
		$html = '';
		if ($_GET["id"] == 1)
		{
			$module = new ModulesMgr();
			$module->loadModule('AdminUsr');
			$okAction = $module->getModuleActionIdByName('ShowAdmins');
			$dialog = new dialog('Usuwanie użytkoniwka', 'Usunięcie użytkownika głównego zabronione!', 'alert', 300, 150);
			$dialog->setAlign('center');
			$dialog->setOkCaption('Ok');
			$dialog->setOkAction($okAction);
			$html .= $dialog->show(1);
		}
		else
		{
			$userLogin = $this->getUserLogin($id);
			$query = 'DELETE FROM cmsUsers WHERE id='.$id;
				
			$tmpModule = new ModulesMgr();
			$tmpModule->loadModule('AdminUsr');
			$action = $tmpModule->getModuleActionIdByName('ShowAdmins');

			$this->DBInt->ExecQuery($query);

			$dialog = new dialog('Usuwanie użytkownika', 'Dane użytkownika usunięte', 'alert', 300, 100);
			$dialog->setAlign('center');
			$dialog->setOkAction($action);
			$dialog->setOkCaption('Ok');
			$html .=$dialog->show(1);
			$this->adminLog->writeLog('adminDelete', '(userId)id='.$id, 'Usuniecie użytkownika '.$userLogin) ;
		}
		return $html;
	}

	public function getLogin()
	{
		$query = "SELECT Login FROM cmsUsers where id=".$_SESSION['adminId'];
		$result = $this->DBInt->ExecQuery($query);
		$data = $result->fetchRow(DB_FETCHMODE_ASSOC);
		return $data['Login'];
	}
	public function getName()
	{
		$query = "SELECT Name FROM cmsUsers where id=".$_SESSION['adminId'];
		$result = $this->DBInt->ExecQuery($query);
		$data = $result->fetchRow(DB_FETCHMODE_ASSOC);
		return $data['Name'];

	}
	public function getLastName()
	{
		$query = "SELECT LastName FROM cmsUsers where id=".$_SESSION['adminId'];
		$result = $this->DBInt->ExecQuery($query);
		$data = $result->fetchRow(DB_FETCHMODE_ASSOC);
		return $data['LastName'];
	}
	public function getSessionBeginTime()
	{
		$query = "SELECT LastLogin FROM cmsUsers where id=".$_SESSION['adminId'];
		$result = $this->DBInt->ExecQuery($query);
		$data = $result->fetchRow(DB_FETCHMODE_ASSOC);
		return $data['LastLogin'];
	}
	public function getUserLoginById($id)
	{
		$query = "SELECT Login FROM cmsUsers where id=".$id;
		$result = $this->DBInt->ExecQuery($query);
		$data = $result->fetchRow(DB_FETCHMODE_ASSOC);
		return $data['Login'];

	}
}
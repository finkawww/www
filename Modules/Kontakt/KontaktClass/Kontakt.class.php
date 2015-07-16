<?php
class KontaktClass
{
	private $dbInt = null;
	
	private $submit; 
	private $brakuje_danych;
	private $dane_nazwa; 
	private $dane_telefon; 
	private $dane_email; 
	private $dane_pytanie;
	private $dzial;
	private $rozl;
	private $rodz;
	private $sp;
	private $zak;
	private $expimp;
	private $dew;
	private $prac;
	private $zlec;
	private $wsp;
	
	private function GetServer()
	{
		$sql = "
				SELECT 
					`SMTPServer`
				FROM 
					`Kontakt`
				";
			
		$data = $this->dbInt->ExecQuery($sql);
			
		$record = $data->fetchRow(DB_FETCHMODE_ASSOC);
		return $record['SMTPServer'];
	}
	private function GetPort()
	{
		$sql = "
			SELECT 
				`PORT`		
			FROM 
				`Kontakt`
			";
			
		$data = $this->dbInt->ExecQuery($sql);
			
		$record = $data->fetchRow(DB_FETCHMODE_ASSOC);
		return $record['PORT'];		
	}
	private function GetLogin()
	{
		$sql = "
			SELECT 
				`Login`		
			FROM 
				`Kontakt`
			";
			
		$data = $this->dbInt->ExecQuery($sql);
			
		$record = $data->fetchRow(DB_FETCHMODE_ASSOC);
		return $record['Login'];
	}
	private function GetPass()
	{
		$sql = "
			SELECT 
				`Pass`		
			FROM 
				`Kontakt`
			";
			
		$data = $this->dbInt->ExecQuery($sql);
			
		$record = $data->fetchRow(DB_FETCHMODE_ASSOC);
		return $record['Pass'];
	}
	private function GetOd()
	{
		$sql = "
			SELECT 
				`Od`		
			FROM 
				`Kontakt`
			";
			
		$data = $this->dbInt->ExecQuery($sql);
			
		$record = $data->fetchRow(DB_FETCHMODE_ASSOC);
		return $record['Od'];
	}
	private function GetDo()
	{
		$sql = "
			SELECT 
				`Do`		
			FROM 
				`Kontakt`
			";
			
		$data = $this->dbInt->ExecQuery($sql);
			
		$record = $data->fetchRow(DB_FETCHMODE_ASSOC);
		return $record['Do'];
		
	}
	private function GetTitle()
	{
		$sql = "
			SELECT 
				`Tytul`		
			FROM 
				`Kontakt`
			";
			
		$data = $this->dbInt->ExecQuery($sql);
			
		$record = $data->fetchRow(DB_FETCHMODE_ASSOC);
		return $record['Tytul'];
		
	}
	private function CheckCookies()
	{
		$test = '';
		if (isset($_COOKIE['test']))
		  $test = $_COOKIE['test'];
		
		if ($test == '')
		{ 
			return false;
		}
		else if ($test == 'ok')
		{
			return true;
		}
	}
	private function SaveKontaktDB($server, $port, $login, $pass, $od, $do, $title)
	{
		$dmlKontakt = "
			UPDATE 
				`Kontakt` 
			SET
				`SMTPServer` = '$server',
				`PORT` = $port,
				`Login` = '$login',
				`Pass` = '$pass',
				`Do` = '$do',
				`Od` = '$od',
				`Tytul` = '$title' 
				";
		$this->dbInt->ExecQuery($dmlKontakt);
				
		
	}
	private function GetKontaktTemplate()
	{
		try
		{
			$content = '';
			$file = './smartydirs/templates/kontakt.tpl';
			$plik = fopen ($file, 'r');
			if (filesize($file)>0)
			{
				$content = fread($plik, filesize($file));
				fclose($plik);
			}
			return $content;
		}
		catch (exception $e)
		{
			fclose($plik);
		}
	}
	 
	private function SaveKontaktTemplate($content)
	{
		try
		{
			$nazwaPliku = './smartydirs/templates/kontakt.tpl';
			
			$plik = fopen ($nazwaPliku, 'w+');
			
			if (fwrite($plik, $content) === FALSE)
   			{
       			throw new exception("Nie mogę zapisać do pliku ($nazwaPliku)");
       			exit;
    		}
    		fclose($plik);
    		return true;
		}
		catch (exception $e)
		{
			fclose($plik);
			return false;
		} 
	}

	private function SendForm($nazwa, $tel, $email, $formaDzialalnosci, $formaRozliczen, $rodzajDzialalnosci, 
			$lDokS, $lDokZ, $expImp, $dokDew, $lPracEtat, $zlec, $rodzWspolpracy, $uwagi)
	{
		//pobieram dane szablonu i wysylam do uzytkownika
		
		$msg = '';
		
		$smarty = new mySmarty();

 		if ($smarty->template_exists('kontakt.tpl'))
		{
			$smarty -> assign('nazwa', htmlspecialchars($nazwa));
			$smarty -> assign('tel', htmlspecialchars($tel));
			$smarty -> assign('email', htmlspecialchars($email));
			$smarty -> assign('formaDzialanosci', $formaDzialalnosci);
			$smarty -> assign('formaRozliczen', $formaRozliczen);
			$smarty -> assign('rodzajDzialalnosci', $rodzajDzialalnosci);
			$smarty -> assign('ldoks', $lDokS);
			$smarty -> assign('ldokz', $lDokZ);
			$smarty -> assign('expimp', $expImp);
			$smarty -> assign('dokdew', $dokDew);
			$smarty -> assign('lpracetat', $lPracEtat);
			$smarty -> assign('zlec', $zlec);
			$smarty -> assign('rodzwspolpracy', $rodzWspolpracy);
			$smarty -> assign('uwagi', $uwagi);
			//wyswietlam
			$msg = $smarty->fetch('kontakt.tpl');
		}
		else
		{
			throw new exception("Brak zdefiniowanego szablonu o nazwie $this->templateName");
		}
		
		
		$mail = new PHPMailer(false); // the true param means it will throw exceptions on errors, which we need to catch
		$mail->IsSMTP(); // telling the class to use SMTP
		try 
		{
			
			$mail->Host       = $this->GetServer(); // SMTP server
		  	//$mail->SMTPDebug= 2;                     // enables SMTP debug information (for testing)
		  	$mail->SMTPAuth   = true;                  // enable SMTP authentication
		  	$mail->Port       = $this->GetPort();                    // set the SMTP port for the GMAIL server
		  	$mail->Username   = $this->GetLogin(); // SMTP account username
		  	$mail->Password   = $this->GetPass();        // SMTP account password
		  	$mail->AddAddress($this->GetDo(), 'TIK-SOFT Biuro');
		  	$mail->SetFrom($this->GetOd(), 'Formularz biuro on-line');
		  	$mail->Subject = $this->GetTitle();
		  	$mail->AltBody = 'Mail w formacie HTML. Należy użyć odpowiedniego klienta poczty!'; // optional - MsgHTML will create an alternate automatically
			$mail->MsgHTML($msg);
					
		  	$mail->Send();
		  	$html = '';
		  	$html = '<center><div class="font_cm">Dziękujemy za wypełnienie formularza. Nasi konsultanci skontaktują się z Państwem. <br/><br/></div>';
		  	$html .= '<a class="" href="http://tiksoft.h2.pl/FrontPage/index.php?mp=12">powrót</a></center>';
		  	 
		  	return $html;  
		  	
		  	
		} 

		catch (phpmailerException $e) 
		{
		 	return 'Dane nie wyslane: '.$e->errorMessage(); //Pretty error messages from PHPMailer
		} 
		catch (Exception $e) 
		{
	 		return 'Dane nie wysłane: '.$e->getMessage(); //Boring error messages from anything else!
		}
		unset($mail);
	}
	
	public function __construct()
	{
		$this->dbInt = DBSingleton::getInstance();
	}
	
	public function Display()
	{
	$ret = '';
		$ret .= '<center><br><div class="font"> <b>Dane adresowe:</b>  </div><div class="font"> al. Wilanowska 5 lok 19</div>
				 <div class="font">02-765 Warszawa </div>
				 <div class="font">tel./fax: (22) 408-48-00, (22) 885-66-99</div>
				 <div class="font"><a href="mailto:zapytanie@tiksoft.pl">zapytanie@tiksoft.pl</a></div><br></center>';
	
	if (!$this->CheckCookies())
	{
		$ret .= '<table width="600"  height="400"  align="center" cellpadding="0" cellspacing="0" border="0"><tr><td valign="top" align="center">';
		
		$ret .= '<font color="red">UWAGA!!! Aby wyświeltić formularz kontaktowy należy włączyć obsługę cookies w przeglądarce!</font>';
		$ret .= '</tr></tr></table>';	
	}
	else
	{
	//
	$ret = '';
		$ret .= '<center><br><div class="font"> <b>Dane adresowe:</b>  </div><div class="font"> al. Wilanowska 5 lok 19</div>
				 <div class="font">02-765 Warszawa </div>
				 <div class="font">tel./fax: (22) 408-48-00, (22) 885-66-99</div>
				 <div class="font"><a href="mailto:biuro@tiksoft.pl">biuro@tiksoft.pl</a><br><br>
				 <div class="font"><b>Kontakt w sprawie ofert: </b><br>p.Ewa Hobora tel. 668-300-749, 022-408-48-00 wew.209.</div>
				 <div class="font"><a href="mailto:biuro@tiksoft.pl">ehobora@tiksoft.pl</a></div><br></center>';
		$ret .= '<table width="600"  height="600"  align="center" cellpadding=0 cellspacing=0 border=0><tr><td valign="top">
		<hr/><br></td></tr><tr><td valign="top">';
		/*if ($this->CheckCookies())
		{
			echo 'OK';
		}
		else
		{
			echo 'BRAK COOKIES';
		}*/
		$myForm = null;
		$myForm = new Form('dFORM', 'POST');
		$kontaktForm = $myForm->getFormInstance();
		$kontaktForm->addElement('header', ' hdrTest', 'Dane kontaktowe');
		
		$elementNazwa = $kontaktForm->addElement('text', 'txtNazwa', 'Nazwa firmy/ Imię i Nazwisko', array('size' => 20, 'maxlength'=> 100));
		$kontaktForm->addRule('txtNazwa', 'Podaj nazwę', 'required', null, 'server');
		$kontaktForm->addRule('txtNazwa', 'Użyto niedozowlonych znaków', 'nopunctuation', null, 'server');
		
		
		$elementTel = $kontaktForm->addElement('text', 'txtTel', 'Telefon, Faks', array('size' => 20, 'maxlength'=> 80));
		$kontaktForm->addRule('txtTel', 'Podaj numer telefonu', 'required', null, 'server');		
		$kontaktForm->addRule('txtTel', 'Użyto niedozowlonych znaków', 'nopunctuation', null, 'server');
		
		$elementEmail = $kontaktForm->addElement('text', 'txtEmail', 'E-Mail', array('size' => 20, 'maxlength'=> 80));
		$kontaktForm->addRule('txtEmail', 'Podaj adres e-mail', 'required', null, 'server');
		$kontaktForm->addRule('txtEmail', 'Podaj poprawny adres e-mail', 'email');
						
		$kontaktForm->addElement('header', ' hdrTest2', 'Profil firmy');
		
		$formaList['']= '--Wybierz z listy--';
		$formaList['Osoba fizyczna'] = 'Osoba fizyczna';
		$formaList['Spolka cywilna'] = 'Spólka cywilna';
		$formaList['Spolka z o.o.'] = 'Spólka z o.o.';
		$formaList['Spolka komandytowa'] = 'Spólka komandytowa';
		$formaList['Spolka akcyjna'] = 'Spólka akcyjna';
		$formaList['Spolka jawna'] = 'Spólka jawna';
		$formaList['Fundacja/Stowarzyszenie'] = 'Fundacja/Stowarzyszenie';
		$formaList['Kolo lowieckie'] = 'Koło łowieckie';
		$formaList['Inna'] = 'Inna';				
		$elementFormaDzial = $kontaktForm->addElement('select', 'cbFormaDzial', 'Forma działalności', $formaList);
		
		$rozliczList['']= ' --Wybierz z listy--';
		$rozliczList['Ksiegi handlowe']= 'Księgi handlowe';
		$rozliczList['Ksiazka przychodow i rozchodow']= 'Książka przychodów i rozchodów';
		$rozliczList['Ryczalt']= 'Ryczałt';
		$elementRozlicz = $kontaktForm->addElement('select', 'cbRozlicz', 'Forma rozliczeń', $rozliczList);

		$rodzDzialalnList[''] = ' --Wybierz z listy--';
		$rodzDzialalnList['Handlowa'] = 'Handlowa';
		$rodzDzialalnList['Uslugowa'] = 'Usługowa';
		$rodzDzialalnList['Produkcyjna'] = 'Produkcyjna';
		$rodzDzialalnList['Inna'] = 'Inna';
		$elementRodzDzial = $kontaktForm->addElement('select', 'cbRodzDzialaln', 'Rodzaj działalności', $rodzDzialalnList);
		
		$liczbaDokSList['']= ' --Wybierz z listy--';
		$liczbaDokSList['do 10']= 'do 10';
		$liczbaDokSList['do 50']= 'do 50';
		$liczbaDokSList['do 100']= 'do 100';
		$liczbaDokSList['do 200']= 'do 200';
		$liczbaDokSList['powyzej 200']= 'powyżej 200';								
		$elementLiczbaDokS = $kontaktForm->addElement('select', 'cbLiczbaDokS', 'Liczba dokumentów sprzedaży', $liczbaDokSList);

		$liczbaDokZList['']= ' --Wybierz z listy--';
		$liczbaDokZList['do 10']= 'do 10';
		$liczbaDokZList['do 50']= 'do 50';
		$liczbaDokZList['do 100']= 'do 100';
		$liczbaDokZList['do 200']= 'do 200';
		$liczbaDokZList['powyzej 200']= 'powyżej 200';								
		$elementLiczbaDokZ = $kontaktForm->addElement('select', 'cbLiczbaDokZ', 'Liczba dokumentów zakupu', $liczbaDokZList);
		
		$czyExpImpList[''] = '--Wybierz z listy--';
		$czyExpImpList['Tak'] = 'Tak';
		$czyExpImpList['Nie'] = 'Nie';			
		$elementExpImp = $kontaktForm->addElement('select', 'cbExpImp', 'Czy występuje eksport/import?', $czyExpImpList);
		
		$czyDokDewList[''] = '--Wybierz z listy--';
		$czyDokDewList['Tak'] = 'Tak';
		$czyDokDewList['Nie'] = 'Nie';
		$elementDokDew = $kontaktForm->addElement('select', 'cbDokDew', 'Czy występują dokumenty dewizowe?', $czyDokDewList);
		
		$pracEtatList[''] = '--Wybierz z listy--';
		$pracEtatList['do 5'] = 'do 5';
		$pracEtatList['do 10'] = 'do 10';
		$pracEtatList['do 20'] = 'do 20';
		$pracEtatList['do 50'] = 'do 50';
		$pracEtatList['powyzej 50'] = 'powyżej 50';				
		$elementLiczbaPracEtat = $kontaktForm->addElement('select', 'cbliczbaPracEtat', 'Liczba pracowników etatowych', $pracEtatList);
		
		$pracZlecList[''] = '--Wybierz z listy--';
		$pracZlecList['do 5'] = 'do 5';
		$pracZlecList['do 10'] = 'do 10';
		$pracZlecList['do 20'] = 'do 20';
		$pracZlecList['do 50'] = 'do 50';
		$pracZlecList['powyzej 50'] = 'powyżej 50';				
		$elementLiczbaPracZlec = $kontaktForm->addElement('select', 'cbliczbaPracZlec', 'Liczba pracowników na zlecenie', $pracZlecList);
		
		$rodzWspolpracyList['']= '--Wybierz z listy--';
		$rodzWspolpracyList['Stala (biezaca) obsluga']= 'Stała (bieżąca) obsługa';
		$rodzWspolpracyList['Wyprowadzanie zaleglosci']= 'Wyprowadzanie zaległości';
		$rodzWspolpracyList['Inna']= 'Inna';
		$elementRodzWspolpracy = $kontaktForm->addElement('select', 'cbRodzajWspolpracy', 'Rodzaj współpracy', $rodzWspolpracyList);
		
		$elementUwagi = $kontaktForm->addElement('textarea', 'Uwagi', 'Uwagi', array('cols'=>30, 'rows'=>3));
		$kontaktForm->addRule('Uwagi', 'Użyto niedozowlonych znaków', 'nopunctuation', null, 'server');
				
		$kontaktForm->addElement('header', ' hdrTest3', '&nbsp;');				
		
		$kontaktForm->addElement('submit', 'btnSubmit', 'Wyślij', array('style'=>'width: 100px;'));
		$kontaktForm->addElement('reset', 'btnReset', 'Wyczyść', array('style'=>'width: 100px;'));
						
		$kontaktForm->applyFilter('__ALL__', 'trim');
		
		$myForm->setStyle(2);
		
		if ($kontaktForm->validate())
		{
			$activeArray = array();
			//$_SESSION['m'] = -1;
			$kontaktForm->freeze();
			
			$nazwa = $elementNazwa->GetValue();
			$tel = $elementTel->GetValue();
			$email = $elementEmail->GetValue();
			$formaDzialalnosci = $elementFormaDzial->GetValue();
			$formaRozliczen = $elementRozlicz->GetValue();
			$rodzajDzialalnosci = $elementRodzDzial->GetValue();
			$lDokS = $elementLiczbaDokS->GetValue();
			$lDokZ = $elementLiczbaDokZ->GetValue();
			$expImp = $elementExpImp->GetValue();
			$dokDew = $elementDokDew->GetValue();
			$lPracEtat = $elementLiczbaPracEtat->GetValue();
			$Zlec = $elementLiczbaPracZlec->GetValue();
			$rodzWspolpracy = $elementRodzWspolpracy->GetValue();
			$uwagi = $elementUwagi->GetValue();
						
			$ret .= $this->sendForm($nazwa, $tel, $email, $formaDzialalnosci[0], $formaRozliczen[0], $rodzajDzialalnosci[0], 
			$lDokS[0], $lDokZ[0], $expImp[0], $dokDew[0], $lPracEtat[0], $Zlec[0], $rodzWspolpracy[0], $uwagi);
		//	$pageTitle = $titleElement -> getValue();
		//	$this->DBInt->ExecQuery("Update cmsConfig Set Title = '$pageTitle'");
		}	
		else
		{
						
			$ret .= $kontaktForm->toHtml();
		}
				
		$ret .= '</td></tr></table>';
	}//of checkCookies
		return $ret;

	}	
	
	public function Config()
	{
		$html = '';
		$html .= '<table width="600"  height="500" align="center" cellpadding=0 cellspacing=0 border=0><tr><td>';
		$myForm = null;
		$myForm = new Form('dFORM', 'POST');
		$kontaktForm = $myForm->getFormInstance();
		$kontaktForm->addElement('header', ' hdr', 'Konfiguracja SMTP');
		$elementServer = $kontaktForm->addElement('text', 'txtServer', 'SMTP Server', array('size' => 60, 'maxlength'=> 100));
		$elementPort = $kontaktForm->addElement('text', 'txtPort', 'Port', array('size' => 60, 'maxlength'=> 100));
		$elementLogin = $kontaktForm->addElement('text', 'txtLogin', 'Login SMTP', array('size' => 60, 'maxlength'=> 100));
		$elementPass = $kontaktForm->addElement('text', 'txtPass', 'Hasło SMTP', array('size' => 60, 'maxlength'=> 100));
		$elementOd = $kontaktForm->addElement('text', 'txtOd', 'Adres nadawcy', array('size' => 60, 'maxlength'=> 100));
		$elementDo = $kontaktForm->addElement('text', 'txtDo', 'Adres docelowy', array('size' => 60, 'maxlength'=> 100));
		$kontaktForm->addElement('header', ' hdr1', 'Konfiguracja wiadomości');
		$elementTitle = $kontaktForm->addElement('text', 'txtTytul', 'Tytuł', array('size' => 60, 'maxlength'=> 100));
		$elementMailContent = $kontaktForm->addElement('textarea', 'MailTemplate', 'Szablon wiadomości', array('cols'=>50, 'rows'=>15));
		$kontaktForm->addElement('submit', 'btnSubmit', 'Wyślij');
		$kontaktForm->addElement('reset', 'btnReset', 'Wyczyść');
		
				
		$kontaktForm->applyFilter('__ALL__', 'trim');
				
		$myForm->setStyle(2);
		
		if ($kontaktForm->validate())
		{
			$kontaktForm->freeze();
			
			$server = $elementServer->GetValue();
			$port = $elementPort->GetValue();
			$login = $elementLogin->GetValue();
			$pass = $elementPass->GetValue();
			$od = $elementOd->GetValue();
			$do = $elementDo->GetValue();
			$title = $elementTitle->GetValue();
			$mailTemplate = $elementMailContent->GetValue();
			$this->SaveKontaktDB($server, $port, $login, $pass, $od, $do, $title);
			$this->SaveKontaktTemplate($mailTemplate);
			
			$okAction = 0;
			$dialog = new dialog('Zapis danych' , 'Dane zapisane', 'info', 300, 150);
			$dialog->setAlign('center');
			$dialog->setOkCaption('Ok');
			$dialog->setOkAction($okAction);
			$html .= $dialog->show(1);		
		
		}	
		else
		{
			$sql = "
				SELECT 
					`SMTPServer`,
					`PORT`,
					`Login`,
					`Pass`,
					`Do`,
					`Od`,
					`Tytul`
				FROM 
					`Kontakt`
				";
			
			$data = $this->dbInt->ExecQuery($sql);
			
			$record = $data->fetchRow(DB_FETCHMODE_ASSOC);
			$elementServer->setValue($record['SMTPServer']);
			$elementPort->setValue($record['PORT']);
			$elementLogin->setValue($record['Login']);
			$elementPass->setValue($record['Pass']);
			$elementDo->setValue($record['Do']);
			$elementOd->setValue($record['Od']);
			$elementTitle->setValue($record['Tytul']);
			
			$elementMailContent->SetValue($this->GetKontaktTemplate());
			
			$html .= $kontaktForm->toHtml();
		}
				
		$html .= '</td></tr></table>';
		
		return $html;
	}
}
?>
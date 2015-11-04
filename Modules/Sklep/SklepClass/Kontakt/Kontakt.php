<?php
final class ZamowieniaItems
{
	public $nazwaTowaru;
	public $ilosc_stan;
	public $ilosc_firm;
	public $cena_poz;
}

class KontaktKlient
{
	protected $klient = null;

	private $host;
	private $port;
	private $username;
	private $password;
	private $nadawca;
	private $subject;
	private $bodyTemplate;
	private $alterBodyTemplate;
	private $bodyTemplateContent;
	private $alterBodyTemplateContent;
	private $bodyContent;
	private $alterBodyContent;

	private $query;
	private $typ;

	protected $zamowienie = null;
	private $formTitle;
	private $translator;
	private $dbInt;
	private $mail;
	//stosuje szablonsmarty''

	private function Translate($field)
	{
		return $this->translator->translate($field);
	}
	private function TranslateCaptionsSkladanieZam($smarty)
	{

		$txtDaneZamowienia = $this->Translate('txtDaneZamowienia');
		$txtNumerZam = $this->Translate('txtNumerZam');
		$txtPozycjeZam = $this->Translate('txtPozycjeZam');
		$txtFormaDostawy = $this->Translate('txtFormaDostawy');
		$txtCenaDostawy = $this->Translate('txtCenaDostawy');
		$txtRazem = $this->Translate('txtRazem');
		$txtFormaPlatnosci = $this->Translate('txtFormaPlatnosci');

		$txtDaneDostawy = $this->Translate('txtDaneDostawy');
		$txtDaneDoFaktury = $this->Translate('txtDaneDoFaktury');

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
		$txtIloscStan = $this->Translate('txtIloscStan');
		$txtIloscFirm = $this->Translate('txtIloscFirm');
		$txtZdjecieTow = $this->Translate('txtZdjecieTow');

		$txtRazem = $this->Translate('txtRazem');
		$txtFormaDostawy = $this->Translate('txtFormaDostawy');
		$txtCena = $this->Translate('txtCena');
		$txtWartoscZam = $this->Translate('txtWartoscZam');

		$txtZatwierdz = $this->Translate('txtZatwierdz');
		$txtAnuluj = $this->Translate('txtAnuluj');
		$txtPopraw = $this->Translate('txtPopraw');
		$txtUwagi = $this->Translate('txtUwagi');

		$smarty->assign('txtNazwaTow', $txtNazwaTow);
		$smarty->assign('txtCenaTow', $txtCenaTow);
		$smarty->assign('txtIloscStan', $txtIloscStan);
		$smarty->assign('txtIloscFirm', $txtIloscFirm);
		$smarty->assign('txtNumerZam', $txtNumerZam);
		$smarty->assign('txtPozycjeZam', $txtPozycjeZam);
		$smarty->assign('txtDaneDostawy', $txtDaneDostawy);
		$smarty->assign('txtDaneDoFaktury', $txtDaneDoFaktury);

		$smarty->assign('txtRazem', $txtRazem);
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

	}

	private function PrepareHtmlMessage()
	{

		$smarty = new mySmarty();
		//echo $this->bodyTemplate;
		if ($smarty->template_exists('modules/'.$this->bodyTemplate))
		{
			/*
			 * $imie, $nazwisko, $idKraj, $miasto, $ulica, $nrDomu, $nrMieszkania,
			 $email, $kodPocztowy, $nrTel, $nrTel2, $czyFirma, $nazwaFirmy, $nip
			 */


			if ($this->typ == 'wysylanieRabatu')
			{
				$tresc = 'Szanowny Kliencie,<br/>
						Przesyłamy link do ofert z uwzględnionym rabatem. Należy wybrać link lub skopiować go w okno przeglądarki<br/>';
				$idZam = $this->zamowienie->GetId();
				$statusRab = $this->zamowienie->GetStatusRabatuInt();
				$this->klient = $this->zamowienie->klient;
				$idKli = $this->klient->GetId();
				
				$moduleTmp = new ModulesMgr();
				$moduleTmp->loadModule('Sklep');
				$actnPokazZamPoRabacie = $moduleTmp->getModuleActionIdByName('PokazZamPoRabacie');
				$tx = 'https://finka.pl?a='.$actnPokazZamPoRabacie.'&link='.MD5($idZam.$statusRab.$idKli);
				$link = '<a href="'.$tx.'">'.$tx.'</a>';  	
				$smarty->assign('tresc', $tresc);
				$smarty->assign('link', $link);
			}
			if ($this->typ == 'rejestracja')
			{
				$login = $this->klient->GetLogin();
				$tmpPass = $this->klient->GetTmpPass();
				$tresc = 'Witamy w sklepie galeriatinta.pl.<br/>
						Rejestracja przyśpiesza proces zakupów oraz umożliwia śledzenie stanu realizacji zamówienia.
						<br/>Dane logowania:<br/>';
						
				$smarty->assign('tresc', $tresc);
				$smarty->assign('login', $login);
				$smarty->assign('pass', $tmpPass);
			}
			if ($this->typ == 'resetHasla')
			{
				$noweHaslo = $this->klient->GetTmpPass();
				$smarty->assign('tmpPass', $noweHaslo);
			}
			//zamowienie
			if ($this->typ == 'zlozenieZamowienia')
			{
				if (isset($_SESSION['Zamowienie']))
				{
					$zamowienie = $_SESSION['Zamowienie'];
					$numer = $zamowienie->GetNumer();
					$uwagi = $zamowienie->GetUwagi();


					$idDostawy = $zamowienie->GetDostawa();

					$idPlatnosci = $zamowienie->GetPlatnosc();
					$towaryArr = $zamowienie->GetTowar();

					$platnosc = new Platnosc();
					$platnosc->Load($idPlatnosci, $_SESSION['lang']);

					$platnoscNazwa = $platnosc->GetNazwa();

					$dostawa = new Dostawa();
					$dostawa->Load($idDostawy, $_SESSION['lang']);

					$dostawaNazwa = $dostawa->GetNazwa();
					$dostawaCena = $dostawa->GetCena();
					$towaryArr = $_SESSION['Zamowienie']->GetTowar();
					//print_r($towaryArr);
                                        $rabat = new Rabat();
                                        $rabat->Load();
					$pozycjeZam = array();
					$wartoscZam = 0.0;
					foreach($towaryArr as $tow)
					{
						$towarTmp = new Towar();
						$towarTmp->Load($tow->towarId, $_SESSION['lang']);

						$zamItem = new ZamowieniaItems();
						$zamItem->nazwaTowaru = $towarTmp->GetNazwa();
						$zamItem->ilosc_stan = $tow->iloscStanowisk;
						$zamItem->ilosc_firm = $tow->iloscFirm;
						$konfiguracja = new Konfiguracja();
                                                if (!$rabat->GetRabatEnabled())
                                                {
                                                    $zamItem->cena_poz = $towarTmp->GetCena($tow->iloscStanowisk, $tow->iloscFirm)*(1+$konfiguracja->GetStawkaVat()/100);
                                                }
                                                else
                                                {
                                                    $zamItem->cena_poz = $towarTmp->GetCenaParams($tow->iloscStanowisk, $tow->iloscFirm)*(1+$konfiguracja->GetStawkaVat()/100);
                                                }

						$pozycjeZam[]=$zamItem;

						//$wartoscZam += $towarTmp->GetCena($tow->iloscSanowisk, $tow->iloscFirm)*(1+$konfiguracja->GetStawkaVat()/100);
					}
					$wartoscZam = $zamowienie->GetWartosc();
					$wartoscZam += $dostawaCena;

					$klientTmp = $_SESSION['Zamowienie']->klient;


					//zawartosc maila: calosc zamowienia - pozycje, ilosci, ceny, wartosc zamowienia


					$klientTmp = $_SESSION['Zamowienie']->klient;
					$imie = $klientTmp->GetImie();
					$nazwisko = $klientTmp->GetNazwisko();
					$kraj = $klientTmp->GetKraj();
					$miasto = $klientTmp->GetMiasto();
					$ulica = $klientTmp->GetUlica();
					$nrDomu = $klientTmp->GetNrDomu();
					$nrMieszkania = $klientTmp->GetNrMieszkania();
					$kodPocztowy = $klientTmp->GetKodPocztowy();
					$nrTel = $klientTmp->GetNrTel();

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

					$smarty->assign('numerZam', $numer);

					$smarty->assign('pozycjeZam', $pozycjeZam);
					$smarty->assign('dostawaNazwa', $dostawaNazwa);
					$smarty->assign('dostawaCena', $dostawaCena);
					$smarty->assign('wartoscZam', $wartoscZam);
					$smarty->assign('platnoscNazwa', $platnoscNazwa);

					$smarty->assign('imie', $imie);
					$smarty->assign('nazwisko', $nazwisko);
					$smarty->assign('kraj', $kraj) ;
					$smarty->assign('miasto', $miasto);
					$smarty->assign('ulica', $ulica);
					$smarty->assign('nrDomu', $nrDomu);
					$smarty->assign('nrMieszkania', $nrMieszkania);
					$smarty->assign('kodPocztowy', $kodPocztowy);
					$smarty->assign('nrTel', $nrTel);

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

					$this->TranslateCaptionsSkladanieZam(&$smarty);

					if ($platnosc->GetTyp() == 1)
					{
						//wywylam maila z potwierdzeniem (link)
						$moduleTmp = new ModulesMgr();
						$moduleTmp->loadModule('Sklep');
						$potwierdzMailAct = $moduleTmp->getModuleActionIdByName('PotwierdzZamowienieMail');
						$zamSHA = hash('sha512', $_SESSION['Zamowienie']->GetId());

						$trescZPotw ="
						Szanowny Kliencie!<br/><br/>
						dziękujemy za złożenie zamówienia na programy FINKA.
						Aby potwierdzić zamówienie należy kliknąć link poniżej:<br/>
						<a href=\"http://finka.pl?a=$potwierdzMailAct&zam=$zamSHA\">
						http://finka.pl?a=$potwierdzMailAct&zam=$zamSHA
						</a>
						<br/>
						Po kliknięciu powinna otowrzyć się przeglądaraka, która przekieruję na 
						stronę potwierdzenia w sklepie finka.pl. W przypdaku, gdy przeglądarka się nie otworzy należy 
						wkleić link w pasek adresu przeglądarki. 
						"; 						

						$smarty->assign('tresc', $trescZPotw);
					}
					else
					{
						//platnosc elektorniczna - mail tylko z potwierdzeniem
						$tresc = "
						Szanowny Kliencie,<br/><br/>
						dziękujemy za złożenie zamówienia na programy FINKA. Poniżej znajdują się szczegóły zamówienia.
						";

						$smarty->assign('tresc', $tresc);
					}



				}
			}
			if ($this->typ == 'zmianaStat')
			{

				
				$status = $this->zamowienie->GetStatus();
				$nr = $this->zamowienie->GetNumer();
				//$zamowienieId = $zamowienie->GetId();
				//$linkId = MD5($zamowienieId);
				$statusTxt = '';	
				switch($status)
				{

					case 2:
						{
							$statusTxt = "Zamówienie <b>$nr</b> zostało przyjęte do realizacji.";
							break;
						}
					case 3:
						{
							$statusTxt = "Zamówienie <b>$nr</b> zostało wysłane.";
							break;
						}
					case 4:
						{
							$statusTxt = "Zamówienie <b>$nr</b> zostało zrealizowane.";
							break;
						}	

				}
					
					
					
				$smarty->assign('statusTxt', $statusTxt);
					

			}

			//wyswietlam
			$this->bodyContent = $smarty->fetch('modules/'.$this->bodyTemplate);
		}
		else
		{
			throw new exception("Brak zdefiniowanego szablonu o nazwie $this->bodyTemplate");
		}
	}
	private function PrepareTextMessage()
	{
		$smarty = new mySmarty();

		if ($smarty->template_exists('modules/'.$this->alterBodyTemplate))
		{
			/*
			 * $imie, $nazwisko, $idKraj, $miasto, $ulica, $nrDomu, $nrMieszkania,
			 $email, $kodPocztowy, $nrTel, $nrTel2, $czyFirma, $nazwaFirmy, $nip
			 */
			if ($this->typ == 'wysylanieRabatu')
			{
				$tresc = 'Szanowny Kliencie,
						Przesyłamy link do ofert z uwzględnionym rabatem. Należy wybrać link lub skopiować go w okno przeglądarki';
				$idZam = $this->zamowienie->GetId();
				$statusRab = $this->zamowienie->GetStatusRabatuInt();
				$idKli = $this->klient->GetId();
				
				$moduleTmp = new ModulesMgr();
				$moduleTmp->loadModule('Sklep');
				$actnPokazZamPoRabacie = $moduleTmp->getModuleActionIdByName('PokazZamPoRabacie');
				
				
				$link = 'https://finka.pl?a='.$actnPokazZamPoRabacie.'&link='.MD5($idZam.$statusRab.$idKli);  	
				$smarty->assign('tresc', $tresc);
				$smarty->assign('link', $link);
			}
			if ($this->typ == 'zmianaStat')
			{
				
				$status = $this->zamowienie->GetStatus();
				$statusTxt = '';
				
				$nr = $this->zamowienie->GetNumer();
				//$zamowienieId = $zamowienie->GetId();
				//$linkId = MD5($zamowienieId);
					
				switch($status)
				{

					case 3:
						{
							$statusTxt = "Zamówienie $nr zostało przyjęte do realizacji";
							break;
						}
					case 4:
						{
							$statusTxt = "Zamówienie $nr zostało wysłane";
							break;
						}

				}
					
					
					
				$smarty->assign('statusTxt', $statusTxt);
					
			}
		if ($this->typ == 'rejestracja')
		{
				$login = $this->klient->GetLogin();
				$tmpPass = $this->klient->GetTmpPass();
				$tresc = 'Witamy w sklepie tiksoft.pl.	Rejestracja przyśpiesza proces zakupów oraz umożliwia śledzenie stanu realizacji zamówienia.
						Dane logowania:';
						
				$smarty->assign('tresc', $tresc);
				$smarty->assign('login', $login);
				$smarty->assign('pass', $tmpPass);
		}
		if ($this->typ == 'zlozenieZamowienia')
			{
				if (isset($_SESSION['Zamowienie']))
				{
					$zamowienie = $_SESSION['Zamowienie'];
					$numer = $zamowienie->GetNumer();
					$uwagi = $zamowienie->GetUwagi();


					$idDostawy = $zamowienie->GetDostawa();

					$idPlatnosci = $zamowienie->GetPlatnosc();
					$towaryArr = $zamowienie->GetTowar();

					$platnosc = new Platnosc();
					$platnosc->Load($idPlatnosci, $_SESSION['lang']);

					$platnoscNazwa = $platnosc->GetNazwa();

					$dostawa = new Dostawa();
					$dostawa->Load($idDostawy, $_SESSION['lang']);

					$dostawaNazwa = $dostawa->GetNazwa();
					$dostawaCena = $dostawa->GetCena();
					$towaryArr = $_SESSION['Zamowienie']->GetTowar();
					//print_r($towaryArr);
                                        $rabat = new Rabat();
					$pozycjeZam = array();
					$wartoscZam = 0.0;
					foreach($towaryArr as $tow)
					{
						$towarTmp = new Towar();
						$towarTmp->Load($tow->towarId, $_SESSION['lang']);

						$zamItem = new ZamowieniaItems();
						$zamItem->nazwaTowaru = $towarTmp->GetNazwa();
						$zamItem->ilosc = $tow->ilosc;
						$konfiguracja = new Konfiguracja();
						if(!$rabat->GetRabatEnabled())
                                                {
                                                $zamItem->cena = $towarTmp->GetCena($tow->iloscStanowisk, $tow->iloscFirm)*(1+$konfiguracja->GetStawkaVat()/100);;
                                                }
                                                else
                                                {
                                                    $zamItem->cena = $towarTmp->GetCenaParams($tow->iloscStanowisk, $tow->iloscFirm)*(1+$konfiguracja->GetStawkaVat()/100);;
                                                }

						$pozycjeZam[]=$zamItem;
                                                if(!$rabat->GetRabatEnabled())
                                                {
						$wartoscZam += $towarTmp->GetCena($tow->iloscStanowisk, $tow->iloscFirm)*1;//*tow->ilosc
                                                }
                                                else
                                                {
                                                $wartoscZam += $towarTmp->GetCenaParams($tow->iloscStanowisk, $tow->iloscFirm)*1;//*tow->ilosc
                                                }
					}
					$wartoscZam += $dostawaCena;

					$klientTmp = $_SESSION['Zamowienie']->klient;


					//zawartosc maila: calosc zamowienia - pozycje, ilosci, ceny, wartosc zamowienia


					$klientTmp = $_SESSION['Zamowienie']->klient;
					$imie = $klientTmp->GetImie();
					$nazwisko = $klientTmp->GetNazwisko();
					$kraj = $klientTmp->GetKraj();
					$miasto = $klientTmp->GetMiasto();
					$ulica = $klientTmp->GetUlica();
					$nrDomu = $klientTmp->GetNrDomu();
					$nrMieszkania = $klientTmp->GetNrMieszkania();
					$kodPocztowy = $klientTmp->GetKodPocztowy();
					$nrTel = $klientTmp->GetNrTel();

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

					$smarty->assign('numerZam', $numer);

					$smarty->assign('pozycjeZam', $pozycjeZam);
					$smarty->assign('dostawaNazwa', $dostawaNazwa);
					$smarty->assign('dostawaCena', $dostawaCena);
					$smarty->assign('wartoscZam', $wartoscZam);
					$smarty->assign('platnoscNazwa', $platnoscNazwa);

					$smarty->assign('imie', $imie);
					$smarty->assign('nazwisko', $nazwisko);
					$smarty->assign('kraj', $kraj) ;
					$smarty->assign('miasto', $miasto);
					$smarty->assign('ulica', $ulica);
					$smarty->assign('nrDomu', $nrDomu);
					$smarty->assign('nrMieszkania', $nrMieszkania);
					$smarty->assign('kodPocztowy', $kodPocztowy);
					$smarty->assign('nrTel', $nrTel);

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

					$this->TranslateCaptionsSkladanieZam(&$smarty);

					if ($platnosc->GetTyp() == 1)
					{
						//wywylam maila z potwierdzeniem (link)
						$moduleTmp = new ModulesMgr();
						$moduleTmp->loadModule('Sklep');
						$potwierdzMailAct = $moduleTmp->getModuleActionIdByName('PotwierdzZamowienieMail');
						$zamSHA = hash('sha512', $_SESSION['Zamowienie']->GetId());

						$trescZPotw ="
						Szanowny Kliencie!<br/><br/>
						Dziękujemy za dokonanie zakupów w naszym sklepie.
						Aby potwierdzić zamówienie należy kliknąć link poniżej:<br/>
						<a href=\"http://finka.pl?a=$potwierdzMailAct&zam=$zamSHA\">
						http://finka.pl?a=$potwierdzMailAct&zam=$zamSHA
						</a>
						<br/>
					
						"; 						

						$smarty->assign('tresc', $trescZPotw);
					}
					else
					{
						//platnosc elektorniczna - mail tylko z potwierdzeniem
						$tresc = "
						Szanowny Kliencie,<br/><br/>
						dziękujemy za złożenie zamówienia na programy FINKA. Poniżej dostępne są szczegóły zamówienia.
						";

						$smarty->assign('tresc', $tresc);
					}



				}
			}
			//wyswietlam
			$this->alterBodyContent = $smarty->fetch('modules/'.$this->alterBodyTemplate);
			//echo $this->alterBodyContent;
		}
		else
		{
			throw new exception("Brak zdefiniowanego szablonu o nazwie $this->alterBodyTemplate");
		}
	}
	//
	private function LoadBodyTemplate()
	{
		try
		{
			$content = '';
			$nazwaPliku = "./smartydirs/templates/modules/$this->bodyTemplate";

			$plik = fopen ($nazwaPliku, 'r');
			if (filesize($nazwaPliku)>0)
			{
				$this->bodyTemplateContent = fread($plik, filesize($nazwaPliku));
				fclose($plik);
			}

		}
		catch (exception $e)
		{
			fclose($plik);
		}
	}
	private function LoadAlterBodyTemplate()
	{
		try
		{
			$content = '';
			$nazwaPliku = "./smartydirs/templates/modules/$this->alterBodyTemplate";
			$plik = fopen ($nazwaPliku, 'r');
			if (filesize($nazwaPliku)>0)
			{
				$this->alterBodyTemplateContent = fread($plik, filesize($nazwaPliku));
				fclose($plik);
			}
		}
		catch (exception $e)
		{
			fclose($plik);
		}
	}
	private function SaveBodyTemplate()
	{
		try
		{
			$nazwaPliku = "./smartydirs/templates/modules/$this->bodyTemplate";
			$plik = fopen ($nazwaPliku, 'w+');
			//$this->bodyTemplateContent = 'sdadadfsadffds';
			if (fwrite($plik, $this->bodyTemplateContent) === FALSE)
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
	private function SaveAlterBodyTemplate()
	{
		try
		{
			$nazwaPliku = "./smartydirs/templates/modules/$this->alterBodyTemplate";

			$plik = fopen ($nazwaPliku, 'w+');

			if (fwrite($plik, $this->alterBodyTemplateContent) === FALSE)
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


	protected function SetBodyTemplate($template)
	{
		$this->bodyTemplate = $template;
	}
	protected function SetAlterBodyTemplate($template)
	{
		$this->alterBodyTemplate = $template;
	}
	protected function SetTyp($typ)
	{
		$this->typ = $typ;
	}

	protected function SetZamowienie($id)
	{
		//$this->zamowienie = $id;
	}

	protected function SetFormTitle($title)
	{
		$this->formTitle = $title;
	}
	public function __construct()
	{
		$this->translator = new translator(rootPath.'/Modules/Sklep/SklepClass/Kontakt/Kontakt.Translation.xml');
		$this->translator->setLanguage($_SESSION['lang']);

		$this->dbInt = DBSingleton::GetInstance();
		$typ = $this->typ;
		$this->query = "SELECT * FROM MailerDataCust WHERE typ='$this->typ'";
		$dbInt = DBSIngleton::GetInstance();
		$res = $dbInt->ExecQuery($this->query);
			
		$data = $res->fetchRow(DB_FETCHMODE_ASSOC);

		$this->host = $data['SMTPServer'];
		$this->port = $data['PORT'];
		$this->username = $data['Login'];
		$this->password = $data['Pass'];
		$this->nadawca = $data['Od'];
		$this->subject = $data['Tytul'];
		$this->bodyTemplateContent = $this->LoadBodyTemplate();
		$this->alterBodyTemplateContent = $this->LoadAlterBodyTemplate();
	}

	public function Save()
	{
		//zapisuje dane

		$queryExists =
		"
			SELECT count(1) as ile FROM MailerDataCust WHERE typ='$this->typ';
		";
		$dbInt = DBSIngleton::GetInstance();
		$res = $dbInt->ExecQuery($queryExists);
		$data = $res->fetchRow(DB_FETCHMODE_ASSOC);

		$ile = $data['ile'];
		if ($ile == 0)
		{
			$query =
			" 
				INSERT INTO MailerDataCust (SMTPServer, PORT, Login, Pass, Od, Tytul, Typ)
				VALUES
				('$this->host', '$this->port', '$this->username', 
				'$this->password', '$this->nadawca', '$this->subject', '$this->typ')
					
			";
		}
		else
		{
			$query =
			"
			UPDATE MailerDataCust
			Set
				SMTPServer = '$this->host', 
				PORT = '$this->port',
				Login = '$this->username',
				Pass = '$this->password',
				Od = '$this->nadawca',
				Tytul = '$this->subject'
			WHERE
				Typ='$this->typ' 
			";
		}

		$dbInt = DBSIngleton::GetInstance();
		$dbInt->ExecQuery($query);

		$this->SaveBodyTemplate();
		$this->SaveAlterBodyTemplate();
	}

	//administracja
	public function Config()
	{
		//wyswietlam formularz
		$html = '';
		$html .= '<table width="600"  height="500" align="center" cellpadding=0 cellspacing=0 border=0><tr><td>';
		$myForm = null;
		$myForm = new Form('dFORM', 'POST');
		$kontaktForm = $myForm->getFormInstance();
		$kontaktForm->addElement('header', ' hdr', $this->formTitle);
		$elementServer = $kontaktForm->addElement('text', 'txtServer', 'SMTP Server', array('size' => 60, 'maxlength'=> 100));
		$elementPort = $kontaktForm->addElement('text', 'txtPort', 'Port', array('size' => 60, 'maxlength'=> 100));
		$elementLogin = $kontaktForm->addElement('text', 'txtLogin', 'Login SMTP', array('size' => 60, 'maxlength'=> 100));
		$elementPass = $kontaktForm->addElement('text', 'txtPass', 'Hasło SMTP', array('size' => 60, 'maxlength'=> 100));
		$elementOd = $kontaktForm->addElement('text', 'txtOd', 'Adres nadawcy', array('size' => 60, 'maxlength'=> 100));
		//$elementDo = $kontaktForm->addElement('text', 'txtDo', 'Adres docelowy', array('size' => 60, 'maxlength'=> 100));
		$kontaktForm->addElement('header', ' hdr1', 'Konfiguracja wiadomości');
		$elementTitle = $kontaktForm->addElement('text', 'txtTytul', 'Tytuł', array('size' => 60, 'maxlength'=> 100));
		$elementMailContent = $kontaktForm->addElement('textarea', 'MailTemplate', 'Szablon wiadomości', array('cols'=>50, 'rows'=>15));
		$elementAlterBodyContent = $kontaktForm->addElement('textarea', 'MailAlterTemplate', 'Szablon wiadomości "alter"', array('cols'=>50, 'rows'=>15));
		$kontaktForm->addElement('submit', 'btnSubmit', 'Wyślij');
		$kontaktForm->addElement('reset', 'btnReset', 'Wyczyść');


		$kontaktForm->applyFilter('__ALL__', 'trim');

		$myForm->setStyle(2);

		if ($kontaktForm->validate())
		{
			$kontaktForm->freeze();

			$this->host = $elementServer->GetValue();
			$this->port = $elementPort->GetValue();
			$this->username = $elementLogin->GetValue();
			$this->password = $elementPass->GetValue();
			$this->nadawca = $elementOd->GetValue();
			$this->subject = $elementTitle->GetValue();
			$this->bodyTemplateContent = $elementMailContent->GetValue();
			$this->alterBodyTemplateContent = $elementAlterBodyContent->GetValue();
			$this->Save();
			//$this->SaveBodyTemplate();
			//$this->SaveAlterBodyTemplate();

			$okAction = 0;
			$dialog = new dialog('Zapis danych' , 'Dane zapisane', 'info', 300, 150);
			$dialog->setAlign('center');
			$dialog->setOkCaption('Ok');
			$dialog->setOkAction($okAction);
			$html .= $dialog->show(1);

		}
		else
		{
			$rodzaj = $this->typ;
			$sql = "
				SELECT 
					`SMTPServer`,
					`PORT`,
					`Login`,
					`Pass`,
					`Od`,
					`Tytul`
				FROM 
					MailerDataCust
				WHERE
					typ='$this->typ'
				";

			$data = $this->dbInt->ExecQuery($sql);

			$record = $data->fetchRow(DB_FETCHMODE_ASSOC);
			$elementServer->setValue($record['SMTPServer']);
			$elementPort->setValue($record['PORT']);
			$elementLogin->setValue($record['Login']);
			$elementPass->setValue($record['Pass']);
			$elementOd->setValue($record['Od']);
			$elementTitle->setValue($record['Tytul']);
			$this->LoadBodyTemplate();
			$this->LoadAlterBodyTemplate();
			$elementMailContent->SetValue($this->bodyTemplateContent);
			$elementAlterBodyContent->SetValue($this->alterBodyTemplateContent);
			$html .= $kontaktForm->toHtml();
		}

		$html .= '</td></tr></table>';

		return $html;

	}

	public function Send()
	{
		//pobieram dane szablonu i wysylam do uzytkownika

		$this->mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch
		$this->mail->IsSMTP(); // telling the class to use SMTP
		try
		{
			$this->PrepareHtmlMessage();
			$this->PrepareTextMessage();
			$this->mail->Host       = $this->host; // SMTP server
			$this->mail->CharSet = "UTF-8";
			$this->mail->IsHTML(true);

			$this->mail->SMTPDebug=1;                     // enables SMTP debug information (for testing)
			$this->mail->SMTPAuth   = true;                  // enable SMTP authentication
			$this->mail->Port       = $this->port;                    // set the SMTP port for the GMAIL server
			$this->mail->Username   = $this->username; // SMTP account username
			$this->mail->Password   = $this->password;        // SMTP account password

			$this->mail->AddAddress($this->klient->GetEmail());
			$this->mail->SetFrom($this->nadawca);
			
			$this->mail->Subject = $this->subject;
			$this->mail->MsgHTML($this->bodyContent);
			$this->mail->AltBody = $this->alterBodyContent; // optional - MsgHTML will create an alternate automatically
			$this->mail->Send();
			//return $html;


		}

		catch (phpmailerException $e)
		{
			//echo $e->errorMessage();
			$exc = new ExceptionClass($e, 'Kontakt::Send');
			$exc->writeException();
			return 'Dane nie wyslane: '.$e->errorMessage(); //Pretty error messages from PHPMailer
		}
		catch (Exception $e)
		{
			//echo $e->errorMessage();
			$exc = new ExceptionClass($e, 'Kontakt::Send');
			$exc->writeException();
			return 'Dane nie wysłane: '.$e->getMessage(); //Boring error messages from anything else!
		}
		unset($mail);
	}

}
?>
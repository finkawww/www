<?php
/*
 1. Zloz zamowienie (function ZlozZamowienie)
 a) Pokaz formularz zamowiebnia - dane osobowe, ekran dostawy, platnosc, uwagi
 ekran potiwerdzenia ->dalej b)
 b) Formularz zapisuje obiekt Global Zamowienie.
 -Zapis w bazie danych ze statusem "nowe"
 - Gdy sklep z rezerwacjami - rezerwacja towaru
 - Wysylka maila o nowym, niepotwerdzonym zamoiniu do operatora
 2.  Proba potwierdzenia -> W zaleznosci od formy platnosci
 a) Gdy platnosc<>niz esystem -> wysylamy maila z potwierdzeniem (WyslijPotwierdzenie)
 W przypadku e-platnosci wysylamy maila z zamowineiem ale bez potwierdzania(WyslijInfoOZamowieniu)
 3. Odbior potwierxzenia
 a) Dla sys e-platnosci - przychodzi potwierdzenie z systemu zewnetrznego
 b) dla kazdej innej - uzytkownik kliknal w link, i:
 - System tworzy obiekt globalny na podstawie danych z bd
 - System zmienia status na "potwierdzony"
 - System wysyla maila do operatora - ze jest nowe zamowienie

 */



class SkladanieZamowienia
{
	private $Global = null;
	private $ZamowienieModel = null;
	private $ZamowienieView = null;



	private function ShowAfterZamowienieDialog()
	{
		//echo 'IN';
		$html = 'Dziękujemy za zakupy. Proszę sprawdzić skrzynkę mailową';
		$koszykTmp = GlobalObj()->Koszyk();
		$koszykTmp->WyczyscKoszyk();

		$module = new modulesMgr();
		$module->loadModule('Sklep');
		$clearAction = $module->getModuleActionIdByName('ClearZamowienie');
		$addButton = new button('', 'Zakończ zamówienie', $clearAction, -1);
		$html = $addButton->show(1);
		//$_SESSION['Zamowienie']=null;


		return $html;
	}
	private function ShowNieudaneZamowienieDialog()
	{
		//wyswietlam komunikat i pozniej koszyk - musi ponownie dokonac zamowienia
		echo 'Wystapił błąd podczas zapisu zamówienia. Prosimy o kontakt z Działem Obsługi Klienta.';
	}

	//zatwierdzanie przez uzytkownika
	public function ZatwierdzUsr()
	{

		try
		{
			if (!(isset($_SESSION['Zamowienie']))||(!(count($_SESSION['Zamowienie']->towary)>0)))
			{
				try
				{

					$dbInt = DBSingleton::GetInstance();

					//0. Start transaction
					$queryStartTrans = 'START TRANSACTION';
					$dbInt->ExecQuery($queryStartTrans);
					//1. Rezerwuje

					$koszykTmp = GlobalObj()->Koszyk();
					$arrTowary = $koszykTmp->GetTowaryId();
					$konfig = new Konfiguracja();
					$rezerwacja = new Konfiguracja();
					$rezerwacje = $rezerwacja->Rezerwacje();
					unset($rezerwacja);
					$idx = 0;
					foreach($arrTowary as $id)
					{

						$towarTmp = new Towar();
						$towarTmp->Load($id, $_SESSION['lang']);
						if (($towarTmp->GetZarezerwowany() == 'N')||(!$rezerwacje))
						{
							if ($konfig->Rezerwacje())
							{
								$towarTmp->SetZarezerwowany('T');
							}
							$iloscTow = $koszykTmp->GetIloscTowaru($id);
							$iloscStanowisk = $koszykTmp->GetTowarIlosc($idx);
							$iloscFirm = $koszykTmp->GetTowarIloscFirm($idx);
							$_SESSION['Zamowienie']->AddTowar($id, $iloscTow, $iloscStanowisk, $iloscFirm);
						}
						else
						{
							//ktos w miedzyczasie zarezerwowal towar
							//wysiweltam komunikat i wysylam do koszyka
							$queryRollbackTrans = 'ROLLBACK';
							$dbInt->ExecQuery($queryRollbackTrans);
							//echo 'BACK';

							$this->ShowNieudaneZamowienieDialog($id);
							break;
						}
						$idx++;
					}

					//
					//2. Zapisuje zamowienie do tabeli
					$_SESSION['Zamowienie']->ZmienStatus(0);
					$konfiguracja = new Konfiguracja();
					if ($konfiguracja->CzyRabatWlaczony())
					{
						$_SESSION['Zamowienie']->SetStatusRabatuNienaliczony();
					}

					$_SESSION['Zamowienie']->Save(true);

					$queryCommitTrans = 'COMMIT';
					$dbInt->ExecQuery($queryCommitTrans);
				}
				catch(exception $e)
				{
					//echo 'EXCEPTION 1';
					$queryRollbackTrans = 'ROLLBACK';
					$dbInt->ExecQuery($queryRollbackTrans);
					$exc = new ExceptionClass($e, 'ZatwierdzUsr::exc1');
					$exc->writeException();
					exit; //albo jakis header
				}
					
					
				//3a) dla zaplat tradycyjnych - wysyalm maila z potwierdzniem
				
					
				$kontaktOperator = new KontaktOperator();
				$nrZam = $_SESSION['Zamowienie']->GetNumer();
				$msg = "W systemie zarejestrowano nowe zamówienie o nr $nrZam. Zamówienie jest niepotwierdzone.";
				$kontaktOperator->Send('Nowe, nipotwierdzone zamówienie', $msg);
			}
			else
			{
				$_SESSION['Zamowienie']->Save(false);
			}
			$platnoscId = $_SESSION['Zamowienie']->GetPlatnosc();
			$platnosc = new Platnosc();
			$platnosc->Load($platnoscId, $_SESSION['lang']);
			if ($platnosc->GetTyp() != 3)
			{

				$klientTmp = &$_SESSION['Zamowienie']->klient;
				$klientId = $klientTmp->GetId();
				$kontaktFact = new KontaktKreator();
				$kontakt = $kontaktFact->FactoryMethod('zlozenieZamowienia', $klientId);
				$kontakt->Send();

				$koszykTmp = GlobalObj()->Koszyk();
				$koszykTmp->WyczyscKoszyk();
				$konfiguracja = new Konfiguracja();
				if ($konfiguracja->CzyRabatWlaczony())
				{
					$_SESSION['Zamowienie']->SetStatusRabatuNienaliczony();
				}
				$module = new modulesMgr();
				$module->loadModule('Sklep');
					
				$clearAction = $module->getModuleActionIdByName('ClearZamowienie');
				header("Location: ?a=$clearAction&zam=1");

			}
			//3b dla zaplat elektr przechodze do systemu platnosci
			else
			{

				$klientTmp = &$_SESSION['Zamowienie']->klient;
				$klientId = $klientTmp->GetId();
				$kontaktFact = new KontaktKreator();
				//TODO Nalezy zmodyfikowac wysylanie maila, aby nie szlo potwierdzenie dla platnosci on-line
				$kontakt = $kontaktFact->FactoryMethod('zlozenieZamowienia', $klientId);
				$kontakt->Send();

				$koszykTmp = GlobalObj()->Koszyk();
				$koszykTmp->WyczyscKoszyk();

				$module = new modulesMgr();
				$module->loadModule('Sklep');
					
				$clearAction = $module->getModuleActionIdByName('ClearZamowieniePlatnosci');
				header("Location: ?a=$clearAction&zam=1");

			}



			//Uwaga - gdy wyjatek wolane jest rollback i zapis w logu.
			// - Mail do operatora z danymi zamowienia - ten oddzwania
		}
		catch (exception $e)
		{
			//echo 'EXCEPTION2';
			$exc = new ExceptionClass($e, 'ZatwierdzUsr::exc2');
			$exc->writeException();
		}
	}
	public function AnulujUsr()
	{
		$module = new modulesMgr();
		$module->loadModule('Sklep');
		$clearAction = $module->getModuleActionIdByName('ClearZamowienie');
		header("Location: ?a=$clearAction&zam=0");

		//unset($_SESSION['Zamowienie']);
	}
	public function ZlozZamowienie($strona)
	{
		//echo 'ZlozZamowineie';

		if (!isset($_SESSION['Zamowienie']))
		{
				
			$ZamowienieModel = new Zamowienie();
			$_SESSION['Zamowienie'] = $ZamowienieModel;

		}
		$this->ZamowienieView = new ZamowienieView();
		return $this->ZamowienieView->WyswietlFormularzZamowienia($strona);
	}
	//uzytkownik zatwierdza zamowienie
	//Zatwierdzenie moze byc poprzez - potwierdzenie maila
	public function ZatwierdzZamowienieMail($zam)
	{
		$html = '';
		$DBInt = DBSingleton::GetInstance();
		$query = "SELECT id FROM Zamowienia WHERE status=0";

		$dbRes = $DBInt->ExecQuery($query);
		$statChanged = false;
		while($data = $dbRes->fetchRow(DB_FETCHMODE_ASSOC))
		{
			$id = $data['id'];
			if (hash('sha512',$id) == $zam)
			{
				$tmpZamowienie = new Zamowienie();
				$tmpZamowienie->Load($id);
				$tmpZamowienie->ZmienStatus(1);
				$tmpZamowienie->Save(false);
				$nrZam = $tmpZamowienie->GetNumer();
				$kontaktOperator = new KontaktOperator();
				$msg = "Potwierdzono zamówienie $nrZam. Zamówienie ma teraz status POTWIERDZONE.";
				$kontaktOperator->Send("POTWIERDZONE ZAMÓWIENE $nrZam", $msg);
				$statChanged = true;
				$html = 'Dziękujemy za złożenie zamówienia. Twoje zamówienie zostało potwierdzone';

				break;
			}
		}
		if (!$statChanged)
		{
			$html = 'Zamówienie zostało potwierdzone wcześniej.';
		}
		return $html;
	}

	//pokazuje zamowienie - po zalogowaniu sie
	public function WyswietlZamowienie($idZamowienia)
	{
		//sprawdzxam czy zalogowany, jezeli nie - loguje (na podstawie login i hasla)

	}
}
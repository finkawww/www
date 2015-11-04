<?php
//wczytuje klasy Model, View, Controller
//echo rootPath;
require_once rootPath.'/Modules/Sklep/SklepClass/AdministracjaTowar.php';
require_once rootPath.'/Modules/Sklep/SklepClass/AdministracjaZamowienia.php';
require_once rootPath.'/Modules/Sklep/SklepClass/AdministracjaKlienci.php';
if (!defined('pictPath'))
	DEFINE('pictPath','http://www.finka.pl/FrontPage/Files/ImgShop/');

class Sklep extends moduleTemplate 
{
	private $PrzegladanieKoszyka = null;
	private $PrzegladanieOferty = null;
	private $PrzegladanieGrupOfert = null;
	private $SkladanieZamowienia = null;
	private $ZarzadzanieKontem = null;
	private $AdministracjaTowar = null;
	private $AdministracjaOferta = null; 
	private $AdministracjaKraje = null;
	private $AdministracjaPlatnosci = null;
	private $AdministracjaDostawy = null;
	private $AdministracjaZamowienia = null;
	private $AdministracjaKlienci = null;
	private $PlatnosciPL = null;
	
	public function __create()
	{
		GlobalObj()->Koszyk()->ile=5;
		$koszyk = GlobalObj()->Koszyk();
		
		$koszyk->PrzeliczKoszyk();
	}
	
	public function executeAction($actionName, $l, $varArray)
	{
		
		if ($actionName == 'ankietaSend')
		{
			$result = $this->AnkietaSend();
		}
		else if ($actionName == 'kontaktSend')
		{
			$result = $this->KontaktSend();
		}
		else if ($actionName == 'PokazKoszykFull')
		{
			$result = $this->PokazKoszykFull();
		} 
		else if ($actionName == 'PokazKoszykStatus')
		{
			$result = $this->PokazKoszykStatus();
		}
		else if ($actionName == 'PrzeliczKoszyk')
		{
			$result = $this->PrzeliczKoszyk();
		}
		else if ($actionName == 'WyczyscKoszyk')
		{
			$result = $this->WyczyscKoszyk();
		}
		else if ($actionName == 'UsunPozycjeKoszyk')
		{
			$idTowaru = $_GET['towarId'];
			$result = $this->UsunPozycjeKoszyk($idTowaru);
		}
		else if ($actionName == 'PokazGrupeOfert')
		{
			$idMenu = $_SESSION['mp'];
			$result = $this->PokazGrupeOfert($idMenu);
		}
		else if ($actionName == 'ShowGrupyOfert')
		{
			
			$result = $this->ShowGrupyOfert();
		}
		else if ($actionName == 'PokazOferte')
		{
			
			$idOferty = $_GET['idOferty']; 
			if (isset($_GET['nrStrony']))
			{
				$nrStrony = $_GET['nrStrony'];
			}
			else
			{
				$nrStrony = 0;
			}
			if ($nrStrony>0)
				$nrStrony--;
			$result = $this->PokazOferte($idOferty);
		}
		else if ($actionName == 'PokazOfertyGrupy')
		{
			
			$idGrupy = $_GET['idGrupy']; 
			if (isset($_GET['nrStrony']))
			{
				$nrStrony = $_GET['nrStrony'];
			}
			else
			{
				$nrStrony = 0;
			}
			if ($nrStrony>0)
				$nrStrony--;
			$result = $this->PokazOfertyGrupy($idGrupy);
		}
		else if ($actionName == 'DodajDoKoszykaByImg')
		{
			$imgName = $_GET['img'];
			$towarId = $this->DodajDoKoszykaByImg($imgName);
			$moduleTmp = new ModulesMgr();
			$moduleTmp->loadModule('Sklep');
			$param=array();
			$param[]=$towarId;
			//echo var_dump(serialize($_SESSION['koszyk'])).'<br>';
			$result = $moduleTmp->moduleExecuteAction('DodajDoKoszyka', $param);
			unset($moduleTmp);
			//$result = $this->DodajDoKoszyka($towarId);
		}
		else if ($actionName == 'DodajDoKoszyka')
		{
			$towarId = 0;
			$iloscEgz = 0;
			$iloscFirm = 0;
			if (isset($_GET['towarId']))
			{
				$towarId = $_GET['towarId'];
			}
			else
			{
				$towarId = $varArray[0];
			}
			
			if (isset($_GET['iloscEgz']))
			{
				$iloscEgz = $_GET['iloscEgz']; 
			}
			else
			{
				$iloscEgz = 0;
			}
			
			if (isset($_GET['iloscFirm']))
			{
				$iloscFirm = $_GET['iloscFirm'];
			}
			else
			{
				$iloscFirm = 0;
			}
			
			//echo $towarId;
			$result = $this->DodajDoKoszyka($towarId, $iloscEgz, $iloscFirm);
		}
		else if ($actionName == 'Zaloguj')
		{
			$result = $this->Zaloguj();
		}
		else if ($actionName == 'Wyloguj')
		{
			$result = $this->Wyloguj();
		}
		else if ($actionName == 'AddUser')
		{
			$result = $this->AddUser();
		}
		else if ($actionName == 'UserChangePass')
		{
			$result = $this->UserChangePass();
		}
		else if ($actionName == 'UserResetPass')
		{
			$result = $this->UserResetPass();
		}
		else if ($actionName == 'PokazKlientStatus')
		{
			$result = $this->PokazKlientStatus();
		}
		else if ($actionName == 'ShowUserPage')
		{
			$result = $this->ShowUserPage();
		}
		else if ($actionName == 'KlientShowAdmin')
		{
			$kryt = '';
			
			if (isset($_GET['kryt']))
			{
				$kryt=$_GET['kryt'];
			}
			$result = $this->KlientShowAdmin($kryt);			
		}
		else if ($actionName == 'KlientEditAdmin')
		{
			$id = 0;
			if (isset($_GET['id']))
			{
				$id = $_GET['id'];
			}
			$result = $this->KlientEditAdmin($id); 
		}
		else if ($actionName == 'ZlozZamowienie')
		{
			if (isset($_GET['strona']))
			{
				$strona = $_GET['strona'];
			}
			else if (isset($_POST['strona']))
			{
				$strona = $_POST['strona'];
			}
			else
			{
				$strona = 'daneOsobowe';
			}
			$result = $this->ZlozZamowienie($strona);
		}
		//zatwierdzenie na formularzu podsumowania
		else if ($actionName == 'ClearZamowienie')
		{
			if (isset($_GET['zam']))
			{
				$zam = $_GET['zam'];
			}
			$result = $this->ClearZamowienie($zam);
		}
		else if ($actionName == 'ClearZamowieniePlatnosci')
		{
			if (isset($_GET['zam']))
			{
				$zam = $_GET['zam'];
			}
			$result = $this->ClearZamowieniePlatnosci($zam);
		}
		else if ($actionName == 'NaliczRabat')
		{
			if (isset($_GET['id']))
			{
				$id = $_GET['id'];
			}
			else
			{
				$id = -1;	
			}
			if ($id>0)
			{
				$result = $this->NaliczRabat($id);	
			}
			else
			{
				$result= 'Wystąpił błąd w rejestrtacji rabatu. Prosimy o kontakt z Działem Obsługi Klienta pod numerem (22)408-48-00';
			}
		}
		else if ($actionName == 'ZapiszRabatIWyslij')
		{
			if (isset($_GET['id']))
			{
				$id = $_GET['id'];
			}
			$result = $this->ZapiszRabatIWyslij($id);
		}
		else if ($actionName == 'PokazZamPoRabacie')
		{
			if (isset($_GET['link']))
			{
				$link = $_GET['link'];				
			}
			else
			{
				$link = '';
			}
			if ($link<>'')
			{
			  $result = $this->PokazZamPoRabacie($link);
			}
			else
			{
			  $result = 'Błędny klucz zamówienia';
			}
			  
		}
		else if ($actionName == 'EditPozZam')
		{
			if (isset($_GET['id']))
			{
				$idPoz = $_GET['id'];
				$idZam = $_GET['zamId'];
				$result = $this->EditPozZam($idPoz, $idZam);
			}
			else if (isset($_POST['id']))
			{
				$idPoz = $_POST['id'];
				$idZam = $_POST['zamId'];
				$result = $this->EditPozZam($idPoz, $idZam);
			}
			else
			{
				$result = 'Błąd parametru w EditPozZam';
			}
			
		}
		else if ($actionName == 'ZatwierdzUsr')
		{
			$result = $this->ZatwierdzUsr();
		}
		
		
		else if ($actionName == 'PotwierdzZamowienieMail')
		{
			if (isset($_GET['zam']))
			{
				$zam = $_GET['zam'];
				$result =  $this->ZatwierdzZamowienieMail($zam);	
			}

		}
		else if ($actionName == 'PokazZamowienie')
		{
			$idZam = 0;
			if (isset($_GET['idZam']))
			{
				$idZam = $_GET['idZam'];
			}
			$result = $this->PokazZamowienie($idZam);
		}
		else if ($actionName == 'ShowZamowieniaAdmin')
		{
			$status = 1;
			$order = 'desc';
			
			if (isset($_GET['status']))
			{
				$status = $_GET['status'];
			}
			if (isset($_GET['order']))
			{
				$order = $_GET['order'];
			}
			$result = $this->ShowZamowieniaAdmin($status, $order);
			
		} 
		else if ($actionName == 'EditZamowienieAdmin')
		{
			if (isset($_GET['id']))
			{
				$id = $_GET['id'];
				$result = $this->EditZamowienie($id);				
			}
			else if (isset($_POST['id']))
			{
				$id = $_POST['id'];
				$result = $this->EditZamowienie($id);
			}
			else
			{
				$result = 'Brak wskazanego zamowienia';
			}
		}
		else if ($actionName == 'DelZamowienieAdmin')
		{
			if (isset($_GET['id']))
			{
				$id = $_GET['id'];
				$result = $this->DelZamowienie($id);				
			}
		}
		else if ($actionName == 'ShowZamowienieHistoria')
		{
			if (isset($_GET['id']))
			{
				$id = $_GET['id'];
				$result = $this->ShowZamowienieHistoria($id);
			}
		}
		else if($actionName == 'AnulujZamowienieAdmin')
		{
			if (isset($_GET['id']))
			{
				$id = $_GET['id'];
				$result = $this->AnulujZamowienieAdmin($id);
			}
		}
		else if($actionName == 'AnulujUsr')
		{
			$result = $this->AnulujUsr();
		}
		else if ($actionName == 'SendZamowienieStatus')
		{
			if (isset($_GET['id']))
			{
				$id = $_GET['id'];
				$result = $this->SendZamowienieStatus($id);
			}
		}
		//administracja
		else if ($actionName == 'ShowTowaryAdmin')
		{
			
			$result = $this->ShowTowaryAdmin();
		}
		else if ($actionName == 'AddTowarAdmin')
		{
			
			$result = $this->AddTowarAdmin(0);
		}
		else if ($actionName == 'EditTowarAdmin')
		{
	
			if (isset($_GET['id']))
			{
				$id = $_GET['id'];
			}
			else if (isset($_POST['id']))
			{
				$id = $_POST['id'];
			}
			$result = $this->AddTowarAdmin($id);
		}
		else if ($actionName == 'DelTowar')
		{
			//echo 'del';
			$result = $this->DelTowar($_GET['id']);
		}
		else if ($actionName == 'ShowOfertyAdmin')
		{
			$result = $this->ShowOfertyAdmin();
		}
		else if ($actionName == 'EditOfertaAdmin')
		{
			if (isset($_GET['id']))
			{
				$id = $_GET['id'];
			}
			else if (isset($_POST['id']))
			{
				$id = $_POST['id'];
			}
			$result = $this->AddOfertaAdmin($id);
		}
		else if ($actionName == 'AddOfertaAdmin')
		{
			$result = $this->AddOfertaAdmin(0);
		}
		else if ($actionName == 'ShowPrzypiszTowarOfercie')
		{
			if (isset($_GET['id']))
			{
				$id = $_GET['id'];
			}
			else if (isset($_POST['id']))
			{
				$id = $_POST['id'];
			}
			$result = $this->ShowPrzypiszTowarOfercieAdmin($id);
		}
		else if ($actionName == 'DelOferta')
		{
			if (isset($_GET['id']))
			{
				$id = $_GET['id'];
			}
			else if (isset($_POST['id']))
			{
				$id = $_POST['id'];
			}
			$result = $this->DelOferta($id);
		}
		else if ($actionName == 'DelOfertaDo')
		{
			if (isset($_GET['id']))
			{
				$id = $_GET['id'];
			}
			else if (isset($_POST['id']))
			{
				$id = $_POST['id'];
			}
			$result = $this->DelOfertaDo($id);
		}
		else if ($actionName == 'ChooseMenuOferta')
		{
			$result = $this->ChooseMenuOferta();
		}
		else if($actionName == 'PrzypTowarOfertaAdmin')
		{
			if (isset($_GET['id']))
			{
				$id = $_GET['id'];
			}
			else if (isset($_POST['id']))
			{
				$id = $_POST['id'];
			}
			$result = $this->PrzypiszTowaryOfercie($id);
		}
		else if ($actionName == 'EditPrzypisanie')
		{
			//id przypisania
			if (isset($_GET['id']))
			{
				$id = $_GET['id'];
			}
			else if (isset($_POST['id']))
			{
				$id = $_POST['id'];
			}
			$result = $this->EdytujPrzypisanie($id);
		}
		else if ($actionName == 'DelPrzypisanie')
		{
			if (isset($_GET['id']))
			{
				$id = $_GET['id'];
			}
			else if (isset($_POST['id']))
			{
				$id = $_POST['id'];
			}
			$result = $this->DelPrzypisanie($id);
		}
		else if ($actionName == 'towOfertaUp')
		{
			if (isset($_GET['id']))
			{
				$id = $_GET['id'];
			}
			else if (isset($_POST['id']))
			{
				$id = $_POST['id'];
			}
			return $this->towOfertaUp($id);
		}
		else if ($actionName == 'towOfertaDown')
		{
			if (isset($_GET['id']))
			{
				$id = $_GET['id'];
			}
			else if (isset($_POST['id']))
			{
				$id = $_POST['id'];
			}
			$result = $this->towOfertaDown($id);
		}
		else if ($actionName == 'ChooseTowarOferta')
		{
			$id = 0;
			if (isset($_GET['id']))
			{
				$id = $_GET['id'];
			}
			else if (isset($_POST['id']))
			{
				$id = $_POST['id'];
			}
			$result = $this->ChooseTowarOferta($id);
		}
		else if ($actionName == 'PrzypiszTowaryDo')
		{
			$idTowArr = array();
			if (isset($_GET['id']))
			{
				$id = $_GET['id'];
			}
			else if (isset($_POST['id']))
			{
				$id = $_POST['id'];
			}
			$l = 0;
			for($i=0;$i<100/*count($_GET)*/; $i++)//bo 2 elementy tablicy sa wykorzystane
			{
				if (isset($_GET["idTow$i"]))
				{
					$idTowArr[] = $_GET["idTow$i"];
				}
			}
			/*while(isset($_GET["idTow$l"]))
			{
				$idTowArr[] = $_GET["idTow$l"];
				$l++;
			}*/
			$result = $this->PrzypiszTowaryDo($id, $idTowArr);
		}
		
		else if ($actionName == 'configKontaktRejestracja')
		{
			$result= $this->configKontakt('rejestracja');
		}
		else if ($actionName == 'sendRejestracja')
		{
			$this->send('rejestracja');
		}
		else if ($actionName == 'configKontaktResetHasla')
		{
			$result=$this->configKontakt('resetHasla');
		}
		else if ($actionName == 'sendResetHasla')
		{
			$this->send('resetHasla');
		}
		else if ($actionName == 'configKontaktZlozZam')
		{
			$result=$this->configKontakt('zlozZamow');
		}
		else if ($actionName == 'sendZlozZam')
		{
			$this->send('zlozZamow');
		}
		else if ($actionName == 'configKontaktZmStat')
		{
			$result=$this->configKontakt('zmStat');
		}
		else if ($actionName == 'sendZmStat')
		{
			$this->send('zmStat');
		}
		
		else if ($actionName == 'ShowKrajeAdmin')
		{
			$result = $this->ShowKrajeAdmin();
		}
		else if ($actionName == 'AddKrajAdmin')
		{
			$result = $this->AddKrajAdmin(0);
		}
		else if ($actionName == 'EditKrajAdmin')
		{
			if (isset($_GET['id']))
			{
				$id = $_GET['id'];
			}
			else if (isset($_POST['id']))
			{
				$id = $_POST['id'];
			}
			$result = $this->AddKrajAdmin($id);
		}
		else if ($actionName == 'DelKrajAdmin')
		{
			if (isset($_GET['id']))
			{
				$id = $_GET['id'];
			}
			else if (isset($_POST['id']))
			{
				$id = $_POST['id'];
			}
			$result = $this->DelKrajAdmin($id);
		}
		else if ($actionName == 'KrajUp')
		{
			if (isset($_GET['id']))
			{
				$id = $_GET['id'];
			}
			else if (isset($_POST['id']))
			{
				$id = $_POST['id'];
			}
			
			$result = $this->KrajUp($id);
		}
		else if ($actionName == 'KrajDown')
		{
			if (isset($_GET['id']))
			{
				$id = $_GET['id'];
			}
			else if (isset($_POST['id']))
			{
				$id = $_POST['id'];
			}
			$result = $this->KrajDown($id);
		}
		else if ($actionName == 'ShowPlatnosciAdmin')
		{
			$result = $this->ShowPlatnosciAdmin();
		}
		else if ($actionName == 'AddPlatnoscAdmin')
		{
			$result = $this->AddPlatnoscAdmin(0);
		}
		else if ($actionName == 'EditPlatnoscAdmin')
		{
			if (isset($_GET['id']))
			{
				$id = $_GET['id'];
			}
			else if (isset($_POST['id']))
			{
				$id = $_POST['id'];
			}
			$result = $this->AddPlatnoscAdmin($id);
		}
		else if ($actionName == 'DelPlatnoscAdmin')
		{
			if (isset($_GET['id']))
			{
				$id = $_GET['id'];
			}
			else if (isset($_POST['id']))
			{
				$id = $_POST['id'];
			}
			$result = $this->DelPlatnoscAdmin($id);
		}
		else if ($actionName == 'PlatnoscUp')
		{
			if (isset($_GET['id']))
			{
				$id = $_GET['id'];
			}
			else if (isset($_POST['id']))
			{
				$id = $_POST['id'];
			}
			$this->PlatnoscUp($id);
		}
		else if ($actionName == 'PlatnoscDown')
		{
			if (isset($_GET['id']))
			{
				$id = $_GET['id'];
			}
			else if (isset($_POST['id']))
			{
				$id = $_POST['id'];
			}
			$this->PlatnoscDown($id);
		}
		else if ($actionName == 'URLPozytywnyCallback')
		{
			$sessId = $_GET['session_id'];
			$result = $this->URLPozytywnyCallback($sessId);
		}
		else if ($actionName == 'URLNegatywnyCallback')
		{
			$sessId = $_GET['session_id'];
			$amount = $_GET['amount'];
			$error = $_GET['error'];
			$result = $this->URLNegatywnyCallback($sessId, $amount, $error);
		}
		else if ($actionName == 'URLOnlineCallback')
		{
			$pos_id = $_POST['pos_id'];
			$session_id = $_POST['session_id'];
			$ts = $_POST['ts'];
			$sig = $_POST['sig'];
			
			
			$result = $this->URLOnlineCallback($pos_id, $session_id, $ts, $sig);
			
		}
		else if ($actionName == 'ShowDostawyAdmin')
		{
			$result = $this->ShowDostawyAdmin();
		}
		else if ($actionName == 'AddDostawaAdmin')
		{
			$result = $this->AddDostawaAdmin(0);
		}
		else if ($actionName == 'EditDostawaAdmin')
		{
			if (isset($_GET['id']))
			{
				$id = $_GET['id'];
			}
			else if (isset($_POST['id']))
			{
				$id = $_POST['id'];
			}
			$result = $this->AddDostawaAdmin($id);
		}
		else if ($actionName == 'DelDostawaAdmin')
		{
			if (isset($_GET['id']))
			{
				$id = $_GET['id'];
			}
			else if (isset($_POST['id']))
			{
				$id = $_POST['id'];
			}
			$result = $this->DelDostawaAdmin($id);
		}
		else if ($actionName == 'DostawaUp')
		{
			if (isset($_GET['id']))
			{
				$id = $_GET['id'];
			}
			else if (isset($_POST['id']))
			{
				$id = $_POST['id'];
			}
			$this->DostawaUp($id);
		}
		else if ($actionName == 'DostawaDown')
		{
			if (isset($_GET['id']))
			{
				$id = $_GET['id'];
			}
			else if (isset($_POST['id']))
			{
				$id = $_POST['id'];
			}
			$this->DostawaDown($id);
		}
		
		
		else
		{
			$result = 'Zła akcja! '.$actionName;
		}
		
		return $result;
	}
	//----------------------oferta
	public function PokazGrupeOfert($idMenu)
	{
		$this->PrzegladanieOferty = new PrzegladanieOferty;
		$html = $this->PrzegladanieOferty->PokazGrupeOfert($idMenu);
		unset($this->PrzegladanieOferty);
		return $html;
	}
	public function PokazOferte($IdOferty)
	{
		$this->PrzegladanieOferty = new PrzegladanieOferty();
		GlobalObj()->AddSessPrimitive('koszykBack', '?'.$_SERVER["QUERY_STRING"]);
		$html = $this->PrzegladanieOferty->PokazOferte($IdOferty);
		unset($this->PrzegladanieOferty);
		return $html;
	}
	public function PokazOfertyGrupy($IdGrupy)
	{
		$this->PrzegladanieOferty = new PrzegladanieOferty();
		GlobalObj()->AddSessPrimitive('koszykBack', '?'.$_SERVER["QUERY_STRING"]);
		$html = $this->PrzegladanieOferty->PokazOfertyGrupy($IdGrupy);
		unset($this->PrzegladanieOferty);
		return $html;
	}
	//-----------------------koszyk
	public function PokazKoszykFull()
	{
		$this->PrzegladanieKoszyka = new PrzegladanieKoszyka();
		$html = $this->PrzegladanieKoszyka->PokazKoszykFull();
		return $html;	
	}
	public function PokazKoszykStatus()
	{
		$this->PrzegladanieKoszyka = new PrzegladanieKoszyka();
		$html = $this->PrzegladanieKoszyka->PokazKoszykStatus();
		return $html;
	}
	public function WyczyscKoszyk()
	{
		GlobalObj()->Koszyk()->WyczyscKoszyk();
		GlobalObj()->RefreshCookieKoszyk();
		$moduleTmp = new ModulesMgr();
		$moduleTmp->loadModule('Sklep');
		$action = $moduleTmp->getModuleActionIdByName('PokazKoszykFull');
		unset($moduleTmp);
		header("Location: ?a=$action");
	}
	public function UsunPozycjeKoszyk($idTowaru)
	{
		GlobalObj()->Koszyk()->UsunPozycje($idTowaru);
		GlobalObj()->RefreshCookieKoszyk();
		$moduleTmp = new ModulesMgr();
		$moduleTmp->loadModule('Sklep');
		$action = $moduleTmp->getModuleActionIdByName('PokazKoszykFull');
		unset($moduleTmp);
		header("Location: ?a=$action");
		
	}
	public function PrzeliczKoszyk()
	{
		//postValues - towId1=xx; il1=yy
		$ile = GlobalObj()->Koszyk()->ItemsCount();
		$i=0;
		while (GlobalObj()->Koszyk()->ItemsCount() != $i)
		{
			if (isset($_POST["towId$i"]))
			{
				GlobalObj()->Koszyk()->ZmienIloscPozycji($_POST["towId$i"], $_POST["il$i"], $_POST["ilFirm$i"]);
				GlobalObj()->RefreshCookieKoszyk();
			}
			$i++;	
		}
		//$html = $this->PokazKoszykFull();
		//return $html;
		$moduleTmp = new ModulesMgr();
		$moduleTmp->loadModule('Sklep');
		$action = $moduleTmp->getModuleActionIdByName('PokazKoszykFull');
		unset($moduleTmp);
		header("Location: ?a=$action");
	}
	
	public function DodajDoKoszyka($towarId, $iloscEgz, $iloscFirm)
	{
		$html = '';
		//echo var_dump(serialize($_SESSION['koszyk'])).'<br>';
		$koszyk = GlobalObj()->Koszyk();
		//echo var_dump(serialize($_SESSION['koszyk'])).'<br>';
		
		$konfiguracja = new Konfiguracja();
		$rezerwacje = $konfiguracja->Rezerwacje();
		if (($rezerwacje)&&(!$koszyk->ItemExists($towarId))
			||(!$rezerwacje))
			{
				$koszyk->AddTowar($towarId, $iloscEgz, $iloscFirm);
				GlobalObj()->RefreshCookieKoszyk();
			}
		$moduleTmp = new ModulesMgr();
		$moduleTmp->loadModule('Sklep');
		$action = $moduleTmp->getModuleActionIdByName('PokazKoszykFull');
		unset($moduleTmp);
		header("Location: ?a=$action");
	}
	public function DodajDoKoszykaByImg($imgName)
	{
		$idQuery = "SELECT  id FROM Towary WHERE obrazMin = '$imgName' OR obrazFull = '$imgName'";
		$DBInt = DBSIngleton::getInstance();
    	$qResult = $DBInt->ExecQuery($idQuery);
    	$data = $qResult->fetchRow(DB_FETCHMODE_ASSOC);
    	return $data['id'];
	}
//-------------------------Klient
	public function Zaloguj()
	{
		$this->ZarzadzanieKontem = new ZarzadzanieKontem();
		$html = $this->ZarzadzanieKontem->Zaloguj();
		return $html;

	}

	public function Wyloguj()
	{
		$this->ZarzadzanieKontem = new ZarzadzanieKontem();
		$html = $this->ZarzadzanieKontem->Wyloguj();
		return $html;
	}
	public function AddUser()
	{
		$this->ZarzadzanieKontem = new ZarzadzanieKontem();
		$html = $this->ZarzadzanieKontem->AddUser();
		return $html;
	}
	public function UserChangePass()
	{
		$this->ZarzadzanieKontem = new ZarzadzanieKontem();
		$html = $this->ZarzadzanieKontem->UserChangePass();
		return $html;
	}
	public function UserResetPass()
	{
		$this->ZarzadzanieKontem = new ZarzadzanieKontem();
		$html = $this->ZarzadzanieKontem->UserResetPass();
		return $html;
	}
	public function PokazKlientStatus()
	{
		$this->ZarzadzanieKontem = new ZarzadzanieKontem();
		$html = $this->ZarzadzanieKontem->PokazKlientStatus();
		return $html;
	}
	public function ShowUserPage()
	{
		$this->ZarzadzanieKontem = new ZarzadzanieKontem();
		$html = $this->ZarzadzanieKontem->ShowUserPage();
		return $html;
	}
	public function KlientShowAdmin($kryt)
	{
		$this->AdministracjaKlienci = new AdministracjaKlienci();
		return $this->AdministracjaKlienci->ShowAdmin($kryt);
	}
	public function KlientEditAdmin($id)
	{
		$this->AdministracjaKlienci = new AdministracjaKlienci();
		return $this->AdministracjaKlienci->EditAdmin($id);
	}
//-----------------------------Zamowienie
	public function ZlozZamowienie($strona)
	{
		$this->SkladanieZamowienia = new SkladanieZamowienia();
		$html = $this->SkladanieZamowienia->ZlozZamowienie($strona);
		return $html;
	}
	
	//akcja po kliknieciu w link maila lub po dokonaniu platnosci 
	public function ZatwierdzZamowienieMail($zam)
	{
		$this->SkladanieZamowienia = new SkladanieZamowienia();
		$html = $this->SkladanieZamowienia->ZatwierdzZamowienieMail($zam);
		return $html;
	}
	//automatycznie wołana akcja z esystemu platnosci
	public function PotwierdzEPlatnosc()
	{
		
	} 
	//wysyla potwierrdzenie mailem
	public function WyslijPotwirdzenie($idZam)
	{
		
	}
	
	public function PokazZamowienie($idZam)
	{
		$html = $this->SkladanieZamowienia->WyswietlZamowienie();
		return $html;
	}
	public function ZatwierdzUsr()
	{
		$this->SkladanieZamowienia = new SkladanieZamowienia();
		$html = $this->SkladanieZamowienia->ZatwierdzUsr();
		
		/*$zam = $_SESSION['Zamowienie'];
		unset($zam);
		unset ($_SESSION['Zamowienie']);*/
		
		return $html;
	}
	public function ClearZamowienie($ok)
	{
		unset($_SESSION['Zamowienie']);
		if ($ok == 1)
		{
			return '<div class="font">Dziękujemy za złożenie zamówienia na programy FINKA.<br/> Na podany adres e-mail otrzymają Państwo fakturę pro forma, uwzględniającą aktualne rabaty. Zapraszamy ponownie do e-sklepu Finka.pl.</div>';
		}
		else
		{
			return 'Zamówienie zostało anulowane. Zapraszamy ponownie.';	
		}
				
	}
	public function ClearZamowieniePlatnosci($ok)
	{
		
		$zamTmp = $_SESSION['Zamowienie'];
		$klientTmp = $zamTmp->klient;
		$sessId = $zamTmp->GetId();
		$amount = ($zamTmp->GetWartosc()+$zamTmp->GetWartoscDostawy())*100; //w groszach
		$desc = 'Platnosc za zamowienie '.$zamTmp->GetNumer().' zlozone Tiksoft';
		$desc2 = '';
		$trsDesc = '';
		$imie = $klientTmp->GetImie();
		$nazwisko = $klientTmp->GetNazwisko();
		$email = $klientTmp->GetEmail();
		$language = $_SESSION['lang'];
		
		$ip = '';
		if ( isset($_SERVER["REMOTE_ADDR"]) )    
		{
			$ip=$_SERVER["REMOTE_ADDR"] . ' ';
		} 
		else if ( isset($_SERVER["HTTP_X_FORWARDED_FOR"]) )    
		{
			$ip=$_SERVER["HTTP_X_FORWARDED_FOR"] . ' ';
		} 
		else if ( isset($_SERVER["HTTP_CLIENT_IP"]) )    
		{
			$ip=$_SERVER["HTTP_CLIENT_IP"] . ' ';
		} 
		
		$client_ip = $ip; 

		$arrArgs = array(
			'sessId' 	=> $sessId,
			'amount'	=> $amount,
			'desc' 		=> "$desc",
			'desc2'		=> "$desc2",
			'trsDesc'	=> "$trsDesc",
			'firstName'	=> "$imie",
			'lastName'	=> "$nazwisko",
			'language'	=> "$language",
			'email'		=> "$email",
			'cliIp'		=> "$client_ip"
		);
		
		//unset($_SESSION['Zamowienie']);
		if ($ok == 1)
		{
			$this->PlatnoscPL = new PlatnosciPl();

			return $this->PlatnoscPL->NewPayment($arrArgs);
			
			//return 'Dziękujemy za złożenie zamówienia na programy FINKA. W celu zrealizowania płątności, nastąpi przekierowanie na stronę Platnosci.pl. Jeżeli strona się nie otwiera, prosimy o kontakt telefoniczny z Działem Obsługi Klienta pod numerami: 22 408 48 00, 22 885 66 99.';
		}
		else
		{
			return 'Zamówienie zostało anulowane. Zapraszamy ponownie.';	
		}
				
	}
	//--------------------------ADMINISTRACJA
	public function ShowTowaryAdmin()
	{
		$this->AdministracjaTowar = new AdministracjaTowar();
		return $this->AdministracjaTowar->ShowTowary();
		unset($this->AdministracjaTowar);
	}
	
	public function AddTowarAdmin($id)
	{
		
		$this->AdministracjaTowar = new AdministracjaTowar();
		return $this->AdministracjaTowar->AddTowar($id);
		
	}
	public function DelTowar($id)
	{
		$this->AdministracjaTowar = new AdministracjaTowar();
		return $this->AdministracjaTowar->DelTowar($id);
	}
	public function ShowOfertyAdmin()
	{
		$this->AdministracjaOferta = new AdministracjaOferta();
		return $this->AdministracjaOferta->ShowOfertyAdmin();
	}
	public function AddOfertaAdmin($id)
	{
		$this->AdministracjaOferta = new AdministracjaOferta();
		return $this->AdministracjaOferta->AddOfertaAdmin($id);
		
	}
	public function ShowPrzypiszTowarOfercieAdmin($id)
	{
		$this->AdministracjaOferta = new AdministracjaOferta();
		return $this->AdministracjaOferta->ShowPrzypiszTowarOfercieAdmin($id);
		
	}
	public function DelOferta($id)
	{
		$this->AdministracjaOferta = new AdministracjaOferta();
		return $this->AdministracjaOferta->DelOferta($id);
		
	}
	public function DelOfertaDo($id)
	{
		$this->AdministracjaOferta = new AdministracjaOferta();
		return $this->AdministracjaOferta->DelOfertaDo($id);
	}
	public function ChooseMenuOferta()
	{
		
		$this->AdministracjaOferta = new AdministracjaOferta();
		return $this->AdministracjaOferta->ChooseGrupyOferta();
		 
	}
	public function ChooseTowarOferta($id)
	{
		$this->AdministracjaOferta = new AdministracjaOferta();
		return $this->AdministracjaOferta->ChooseTowarOferta($id);
	}
	public function PrzypiszTowaryDo($idOferta, $towIdArr)
	{
		
		$this->AdministracjaOferta = new AdministracjaOferta();
		return $this->AdministracjaOferta->PrzypiszTowaryDo($idOferta, $towIdArr);
	}
	public function DelPrzypisanie($id)
	{
		
		$this->AdministracjaOferta = new AdministracjaOferta();
		return $this->AdministracjaOferta->DelPrzypisanie($id);
	}
	public function towOfertaUp($id)
	{
		$this->AdministracjaOferta = new AdministracjaOferta();
		return $this->AdministracjaOferta->towOfertaUp($id);
	}
	public function towOfertaDown($id)
	{
		$this->AdministracjaOferta = new AdministracjaOferta();
		return $this->AdministracjaOferta->towOfertaDown($id);
	}
	public function configKontakt($typ)
	{
		$kreator = new KontaktKreator();
		switch($typ)
		{
			case 'rejestracja':
				{
					$kontakt = $kreator->FactoryMethod('rejestracja', 0);
					break;
				}
			case 'resetHasla':
				{
					$kontakt = $kreator->FactoryMethod('resetHasla', 0);
					break;
				}
			case 'zlozZamow':
				{
					$kontakt = $kreator->FactoryMethod('zlozenieZamowienia', 0);
					break;
				}
			case 'zmStat':
				{
					$kontakt = $kreator->FactoryMethod('zmianaStat', 0);
					break;
				}
		}
		$html = $kontakt->Config();
		return $html;
	}
	public function send($typ)
	{
		$kreator = new KontaktKreator();
		switch($typ)
		{
			case 'rejestracja':
				{
					$kontakt = $kreator->FactoryMethod('rejestracja', 1);
					break;
				}
			case 'resetHasla':
				{
					$kontakt = $kreator->FactoryMethod('resetHasla', 1);
					break;
				}
			case 'zlozZamow':
				{
					$kontakt = $kreator->FactoryMethod('zlozenieZamowienia', 1);
					break;
				}
			case 'zmStat':
				{
					$kontakt = $kreator->FactoryMethod('zmianaStat', 1);
					break;
				}
		}
		$html = $kontakt->send();
		return $html;
	}
	
	
	public function ShowKrajeAdmin()
	{
		$this->AdministracjaKraje = new AdministracjaKraje(0);
		return $this->AdministracjaKraje->ShowAdmin();
	}
	public function AddKrajAdmin($id)
	{
		$this->AdministracjaKraje = new AdministracjaKraje(0);
		return $this->AdministracjaKraje->EditAdmin($id);
	}
	public function DelKrajAdmin($id)
	{
		$this->AdministracjaKraje = new AdministracjaKraje(0);
		return $this->AdministracjaKraje->DelAdmin($id);
	}
	/**
	 * 
	 * @param unknown_type $id
	 */
	public function KrajUp($id)
	{
		$this->AdministracjaKraje = new AdministracjaKraje(0);
		return $this->AdministracjaKraje->KrajUp($id);	
	}
	public function KrajDown($id)
	{
		$this->AdministracjaKraje = new AdministracjaKraje(0);
		return $this->AdministracjaKraje->KrajDown($id);
	} 
	
	public function ShowPlatnosciAdmin()
	{
		$this->AdministracjaPlatnosci = new AdministracjaPlatnosci(0);
		return $this->AdministracjaPlatnosci->ShowAdmin();
	}
	public function AddPlatnoscAdmin($id)
	{
		$this->AdministracjaPlatnosci = new AdministracjaPlatnosci($id);
		return $this->AdministracjaPlatnosci->EditAdmin($id);
	}
	public function DelPlatnoscAdmin($id)
	{
		$this->AdministracjaPlatnosci = new AdministracjaPlatnosci(0);
		return $this->AdministracjaPlatnosci->DelAdmin($id);
	}
	public function PlatnoscUp($id)
	{
		$this->AdministracjaPlatnosci = new AdministracjaPlatnosci();
		return $this->AdministracjaPlatnosci->PlatnoscUp($id);	
	}
	public function PlatnoscDown($id)
	{
		$this->AdministracjaPlatnosci = new AdministracjaPlatnosci(0);
		return $this->AdministracjaPlatnosci->PlatnoscDown($id);
	} 
	
	public function ShowDostawyAdmin()
	{
		$this->AdministracjaDostawy = new AdministracjaDostawy(0);
		return $this->AdministracjaDostawy->ShowAdmin();
	}
	public function AddDostawaAdmin($id)
	{
		$this->AdministracjaDostawy = new AdministracjaDostawy();
		return $this->AdministracjaDostawy->EditAdmin($id);
	}
	public function DelDostawyAdmin($id)
	{
		$this->AdministracjaDostawy = new AdministracjaDostawy();
		return $this->AdministracjaDostawy->DelAdmin($id);
	}
	public function DostawaUp($id)
	{
		$this->AdministracjaDostawy = new AdministracjaDostawy();
		return $this->AdministracjaDostawy->DostawaUp($id);	
	}
	public function DostawaDown($id)
	{
		$this->AdministracjaDostawy = new AdministracjaDostawy();
		return $this->AdministracjaDostawy->DostawaDown($id);
	} 
	public function ShowZamowieniaAdmin($status, $order)
	{
		$this->AdministracjaZamowienia = new AdministracjaZamowienia();
		return $this->AdministracjaZamowienia->ShowZamowienia($status, $order); 
	}
	/**
	 * 
	 * @param unknown_type $id
	 */
		
	public function DelZamowienie($id)
	{
		$this->AdministracjaZamowienia = new AdministracjaZamowienia();
		return $this->AdministracjaZamowienia->DelZamowienie($id);
	}
	public function DelZamowienieDo($id)
	{
		$this->AdministracjaZamowienia = new AdministracjaZamowienia();
		return $this->AdministracjaZamowienia->DelZamowienieDo($id);
	}
	public function EditZamowienie($id)
	{
		$this->AdministracjaZamowienia = new AdministracjaZamowienia();
		return $this->AdministracjaZamowienia->EditZamowienie($id);
	}
	public function EditPozZam($idPoz, $idZam)
	{
		$this->AdministracjaZamowienia = new AdministracjaZamowienia();
		return $this->AdministracjaZamowienia->EditPozZam($idPoz, $idZam);
	}
	public function ShowZamowienieHistoria($id)
	{
		$this->AdministracjaZamowienia = new AdministracjaZamowienia();
		return $this->AdministracjaZamowienia->ShowZamowienieHistoria($id);
	}
	public function AnulujZamowienieAdmin($id)
	{
		$this->AdministracjaZamowienia = new AdministracjaZamowienia();
		return $this->AdministracjaZamowienia->AnulujZamowienieAdmin($id);
		
	}
	public function SendZamowienieStatus($id)
	{
		$this->AdministracjaZamowienia = new AdministracjaZamowienia();
		return $this->AdministracjaZamowienia->SendZamowienieStatus($id);
	}
	public function URLPozytywnyCallback($sessId)
	{
		if (isset($_SESSION['Zamowienie']))
		if ($sessId == $_SESSION['Zamowienie']->GetId())
			unset($_SESSION['Zamowienie']);
		$this->PlatnosciPL = new PlatnosciPL();
		return $this->PlatnosciPL->URLPozytywnyCallback($sessId);
	} 
	public function URLNegatywnyCallback($sessId, $amount, $error)
	{
		if (isset($_SESSION['Zamowienie']))
		  if ($sessId == $_SESSION['Zamowienie']->GetId())
			unset($_SESSION['Zamowienie']);
		
		$this->PlatnosciPL = new PlatnosciPL();
		return $this->PlatnosciPL->URLNegatywnyCallback($sessId, $amount, $error);
	}
	public function URLOnlineCallback($pos_id, $session_id, $ts, $sig)
	{
		
		$this->PlatnosciPL = new PlatnosciPL();
		return $this->PlatnosciPL->URLOnlineCallback($pos_id, $session_id, $ts, $sig);
	}
	public function AnulujUsr()
	{
		$this->SkladanieZamowienia = new SkladanieZamowienia();
		$html = $this->SkladanieZamowienia->AnulujUsr();
		return $html;		
	}
	public function ShowGrupyOfert()
	{
		
		$this->PrzegladanieGrupOfert = new PrzegladanieGrupOfert();
		$html = $this->PrzegladanieGrupOfert->ShowGrupyOfert();
		return $html;		
	}
	public function NaliczRabat($id)
	{
		
		if ((isset($_SESSION['Zamowienie']))&&($_SESSION['Zamowienie']->GetId()==$id))
		{
			$tmpZam = $_SESSION['Zamowienie'];
		}
		else
		{
			$tmpZam = new Zamowienie();
			$tmpZam->Load($id);
			
		}
		$tmpZam->SetStatusRabatuDoNaliczenia();
		$tmpZam->Save(false);
		if (isset($_SESSION['Zamowienie']))
			unset($_SESSION['Zamowienie']);
		
		return 'Dzękujemy za złożenie zamówienia. Po kalkulacji rabatu na podany adres e-mail zostanie przesłany link, umożliwiający finalizację procesu zakupów.';
	}
	public function ZapiszRabatIWyslij($idZam)
	{
		
		$tmpZam = new Zamowienie();
		$tmpZam->Load($idZam);
		$tmpZam->SetStatusRabatuNaliczony();
		$tmpZam->Save(false);

		$platnosc = new Platnosc();
		$platnosc->Load($tmpZam->GetPlatnosc(), $_SESSION['lang']);
		
		if ($platnosc->GetTyp() == 3)
		  $tmpZam->ZapiszRabatIWyslij();
				
		$moduleTmp = new ModulesMgr();
		$moduleTmp->loadModule('Sklep');
		$action = $moduleTmp->getModuleActionIdByName('ShowZamowieniaAdmin');
		unset($moduleTmp);
		header("Location: ?a=$action&status=0&order=desc");		
	}
	public function PokazZamPoRabacie($link)
	{
		$sql = 'SELECT id, statusRabatu, FKKlient FROM Zamowienia WHERE statusRabatu=2';
		$DBInt = DBSIngleton::getInstance();
		$dbRes = $DBInt->ExecQuery($sql);
		$id = -1;
		while($data = $dbRes->fetchRow(DB_FETCHMODE_ASSOC))
		{
			$idZam = $data['id'];
			$status = $data['statusRabatu'];
			$idKli = $data['FKKlient'];
			if (MD5($idZam.$status.$idKli)==$link)
			{
				$id = $data['id'];
				break;
			}
		}
		
		
		if ($id!= -1 )
		{
			$zam = new Zamowienie();
			$_SESSION['Zamowienie']= $zam; 
			$_SESSION['Zamowienie']->Load($id);
			$_SESSION['Zamowienie']->SetStatusRabatuKlikniety();
			
			$this->SkladanieZamowienia = new SkladanieZamowienia();
			$html = $this->SkladanieZamowienia->ZlozZamowienie('potwierdzenie');
			return $html;
		}
		else
		{
			return 'Nie znaleziono zamówienia';
		}
	} 
	public function AnkietaSend()
	{
			
			$p1 = '(waga/ocena) <br><br>1. Jak Państwo oceniają kompletność funkcji programów FINKA? <b>'. $_POST['pyt2'].'/'.$_POST['pyt1'].'</b><br>';
			$p2 = '2. Czy programy FINKA są łatwe w użytkowaniu? <b>'. $_POST['pyt4'].'/'.$_POST['pyt3'].'</b><br>';
			$p3 = '3. Czy uważają Państwo, że programy FINKA są przystępne cenowo? <b>'. $_POST['pyt6'].'/'.$_POST['pyt5'].'</b><br>';
			$p4 = '4. Jak Państwo oceniają kompetencje serwisu teleinformatycznego? <b>'. $_POST['pyt8'].'/'.$_POST['pyt7'].'</b><br>';
			$p5 = '5. Jak Państwo oceniają czas reakcji na zgłoszony problem? <b>'.$_POST['pyt10'].'/'.$_POST['pyt9'].'</b><br>';
			$p6 = '6. Jak Państwo oceniają terminowość dostarczanych aktualizacji? <b>'.$_POST['pyt12'].'/'.$_POST['pyt11'].'</b><br>';
			if (isset($_POST['pyt13']))
			{
				if ($_POST['pyt13'] == 1) {$tmpStr='Tak';} else {$tmpStr='Nie';}
			}
			else
			{
				$tmpStr = 'Nie zaznaczono';
			}
			$p7 = '<br/>7. Czy poleciliby Państwo programy FINKA? '.$tmpStr.'<br>';
			$p8 = '<br/>8. Z których programów FINKA Państwo korzystają? '.$_POST['uwagi'].'<br>';
			$p9 = '9. Uwagi i spostrzeżenia: '.$_POST['uwagi2'].'<br><br/>';
			$excel = '<span style="margin-left: 3em;">'.$_POST['pyt2'].'</span><span style="margin-left: 3em;">'.$_POST['pyt1'].'</span>'.
					'<span style="margin-left: 3em;">'.$_POST['pyt4'].'</span><span style="margin-left: 3em;">'.$_POST['pyt3'].'</span>'.
					'<span style="margin-left: 3em;">'.$_POST['pyt6'].'</span><span style="margin-left: 3em;">'.$_POST['pyt5'].'</span>'.
					'<span style="margin-left: 3em;">'.$_POST['pyt8'].'</span><span style="margin-left: 3em;">'.$_POST['pyt7'].'</span>'.
					'<span style="margin-left: 3em;">'.$_POST['pyt10'].'</span><span style="margin-left: 3em;">'.$_POST['pyt9'].'</span>'.
					'<span style="margin-left: 3em;">'.$_POST['pyt12'].'</span><span style="margin-left: 3em;">'.$_POST['pyt11'].'</span>'.
					'<span style="margin-left: 3em;">'.$tmpStr.'</span><span style="margin-left: 3em;">'.$_POST['uwagi'].'</span><span style="margin-left: 3em;">'.$_POST['uwagi2'].'</span>';
			
			$msg = $p1.$p2.$p3.$p4.$p5.$p6.$p7.$p8.$p9.$excel;
			
			$this->port=0;
			$konfiguracja = new Konfiguracja();
			$this->host = 'poczta.finka.pl';
			$this->port = 26;
			$this->username = 'klienci+finka.pl';
			$this->password = 'wirt#$252';
			$this->nadawca = 'klienci@finka.pl';
			
			$this->mailObj = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch
			$this->mailObj->IsSMTP(); // telling the class to use SMTP
								
			$this->mailObj->Host       = $this->host; // SMTP server
			$this->mailObj->SMTPDebug = 0;
			$this->mailObj->CharSet = "UTF-8";
			
			//$mail->SMTPDebug= 2;                     // enables SMTP debug information (for testing)
			$this->mailObj->SMTPAuth   = true;                  // enable SMTP authentication
			//$this->mailObj->SMTPSecure = "ssl";
			$this->mailObj->Port       = $this->port;                    // set the SMTP port for the GMAIL server
			$this->mailObj->Username   = $this->username; // SMTP account username
			$this->mailObj->Password   = $this->password;        // SMTP account password
			//$this->
			//foreach ($this->adresyArr as $adr)
			//{
			$this->mailObj->AddAddress("klienci@finka.pl");
			//}			
			
			$this->mailObj->SetFrom('klienci@finka.pl');
			$this->mailObj->Subject = 'Ankieta ze strony Finka';
    		$this->mailObj->MsgHTML($msg);
			$this->mailObj->AltBody = $msg;
			$this->mailObj->Send();

	
			return '<div class="font"> Dziękujemy za poświęcony czas.<br> Ankieta jest anonimowa, jeżeli mają Państwo pytania, prosimy o kontakt z Działem Obsługi Klienta. <div>';
	}
	public function KontaktSend()
	{
		$txt1 = 'Nazwa: '.$_POST['dane_nazwa'].'<br>';
		$txt2 = 'Telefon: '.$_POST['dane_telefon'].'<br>';
		$txt3 = 'E-mail: '.$_POST['dane_email'].'<br>';
		$txt4 = 'Pytanie: '.$_POST['dane_pytanie'].'<br>';
		
		$msg = $txt1.$txt2.$txt3.$txt4;
		$this->port=0;
		
		$konfiguracja = new Konfiguracja();
			$host = 'poczta.finka.pl';
			$port = 25;
			$username = 'finka';
			$password = '%6&Tik9';
			$nadawca = 'klienci z www.finka.pl';
			
			$this->mailObj = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch
			$this->mailObj->IsSMTP(); // telling the class to use SMTP
								
			$this->mailObj->Host       = $host; // SMTP server
			$this->mailObj->SMTPDebug = 0;
			$this->mailObj->CharSet = "UTF-8";
			
			//$mail->SMTPDebug= 2;                     // enables SMTP debug information (for testing)
			$this->mailObj->SMTPAuth   = true;                  // enable SMTP authentication
			$this->mailObj->Port       = $port;                    // set the SMTP port for the GMAIL server
			$this->mailObj->Username   = $username; // SMTP account username
			$this->mailObj->Password   = $password;        // SMTP account password
			//$this->
			//foreach ($this->adresyArr as $adr)
			//{
			$this->mailObj->AddAddress("finka@finka.pl");
			//}			
			
			$this->mailObj->SetFrom('finka@finka.pl');
			$this->mailObj->Subject = 'Pytanie ze strony Finka.pl';
                        $this->mailObj->MsgHTML($msg);
			$this->mailObj->AltBody = $msg;
			$this->mailObj->Send();

		
		
			return '<div class="font" height="200px">Dziękujemy za złożenie zapytania. Nasi Konsultanci z Działu Obsługi Kleinta skontaktują się z Państwem. <div>';
	}
        //rabat
        public function ShowRabatAdmin()
        {
            
        }
        public function GetParamNormalVerison()
        {
            $rabat = new Rabat();
            $rabat->Load();
            return $rabat->GetParamNormalVerison();
        }
        public function GetParamNetworkVersion()
        {
            $rabat = new Rabat();
            $rabat->Load();
            return $rabat->GetParamNetworkVersion();
        }
        
        public function GetParamPierwszeNormalVerison()
        {
            $rabat = new Rabat();
            $rabat->Load();
            return $rabat->GetParamPierwszeNormalVerison();
        }
        public function GetParamPierwszeNetworkVersion()
        {
            $rabat = new Rabat();
            $rabat->Load();
            return $rabat->GetParamPierwszeNetworkVerison();
        }
	
}

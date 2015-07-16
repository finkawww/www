<?php
class ZamowienieItem
{
	public $idPozycji, $towarId, $ilosc, $iloscFirm, $iloscStanowisk, $wartoscPozycji, $wartoscPozycjiNetto,$procRabatu;
	public $wartoscPozycjiNettoPrzedRabatem;
}
class Zamowienie
{

	private $idPlatnosci = 0;
	private $idDostawy = 0;
	private $uwagi = '';
	public $towary = array(); //of ZamowieniaItems
	private $numer = 0;
	private $status = 0;
	private $id = 0;
	private $dataStatusu;
	private $statusRabatu = -1;//-1 - wył, 0 - nienaliczony; 1 - do naliczenia; 2 - naliczony; 3-klikniety(zaakceptowany)
	public $klient = null;
	public $oplacone = 'N';

	public function Delete()
	{
		$id = $this->id;

		$err = false;
		$DBInt = DBSIngleton::getInstance();
		try
		{

			$queryTrans = 'START TRANSACTION';
			$queryCommit = 'COMMIT';
			$queryTowaryZam = "DELETE FROM ZamowieniaTowary WHERE FkZam=$id";
			$queryZam = "DELETE FROM Zamowienia WHERE id=$id";
			$DBInt->ExecQuery($queryTrans);
			$DBInt->ExecQuery($queryTowaryZam);
			$DBInt->ExecQuery($queryZam);
			$DBInt->ExecQuery($queryCommit);
		}
		catch (exception $e)
		{
			$exc = new ExceptionClass($e, "Zamowienie::Del($id)");
			$exc->writeException();
			$queryRollback = 'ROLLBACK';
			$DBInt->ExecQuery($queryRollback);
			$err = true;
		}
		if (!$err)
		{

			foreach($this->towary as $tow)
			{
				$towTmp = new Towar();
				$towTmp->Load($tow->towarId, 'PL');
				if ($towTmp->GetZarezerwowany())
				{
					$towTmp->SetZarezerwowany('N');
				}
				//jezeli byl wyslany i usuwamy zamowienie to zwracamy towar na magazyn
				if ($this->status > 2)
				{
					$towTmp->SetIlosc($towTmp->GetIlosc()+1);
				}
				$towTmp->Save($tow->towarId);

			}
			$log = new adminLog(0);
			$log->writeUserLog("Usunięte zamówienie ZAM$id");
		}
	}
	private function SetStatusRabatu($status)
	{
		$this->statusRabatu = $status;
	}
	public function SetStatusRabatuWyl()
	{
		$this->SetStatusRabatu(-1);
	}
	public function SetStatusRabatuNienaliczony()
	{
		$this->SetStatusRabatu(0);
	}
	public function SetStatusRabatuDoNaliczenia()
	{
		$this->SetStatusRabatu(1);
	}
	public function SetStatusRabatuNaliczony()
	{
		$this->SetStatusRabatu(2);
	}
	public function SetStatusRabatuKlikniety()
	{
		$this->SetStatusRabatu(3);
	}
	public function GetStatusRabatu()
	{
		switch($this->statusRabatu)
		{
			case -1 : {return 'wylaczony'; break;}
			case 0 :  {return 'nienaliczony'; break;}
			case 1 :  {return 'do naliczenia'; break;}
			case 2 :  {return 'naliczony'; break;}
			case 3 :  {return 'zaakceptowany'; break;}
			default : return 'wylaczony';
		}
	}
	public function GetStatusRabatuInt()
	{
		return $this->statusRabatu;
	}
	public function SetStatusRabatuZaakceptowany()
	{
		$this->SetStatusRabatu(3);
	}
	
	public function ZastosujRabat($idPozycji, $rabat)
	{
                $rabatObj = new Rabat();
                $rabatObj->Load();
		foreach($this->towary as $towar)
		{
			
			if ($towar->idPozycji == $idPozycji)
			{
				
				$konfiguracja = new Konfiguracja();
				$towarTmp = new Towar();
				$towarTmp->Load($towar->towarId, 'PL');
				
                                if(!$rabatObj->GetRabatEnabled())
                                {
                                    $towar->procRabatu = $rabat;
                                    $towar->wartoscPozycjiNetto = $towarTmp->GetCena($towar->iloscStanowisk, $towar->iloscFirm)*(1-$rabat/100);
                                    $towar->wartoscPozycji = $towar->wartoscPozycjiNetto * (1+$konfiguracja->GetStawkaVat()/100);
                                }
                                else
                                {
                                    $towar->procRabatu = $rabat;
                                    $towar->wartoscPozycjiNetto = $towarTmp->GetCenaParams($towar->iloscStanowisk, $towar->iloscFirm)*(1-$rabat/100);
                                    $towar->wartoscPozycji = $towar->wartoscPozycjiNetto * (1+$konfiguracja->GetStawkaVat()/100);
                                }   
								
				break;
			}
		}
	}
	public function ZapiszRabatIWyslij()
	{
		$kontaktFact = new KontaktKreator();
		$kontakt = $kontaktFact->FactoryMethod('wysylanieRabatu', $this->id);
		$kontakt->Send();
		 
	}
	public function Save($new)
	{
		$idKli = 0;
		//$nowe = ($this->id == 0);
		$admin = 0;

		if (isset($_SESSION['adminId']))
		{
			$admin = $_SESSION['adminId'];
		}
		
		if (isset($_SESSION['klient']) && ($_SESSION['klient']>0))
		{

			if ($new == true)
			{
			
				$this->klient->Save($_SESSION['klient'], false);
				

			}
			$idKli = $_SESSION['klient'];

		}
		else
		{

			if ($new == true)
			{
			
				$idKli = $this->klient->Save(0, true);
				$this->klient->SetId($idKli);
			
			}
			else
			{
				$idKli = $this->klient->GetId();
			}
		}

		/*else
		 {
			$idKli = $this->klient->GetId();

			}*/

		//teraz selecty z id i uwagami i koniec

		$insid = session_id();
		$dostawa = $this->idDostawy;
		$platnosc = $this->idPlatnosci;
		$uwagi = $this->uwagi;
		$status = $this->status;
		$oplacone = $this->oplacone;
		$dataStatusu = $this->dataStatusu;
		$statusRabatu = $this->statusRabatu;
		$newStat = date('Y-m-d H:i:s');

		if ($new == true)
		{
			$query = "
			INSERT INTO Zamowienia(FKKlient, FkDostawa, FKPlatnosci, insid, Uwagi, status, dataStatusu, adminId, oplacone, statusRabatu)
			VALUES
			($idKli, $dostawa, $platnosc, '$insid', '$uwagi', $status, '$newStat', $admin, '$oplacone', $statusRabatu)
			";
			
		}
		else
		{
			if (isset($_SESSION['adminId']))
			{
				$userId = $_SESSION['adminId'];
			}
			else
			{
				$userId = 0;
			}
			$id = $this->id;
			$query =
			"
				UPDATE Zamowienia SET
					FKKlient = $idKli,
					FkDostawa = $dostawa,
					FKPlatnosci = $platnosc,
					insid='$insid', 
					Uwagi = '$uwagi', 
					status = $status,
					oplacone = '$oplacone',
					dataStatusu = '$dataStatusu',
					statusRabatu = $statusRabatu,
					adminId = $userId
				WHERE id=$id
			";
		}
		
		$DBInt = DBSIngleton::getInstance();
		$DBInt->ExecQuery($query);
		
		$querySelect = "SELECT id FROM Zamowienia WHERE insid='$insid'";
		$dbRes = $DBInt->ExecQuery($querySelect);
		$data = $dbRes->fetchRow(DB_FETCHMODE_ASSOC);
		$idZam = $data['id'];
		$this->id = $idZam;
		
		$queryUpdate = "UPDATE Zamowienia SET insid='' WHERE id=$idZam";
		$DBInt->ExecQuery($queryUpdate);

		//inserting ZamowieniaTowary
		if ($new == true)
		{
                        
			foreach($this->towary as $towar)
			{
				$ilosc = $towar->ilosc;
				$id = $towar->towarId;
				$iloscFirm = $towar->iloscFirm;
				$iloscStanowisk = $towar->iloscStanowisk;
				
                                $wartoscPozycji = $towar->wartoscPozycji;
				$wartoscPozycjiNetto = $towar->wartoscPozycjiNetto;
				$wartoscPozycjiNettoPrzedRabatem = $towar->wartoscPozycjiNettoPrzedRabatem;
				$procRabatu = 0;//$towar->procRabatu;
				

				$queryInsTow = "
				INSERT INTO ZamowieniaTowary (FkZam, FkTow, ilosc, iloscFirm, iloscStanowisk, wartoscPozycji, wartoscPozycjiNetto,wartoscPozycjiNettoPrzedRabatem, procRabatu) VALUES
				($idZam, $id, $ilosc, $iloscFirm, $iloscStanowisk, $wartoscPozycji, $wartoscPozycjiNetto,$wartoscPozycjiNettoPrzedRabatem, $procRabatu)";
					
				$DBInt->ExecQuery($queryInsTow);
			}
		
		}
		else
		{
			foreach($this->towary as $towar)
			{
				$ilosc = $towar->ilosc;
				$id = $towar->towarId;
				$iloscFirm = $towar->iloscFirm;
				$iloscStanowisk = $towar->iloscStanowisk;
				$wartoscPozycji = $towar->wartoscPozycji;
				$wartoscPozycjiNetto = $towar->wartoscPozycjiNetto;
				$wartoscPozycjiNettoPrzedRabatem = $towar->wartoscPozycjiNettoPrzedRabatem;
				$procRabatu = $towar->procRabatu;
				

				$queryUpdTow = "
				UPDATE ZamowieniaTowary SET
				ilosc=$ilosc, 
				iloscFirm=$iloscFirm, 
				iloscStanowisk=$iloscStanowisk, 
				wartoscPozycji=$wartoscPozycji, 
				wartoscPozycjiNetto=$wartoscPozycjiNetto,
				wartoscPozycjiNettoPrzedRabatem=$wartoscPozycjiNettoPrzedRabatem, 
				procRabatu=$procRabatu
				WHERE FkZam=$idZam and FkTow=$id 
				";
				 		
				$DBInt->ExecQuery($queryUpdTow);
			}
		}


	}

	public function ZmienStatus($status)
	{
		$this->status = $status;
		$this->dataStatusu =date('Y-m-d H:i:s');
	}
	public function Load($id)
	{
		//wczytuje wszysktie pola

		$this->id = $id;

		$DBInt = DBSIngleton::getInstance();

		$queryCount = "SELECT count(1)as ile FROM Zamowienia WHERE id=$id";
		$tmpRes = $DBInt->ExecQuery($queryCount);
		$dataTmp = $tmpRes->fetchRow(DB_FETCHMODE_ASSOC);
		if ($dataTmp['ile']>0)
		{

			$query = "SELECT * FROM Zamowienia WHERE id=$id";

			$dbRes = $DBInt->ExecQuery($query);
			$data = $dbRes->fetchRow(DB_FETCHMODE_ASSOC);

			$this->idPlatnosci = $data['FKPlatnosci'];
			$this->idDostawy = $data['FkDostawa'];
			$this->uwagi = $data['Uwagi'];
			$this->status = $data['status'];
			$this->oplacone = $data['oplacone'];
			$this->dataStatusu = $data['dataStatusu'];
			$this->statusRabatu = $data['statusRabatu'];
			$kliId = $data['FKKlient']; 
				
			$this->klient = new Klient();
			$this->klient->LoadById($kliId);

			//pobieram towary
			$queryTowary = "SELECT * FROM ZamowieniaTowary WHERE FkZam=$id";
			$dbRes2 = $DBInt->ExecQuery($queryTowary);

			while($data2 = $dbRes2->fetchRow(DB_FETCHMODE_ASSOC))
			{
                            
				$zamItem = new ZamowienieItem();
				$zamItem->idPozycji = $data2['id'];
				$zamItem->towarId = $data2['FkTow'];
				$zamItem->ilosc = $data2['ilosc'];
				$zamItem->iloscFirm = $data2['iloscFirm'];
				$zamItem->iloscStanowisk = $data2['iloscStanowisk'];
				$zamItem->wartoscPozycji = $data2['wartoscPozycji'];
				$zamItem->wartoscPozycjiNetto = $data2['wartoscPozycjiNetto'];
				$zamItem->wartoscPozycjiNettoPrzedRabatem = $data2['wartoscPozycjiNettoPrzedRabatem'];
				$zamItem->procRabatu = $data2['procRabatu'];
				$this->towary[]=$zamItem;
                                
			}
			return true;
		}
		else
		{
			return false;
		}


		//$this->klient
	}
	public function SetPlatnosc($idPlatnosci)
	{
		$this->idPlatnosci = $idPlatnosci;
	}
	public function GetPlatnosc()
	{
		return $this->idPlatnosci;
	}
	public function SetDostawa($idDostawy)
	{
		$this->idDostawy = $idDostawy;
	}
	public function GetDostawa()
	{
		return $this->idDostawy;
	}
	public function SetUwagi($uwagi)
	{
		$this->uwagi = $uwagi;
	}
	public function GetUwagi()
	{
		return $this->uwagi;
	}
	public function AddTowar($id, $ilosc, $iloscStanowisk, $iloscFirm)
	{
		$item = new ZamowienieItem();
		$item->towarId = $id;
		$item->ilosc = $ilosc;
		$item->iloscStanowisk = $iloscStanowisk;
		$item->iloscFirm = $iloscFirm;
		$towarTmp = new Towar();
		$towarTmp -> Load($id, $_SESSION['lang']);
		$konfiguracja = new Konfiguracja(); 
                $rabat = new Rabat();
                $rabat->Load();
                
                if(!$rabat->GetRabatEnabled())
                {
                    
                    $item->wartoscPozycji = $towarTmp->GetCena($iloscStanowisk, $iloscFirm)*(1+$konfiguracja->GetStawkaVat()/100);
                    $item->wartoscPozycjiNetto = $towarTmp->GetCena($iloscStanowisk, $iloscFirm);
                    $item->wartoscPozycjiNettoPrzedRabatem = $towarTmp->GetCena($iloscStanowisk, $iloscFirm);
                }
                else
                {
                    
                    $item->wartoscPozycji = $towarTmp->GetCenaParams($iloscStanowisk, $iloscFirm)*(1+$konfiguracja->GetStawkaVat()/100);
                    $item->wartoscPozycjiNetto = $towarTmp->GetCenaParams($iloscStanowisk, $iloscFirm);
                    $item->wartoscPozycjiNettoPrzedRabatem = $towarTmp->GetCenaParams($iloscStanowisk, $iloscFirm);
                }
                                
		$item->procRabatu =0;
		$this->towary[] =  $item;
		
	}
	public function GetTowar()
	{
		return $this->towary;
	}
	public function GetTowarByIdx($i)
	{
		return $this->towary[$i];
	}
	public function TowaryCount()
	{
		return count($this->towary);
	}
	public function GetId()
	{
		return $this->id;
	}
	public function GetKlient()
	{
		return $this->klient;
	}
	public function SetKlient($id)
	{
		$zamKlient = new Klient();
		$klient->LoadById($id);
		$this->klient = $klent;
	}
	public function SetNumer($numer)
	{
		//$this->numer = $numer;
	}

	public function GetNumer()
	{
		return 'ZAM'.$this->id;
	}
	public function GetStatus()
	{
		return $this->status;
	}
	public function GetDataStatusu()
	{
		return $this->dataStatusu;
	}
	public function GetWartosc($netto = false)
	{
		$wartosc = 0;
		$konfiguracja = new Konfiguracja();
		foreach($this->towary as $tow)
		{
			$tmpTow = new Towar();
			$tmpTow->Load($tow->towarId, 'PL');
			if ($netto == true)
			{
			  $wartosc += $tow->wartoscPozycjiNetto;//$tmpTow->GetCena($tow->iloscStanowisk, $tow->iloscFirm);
			}
			else
			{
				$wartosc += $tow->wartoscPozycji;//$tmpTow->GetCena($tow->iloscStanowisk, $tow->iloscFirm)*(1+$konfiguracja->GetStawkaVat()/100);
			}
			
			//$wartosc += $cena*$tow->ilosc;
		}
		
		return $wartosc;
	}
	public function GetWartoscDostawy()
	{
		$tmpDost = new Dostawa();
		$tmpDost->Load($this->idDostawy, 'PL');
		return  $tmpDost->GetCena();
	}
	
	public function GetOplacone()
	{
		return $this->oplacone;
	}
	public function SetOplacone($oplacone)
	{
		$this->oplacone = $oplacone;
	}


}
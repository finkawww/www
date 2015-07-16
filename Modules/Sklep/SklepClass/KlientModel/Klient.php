<?php
class Klient
{
	private $imie, $nazwisko, $idKraj, $miasto, $ulica, $nrDomu, $nrMieszkania, 
			$email, $kodPocztowy, $nrTel, $nrTel2, $czyFirma, $nazwaFirmy, $nip,
			$fakturaImie, $fakturaNazwisko,
			$fakturaIdKraj, $fakturaMiasto, $fakturaUlica, $fakturaNrDomu, $fakturaNrMieszkania, 
			$fakturaEmail, $fakturaKodPocztowy, $fakturaNrTel, $fakturaNrTel2, $fakturaCzyFirma, 
			$fakturaNazwaFirmy, $fakturaNip, $login, $pass, $tmpPass,
			$id;
	
	//gettery i settery
	public function GetId()
	{
		return $this->id;	
	}
	public function SetId($id)
	{
		$this->id = $id;
	}		
	
	public function GetLogin()
	{
		return $this->login;
	}
	public function GetPass()
	{
		return $this->pass;
	}
	public function GetTmpPass()
	{
		return $this->tmpPass;
	}
	public function GetImie()
	{
		return $this->imie;	
	}
	public function GetNazwisko()
	{
		return $this->nazwisko;	
	}
	public function GetKraj()
	{
		return $this->idKraj;
	}
	public function GetMiasto()
	{
		return $this->miasto;
	}
	public function GetUlica()
	{
		return $this->ulica;
	}
	public function GetNrDomu()
	{
		return $this->nrDomu;
	}
	public function GetNrMieszkania()
	{
		return $this->nrMieszkania;
	}
	public function GetEmail()
	{
		return $this->email;
	}
	public function GetKodPocztowy()
	{
		return $this->kodPocztowy;
	}
	public function GetNrTel()
	{
		return $this->nrTel;	
	}
	public function GetNrTel2()
	{
		return $this->nrTel2;
	}
	public function GetCzyFirma()
	{
		return $this->czyFirma;	
	}
	public function GetNazwaFirmy()
	{
		return $this->nazwaFirmy;
	}
	public function GetNip()
	{
		return $this->nip;
	}
	
	public function GetFakturaImie()
	{
		return $this->fakturaImie;	
	}
	public function GetFakturaNazwa()
	{
		return $this->fakturaNazwaFirmy;
	}
	public function GetFakturaNIP()
	{
		return $this->fakturaNip;
	}
	public function GetFakturaNazwisko()
	{
		return $this->fakturaNazwisko;	
	}
	 
	public function GetFakturaKraj()
	{
		return $this->fakturaIdKraj;	
	}
	public function GetFakturaMiasto()
	{
		return $this->fakturaMiasto;
	}
	public function GetFakturaUlica()
	{
		return $this->fakturaUlica;
	}
	public function GetFakturaNrDomu()
	{
		return $this->fakturaNrDomu;	
	}
	public function GetFakturaNrMieszkania()
	{
		return $this->fakturaNrMieszkania;
	}
	public function GetFakturaEmail()
	{
		return $this->fakturaEmail;
	}
	public function GetFakturaKodPocztowy()
	{
		return $this->fakturaKodPocztowy;
	}
		
	public function GetFakturaNrTel()
	{
		
	}
	public function GetFakturaNrTel2()
	{
		
	}
	
	public function GetUserIdByLoginAndPass($login, $pass)
	{
		
	}
	
	public function SetImie($imie)
	{
		$this->imie = $imie; 
	}
	public function SetNazwisko($nazwisko)
	{
		$this->nazwisko = $nazwisko;
	}
	public function SetKrajId($id)
	{
		$this->idKraj = $id;
	}
	public function SetMiasto($miasto)
	{
		$this->miasto = $miasto;
	}
	public function SetUlica($ulica)
	{
		$this->ulica = $ulica;
	}
	public function SetNrDomu($nrDomu)
	{
		$this->nrDomu = $nrDomu;
	}
	public function SetNrMieszkania($nrMieszkania)
	{
		$this->nrMieszkania = $nrMieszkania;
	}
	public function SetEmail($email)
	{
		$this->email = $email;	
	}
	public function SetKodPocztowy($kodPocztowy)
	{
		$this->kodPocztowy = $kodPocztowy;
	}
	public function SetNrTel($nrTel)
	{
		$this->nrTel = $nrTel;
	}
	public function SetNrTel2($nrTel2)
	{
		$this->nrTel2 = $nrTel2;
	}
	public function SetCzyFirma($czyFirma)
	{
		$this->czyFirma = $czyFirma;
	}
	public function SetNazwaFirmy($nazwaFirmy)
	{
		$this->nazwaFirmy = $nazwaFirmy;
	}
	public function SetNip($nip)
	{
		$this->nip = $nip;
	}
	public function SetFakturaImie($imie)
	{
		$this->fakturaImie = $imie; 
	}
	public function SetFakturaNazwa($nazwa)
	{
		$this->fakturaNazwaFirmy = $nazwa;
	}
	public function SetFakturaNIP($NIP)
	{
		$this->fakturaNip = $NIP;
	}
	public function SetFakturaNazwisko($nazwisko)
	{
		$this->fakturaNazwisko = $nazwisko;	
	}
	public function SetFakturaKrajId($krajId)
	{
		$this->fakturaIdKraj = $krajId;	
	}
	public function SetFakturaMiasto($miasto)
	{
		$this->fakturaMiasto = $miasto;
	}
	public function SetFakturaUlica($ulica)
	{
		$this->fakturaUlica = $ulica;
	}
	public function SetFakturaNrDomu($nrDomu)
	{
		$this->fakturaNrDomu = $nrDomu; 
	}
	public function SetFakturaNrMieszkania($nrMieszkania)
	{
		$this->fakturaNrMieszkania = $nrMieszkania;		
	}
	public function SetFakturaEmail()
	{
	
	}
	public function SetFakturaKodPocztowy($kod)
	{
		$this->fakturaKodPocztowy = $kod;
	}
	public function SetFakturaNrTel()
	{
		
	}
	public function SetFakturaNrTel2()
	{
		
	}
	public function SetFakturaCzyFirma($czyFirma)
	{
		$this->fakturaCzyFirma = $czyFirma;	
	}
	public function SetUserIdByLoginAndPass($login, $pass)
	{
		
	}
	public function SetLogin($login)
	{
		$this->login = $login;
	}
	public function SetPass($pass)
	{
		$this->pass = $pass;	
	}
	public function SetTmpPass($tmpPass)
	{
		$this->tmpPass = $tmpPass;	
	}
	public function LoadById($id)
	{
		$ofertaQuery = 
		'
			SELECT
			`id`, `imie`, `nazwisko`, `krajId`, `miasto`, `ulica`, 
			`nrDomu`, `nrMieszkania`, `email`, `kodPocztowy`, `nrTel`, 
			`nrTel2`, `czyFirma`, `nazwaFirmy`, `nip`, `login`, `pass`, `tmpPass`,
			
			`dostImie`, `dostNazwisko`, `dostKrajId`, `dostMiasto`, `dostUlica`, 
			`dostNrDomu`, `dostNrMieszkania`,`dostKodPocztowy`, `dostNazwaFirmy`, `dostNip`
			FROM 
				Klienci 
			WHERE id = '.$id;
		
		$DBInt = DBSIngleton::getInstance();
    	$qResult = $DBInt->ExecQuery($ofertaQuery);
    	$data = $qResult->fetchRow(DB_FETCHMODE_ASSOC);
    	$this->id = $id;
    	$this->imie = $data['imie'];
    	$this->nazwisko = $data['nazwisko'];
    	$this->idKraj = $data['krajId'];
    	$this->miasto = $data['miasto'];
    	$this->ulica = $data['ulica'];
    	$this->nrDomu = $data['nrDomu'];
    	$this->nrMieszkania = $data['nrMieszkania'];
    	$this->email = $data['email'];
    	$this->kodPocztowy = $data['kodPocztowy'];
    	$this->nrTel = $data['nrTel'];
    	$this->nrTel2 = $data['nrTel2'];
    	$this->czyFirma = $data['czyFirma'];
    	$this->nazwaFirmy = $data['nazwaFirmy'];
    	$this->nip = $data['nip'];
    	$this->login = $data['login'];
    	$this->pass = $data['pass'];
    	$this->tmpPass = $data['tmpPass'];

    	$this->fakturaImie = $data['dostImie'];
    	$this->fakturaNazwisko = $data['dostNazwisko'];
    	$this->fakturaIdKraj = $data['dostKrajId'];
    	$this->fakturaMiasto = $data['dostMiasto'];
    	$this->fakturaUlica = $data['dostUlica'];
    	$this->fakturaNrDomu = $data['dostNrDomu'];
    	$this->fakturaNrMieszkania = $data['dostNrMieszkania'];
    	$this->fakturaKodPocztowy = $data['dostKodPocztowy'];
    	$this->fakturaNazwaFirmy = $data['dostNazwaFirmy'];
    	$this->fakturaNip = $data['dostNip'];
    	
	}
	public function Save($id, $needId = false)
	{
		$pass = $this->pass;
		$query = '';
		if ($id == 0)
		{
			//insert
			if ($needId)
			{
				$insid = session_id();
			}
			else
			{
				$insid = 0;
			}
				
			$query = "
			INSERT INTO Klienci
			(`imie`, `nazwisko`, `krajId`, `miasto`, `ulica`, 
			`nrDomu`, `nrMieszkania`, `email`, `kodPocztowy`, `nrTel`, 
			`nrTel2`, `nazwaFirmy`, `nip`, `login`, `pass`, `tmpPass`,
			`dostImie`, `dostNazwisko`, `dostKrajId`, `dostMiasto`, `dostUlica`, 
			`dostNrDomu`, `dostNrMieszkania`, `dostKodPocztowy`,`dostNazwaFirmy`, `dostNip`, 
			`insid`)
			VALUES
			(
			'$this->imie', 
    		'$this->nazwisko', 
    		$this->idKraj, 
    		'$this->miasto', 
    		'$this->ulica', 
    		'$this->nrDomu', 
    		'$this->nrMieszkania',
    		'$this->email', 
    		'$this->kodPocztowy',
    		'$this->nrTel', 
	    	'$this->nrTel2' ,
	    	'$this->nazwaFirmy',
    		'$this->nip', 
	    	'$this->login', 
    		'$pass',
    		'$this->tmpPass',
    		
    		'$this->fakturaImie', 
    		'$this->fakturaNazwisko', 
    		$this->fakturaIdKraj, 
    		'$this->fakturaMiasto', 
    		'$this->fakturaUlica', 
    		'$this->fakturaNrDomu', 
    		'$this->fakturaNrMieszkania',
    		'$this->fakturaKodPocztowy',
    		'$this->fakturaNazwaFirmy',
    		'$this->fakturaNip',  		
    		'$insid'  
			)";
    		
			
		}
		else
		{
			$query = "
			UPDATE `Klienci` SET
			`imie`='$this->imie', 
    		`nazwisko`='$this->nazwisko', 
    		`krajId`=$this->idKraj, 
    		`miasto`='$this->miasto', 
    		`ulica`='$this->ulica', 
    		`nrDomu`='$this->nrDomu', 
    		`nrMieszkania`='$this->nrMieszkania',
    		`email`='$this->email', 
    		`kodPocztowy`='$this->kodPocztowy',
    		`nrTel`='$this->nrTel', 
	    	`nrTel2`='$this->nrTel2' ,
	    	`nazwaFirmy`='$this->nazwaFirmy',
    		`nip`='$this->nip', 
	    	`login`='$this->login', 
    		`pass`='$pass',  
			`tmpPass`='$this->tmpPass',
    		
    		`dostImie`='$this->fakturaImie', 
    		`dostNazwisko`='$this->fakturaNazwisko', 
    		`dostKrajId`=$this->fakturaIdKraj, 
    		`dostMiasto`='$this->fakturaMiasto', 
    		`dostUlica`='$this->fakturaUlica', 
    		`dostNrDomu`='$this->fakturaNrDomu', 
    		`dostNrMieszkania`='$this->fakturaNrMieszkania',
    		`dostKodPocztowy`='$this->fakturaKodPocztowy',
    		`dostNazwaFirmy`='$this->fakturaNazwaFirmy',
    		`dostNip`='$this->fakturaNip' 
	    	    		
			WHERE `id`=$id";
			
		}
	
		try
		{
			
			if (!$needId)
			{
				$DBInt = DBSIngleton::getInstance();
				$DBInt->ExecQuery($query);
				return 0;
			}
			else
			{
				if ($id == 0) //dla ins
				{
					
					$DBInt = DBSIngleton::getInstance();
										
					$DBInt->ExecQuery($query);

					
					$querySelect = "SELECT id FROM Klienci WHERE insid='$insid'";
					$dbRes = $DBInt->ExecQuery($querySelect);
					$data = $dbRes->fetchRow(DB_FETCHMODE_ASSOC);
					$idKli = $data['id'];
					
					$queryUpdate = "UPDATE Klienci SET insid='' WHERE id=$idKli";
					$DBInt->ExecQuery($queryUpdate);
					return $idKli;
				}
				else //dla upd
				{
					
					$DBInt = DBSIngleton::getInstance();
					$DBInt->ExecQuery($query);
					return $id;
				}
			}
			
			
		}
		catch(exception $e)
		{
			$exc = new ExceptionClass($e, 'Klient->Save;');
			$exc->writeException();
			/*$dialog = new dialog('Edycja użytkownika', 'Wystąpiły problemy. Dane nie zostały zmienione!', 'info', 200, 100);
	 		$dialog->setAlign('alert');
 			$dialog->setOkAction($action);
 			$dialog->setOkCaption('Ok');
 			$html .=$dialog->show(1);*/
			$html = 'Wystąpił błąd krytyczny podczas zapisu danych klienta.';
 			echo $exc->UserErrorForm($html);
		}
		
	}
	
}
?>
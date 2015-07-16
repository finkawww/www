<?php
/**
 *
 * @author Piotr Briodziński
 * Klasa opakowująca komunikację z Platnosci.pl
 * Uwaga! sess_id = zamowienieId
 *
 */

class PlatnosciPL
{

	private $session_id = '';

	private function AddInfo($info)
	{
		try
		{
			//wstawia do bd komunikat do odpowiedniego zamowienia
			//wysyla maila do operatora - z nr zamowienia
			$sqlChk = "SELECT count(1) AS ile FROM PlatnosciMesg WHERE FK_Zamowienia = $this->session_id";
			$DBInt = DBSIngleton::getInstance();
			$tmpRes = $DBInt->ExecQuery($sqlChk);
			$dataTmp = $tmpRes->fetchRow(DB_FETCHMODE_ASSOC);
			if ($dataTmp['ile']>0)
			{
					$query="UPDATE 
								PlatnosciMesg 
							SET
								mesg='$info'
							WHERE
								FK_Zamowienia = $this->session_id
							";
			}
			else
			{
					$query="INSERT INTO PlatnosciMesg(mesg, FK_Zamowienia) 
							VALUES('$info', $this->session_id)";
			}
			$DBInt->ExecQuery($query);
		}
		catch(Exception $e)
		{
			$exc = new ExceptionClass($e, 'PlatnosciPL::AddInfo; '.$query);
			$exc->WriteException();	
		}
	}
	private function SaveStatusZatw()
	{
		//zapisuje zamowienie do bd
		$zam = new Zamowienie();
		if ($zam->Load($this->GetSessionId()))
		{
			if ($zam->GetStatus() < 1)
			{
				$zam->ZmienStatus(1);
				$zam->SetOplacone('T');
				$zam->Save(false);
				$kontaktOperator = new KontaktOperator();
				$kontaktOperator->Send("Potwierdzenie zamowienia ZAM$this->session_id", "Zamówienie ZAM$this->session_id zostało potwierdzone [przez Platnosci.pl]");
			}
		}
		else
		{
			$log = new adminLog(null);
			$log->writeErrorLog('Proba potwierdzenia przez platnosci.pl nieistniejącego zamowienia '.$this->GetSessionId());
			$kontaktOperator = new KontaktOperator();
			$kontaktOperator->Send('Informacja od Platnosci.pl', 'Proba potwierdzenia przez platnosci.pl nieistniejącego zamowienia '.$this->GetSessionId());
				
		}
		unset($zam);
	}

	public function __construct()
	{
		require_once './Modules/Sklep/SklepClass/PlatnosciPL/Private/Private.php';
	}
	public function SetSessionId($sessId)
	{
		$this->session_id = $sessId;
	}
	public function GetSessionId()
	{
		return $this->session_id;
	}

	/**
	 *
	 * @param assoc $arrArgs - tablica asocjacyjna argumentów
	 */
	public function NewPayment($arrArgs)
	{
		$newPayment = new Payment();

		return $newPayment->SendNewPayment($arrArgs);
	}
	public function URLPozytywnyCallback()
	{
		return 'Dziekujemy za zakupy.';
	}
	public function URLNegatywnyCallback($sessId, $amount, $error)
	{
		//echo 'errrrr';
		$tx = 'Przykro nam, transakcja nie została zakończona pozytywnie. <br/>';
		$err = new ErrorCodes();
		$tx .= $err->GetOpis($error);

		$logTxt = $err->GetOpis($error)."; sesja:$sessId; kwota:$amount; errnr:$error";
		$log = new adminLog(null);
		$log->writeErrorLog($logTxt);
		return $tx;


	}
	/**
	 * Metoda wywołuje metodę pytającą o stan - na jej podstawie podejmujemy decyzje
	 */
	public function URLOnlineCallback($pos_id, $session_id, $ts, $sig)
	{
		$this->SetSessionId($session_id);
		try
		{
			$statusObj = new Status();
			if ($statusObj->CheckSigOnlineCallback($pos_id, $session_id, $ts, $sig))
			{
				//1.wysylam "OK"

				echo 'OK';

				//2.wysylam pytanie o status


				$this->PaymentGetStatus();
				//return $result;

			}
			else
			{
				throw new Exception('Błędna sygnatura onlineCallback');
			}

		}
		catch(Exception $e)
		{
			$this->AddInfo('Błąd podczas wywołania Callback::Online. ['.$e->GetMessage().']');
			$exc = new ExceptionClass($e, 'PlatnosciPL::URLOnlineCallback');
			$exc->WriteException();
			return '';
		}
	}
	public function PaymentGetStatus()
	{
		try
		{
			$status = 0;
			if ($this->session_id=='')
			{
				throw new Exception('sess_id niezainicjalizowana');
			}

			$statusObj = new Status();
			$statusObj->Ask($this->GetSessionId());

			//odpowiedzi
			$statusMsg = $statusObj->GetMsgStatus();
			if ($statusMsg == 'ERROR')
			{
				$errNr = $statusObj->GetErrorNr();
				$errObj = new ErrorCodes();
				$errTx = $errObj->GetOpis($errNr);

				$info="Platnosci.pl wysłały potwierdzenie o błędzie: (nr $errNr) $errTx - zamówienie ZAM$this->session_id";
				$this->AddInfo($info);
				$kontaktOperator = new KontaktOperator();
				$kontaktOperator->Send('Informacja od Platnosci.pl', $info);
			}
			else
			{
				$status = $statusObj->GetStatus();
					

				if ($status == 99)
				{
					$stat_txt = $statusObj->GetStatusSlownie($status);
					$info = "Platnosci.PL potwierdziły status: (nr $status) $stat_txt - zamówienie ZAM$this->session_id";
					$this->AddInfo($info);
					$this->SaveStatusZatw();
					$kontaktOperator = new KontaktOperator();
					$kontaktOperator->Send('Informacja od Platnosci.pl', $info);

				}
				else
				{
					$stat_txt = $statusObj->GetStatusSlownie($status);
					$info = "Platnosci.PL potwierdziły status: (nr $status) $stat_txt - zamówienie ZAM$this->session_id";
					$this->AddInfo($info);
					$kontaktOperator = new KontaktOperator();
					$kontaktOperator->Send('Informacja od Platnosci.pl', $info);

				}
			}

		}
		catch(Exception $e)
		{
			$exc = new ExceptionClass($e, 'PlatnosciPL::PaymentGetStatus');
			$exc->writeException();
		}
	}

}
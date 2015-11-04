<?php

class Status
{
	private $ASK_URL = 'https://www.platnosci.pl/paygw/UTF/Payment/get/xml';
	private $PAYMENT_URL = 'https://www.platnosci.pl/paygw/UTF/NewPaymentl';

	private $KEY1 = 'fb3636767499b0cc18813addd4c396ba';
	private $KEY2 = '5a3a288586251528f6548507fbe89792';
	private $pos_id = 106622; //wymagane
	private $pos_auth_key = 'hutkr6d';//str{7,7}, wymagane

	private $xmlContent='';
	private $msg_status;
	private $session_id;
	private $order_id;
	private $amount;
	private $status;
	private $pay_type;
	private $pay_gw;
	private $desc;
	private $desc2;
	private $create;
	private $init;
	private $sent;
	private $recv;
	private $cancel;
	private $auth_fraud;
	private $ts;
	private $sig;
	private $error_nr;

	private function StatusResponse()
	{
		try
		{
			if ($this->xmlContent=='')
			{
				throw new Exception('Status::StatusReponse - xmlFile is null');
			}
			
			$xmlDoc = simplexml_load_string($this->xmlContent);
			$msgstatus = $xmlDoc->xpath('/response/status');
			$posid = $xmlDoc->xpath('/response/trans/pos_id');
			$sessionid = $xmlDoc->xpath('/response/trans/session_id');
			$orderid = $xmlDoc->xpath('/response/trans/order_id');
			$amount = $xmlDoc->xpath('/response/trans/amount');
			$status = $xmlDoc->xpath('/response/trans/status');
			
			$paytype = $xmlDoc->xpath('/response/trans/pay_type');
			$paygw = $xmlDoc->xpath('/response/trans/pay_gw');
			$desc = $xmlDoc->xpath('/response/trans/desc');
			$desc2 = $xmlDoc->xpath('/response/trans/desc2');
			$create = $xmlDoc->xpath('/response/trans/create');
			$init = $xmlDoc->xpath('/response/trans/init');
			$sent = $xmlDoc->xpath('/response/trans/sent');
			$recv = $xmlDoc->xpath('/response/trans/recv');
			$cancel = $xmlDoc->xpath('/response/trans/cancel');
			$authfraud = $xmlDoc->xpath('/response/trans/auth_fraud');
			
			$ts = $xmlDoc->xpath('/response/trans/ts');
			$sig = $xmlDoc->xpath('/response/trans/sig');
				
			$errornr = $xmlDoc->xpath('/response/error/nr');
			
			$this->msg_status = $msgstatus[0];
			$this->pos_id = $posid[0];
			$this->session_id = $sessionid[0];
			$this->order_id = $orderid[0];
			$this->amount = $amount[0];
			$this->status = $status[0];
			$this->pay_type = $paytype[0];
			$this->pay_gw = $paygw[0];
			$this->desc = $desc[0];
			$this->desc2 = $desc2[0];
			$this->create = $create[0];
			$this->init = $init[0];
			$this->sent = $sent[0];
			$this->recv = $recv[0];
			$this->cancel = $cancel[0];
			$this->auth_fraud = $authfraud[0];
			$this->ts = $ts[0];
			$this->sig = $sig[0];
			$this->error_nr = $errornr[0];
				
		}
		catch(Exception $e)
		{
			$exc = new ExceptionClass($e, 'XMLERROR');
			$exc->writeException();
		}
	}

	public function GetMsgStatus()
	{
		return $this->msg_status;
	}
	public function GetPosId()
	{
		return $this->pos_id;
	}
	public function GetSessionId()
	{
		return $this->session_id;
	}
	public function GetOrderId()
	{
		return $this->order_id;
	}
	public function GetAmount()
	{
		return $this->amount;
	}
	public function GetStatus()
	{
		return $this->status;
	}
	public function GetErrorNr()
	{
		return $this->error_nr;
	}
	public function GetStatusSlownie()
	{
		try
		{
			switch ($this->status)
			{
				case 1:
					{
						return 'nowa';
						break;
					}
				case 2:
					{
						return 'anulowana';
						break;
					}
				case 3:
					{
						return 'odrzucona';
						break;
					}
				case 4:
					{
						return 'rozpoczęta';
						break;
					}
				case 5:
					{
						return 'oczekuje na odbiór';
						break;
					}
				case 7:
					{
						return 'płatność odrzucona, otrzymano środki od klienta po wcześniejszym anulowaniu transakcji lub nie było możliwości zwrotu środków w sposób automatyczny, sytuacje takie będą monitorowane i wyjąsniane przez zespół Platnosci.pl';
						break;
					}
				case 99:
					{
						return 'płatność odebrana - zakończona';
						break;
					}
				case 888:
					{
						return 'błędny status - prosimy o kontakt';
						break;
					}
				default:
					{
						throw new Exception('Nieznany kod statusu');
					}

			}
		}
		catch(Exception $e)
		{
			$exc = new ExceptionClass($e, 'Status::GetStatusSlownie');
			$exc->writeException();
			return 'Nieznany kod statusu';
		}
	}
	public function GetPayType()
	{
		return $this->pay_type;
	}
	public function GetPayGw()
	{
		return $this->pay_gw;
	}
	public function GetDesc()
	{
		return $this->desc;
	}
	public function GetDesc2()
	{
		return $this->desc2;
	}
	public function GetCreate()
	{
		return $this->create;
	}
	public function GetInit()
	{
		return $this->init;
	}
	public function GetSent()
	{
		return $this->sent;
	}
	public function GetRecv()
	{
		return $this->recv;
	}
	public function GetCancel()
	{
		return $this->cancel;
	}
	public function GetAuthFraud()
	{
		return $this->auth_fraud;
	}
	public function GetTs()
	{
		return $this->ts;
	}
	public function GetSig()
	{
		return $this->sig;
	}


	public function CheckSigOnlineCallback($pos, $sess, $ts, $sig)
	{
		$sigPriv = MD5($pos.$sess.$ts.$this->KEY2);
		return true;//$sig == $sigPrv;
	}



	public function Ask($sessId)
	{
		try
		{
				
			
			//uzywam biblioteki c_url do przeslania naglowkow z parametrami post
			$this->ts = time();
			$tmpSig = $this->GetPosId().$sessId.$this->ts.$this->KEY1;
			$this->sig=MD5($tmpSig);
			$fields="pos_id=$this->pos_id&session_id=$sessId&ts=$this->ts&sig=$this->sig";

			$handle = curl_init();
			curl_setopt($handle, CURLOPT_URL, $this->ASK_URL);
			curl_setopt($handle, CURLOPT_POST, 1);
			curl_setopt($handle, CURLOPT_POSTFIELDS, $fields);
			curl_setopt($handle, CURLOPT_RETURNTRANSFER, 1);
			$this->xmlContent = curl_exec($handle);
			
			curl_close($handle);
		
			$this->StatusResponse();
		}
		catch(Exception $e)
		{
			$exc = new ExceptionClass($e, 'Status::Ask');
			$exc->writeException();
				
		}

	}

}

class Payment
{
	private $ASK_URL = 'https://www.platnosci.pl/paygw/UTF/Payment/get/xml';
	private $PAYMENT_URL = 'https://www.platnosci.pl/paygw/UTF/NewPayment';

	private $KEY1 = 'fb3636767499b0cc18813addd4c396ba';
	private $KEY2 = '5a3a288586251528f6548507fbe89792';
	private $pos_id = 106622; //wymagane
	private $pos_auth_key = 'hutkr6d';//str{7,7}, wymagane

	private $session_id = 0;//str{1,1024}
	private $amount; //kwota w groszach, str{1,10}
	private $desc; //opis - pokazywany klientowi, trafia na wyciągi, str {1, 50}
	private $desc2 = ''; //dowolna informacja - niewymagane, str{0,1024}
	private $trsDesc=''; //niewymagany opis, trafia na przelwy bankowe, str{0,27}
	private $first_name; //imie, str{0,100}
	private $last_name; //nazwisko, str{0,100}
	private $email;//str{0,100}
	private $language; //niewymagane, kod języka, PL, EN
	private $client_ip; //IP klienta
	private $sig; //niewymagane, zalecany!, suma kontrolna pól w formularzu
	private $ts; //niewymagany, zalecany!, znacznik czasowy wyorzystywnay do obliczenia wartosci sig

	private function CheckRequiredFields()
	{
		$excTxt = '';
		if ($this->pos_id == 0)
		{
			$excTxt = 'Niezainicjalizowana wartosc pos_id. ';
		}
		if ($this->pos_auth_key == '')
		{
				
		}

	}
	private function SetFields($arrArgs)
	{
		$this->SetSessionId($arrArgs['sessId']);
		$this->SetAmount($arrArgs['amount']);
		$this->SetDesc($arrArgs['desc']);
		if (array_key_exists('desc2', $arrArgs))
		$this->SetDesc2($arrArgs['desc2']);
		if (array_key_exists('trsDesc', $arrArgs))
		$this->SetTrsDesc($arrArgs['trsDesc']);
		$this->SetFirstName($arrArgs['firstName']);
		$this->SetLastName($arrArgs['lastName']);
		$this->SetEmail($arrArgs['email']);
		if (array_key_exists('language', $arrArgs))
		$this->SetLanguage($arrArgs['language']);
		$this->SetClientIp($arrArgs['cliIp']);
		$this->ts = time();

		$sig = $this->GetPosId().''.$this->GetSessionId().
		$this->GetPosAuthKey().$this->GetAmount().
		$this->GetDesc().$this->GetDesc2().
		$this->GetTrsDesc().$this->GetFirstName().''.
		$this->GetLastName().''.''.''.''.''.''.''.$this->GetEmail().''.$this->GetLanguage().
		$this->GetClientIp().$this->GetTs().
		$this->KEY1;

		$this->sig = md5($sig);

	}
	private function BuildFieldsStrNewPayment()
	{
		$queryStr = '';
		$queryStr .= 'pos_id='.$this->pos_id;
		$queryStr .= '&pos_auth_key='.$this->GetPosAuthKey();
		$queryStr .= '&session_id='.$this->session_id;
		$queryStr .= '&amount='.$this->amount;
		$queryStr .= '&desc='.$this->desc;
		if ($this->desc2 != '')
		$queryStr .= '&desc2='.$this->desc2;
		if ($this->trsDesc != '')
		$queryStr .= '&trsDesc='.$this->trsDesc;
		$queryStr .= '&first_name='.$this->first_name;
		$queryStr .= '&last_name='.$this->last_name;
		$queryStr .= '&email='.$this->email;
		if ($this->language!='')
		$queryStr .= '&language='.$this->language;
		$queryStr .= '&client_ip='.$this->client_ip;

		$queryStr .= '&sig='.$this->sig;
		$queryStr .= '&ts='.$this->ts;

		return $queryStr;
	}

	public function SendNewPayment($arrArgs)
	{
		//Metoda  wysyla postem wartosci.
		try
		{
			$this->SetFields($arrArgs);
			$excTxt = '';
			$excTxt = $this->CheckRequiredFields();

			if ($excTxt != '')
			{
				throw new Exception($excTxt);
			}
			//echo phpinfo();
			/*$fields = $this->BuildFieldsStrNewPayment();
			 print_r($fields);
			 $handle = curl_init();
			 curl_setopt($handle, CURLOPT_URL, $this->PAYMENT_URL);
			 //curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, 0);
			 curl_setopt($handle, CURLOPT_HEADER, 0);
			 curl_setopt($handle, CURLOPT_TIMEOUT, 20);
			 curl_setopt($handle, CURLOPT_POST, 1);
			 curl_setopt($handle, CURLOPT_POSTFIELDS, $fields);
			 curl_exec($handle);
			 curl_close($handle);*/
				
			$url = $this->PAYMENT_URL;
			$form = "
				<form action='$url' method='POST' name='payform'>
				<input type='hidden' name='pos_id' value='$this->pos_id'>
				<input type='hidden' name='pos_auth_key' value='$this->pos_auth_key'>
				<input type='hidden' name='session_id' value='$this->session_id'>
				<input type='hidden' name='amount' value='$this->amount'>
				<input type='hidden' name='desc' value='$this->desc'>
				<input type='hidden' name='desc2' value='$this->desc2'>
				<input type='hidden' name='trsDesc' value='$this->trsDesc'>
				<input type='hidden' name='first_name' value='$this->first_name'>
				<input type='hidden' name='last_name' value='$this->last_name'>
				<input type='hidden' name='email' value='$this->email'>
				<input type='hidden' name='language' value='$this->language'>
				<input type='hidden' name='client_ip' value='$this->client_ip'>
				<input type='hidden' name='sig' value='$this->sig'>
				<input type='hidden' name='ts' value='$this->ts'>
				<input type='submit' value='Zaplac platnosci.pl'>
				</form>";
				if ($_SESSION['Zamowienie']->GetStatusRabatu()=='nienaliczony')
				{
					$module = new modulesMgr();
 					$module->loadModule('Sklep');
 					$actnNaliczRabat = $module->getModuleActionIdByName('NaliczRabat');
					$idZam = $_SESSION['Zamowienie']->GetId();
					$form .= "<button onClick=\"document.location.href='?a=$actnNaliczRabat&id=$idZam';\">
					Nalicz rabat
					</button>";
				}
			
				
			return $form;
				
		}
		catch(Exception $e)
		{
				
			$exc = new ExceptionClass($e, 'Payment::SendNewException');
			$exc->writeException();

		}

	}
	public function GetTs()
	{
		return $this->ts;
	}
	public function GetPosAuthKey()
	{
		return $this->pos_auth_key;
	}
	public function GetPosId()
	{
		return $this->pos_id;
	}
	public function SetSessionId($sessId)
	{
		$this->session_id = $sessId;
	}
	public function GetSessionId()
	{
		return $this->session_id;
	}
	public function SetAmount($amount)
	{
		$this->amount = $amount;
	}
	public function GetAmount()
	{
		return $this->amount;
	}
	public function SetDesc($desc)
	{
		$this->desc = $desc;
	}
	public function GetDesc()
	{
		return $this->desc;
	}
	public function SetDesc2($desc2)
	{
		$this->desc2 = $desc2;
	}
	public function GetDesc2()
	{
		return $this->desc2;
	}
	public function SetTrsDesc($trsDesc)
	{
		$this->trsDesc = $trsDesc;
	}
	public function GetTrsDesc()
	{
		return $this->trsDesc;
	}
	public function SetFirstName($firstName)
	{
		$this->first_name = $firstName;
	}
	public function GetFirstName()
	{
		return $this->first_name;
	}
	public function SetLastName($lastName)
	{
		$this->last_name = $lastName;
	}
	public function GetLastName()
	{
		return $this->last_name;
	}

	public function SetEmail($email)
	{
		$this->email = $email;
	}
	public function GetEmail()
	{
		return $this->email;
	}
	public function SetLanguage($lang)
	{
		$this->language = $lang;
	}
	public function GetLanguage()
	{
		return $this->language;
	}
	public function SetClientIp($cliIp)
	{
		$this->client_ip = $cliIp;
	}
	public function GetClientIp()
	{
		return $this->client_ip;
	}



}

class ErrorCodes
{
	private $errArr = array(
	100 => 'Brak lub bledna wartosc parametru pos_id',
	101 => 'Brak parametru session_id',
	102 => 'Brak parametru ts',
	103 => 'Brak lub błędna wartość parametru sig',
	104 => 'Brak parametru desc',
	105 => 'Brak parametru client_ip',
	106 => 'Brak parametru first_name',
	107 => 'Brak parametru last_name',
	108 => 'Brak parametru street',
	109 => 'Brak parametru city',
	110 => 'Brak parametru post_code',
	111 => 'Brak parametru amount',
	112 => 'Błędny numer konta bankowego',
	113 => 'Brak parametru email',
	114 => 'Brak numeru telefonu',
	200 => 'Inny chwilowy błąd',
	201 => 'Inny chwilowy błąd bazy danych',
	202 => 'POS o podanym identyfikatorze jest zablokowany',
	203 => 'Niedozwolona wartość pay_type dla danego pos_id',
	204 => 'Podana metoda płatności pay_type jest chwilowo zablokowana dla danego pos_id, np przerwa konserwacyjna branki płatniczej',
	205 => 'Kwota transakcji mniejsza od wartości minimalnej ',
	206 => 'Kwota transakcji większa od transakcji maksymalnej',
	207 => 'Przekroczona wartość wszystkich transakcji dla jednego klienta w ostatnim przedziale czasowym',
	208 => 'POS działa w trybie ExpressPayment lecz nie nastąpiła aktywacja tego wariantu współpracy (czekamy na zgodę działu obsługi klienta)',
	209 => 'Błędny numer pos_id lub pos_auth_key',
	500 => 'Transakcja nie istnieje',
	501 => 'Brak autoryzacji dla danej transakcji',
	502 => 'Transakcja rozpoczęta wcześniej',
	503 => 'Autoryzacja do transakcji była już przeprowadzona',
	504 => 'Transakcja anulowana wcześniej',
	505 => 'Transakcja przekazana do odbioru wcześniej',
	506 => 'Transakcja już odebrana',
	507 => 'Błąd podczas zwrotu środków do klienta',
	599 => 'Błędny stan transakcji, np nie można uznać transakcji kilka razy lub inny, prosimy o kontakt',
	999 => 'Inny błąd krytyczny - prosimy o kontakt'
	);

	public function  GetOpis($errNum)
	{
		try
		{
			if (array_key_exists($errNum, $this->errArr))
			{
				return $this->errArr[$errNum];
			}
			else
			{
				throw new Exception('Brak zdefinowanego komuniaktu błędu');
			}
		}
		catch(Exception $e)
		{
			$exc = new ExceptionClass($e, 'ErrCodes::GetOpis');
			$exc->writeException();

			return 'Błąd w transferze o nieznanym komunikacie';
		}

	}
}
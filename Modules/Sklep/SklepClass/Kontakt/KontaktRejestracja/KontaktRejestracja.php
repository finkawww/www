<?php
class KontaktRejestracja extends KontaktKlient
{
	public function __construct($typ, $kliId)
	{
		
		
		$this->SetTyp($typ);
		
		$this->SetBodyTemplate('KontaktRejestracja.tpl');
		$this->SetAlterBodyTemplate('KontaktRejestracjaAlter.tpl');
		
		$this->SetFormTitle('Konfiguracja SMTP - rejestracja klienta');
		
		if ($kliId != 0)
		{
			$this->klient = new Klient();
			$this->klient->LoadById($kliId);
		}
		parent::__construct();
		
	}
	public function __destruct()
	{
		if (isset($this->klient))
			unset($this->klient);
	}
	
}
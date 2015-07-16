<?php
class KontaktResetHasla extends KontaktKlient
{
	public function __construct($typ, $kliId)
	{
		
		
		$this->SetTyp($typ);
		
		$this->SetBodyTemplate('KontaktResetHasla.tpl');
		$this->SetAlterBodyTemplate('KontaktResetHaslaAlter.tpl');
		
		$this->SetFormTitle('Konfiguracja SMTP - reset hasła');
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
?>
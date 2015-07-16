<?php
class KontaktZlozenieZamowienia extends KontaktKlient
{
	public function __construct($typ, $kliId)
	{
		
		
		$this->SetTyp($typ);
		//$this->SetZamowienie($zamId);
		$this->SetBodyTemplate('KontaktZlozenieZamowienia.tpl');
		$this->SetAlterBodyTemplate('KontaktZlozenieZamowieniaAlter.tpl');
		
		$this->SetFormTitle('Konfiguracja SMTP - złożenie zamówienia');
		
		if ($kliId != 0)
		{
			$this->klient = new Klient();
			$this->klient->LoadById($kliId);
		}
		parent::__construct();
		
	}
	public function __destruct()
	{
		
	}
	
}
?>
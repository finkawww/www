<?php
class KontaktWysylanieRabatu extends KontaktKlient
{
	public function __construct($typ, $zamId)
	{
		
		
		$this->SetTyp($typ);
		//$this->SetZamowienie($zamId);
		$this->SetBodyTemplate('KontaktWysylanieRabatu.tpl');
		$this->SetAlterBodyTemplate('KontaktWysylanieRabatuAlter.tpl');
		
		$this->SetFormTitle('Konfiguracja SMTP - wysylanie rabatu');
		
		if ($zamId != 0)
		{
			$this->zamowienie = new Zamowienie();
			$this->zamowienie->Load($zamId);
			$this->klient = $this->zamowienie->klient;
		}
		parent::__construct();
		
	}
	public function __destruct()
	{
		
	}
	
}
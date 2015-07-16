<?php
class KontaktZmianaStat extends KontaktKlient
{
	public function __construct($typ, $zamId)
	{
		echo 'Creator ZmianaStat';
		
		$this->SetTyp($typ);
		
		$this->SetBodyTemplate('KontaktZmianaStat.tpl');
		$this->SetAlterBodyTemplate('KontaktZmianaStat.tpl');
		
		$this->SetFormTitle('Konfiguracja SMTP - zmiana statusu');
		
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
?>
<?php
class AdministracjaKlienci
{
	

private $klient = null;
	
	public function __construct($id)
	{
		
		$this->klient = new Klient();
		
		if ($id >0)
		{
			$this->klient->LoadById($id);	
		}
		
	}
	
	public function __destruct()
	{
		unset($this->kraj);
	}
	
	public function ShowAdmin($kryt)
	{
		$klientView = new KlientView();
		return $klientView->ShowAdmin($kryt);
	} 
	
	public function EditAdmin($id)
	{
		$klientView = new KlientView();
		return $klientView->EditAdmin($id);
	}
}
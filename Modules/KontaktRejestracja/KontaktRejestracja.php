<?php
class KontaktRejestracja extends moduleTemplate
{
	private $objKontakt = null;
	
	public function __construct()
  	{
  		require_once('./Modules/Kontakt/KontaktRejestracjaClass/KontaktRejestracja.class.php');
  		$this->objKontakt = new KontaktRejestracjaClass();
  	} 	
  	public function executeAction($actionName, $l, $varArray)
  	{
  		if ($actionName =='Display')
  		{
  			return $this->objKontakt->display();
  		}
  		
  		if ($actionName =='Config')
  		{
  			return $this->objKontakt->Config();
  		}
  		else
  		{
  			return "Błąd w module Kontakt";
  		}
  	}
  	
  	
  	public function __destruct()
  	{
  		unset($this->objKontakt);
  	}
}
?>
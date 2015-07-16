<?php
class Kontakt extends moduleTemplate
{
	private $objKontakt = null;
	
	public function __construct()
  	{
  		require_once('./Modules/Kontakt/KontaktClass/Kontakt.class.php');
  		$this->objKontakt = new KontaktClass();
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
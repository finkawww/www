<?php
class KontaktRejestracja extends moduleTemplate
{
	private $objKontakt = null;
	
	public function __construct()
  	{
  		require_once('./Modules/KontaktHeader/KontaktHeaderClass/KontaktHeader.class.php');
  		$this->objKontakt = new KontaktHeaderClass();
  	} 	
  	public function executeAction($actionName, $l, $varArray)
  	{
  		if ($actionName == 'Display')
		{
			return $this->objKontakt->Display();
		}
		
	}
	public function Send()
	{
	}

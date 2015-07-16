<?php
class KontaktHeader extends moduleTemplate
{
	private $objKontakt = null;
	
	public function __construct()
  	{
  		require_once('./Modules/KontaktHeader/KontaktHeaderClass/KontaktHeader.class.php');
  		$this->objKontakt = new KontaktHeaderClass();
  	} 	
	
  	public function executeAction($actionName, $l, $varArray)
  	{
		$html = "";
  		if ($actionName == 'Display')
		{
			$html = $this->objKontakt->Display();
		}
		
  		if ($actionName == 'Send')
		{
			$html = $this->objKontakt->Send();
		}
		return $html;
	}
	
	
}
?>
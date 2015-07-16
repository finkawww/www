<?php
class Szukanie extends moduleTemplate
{
	private $objSzukanie = null;

	
	public function __construct()
  	{
  		require_once './Modules/Szukanie/SzukanieClass/Szukanie.class.php';
  		$this->objSzukanie = new SzukanieClass();
  		
  	} 	
  	public function executeAction($actionName, $l, $varArray)
  	{
  		if ($actionName == 'Szukaj')
  		{
  			if (isset($_POST['findStr']))
  			{
  				$FindStr = $_POST['findStr'];
  			}
  			else
  			{
  				$FindStr = '';
  			}
  			$result = $this->objSzukanie->Szukaj($FindStr);
  			
  		}
  		else if ($actionName == 'SzukajStatus')
  		{
  			$result = $this->objSzukanie->ShowSzukajStatus();
  		}
  		return $result;
  	}
	public function __destruct()
  	{
  		unset($this->objSzukanie);
  	}
  	
  	
}
?>
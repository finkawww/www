<?php
class Lang
{
	private $objLang = null;
	public function __construct()
  	{
  		require_once('./Modules/Lang/LangClass/Lang.class.php');
  		$this->objLang = new LangClass();
  	} 	
	
	public function executeAction($actionName, $l, $varArray)
  	{
  		$html = '';
		if ($actionName=='ShowStatusLangs')
  		{
  			$html = $this->objLang->ShowStatusLangs();
  		}
  		else if ($actionName=='SetLang')
  		{
  			if (isset($_GET['idLang']))
  			{
  				$idLang =$_GET['idLang'];
  			} 
  			else 
  			{
  				$idLang = 0;
  			}
  			if ($idLang != 0)
  				$this->objLang->SetLang($idLang);
  		}
  		return $html;
  	}
  	
}
?>
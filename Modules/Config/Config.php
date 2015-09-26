<?php

/**
 * Modul wbudowany sluzacy do ustawien konfiguracyjnych
 *  
*/

class Config extends moduleTemplate
{
	private $objConfig = null;
	
	public function __construct()
	{
		require_once rootPath.'/Modules/Config/configClass/config.class.php';
  		$this->objConfig = new configClass();
	}
	
  	public function executeAction($actionName, $l, $varArray)
  	{
  		  
  		$result = '';
  		
  		switch($actionName)
  		{
  			case 'printConfig':
  				{
  					$result =  $this->printConfig();
  					break;
  				}
  			case 'getMainPageTitle':
  				{
  					$result = $this->getMainPageTitle();
  					break;
  				}
  			case 'editLang':
  				{
  					$result = $this->editLang();
  					break;
  				}
  			case 'delLang':
  				{
  					$result = $this->delLang();
  					break;
  				}
  			case 'delLangDo':
  				{
  					$result = $this->delLangDo();
  					break;
  				}
  			case 'printLangGrid':
  				{
  					$result = $this->printLangGrid();
  					break;
  				}
  			case 'choosePage':
  				{
  					$result = $this->choosePage();
  					break;
  				}
  			
  		}
  		
  		return $result;
  	}
  	
  	public function choosePage()
  	{
  		return $this->objConfig->choosePage();
  	}
  	
  	public function printConfig()
  	{
  		try
  		{
  			return $this->objConfig->printConfig();
  		}
  		catch (exception $e)
  		{
  			$exc = new ExceptionClass($e, 'printConfig');
   			$exc->writeException();   
  		}
  		
  	}
  	
  	public function getMainPageTitle()
  	{
  		try
  		{
  			return $this->objConfig->getMainPageTitle();
  		}
  		catch (exception $e)
  		{
  			$exc = new ExceptionClass($e, 'getMainPageTitle');
   			$exc->writeException();
  		}   
  	}
  	
  	public function editLang()
  	{
  		if (isset($_GET['id']))
  		{
  			$id = $_GET['id'];
  		}
  		else if (isset($_POST['id']))
  		{
  			$id = $_POST['id'];
  		}
  		else
  		{
  			$id = -1;
  		}
  		return $this->objConfig->editLang($id);
	  		 
  	}
  	
  	public function delLang()
  	{
  		try
  		{
  			return $this->objConfig->delLang();
  		}
  		catch (exception $e)
  		{
  			$exc = new ExceptionClass($e, 'delLang');
   			$exc->writeException();
  		}   
  	}
  	
  	  	
  	public function delLangDo()
  	{
  		return $this->objConfig->delLangDo();
  	}
  	
  	public function printLangGrid()
  	{
  		return $this->objConfig->printLangGrid();
  	}  	
}

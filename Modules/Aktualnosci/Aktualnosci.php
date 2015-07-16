<?php

class Aktualnosci extends moduleTemplate
{
	private $objAktualnosci = null;
		
	public function __construct()
  	{
  		require_once './Modules/Aktualnosci/AktualnosciClass/Aktualnosci.class.php';
  		$this->objAktualnosci = new AktualnosciClass();
  		
  	} 	
  	public function executeAction($actionName, $l, $varArray)
  	{
  		//ADMIN
  		if ($actionName == 'AktualnosciShowAdmin')
  		{
  			$result = $this->ShowAdmin();
  		}
  		else if ($actionName == 'AktualnosciAdd')
  		{
  			$result = $this->Add(0);
  		}
  		else if ($actionName == 'AktualnosciEdit')
  		{
  			if(isset($_GET['id']))
  			{
  				$id = $_GET['id'];  				
  			}
  			else if (isset($_POST['id']))
  			{
  				$id = $_POST['id'];  				
  			}
  			else
  			{
  				$id = 0;
  			}
  			$result = $this->Add($id);
  		}
  		else if ($actionName == 'AktualnosciDel')
  		{
  			if(isset($_GET['id']))
  			{
  				$id = $_GET['id'];  				
  			}
  			else if (isset($_POST['id']))
  			{
  				$id = $_POST['id'];  				
  			}
  			else
  			{
  				$id = 0;
  			}
  			$result = $this->Del($id);
  		}
  		//FRONTEND
  		else if ($actionName == 'AktualnosciShowShort')
  		{
  			return $this->objAktualnosci->ShowShort();
  		}
  		else if ($actionName == 'AktualnosciShowFull')
  		{
  			return $this->objAktualnosci->ShowFull();
  		}
  		else
  		{
  			$result = 'Brak takiej akcji';
  		}
  		
  		return $result;
  	}
  	public function Add($id)
  	{
  		return $this->objAktualnosci->Add($id);
  	}
  	public function ShowAdmin()
  	{
  		return $this->objAktualnosci->ShowAdmin();
  	}
  	public function Del($id)
  	{
  		return  $this->objAktualnosci->Del($id);
  	}
}
?>
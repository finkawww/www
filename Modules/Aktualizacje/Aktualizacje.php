<?php

class Aktualizacje extends moduleTemplate
{
	private $objAktualizacje = null;
		
	public function __construct()
  	{
  		require_once './Modules/Aktualizacje/AktualizacjeClass/Aktualizacje.class.php';
  		$this->objAktualizacje = new AktualizacjeClass();
  		
  	} 	
  	public function executeAction($actionName, $l, $varArray)
  	{
  		//ADMIN
  		if ($actionName == 'ShowAdmin')
  		{
  			if (isset($_GET['s']))
  			{
  				$_SESSION['s']=$_GET['s'];
  			}
  			
  			$result = $this->ShowAdmin();
  		}
  		else if ($actionName == 'Add')
  		{
  			$result = $this->Add(0);
  		}
  		else if ($actionName == 'Edit')
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
			//$result = 'ala';
  		}
  		else if ($actionName == 'Del')
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
  		else if ($actionName == 'ShowShort')
  		{
  			$result= $this->ShowShort();
  		}
  		else if ($actionName == 'ShowFull')
  		{
  			if (isset($_GET['page']))
  			{
  				$page=$_GET['page'];
  			}
  			else
  			{
  				$page=0;
  			}
  			
  			
  			$id = $varArray[0];
  			
  			$result = $this->ShowFull($id, $page);
  		}
  		else if ($actionName == 'chooseProgram')
  		{
  			return $this->chooseProgram();
  		}
  		else
  		{
  			$result = 'Brak takiej akcji';
  		}
  		
  		return $result;
  	}
  	public function Add($id)
  	{
  		return $this->objAktualizacje->Add($id);
  	}
  	public function ShowAdmin()
  	{
  		return $this->objAktualizacje->ShowAdmin();
  	}
  	public function Del($id)
  	{
  		return  $this->objAktualizacje->Del($id);
  	}
  	public function chooseProgram()
  	{
  		return $this->objAktualizacje->chooseProgram();
  	}
  	public function ShowShort()
  	{
  		return $this->objAktualizacje->ShowShort();
  	}
  	public function ShowFull($id, $page)
  	{
  		return $this->objAktualizacje->ShowFull($id, $page);
  	}
  	
}

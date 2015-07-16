<?php

class Galeria extends moduleTemplate
{
	private $objGaleria = null;

	
	public function __construct()
  	{
  		require_once './Modules/Galeria/GaleriaClass/Galeria.class.php';
  		$this->objGaleria = new GaleriaClass();
  		
  	} 	
  	public function executeAction($actionName, $l, $varArray)
  	{
  		//wszystkie realizacje, miniatury, po 4 w wierszu
  		$result = '';
  		
  		if ($actionName =='ShowGallery')
  		{
  			
  			$menuId = $_SESSION['mp'];
  			$idGalerii = $this->objGaleria->GetId($menuId);
  			if ($idGalerii ==0)
  			{
  				$result = 'Brak przypisanej galerii!';
  			}
  			else
  			{
  				$result = $this->objGaleria->ShowGallery($idGalerii);
  			}
  		}
  		
  		if ($actionName =='ShowRealizacja')
  		{
  			//kon kretna realizacja, pokazuje zdjecia
  			$idRealizacji = $_GET['real'];
  			$this->objGaleria->ShowRealizacja($idRealizacji);
  		}
  		if ($actionName == 'ShowGalleriesAdmin')
  		{
  			$result = $this->objGaleria->ShowAdmin();
  		}
  		if ($actionName == 'ShowRealizacjeAdmin')
  		{
  		    if (isset($_GET['idGal']))
  			{
  				$idGal = $_GET['idGal'];
  			}
  			else if (isset($_POST['idGal']))
  			{
  				$idGal = $_POST['idGal'];
  				
  			}
  			else
  			{
  				$idGal = 0;
  			}
  			$result = $this->objGaleria->ShowRealizacjeAdmin($idGal);
  		}
  		if ($actionName == 'realUpAction')
  		{
  			
  		}
  		if ($actionName == 'realDownAction')
  		{
  			
  		}
  		
  		if ($actionName == 'AddRealizacja')
  		{
  			$result = $this->objGaleria->AddRealizacja(0);
  		}
  		if ($actionName == 'EditRealizacja')
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
  				$id = 0;
  			}
  			
  			$result = $this->objGaleria->AddRealizacja($id);
  		}
  		if ($actionName == 'ShowZdjeciaAdmin')
  		{
  			if (isset($_GET['id']))
  			{
  				$idGal = $_GET['id'];
  			}
  			else if (isset($_POST['id']))
  			{
  				$idGal = $_POST['id'];
  				
  			}
  			else
  			{
  				$idReal = 0;
  			}
  			$result = $this->objGaleria->ShowZdjeciaAdmin($idReal);
  		}
  		if ($actionName == 'AddZdjecia')
  		{
  			$result = $this->objGaleria->AddZdjecia(0, 0);
  		}
  		if ($actionName == 'AddGallery')
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
  				$id = 0;
  			}
  			
  			$result = $this->objGaleria->AddGallery($id);
  		}
  		if ($actionName == 'EditGallery')
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
  				$id = 0;
  			}
  			$result = $this->objGaleria->AddGallery($id);
  		}
  		
  		return $result;
  	}
  	
  	
  	public function __destruct()
  	{
  		unset($this->objGaleria);
  	}
}
?>
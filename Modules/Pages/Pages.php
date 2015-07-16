<?php

class Pages extends moduleTemplate
{
	private $objPages = null;
	
	public function __construct()
  	{
  		require_once(rootPath.'/Modules/Pages/PagesClass/Pages.class.php');
  		$this->objPages = new PagesClass();
  	} 	
  	
  	public function __destruct()
  	{
  		unset($this->objPages);
  	}
  	
  	/**
  	 * Wywołanie odpowiedniej metody z klasy Pages
  	 * Pośredniczenie w pobieraniu argumentów
  	 * @var $actionName Nazwa akcji
  	 * @var $l Język tłumacznia interfejsów
  	 * @var $varArray Tablica przekazanych zmiennych
  	 * @access public
  	 * @author Piotr Brodziński
  	 */
  	public function executeAction($actionName, $l, $varArray)
  	{
  		$result = '';
  		switch ($actionName)
  		{
  			case 'showPages':
  				{
  				
  					return $this->objPages->showPages();
  					break; 
  				}
  			case 'showPagesChoose':
  				{
  					
  					return $this->objPages->showPagesChoose();
  					break; 
  				}
  			case 'showEditPage':
  				{
  					$id=-1;
  					if (isset($_GET['id']))
  					{
  						$id = $_GET['id'];
  					}
  					else if (isset($_POST['id']))
  					{
  						$id = $_POST['id'];
  					}
  					return $this->objPages->showEditPage($id);
  					break;
  				}
  			case 'editPageSave':
  				{
  					//tu odczyt wartosci
  					$id=-1;
  					if (isset($_GET['id']))
  						$id = $_GET['id'];
  					return $this->objPages->editPageSave($id);
  					break;
  				}
  			case 'showAddPage':
  				{
  					return $this->objPages->showAddPage();
  					break;
  				}
  			case 'genPages':
  				{
  					return $this->objPages->genPages();
  					break;
  				}
  			case 'addPageSave':
  				{
  					//tu odczytanie argumentów
  					return $this->objPages->addPageSave();
  					break;
  				}
  			case 'delPage': //pytanie czy usunac
  				{
  					$id = -1; 
  					if (isset($_GET['id']))
  						$id = $_GET['id'];
  					
  					return $this->objPages->delPage($id);
  					break;  				}
  			case 'delPageDo': // ususniecie
  				{
  					$id = -1;
  					if (isset($_GET['id']))
  						$id = $_GET['id'];
  					
  					return $this->objPages->delPageDo($id);
  					break;
  				}	
  			case 'pagesTemplates':
  				{
  					return $this->objPages->pagesTemplates();
  					break;
  				}
  			case 'pagesTemplatesAdd':
  				{
  					return $this->objPages->addTemplate(0);
  					break;
  				}
  			case 'pagesTemplatesEdit':
  				{
  					$id=0;
  					if (isset($_GET['id']))
  					{
  						$id = $_GET['id'];
  					}
  					else if (isset($_POST['id']))
  					{
  						$id = $_POST['id'];
  					}
  					return $this->objPages->addTemplate($id);
  					break;
  				}
  			case 'pagesTemplatesDelete':
  			{
  			$id = -1; 
  					if (isset($_GET['id']))
  						$id = $_GET['id'];
  					
  					return $this->objPages->delTemplate($id);
  					break;  				
  			}
  			case 'chooseTemplate':
  				{
  					return $this->objPages->chooseTemplate();
  					break;
  				}
  			case 'cssEdit':
  				{
  					return $this->objPages->cssEdit();
  					break;
  				}
  		}
  		  		
  		return $result;
  	}
}
?>
<?php
class Sections Extends moduleTemplate
{
	private $sectionsObj = null;  
	
	public function __construct()
	{
		require_once rootPath.'/Modules/Sections/SectionsClass/sections.class.php';
		$this->sectionsObj = new sectionsClass();
	}
	
  	public function executeAction($actionName, $l, $varArray)
  	{
  		$result = '';
  		
  		if ($actionName == 'showPageSections')
  		{
  			$id = 0;
  			if (isset($_GET['id']))
			{
				$id = $_GET['id'];
			}
			else if (isset($_POST['id']))
			{
				$id = $_POST['id'];
			}
			$result =  $this->sectionsObj->showPageSections($id);  			
  		}
  		else if ($actionName == 'addSection')
  		{
  			$id = 0;
  			if (isset($_GET['id']))
			{
				$id = $_GET['id'];
			}
			else if (isset($_POST['id']))
			{
				$id = $_POST['id'];
			}
			//$result =  $this->sectionsObj->showPageSections($id);
  			if (isset($_GET['pageId']))
			{
				$id = $_GET['pageId'];
			}
			else if (isset($_POST['pageId']))
			{
				$id = $_POST['pageId'];
			}
  			
  			//id = pageId
  		    $result = $this->sectionsObj->addSection($id);
  		}
  		else if ($actionName == 'editSectionContent')
  		{
  			$id = 0;
  			if (isset($_GET['id']))
			{
				$id = $_GET['id'];
			}
			else if (isset($_POST['id']))
			{
				$id = $_POST['id'];
			}
  			if (isset($_GET['sectionId']))
			{
				$id = $_GET['sectionId'];
			}
			else if (isset($_POST['sectionId']))
			{
				$id = $_POST['sectionId'];
			}
			echo "in";
  			$result = $this->sectionsObj->editSectionContent($id);
			
  		}
  		else if ($actionName == 'addPage')
  		{
  			
  		}
  		else if ($actionName == 'printPageList')
  		{
  			
  		}
  		else if ($actionName == 'editSection')
  		{
  			$sectionId = 0;
  			$pageId = 0;
  			
  			if (isset($_GET['id']))
			{
				$sectionId = $_GET['id'];
			}
			else if (isset($_POST['id']))
			{
				$sectionId = $_POST['id'];
			}
			
  			if (isset($_GET['pageId']))
			{
				$pageId = $_GET['pageId'];
			}
			else if (isset($_POST['pageId']))
			{
				$pageId = $_POST['pageId'];
			}
			
  			$result = $this->sectionsObj->addSection($pageId, $sectionId);
  		}
  		else if ($actionName == 'delSection')
  		{
  			$id = 0;
  			if (isset($_GET['id']))
			{
				$id = $_GET['id'];
			}
			else if (isset($_POST['id']))
			{
				$id = $_POST['id'];
			}
  			$result = $this->sectionsObj->delSection($id);
  		}
  		else
  		{
  			
  		}
  		
  		return $result;
  	}
}
?>
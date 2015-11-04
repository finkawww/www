<?php
class CmsInfo extends moduleTemplate
{
	private $objCmsInfo = null;
	
	public function __construct()
  	{
  		require_once(rootPath.'/Modules/CmsInfo/CmsInfoClass/CmsInfo.class.php');
  		$this->objCmsInfo = new CmsInfoClass();
  	} 	
  	
  	public function __destruct()
  	{
  		unset($this->objCmsInfo);
  	}
  	
  	public function executeAction($actionName, $l, $varArray)
  	{
  		if ($actionName == 'showCmsInfo')
  		{
  			$userId = $_SESSION['adminId']; 
  			return $this->objCmsInfo->showCmsInfo($userId);
  		}
  		if ($actionName == 'addCmsMessage')
  			return $this->objCmsInfo->AddCmsMessage();
  		if ($actionName == 'User')
  			return $this->objCmsInfo->User();
  		if ($actionName == 'addBug')
  			return $this->objCmsInfo->addBug(0);
  		if ($actionName == 'editBug')
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
  			return $this->objCmsInfo->addBug($id);
  		}
  			
  			
  	}
}
?>
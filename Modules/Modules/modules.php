<?php
class CmsModules extends moduleTemplate
{
	private $moduleObj = null;
	
	//-------------inicjalizacja i niszczenie--------
	
	public function __construct()
	{
		require_once rootPath.'/Modules/Modules/modulesClass/modules.class.php';
		$this->moduleObj = new moduleClass();
	}
		
	public function __destruct()
	{
		unset($this->moduleObj);	
	}
	
	public function executeAction($actionName, $l, $varArray)
	{
		switch($actionName)
		{
			case 'showModulesList':
				{
					return $this->moduleObj->showModulesList();
					break;
				}
			case 'showModulesAndActionsList':
				{
					return $this->moduleObj->showModulesAndActionsList();
					break;
				}
			case 'addModule':
				{
					return $this->moduleObj->editModule(0);
					break;
				}
			case 'editModule':
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
					if ($id == 0)
					{
						throw new exception('Brak identyfkatora rekordu');
					}
					return $this->moduleObj->editModule($id);
					break;
				}
			case 'deleteModule':
				{
					$id = $_GET['id'];
					return $this->moduleObj->deleteModule($id);
					break;
				}
			case 'deleteModuleDo':
				{
					$id = $_GET['id'];
					return $this->moduleObj->deleteModuleDo($id);
					break;
				}
			case 'installModule':
				{
					$path = $_GET['path'];
					$this->moduleObj->installModule($path);
					break;
				}
			case 'showActions': //dla danego moduleId
				{
					$id = $_GET['id'];
					return $this->moduleObj->showActions($id);
					break;
				}
			case 'addAction': //dla danego moduleId
				{
					$moduleId = 0;
					if (isset($_GET['id']))
					{
						$moduleId = $_GET['id'];
					}
					
				if (isset($_GET['moduleid']))
					{
						$moduleId = $_GET['moduleid'];
					}
					else if (isset($_POST['moduleid']))
					{
						$moduleId = $_POST['moduleid'];
					}
					
					return $this->moduleObj->addAction($moduleId);
					break;
				}
			case 'editAction': //dla danego actionId
				{
					$moduleId = 0;
					$actionId = 0;
					if (isset($_GET['id']))
					{
						$actionId = $_GET['id'];	
					}
					else
					{
						if (isset($_GET['actionid']))
						{
							$actionId = $_GET['actionid'];
						}
						else if (isset($_POST['actionid']))
						{
							$actionId = $_POST['actionid'];
						}
					}
					
					if (isset($_GET['moduleid']))
					{
						$moduleId = $_GET['moduleid'];
					}
					else if (isset($_POST['moduleid']))
					{
						$moduleId = $_POST['moduleid'];
					}
					
					return $this->moduleObj->addAction($moduleId, $actionId);
					break;
				}
			case 'delAction': //dla danego actionId - ustawia active na false
				{
					$actionId = $_GET['id'];
					return $this->moduleObj->delAction($actionId);
					break;
				}
			case 'delActionDo':
				{
					$actionId = $_GET['id'];
					return $this->moduleObj->delActionDo($actionId);
					break;
				}
			case 'showModulesActionsChoose':
				{
					return $this->moduleObj->showModulesActionsChoose();
					break;
				}
			
		}
	}
}

?>
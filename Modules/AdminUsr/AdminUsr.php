<?php
/**
 * 
 * Modul zarządzania użytkownikami systemu CMS
 *  - administratorami, operatorami
 * 
 * @access public
 * @author Piotr Brodziński
 * 
 */

 class AdminUsr extends moduleTemplate
{
	private $content;
	private $objAdminUsr = null;
	
	/**
	 * var $log Referencja do obieku adminLog
	 * @access private
	 */
	private $log = null;
	
	public function __construct()
	{
		require_once rootPath.'/Modules/AdminUsr/adminUsrClass/adminUsr.class.php';
		if ($this->objAdminUsr == null)
  			$this->objAdminUsr = new adminUsrClass();
  		
  		if (isset($_SESSION['adminId']) && ($_SESSION['adminId'] > -1))
  		{	
  			$this->log = new adminLog(($_SESSION['adminId']));
  		}
  		
  			
	}
	
	public function AdminExist($login)
	{
		 
	}
		 
	public function executeAction($actionName, $lang, $varArray)
  	{
  		$result = '';
  		
  		//1. pokazanie listy uzytkownikow do zmiany przywilejow
  		if ($actionName == 'showPrivilegesUsers')
  		{
  			$result = $this->objAdminUsr->showPrivilegesUsers();  			
  		}
  		
  		//2. lista modulow do zmiany przywilejow - dla uzytkonika
  		else if ($actionName == 'showPrivilegesModules')
  		{
  			$result = $this->objAdminUsr->showPrivilegesModules();
  		}
  		//3. lista akcji dla modolow
  		else if ($actionName == 'showPrivilegesActions')
  		{
  			
  			$result = $this->objAdminUsr->showPrivilegesActions();
  		}
  		else if ($actionName == 'showAdmins')
  		{
  			$result = $this->objAdminUsr->showAdmins();
  		}
  		else if ($actionName == 'adminAdd')
  		{
  			$result = $this->objAdminUsr->adminAdd();
  		}
  		else if ($actionName == 'adminAddDo')
  		{
  			$result = $this->objAdminUsr->adminAddDo();
  		}
  		else if ($actionName == 'adminLogin')
  		{
  			$result = $this->objAdminUsr->adminLogin();
  		}
  		else if ($actionName == 'adminLogout')
  		{
  			$result = $this->objAdminUsr->adminLogout();
  		}
  		else if ($actionName == 'adminEdit')
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
  				$result = $this->objAdminUsr->showAdmins();
  			}
  			
  			//$id = $this->getID($this->objAdminUsr->showAdmins());
  			$result = $this->objAdminUsr->adminEdit($id);
  		}
  		else if ($actionName == 'adminPassEdit')
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
  				$result = $this->objAdminUsr->showAdmins();
  			}
  			
  			$result = $this->objAdminUsr->adminPassEdit($id);
  			
  		}
  		else if ($actionName == 'updatePrivileges')
  		{
  		    //$this->log->writeLog('updatePrivileges', '', $_GET['userId']);
  			
  			//$this->objAdminUsr->updatePrivileges($_POST['userId'], $_POST['id']);
  			$result  = $this->objAdminUsr->updatePrivileges();
  		}
  		else if ($actionName == 'chkPrivileges')
  		{
  			return $this->objAdminUsr->chkPrivileges($varArray);
  		}
  		
  		else if ($actionName == 'adminDelete')
  		{
  			if (isset($_GET['id']))
  			{
  				$html = '';
  				$id = $_GET['id'];
  				$tmpModule = new ModulesMgr();
  				$tmpModule->loadModule('AdminUsr');
  				$actionCancel = $tmpModule->getModuleActionIdByName('ShowAdmins');
  				$actionOk = $tmpModule->getModuleActionIdByName('adminDeleteDo');

  				$dialog = new dialog('Usuwanie użytkownika', 'Czy usunac użytkownika?', 'query', 300, 150);
  				$dialog->setAlign('center');
  				$dialog->setOkAction($actionOk);
  				$dialog->setOkCaption('Tak');
  				$dialog->setCancelAction($actionCancel);
  				$dialog->setCancelCaption('Nie');
  				$dialog->setId($id);
  				$html .= $dialog->show(1);
  			}
  			else
  			{
  				$tmpModule = new ModulesMgr();
  				$tmpModule->loadModule('AdminUsr');
  				$action = $tmpModule->getModuleActionIdByName('ShowAdmins');

  				$dialog = new dialog('Usuwanie użytkownika', 'Nie wybrano użytkownika', 'alert', 300, 200);
  				$dialog->setAlign('center');
  				$dialog->setOkAction($action);
  				$dialog->setOkCaption('Ok');
  				$html .=$dialog->show(1);
  			}
  			return $html;
 		}
  		
  		else if ($actionName == 'adminDeleteDo')
  		{
  			$id = $_GET['id'];
  			$result = $this->objAdminUsr->AdminDelete($id);
  		}
  		else if ($actionName == 'getLogin')
  		{
  			$result = $this->objAdminUsr->getLogin();	
  		}
  		else if ($actionName == 'getName')
  		{
  			$result = $this->objAdminUsr->getName();
  		}
  		else if ($actionName == 'getLastName')
  		{
			$result = $this->objAdminUsr->getLastName();
  		}
  		else if ($actionName == 'getSessionBeginTime')
  		{
  			$result = $this->objAdminUsr->getSessionBeginTime();
  		}
  		else if ($actionName == 'getUserLoginById')
  		{
  			//element 0 - id usera 
  			$result = $this->objAdminUsr->getUserLoginById($varArray[0]);
  		}
  		else
  		{
  			throw new exception('Niezdefiniowana funkcja '.$actionName);
  		}
  		
  		return $result;
  	}
}
?>
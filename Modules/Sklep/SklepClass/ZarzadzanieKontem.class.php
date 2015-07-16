<?php
class ZarzadzanieKontem
{
	private $Klient = null;
	private $KlientView = null;
	
	
	public function __Construct()
	{
		require_once rootPath.'/Modules/Sklep/SklepClass/KlientModel/Klient.php';
		$this->Klient = new Klient();
		require_once rootPath.'/Modules/Sklep/SklepClass/KlientView/KlientView.php';
		$this->KlientView = new KlientView();
		require_once rootPath.'/Modules/Sklep/SklepClass/Global/Global.php';
		
			
	}
	
	public function ZalogujDo($login, $pass)
	{
		
	}
	public function Zaloguj()
	{
		return $this->KlientView->ShowEkranLogowania();
		
	}
	
	public function Wyloguj()
	{
		header('Location: ?');
		//echo 'wylogowanie';
		$_SESSION['klient'] = 0;
		$moduleTmp = new ModulesMgr();
		$moduleTmp->loadModule('Sklep');
		$result = $moduleTmp->moduleExecuteAction('Zaloguj', null);
		unset($moduleTmp);
		return $result;
	}
	public function AddUser()
	{
		return $this->KlientView->ShowUserDataForm();
	}
	public function AddUserDo()
	{
		
	}
	public function PokazKlientStatus()
	{
		return $this->KlientView->PokazKlientStatus();
	}
	public function ShowUserPage()
	{
		return $this->KlientView->ShowUserPage();
	}
	public function UserChangePass()
	{
		return $this->KlientView->UserChangePass();
	}
	public function UserResetPass()
	{
		return $this->KlientView->UserResetPass();
	} 
}
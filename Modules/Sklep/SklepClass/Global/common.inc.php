<?php
/*
 * tu dajê:
 * interfejsy
 * klasê ShopGlobals - kontener na zmienne sesyjne:
 * - koszyk
 * - id uzytkownika
 * - akcjê
 *  
 */
final class Action
{
	private $actionName = '';
	private $actionQueryString = '';
	private $actionId = 0;
	private $actionMenuId = 0;
	
	public function GetName()
	{
		return $this->actionName;
	}
	public function GetQueryString()
	{
		return $this->actionQueryString;
	}
	public function GetId()
	{
		return $this->actionId;
	}
	public function GetMenuId()
	{
		return $this->actionMenuId;	
	}
	
};

final class ShopGlobals
{
	private static $instance = null; 
	
	private $fAction = null;
	private $fKoszyk = null;
	
	public function  __construct()
	{
		//
	}
	public static function GetSingletone()
	{
		if(empty(self::$instance))
		{
			self::$instance = new ShopGlobals();
		}
		return self::$instance;
	}
	
	//----Akcje ------------
	public function GetAction()
	{
		if (isset($_SESSION['SESS_ACTION']))
		{
			$this->fAction =  $_SESSION['SESS_ACTION'];
		}
		return $this->fAction;
	}
	
	public function AddAction($actionName, $actionQueryString, $actionId, $actionMenuId)
	{
		$this->fAction = new Action();
		
		$this->fAction->actionName = $actionName;
		$this->fAction->actionQueryString = $actionQueryString;
		$this->fAction->actionId = $actionId;
		$this->fAction->actionMenuId = $actionMenuId;
		
		if (isset($_SESSION['SESS_ACTION']))
		{
			//zniszcz SESS_ACTION
			$_SESSION['SESS_ACTION']->dispose();
		}
		//utworz nowa
		$_SESSION['SESS_ACTION'] = $this->fAction;
	}
	public function AddUser($userId)
	{
		$_SESSION['SESS_USER'] = $userId;
	}
	public function RemoveUser()
	{
		
	}
	public function GetUserId()
	{
		if (isset($_SESSION['SESS_USER']))
		{
			return $_SESSION['SESS_USER'];
		}
		else
		{
			return 0;
		}
		
		
	}
	
	
}
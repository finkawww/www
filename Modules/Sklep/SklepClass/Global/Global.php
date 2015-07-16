<?php

class GlobalSingleton
{
	private static $instance = null;
	
	public static function GetInstance()
	{
		if (empty(self::$instance))
		{
			self::$instance = new GlobalSingleton();
		}
		return self::$instance;
		
	}
	
	public function AddSessPrimitive($name, $value)
	{
		$_SESSION[$name] = $value;
	}
	public function GetSessPrimitive($name)
	{
		if (isset($_SESSION[$name]))
		{
			$value = $_SESSION[$name];
		}
		else
		{
			$value = -1;
		}
		return $value;
	}
	public function RemoveSessPrimitive($name)
	{
		if (isset($_SESSION[$name]))
			unset($_SESSION[$name]);
	}
	public function Zamowienie()
	{
		
	}
	
	public function Koszyk()
	{
		
	    if ((!isset($_SESSION['koszyk']))&&(isset($_COOKIE['koszykGal'])))
		{
			//echo 'jest cookie';
			$_SESSION['koszyk'] = unserialize(base64_decode($_COOKIE['koszykGal']));
			
		}
		if (!isset($_SESSION['koszyk']))
		{
				//echo 'nie ma cookie';
				$_SESSION['koszyk'] = new Koszyk();
			
		}
		//$koszyk = unserialize($_COOKIE['koszyk']);//$_SESSION['koszyk'];
		//$koszyk->nic=1;
		return $_SESSION['koszyk'];
	}
	public function RefreshCookieKoszyk()
	{
		$month = 2592000 + time();
		setcookie('koszykGal', base64_encode(serialize($_SESSION['koszyk'])), $month);	
	}
}

function GlobalObj()
{
	return GlobalSingleton::GetInstance();
}

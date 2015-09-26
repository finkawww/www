<?php
/*
---------------------
Singleton Database interface
Created: 23.08.2007
Mod: 23.08.2007
Author: P. Brodzinski
--------------------- 
*/

//PEAR DB package
require_once('DB.php');

final class DBSingleton
{
	private static $dbConnection = null;
	private static $instance = null;
	
	private function __construct()
	{
		if (DB::isError(self::$dbConnection = DB::connect('mysql://' . dbUSER . ':' . dbPASSWD . '@tcp(' . dbHOST . ')/' . dbNAME)))
		{
			throw new Exception(self::$dbConnection->getMessage().'. Kod:'.self::$dbConnection->getCode());
		}

	}
	public function __destruct()
	{
		if (!empty(self::$instance))
		{
//			DB::disconnect();
			self::$dbConnection = null;
			self::$instance = null;
		}
	}
	
	//---------- Zwraca instancje klasy DBSingleton
	public static function getInstance()
	{	
		if (empty(self::$instance))
	  	{
	  	 	self::$instance = new DBSingleton();
	  	}
	  	return self::$instance;	  	 	
	}
	
	//------------- Przekazywanie zapytania - jako sqlString mozna tez przekazywac sterowanie transakcjami - begin, commi/rollback
	public function ExecQuery($sqlString)
	{
		
			if (self::$dbConnection)
			{
				//$result = & 
				
				if (DB::isError($result = &self::$dbConnection->Query($sqlString)))
				{
				
	                throw new Exception($result->getMessage().' '. $result->getCode());
				}
	        	return $result;
			}
		
		
		
	}
}
?> 
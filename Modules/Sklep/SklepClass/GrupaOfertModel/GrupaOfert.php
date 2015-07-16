<?php
class GrupaOfert
{
	private $id, $nazwa;
	
	
	public function GetId()
	{
		return $this->id;
	}
	public function GetNazwa()
	{
		return $this->nazwa;
	}
	public function SetId($id)
	{
		$this->id = $id;
	}
	public function SetNazwa($nazwa)
	{
		$this->nazwa = $nazwa;
	}
	public function Load($id, $lang = 'PL')
	{
		try
		{
			if ($lang=='PL')
			{
				$query = "
					SELECT
						id, nazwa
					FROM
						GrupyOfert
					WHERE
						id=$id
			";
			}
			else
			{
				$query = "
					SELECT
						go.id, gol.nazwa
					FROM
						GrupyOfert go INNER JOIN GrupyOfertLang gol
						ON go.id = gol.FKGrupyOfert
					WHERE
						go.id=$id AND lang='$lang'
			";	
			}
			
			$DBInt = DBSingleton::getInstance();
			$dbResult = $DBInt->ExecQuery($query);
 	    	$data = $dbResult->fetchRow(DB_FETCHMODE_ASSOC);
 	    	
 	    	$this->id = $data['id'];
 	    	$this->nazwa = $data['nazwa'];
		}
		catch (Exception $e)
		{
			$exc = new ExceptionHandler($e, 'GrupaOfert::Load');
			$exc->writeException();
		}
	}
	public function LoadByName($name)
	{
		try
		{
			$query = "SELECT id, nazwa FROM GrupyOfert WHERE nazwa='$name'";
			$DBInt = DBSingleton::getInstance();
			$dbResult = $DBInt->ExecQuery($query);
 	    	$data = $dbResult->fetchRow(DB_FETCHMODE_ASSOC);
 	    	
 	    	$this->id = $data['id'];
 	    	$this->nazwa = $data['nazwa'];
 	    
		}
		catch (Exception $e)
		{
			$exc = new ExceptionHandler($e, 'GrupaOfert::LoadByName');
			$exc->writeException();
			
		}
	}
	public function GetOferty(&$arrOfertId)
	{
		$query = "
			SELECT id FROM GrupyOfert ORDER BY sortkey
		";
		
		$DBInt = DBSingleton::getInstance();
		$dbResult = $DBInt->ExecQuery($query);
 	    while($data = $dbResult->fetchRow(DB_FETCHMODE_ASSOC))
 	    {
 	    	$arrOfertId[]=$data['id'];
 	    }
 	    
 	    
	}

}
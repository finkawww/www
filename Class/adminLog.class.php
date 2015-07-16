<?php
class adminLog
{
	private $userName = '';
	private $userId = -1;
	private $DBInt = null;
	private static $instance = null;
	
	// errorLog
		
	private function write($msg)
	{
		/*$data = getDate();
		$sekunda = $data['seconds'];
		$minuta = $data['minutes'];
		$godzina = $data['hours']; 
		$dzien = $data['mday'];
		$miesiac = $data['month'];
		$rok = $data['year'];
		$logDate = $godzina.'h:'.$minuta.'m:'.$sekunda.'s|'.$dzien.':'.$miesiac.':'.$rok.'|';*/
		
		//$plik = fopen('../Cms/Logs/'.$this->userName.'.log', 'a');
		//fwrite($plik, $logDate."$msg\n");
		//fclose($plik);
		$uid = -1;
		
		if (isset($_SESSION['adminId']))
			$uid = $_SESSION['adminId'];
		$mess = htmlspecialchars($msg);
		
		$sql = "
			INSERT INTO cmsLogs(message, userId) VALUES ('$mess', $uid);
			"; 	
		$this->DBInt->ExecQuery($sql);
		
	}
	
	public function __construct($userId)
	{
		$this->DBInt = DBSingleton::getInstance();
		if (!isset($userId))
		{
			$this->userName = 'error';	
		}
		else
		{
			
			$query = 'SELECT Concat(Login,Id) as UserName FROM cmsUsers WHERE id='.$userId;
			$result = $this->DBInt->ExecQuery($query);
			$data = $result->fetchRow(DB_FETCHMODE_ASSOC);
			$this->userName = $data['UserName'];
		}
	}
	
	public function writeLog($moduleAction, $params, $description)
	{
		$msg = "Action: $moduleAction; Params: $params; Description: $description";
		$this->write($msg);		
	}
	
	public function writeErrorLog($errorMsg)
	{
		$this->write($errorMsg);
	}
	public function writeUserLog($txt)
	{
		$this->write($txt);
	}
	
	public function clearLog()
	{
		//TODO Dorobic czyszczenie loga
	}
}
?>
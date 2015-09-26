<?php
/*
-----------------------
Module exception
Author: P. Brodziński
Created: 20.08.2007
Mod: 20.08.2007
-----------------------
*/  

class ExceptionClass
{
	protected $msg;
	protected $Error;
		
	public function writeException()
	{
		//TODO Dopisać wysyłanie mailem komunikatu msg
		//FIXME Nalezy koniecznie zmniejszyc liczbe informacji w komunikacie o bledzie
	    $result = "Nazwa błędu: ".$this->msg."<br />
				   Komunikat: ".$this->Error->GetMessage()."<br />
				   Kod: ".$this->Error->GetCode()."<br />";
				   //Ścieżka: ".$this->Error->GetTrace()."<br />";
	    
	    $trace = '';
		$tab = $this->Error->GetTrace();
		
		$txtResult =" Nazwa błędu: ".$this->msg."\nKomunikat: ".$this->Error->GetMessage()."\nKod: ";
	    $txtResult .= $this->Error->GetCode()."\n Plik: ".$this->Error->GetFile()."\nLinia: ";
	    $txtResult .= $this->Error->GetLine()."\nŚcieżka: ".$trace."\n";
	    
		$smarty = new mySmarty();
		$smarty->assign('tresc', $result);
		$ret = $smarty->fetch('cms/exception.tpl');
		$log = new adminLog(null);
		$log->writeErrorLog($txtResult);
		return $ret;
		
	}
	public function UserErrorForm($msg)
	{
		$smarty = new mySmarty();
		$smarty->assign('tresc', $msg);
		return $smarty->fetch('modules/exception.tpl');
	}
	
	public function __construct($e, $message)
	{
		$this->msg = $message;
		$this->Error = $e;
	//	$e->GetMessage().'\n'.$e->getCode().'\n'.$e->getFile().'\n'.$e.getTrace();
	}
}
?>
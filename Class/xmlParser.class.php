<?php
/*
-----------------------
Module xmlParser
Author: P. Brodziñski
Created: 21.08.2007
Mod: 21.08.2007
-----------------------
*/  

//XXX !!!!Na razie zarzucone, aplikacja bêdzie wykorzystywaæ SimpleXML
/*include '../Includes/paths.inc.php';

class xmlParser
{
	private $xmlFile;
	//private $xmlObject;
	private $docXML;
	
	public function __construct($xmlFile)
	{
		if (!file_exists($xmlFile))
		{
			throw new Exception('xmlParser - nie znaleziono '.$xmlFile);
		}
		else
		{	
			$this->xmlFile = $xmlFile;
			$this->docXml = new DOMDocument();
			$this->docXml->load($this->xmlFile);
			//if (!$xmlObject = DOMDocument::load($this->xmlFile))
		//		throw new Exception('Nie mo¿na za³adowaæ pliku '.$this->xmlFile);
		}
	}
	public function GetElementByTagName($name)
	{
		return $this->docXML->documentElement->getElementByTagName($name);
	}
	
}*/
?>
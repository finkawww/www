<?php
/*
---------------------
Installer class
Instaluje moduly
Utworzno: 29.08.2007
Mod: 29.08.2007
Autor : P. Brodzinski
---------------------
*/
class installMgr
{
	//o ktory modukl chodzi
	private $moduleName = '';
	
	//tu wartosci z xml - wypelniane przez parseInstallXml (simpleXml)	
	private $modulePath = '';
	
	protected function parseInstallXml()
	{
		Try
		{
			$domDocument = new DOMDocument('1.0','UTF-8');
			$domDocument->load("127.0.0.1/install.xml");
			$modules = $domDocument->getElementsByTagName("module");
			foreach ($modules as $module)
			{
				echo $module->nodeValue;
			}
			//$dokument = DOMDocument::load("127.0.0.1/install.xml");
		//	DOMElement::getAttribute('ver');
			//$path = $dokument->getElementsByTagName('path');
			
			//$module = $dokument->getElementsByTagName('module');
			
			//$s=$module->getAttribute('ver');
						
			//$instXml = simplexml_load_file("127.0.0.1/instal.xml");
			//echo 'Sciezka:'.$instXml->module->path.' !!!';
			//$this->modulePath = $instXml->module['name'];
			//echo "Sciezka:".$this->modulePath;
			
		}
		Catch (Exception $e)
		{
			$exc = new ExceptionClass($e, 'Installer module');
   			$exc->writeException();
		}
		
		
	}
	//zwraca tablice modulow do zainstalowania
	public function getModulesToInstall()
	{
		return $modulesToIntallArray;	
	}
	public function __construct()
	{
		
	}
	public function setModuleSrc($name)
	{
		$this->moduleName = $name;
	}
	public function installModule()
	{
		If ($this->moduleName != '')
		{
			$this->parseinstallXml();
			
		}
		else
		{
			//wyjatek
		}
		
	}
	public function __create()
	{
		
	}
	
}
?>
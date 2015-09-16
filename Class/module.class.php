<?php
// tu klasa abstrakcyjna, definiujaca wymagany interfejs pluginu
  abstract class moduleTemplate
  {
  	/*public $moduleName;
  	public $moduleVersion;*/
  	//metoda abstrakcyjna, wywoluje ekrany jak rowniez zwraca wyniki
  	//jest to jedyny interfejs miedzy aplikacja a modulem
  	private $moduleName;
  	private $moduleVersion;
  	  	
  	
  	public function getModuleName()
  	{
  		 
  	}
  	public function getModuleVersion()
  	{
  		 
  	}
  	
  	abstract public function executeAction($actionName, $l, $varArray);
  }
  

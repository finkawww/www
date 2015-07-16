<?php

/********************************
 *		Moduł Translator		*
 * 	Tłumaczy teskty na języki	*
 *	Autor: Piotr Brodziński		*
 *	Utworzony: 07.05.2008		*
 *								*
 ********************************/
 
 /*
 XPath - / root;
dla dokumantu:
<0>
	<a>
		<b id="1"></b>
		<b id="2"></b>
	</a>
</0>
odczytanie wszysktich b:

/0/a/b

b dla kt id=2
/0/a/b[@id="2"]

bez malpy  - wartosc w wezle

link: 
http://www.eioba.pl/a74722/simplexml_nadchodzi
(!)http://www.ygreg.com/pokaz.php/xpath

*/
 
 class translator
 {
 	private $translationXMLFile = '';
 	private $xmlDoc = null;
 	private $lang = '';
 	

 	public function __construct($xmlFile)
 	{
 		if ($xmlFile == '')
 		{
 			throw new Exception('Nie określono pliku translacji');
 		}
 		Else
 		{
 			$this->translationXMLFile = $xmlFile;
 			try
 			{
				$this->xmlDoc = simplexml_load_file($xmlFile);
 			}
 			Catch(Exception $e)
			{	
				$exc = new ExceptionClass($e, 'translator.Costruct');
   				$exc->writeException();   	   	
			}
 		}
 	}
 	
 	//ustawienie jezyka oraz wczytanie odpowiednich wezlow XML
 	public function setLanguage($lang)
 	{ 		 
 		 if ($lang == '')
 		 {	
 		 	throw new Exception('Brak argumentu lang');
 		 }
 		 else
 		 {
			$this->lang = $lang;
 		 }
 	}
 	
 	public function translate($tagName)
 	{
 		
 		$result = '';
 		
 		if ($this->lang == '')
 		{
 			throw new Exception('Nie ustaiwony język!');
 		}
 		
 		else
 		{
 			try
 			{
 			$tagValues = $this->xmlDoc->xpath("/translation/language[@value = \"$this->lang\"]/tagValue[@name=\"$tagName\"]");
 			$result = ($tagValues[0]['value']);
 			
 			}
 			catch(Exception $e)
 			{
 				$exc = new ExceptionClass($e, 'translator.translate:'.$tagName);
   				$exc->writeException();
 			} 			
 		}
 		return $result;
 	}
 }
?>
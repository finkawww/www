<?php
class Konfiguracja
{
	public function Rezerwacje()
	{
		$res = '';
		$xmlDoc = simplexml_load_file(rootPath.'/konfiguracja.xml');
		$tagValues = $xmlDoc->xpath("rezerwacje");
 		$res = ($tagValues[0][0]); 			
		return  ($res == 'T');
	}
	public function TowNaStrone()
	{
		$value = '';
		$xmlDoc = simplexml_load_file(rootPath.'/konfiguracja.xml');
		$tagValues = $xmlDoc->xpath("towarowNaStronie");
 		$res = ($tagValues[0][0]); 
		return $res;
		//towarowNaStronie
	}
	public function GetKontaktOperatorValue($valueName)
	{
		try
		{
			$value = '';
			$xmlDoc = simplexml_load_file(rootPath.'/Modules/Sklep/SklepClass/Konfiguracja/kontaktOperator.xml');
			$tagValues = $xmlDoc->xpath("$valueName");
 			$result = ($tagValues[0][0]); 	
			
			return $result;
		}
		catch (exception $e)
		{
			//FIXME Tu wpisac blad do loga i kontynuowac	
		}
		
	}
	public function GetStawkaVat()
	{
		$value = '';
		$xmlDoc = simplexml_load_file(rootPath.'/konfiguracja.xml');
		$tagValues = $xmlDoc->xpath("vat");
 		$res = ($tagValues[0][0]); 
		return $res; 
	}
	public function CzyRabatWlaczony()
	{
		$value = '';
		$xmlDoc = simplexml_load_file(rootPath.'/konfiguracja.xml');
		$tagValues = $xmlDoc->xpath("rabaty");
 		$res = ($tagValues[0][0]); 
		return $res=='T';
	}
}
?>

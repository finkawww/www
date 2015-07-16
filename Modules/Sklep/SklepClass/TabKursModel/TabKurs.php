<?php
//Tabele
//slownik walut - w jezykach
//TabKurs - data, nazwa
//TabKursValues - waluta, kurs

final class KursyItems
{
	public $waluta;
	public $kurs;
}

class TabKurs
{
	private $date;
	private $nazwa;
	private $kursyItems = array();
	
	public function __construct()
	{
		
	}
	public function __destruct()
	{
		
	}
	//Zwraca walutę -  na podstawie języka
	public function GetWaluta()
	{
		
	}
	public function GetWartosc($wartoscPLN)
	{
		
	}
	public function Save($id)
	{
		
	} 
	public function Load($date)
	{
		
	}
	
	
	
}
?>
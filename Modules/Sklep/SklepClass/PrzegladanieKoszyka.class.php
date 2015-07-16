<?php
class PrzegladanieKoszyka
{
	private $KoszykView = null;
	
	public function __Construct()
	{
		//require_once rootPath.'/Modules/Sklep/SklepClass/KoszykModel/Koszyk.php';
		//$this->Koszyk = GetKoszykSingletone();
		require_once rootPath.'/Modules/Sklep/SklepClass/KoszykView/KoszykView.php';
		$this->KoszykView = new KoszykView();
	}
	public function PokazKoszykFull()
	{
		//nie przekazuje koszyka gdyz jest on dostepny w sesji
		$html = $this->KoszykView->PokazKoszykFull();
		return $html;
	}
	public function PokazKoszykStatus()
	{
		$html = $this->KoszykView->PokazKoszykStatus();
		return $html;
	}
	public function PrzeliczKoszyk($pozycjeValues)
	{
		
	}
	
}
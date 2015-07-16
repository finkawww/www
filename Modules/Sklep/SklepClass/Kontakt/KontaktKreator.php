<?php
/*
 * 
 * 
 */
class KontaktKreator
{
	private $obj = null;
		
	public function FactoryMethod ($ktory, $Id)
	{
		
		switch($ktory)
		{
			case 'rejestracja':
				{
					require_once rootPath.'/Modules/Sklep/SklepClass/Kontakt/KontaktRejestracja/KontaktRejestracja.php';
					$this->obj = new KontaktRejestracja($ktory, $Id);
					break;  			
				}
			case 'resetHasla':
				{
					require_once rootPath.'/Modules/Sklep/SklepClass/Kontakt/KontaktResetHasla/KontaktResetHasla.php';
					$this->obj = new KontaktResetHasla($ktory,$Id);
					break;
				}
			case 'zlozenieZamowienia':
				{
					
					require_once rootPath.'/Modules/Sklep/SklepClass/Kontakt/KontaktZlozenieZamowienia/KontaktZlozenieZamowienia.php';
					$this->obj = new KontaktZlozenieZamowienia($ktory,$Id);
					break;
				}
			case 'zmianaStat':
				{
					require_once rootPath.'/Modules/Sklep/SklepClass/Kontakt/KontaktZmianaStat/KontaktZmianaStat.php';
					$this->obj = new KontaktZmianaStat($ktory,$Id);
					break;
				}
			case 'wysylanieRabatu':
				{
					require_once rootPath.'/Modules/Sklep/SklepClass/Kontakt/KontaktWysylanieRabatu/KontaktWysylanieRabatu.php';
					$this->obj = new KontaktWysylanieRabatu($ktory,$Id);
					break;
				}
		}
		return $this->obj;
	}
}
?>
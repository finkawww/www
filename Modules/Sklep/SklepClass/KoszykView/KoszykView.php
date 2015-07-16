<?php 
final class PrintItem
{
	public $nazwaTowaru;
	public $opis;
	public $id;
	public $cenaNetto;
	public $cenaBrutto;
	public $ilosc; //ilosc egzemplarzy
	public $iloscFirm;
	public $zdjecieMin;
	public $alg;
	
}
final class PrnKoszykItem
{
	public $towarId;
	public $ilosc; //ilosc egzemplarzy
	public $iloscFirm;
} 

class KoszykView
{
	public function PokazKoszykFull()
	{
		//pozycje - towary
		$koszykItems = array();
		//tablica z pelnymi danymi do wyswietlenia
		$printItems = array();
		$koszykTmp = GlobalObj()->Koszyk();
	
		//pozycje
		//	nazwa ilosc cena brutto
		// podsumowanie - warto�� zam�wienia
		$count = $koszykTmp->ItemsCount();
		
		for ($i=0;$i<$count; $i++)
		{
			$prnItem = new PrnKoszykItem();
			$idTowTmp = $koszykTmp->GetTowarId($i);
			
			$prnItem->towarId = $koszykTmp->GetTowarId($i);
			$prnItem->ilosc = $koszykTmp->GetTowarIlosc($i);
			$prnItem->iloscFirm = $koszykTmp->GetTowarIloscFirm($i);
			
			//
			//sprawdzam, czy towar nie jest zarezerwowany lub nie ma ilosc = 0
			// jezeli ma nie wyswietlam do koszyka
			$towarTmp = new Towar();
			$towarTmp->Load($prnItem->towarId, $_SESSION['lang']);
			
			$rezerwacja = new Konfiguracja();
			$rezerwacje = $rezerwacja->Rezerwacje();
			unset($rezerwacja);
		
			if (($towarTmp->GetIlosc() > 0) && ($towarTmp->GetZarezerwowany()=='N') || (!$rezerwacje))
			{
				$koszykItems[] = $prnItem;
			}
			else
			{
				
				$koszykTmp->UsunPozycje($idTowTmp);
				/*$moduleTmp = new ModulesMgr();
				$moduleTmp->loadModule('Sklep');
				$action = $moduleTmp->getModuleActionIdByName('PokazKoszykFull');
				unset($moduleTmp);
				header("Location: ?a=$action");*/
			}
			unset($towarTmp);
		}
		
		
		$wartoscPrn = 0;
		$count = count($koszykItems);
		$konfiguracja = new Konfiguracja();
                $rabatObj= new Rabat();
                $rabatObj->Load();
		for ($i=0; $i<$count; $i++)
		{
			$idTowaru = $koszykItems[$i]->towarId;
			$ilosc = $koszykItems[$i]->ilosc;
			$iloscFirm = $koszykItems[$i]->iloscFirm;
			$towarTmp = new Towar();
			$towarTmp -> Load($idTowaru, $_SESSION['lang']);
			$printItemTmp = new PrintItem();
			$printItemTmp -> nazwaTowaru = $towarTmp->GetNazwa();
			$printItemTmp -> opis = $towarTmp->GetOpis();
                        if(!$rabatObj->GetRabatEnabled())
                        {
                            $printItemTmp -> cenaNetto = number_format($towarTmp->GetCena($ilosc, $iloscFirm), 2, ',', ' ');
                            $printItemTmp -> cenaBrutto = number_format($towarTmp->GetCena($ilosc, $iloscFirm)*(1+$konfiguracja->GetStawkaVat()/100), 2, ',', ' ');
                        }
                        else
                        {
                            $printItemTmp -> cenaNetto = number_format($towarTmp->GetCenaParams($ilosc, $iloscFirm), 2, ',', ' ');
                            $printItemTmp -> cenaBrutto = number_format($towarTmp->GetCenaParams($ilosc, $iloscFirm)*(1+$konfiguracja->GetStawkaVat()/100), 2, ',', ' ');
                        }
			$printItemTmp -> ilosc = $ilosc; //ilosc egzemplarzy
			$printItemTmp -> iloscFirm = $iloscFirm;
			$printItemTmp -> zdjecieMin = $towarTmp->GetObrazMin();
			$printItemTmp -> id = $towarTmp->GetId();
			$printItemTmp -> alg = $towarTmp->GetAlgCeny(); 
			$printItems[] = $printItemTmp;
                        if(!$rabatObj->GetRabatEnabled())
                        {
                            $wartoscPrn += $towarTmp->GetCena($ilosc, $iloscFirm);
                        }
                        else
                        {
                            $wartoscPrn += $towarTmp->GetCenaParams($ilosc, $iloscFirm);
                        
                        }
			
		}
		//akcje: przelicz, zamow, wr�� do zakup�w(widoczna jezeli qs<>-1)
		$backAction = GlobalObj()->GetSessPrimitive('koszykBack');
		
		$moduleTmp = new ModulesMgr();
		$moduleTmp->loadModule('Sklep');
		$przeliczActn = $moduleTmp->getModuleActionIdByName('PrzeliczKoszyk');
		$ZamowActn = $moduleTmp->getModuleActionIdByName('ZlozZamowienie');
		$WyczyscActn = $moduleTmp->getModuleActionIdByName('WyczyscKoszyk');
		$usunPozActn = $moduleTmp->getModuleActionIdByName('UsunPozycjeKoszyk');
		unset($moduleTmp);
		$konfiguracja = new Konfiguracja();
		$rezerwacje = $konfiguracja->Rezerwacje(); 
		$vat = $konfiguracja->GetStawkaVat();
		$smarty = new mySmarty();
		//pozycje
		$smarty->assign('ilePoz', count($printItems));
		$smarty->assign('pozycje', $printItems);
		//podsumowanie		
		$smarty->assign('razem', number_format($wartoscPrn, 2, ',', ' '));
		$smarty->assign('razemBrutto', number_format($wartoscPrn*(1+$vat/100), 2, ',', ' '));
		$smarty->assign('backAct', $backAction);
		
		$smarty->assign('wyczyscAct', $WyczyscActn);
		$smarty->assign('rezerwacje', $rezerwacje);
		$smarty->assign('usunPozAct', $usunPozActn);
		
		$smarty->assign('przeliczAct', $przeliczActn);
		$smarty->assign('ZamowAct', $ZamowActn);
						
		$html = $smarty->fetch('modules/KoszykFull.tpl');
		
		return $html;
	}
	public function PokazKoszykStatus()
	{
		$koszykTmp = GlobalObj()->Koszyk();
		$koszykTmp->nic = 5;
		$ileTowarow = $koszykTmp->GetIloscWszystkich();
		$moduleTmp = new ModulesMgr();
		$moduleTmp->loadModule('Sklep');
		$koszykAct = $moduleTmp->getModuleActionIdByName('PokazKoszykFull');
		unset($moduleTmp);
		$smarty = new mySmarty();
		$smarty->assign('ile', $ileTowarow);
		$smarty->assign('koszykAct', $koszykAct);
		
		$html = $smarty->fetch('modules/KoszykStatus.tpl');
		
		return $html;
	}
	
}
?>
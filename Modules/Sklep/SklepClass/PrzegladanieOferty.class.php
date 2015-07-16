<?php
class PrzegladanieOferty
{
	
	private $KoszykView = null;
	private $Oferta = null;
	private $OfertaView = null;
	
	public function __Construct()
	{ 
		$this->KoszykView = new KoszykView();
		$this->Oferta = new Oferta();
		$this->OfertaView = new OfertaView();
	}
	
	public function GetIdOferty($idStrony)
	{
		return $this->Oferta->GetId($idStrony);
	}
	public function PokazGrupeOfert($menuId)
	{
		//wczytuje grupy ofert przypisane do
		$arrGrupa = array(); 
		$arrGrupa = $this->Oferta->LoadGrupa($menuId);
		return $this->OfertaView->PokazGrupe($arrGrupa);
	}
	public function PokazOferte($id)
	{
		$this->Oferta->Load($id);
		//$this->OfertaView->SetAddKoszykAction($AddKoszykAction);
		$html = $this->OfertaView->PokazOferte($this->Oferta);
		return $html;
	}
	public function PokazOfertyGrupy($id)
	{
		
		$html = $this->OfertaView->PokazOfertyGrupy($id);
		return $html;
	}
	public function DodajTowarDoKoszyka($idTowaru)
	{
		$towarTmp = new Towar();
		$towarTmp->Load($idTowaru, $_SESSION['lang']);
		if (($towarTmp->GetRezerwacja() == 'N')&&($towarTmp->GetIlosc()>0))
		{
			GlobalObj()->Koszyk()->AddTowar($idTowaru, 1);
		}
		GlobalObj()->RefreshCookieKoszyk();
				
		$moduleTmp = new ModulesMgr();
		$moduleTmp->loadModule('Sklep');
		$html = $moduleTmp->moduleExecuteAction('PokazKoszykFull', nil);
		unset($moduleTmp);
				
		return $html; 
	}
}
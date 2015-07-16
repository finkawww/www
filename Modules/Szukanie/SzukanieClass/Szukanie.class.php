<?php
class SzukanieClass
{
	private $dbInt = null;
	private $translator = null;
	public function __construct()
	{
		$this->dbInt = DBSingleton::GetInstance();
		$this->translator = new translator(rootPath.'/Modules/Szukanie/Szukanie.Translation.xml');
		$this->translator->setLanguage($_SESSION['lang']);
	}
	private function SzukajOfert($str)
	{
			$query = "
			SELECT 
				`tytul`, 
				`opisShort`,
				`id`,
				`obrazTyt`
			FROM 
				`Oferty` 
			WHERE `opis` LIKE '%$str%' or `opisShort` LIKE '%$str%'
			";
			
			$result = $this->dbInt->ExecQuery($query);
			$ile = 0;
			
			$moduleTmp = new ModulesMgr();
			$moduleTmp->loadModule('Sklep');
			$actionOferta = $moduleTmp->getModuleActionIdByName('PokazOferte');
		 	unset($moduleTmp);
			$html = '';
			while ($data = $result->fetchRow(DB_FETCHMODE_ASSOC))
			{
				$ofertaId = $data['id'];
				$tytul = $data['tytul'];
				$opis = $data['opisShort'];
				$obraz = $data['obrazTyt'];
				
				$smarty = new mySmarty();
				$smarty->assign('tytul', $tytul);
				$smarty->assign('obraz', $obraz);
				$smarty->assign('opis', $opis);
				$smarty->assign('id', $ofertaId);
				$smarty->assign('actionOferta', $actionOferta);
				$html .= $smarty->fetch('modules/searchResOferty.tpl');
				unset($smarty);	
			}
			if ($html == '')
				$html = 'Brak wyników wyszukiwania'; 
			return $html;
	}
	private function SzukajTowarow($str)
	{
		$query = "
			SELECT 
				T.`nazwa`, 
				T.`opis`,
				ot.`FkOferta`,
				o.`opis` as opisOferty,
				T.`obrazMin`
			FROM 
				Towary T 
					inner join `OfertyTowary` ot ON T.`id` = ot.`FKTow` 
					inner join `Oferty` o on o.`id` = ot.`FkOferta` 
			WHERE T.`opis` LIKE '%$str%'
			";
			
			$result = $this->dbInt->ExecQuery($query);
			$ile = 0;
			
			$moduleTmp = new ModulesMgr();
			$moduleTmp->loadModule('Sklep');
			$actionOferta = $moduleTmp->getModuleActionIdByName('PokazOferte');
		 	unset($moduleTmp);
			$html = '';
			while ($data = $result->fetchRow(DB_FETCHMODE_ASSOC))
			{
				$ofertaId = $data['FkOferta'];
				$tytul = $data['nazwa'];
				$opis = $data['opis'];
				$obraz = $data['obrazMin'];
				$opisOferty = $data['opisOferty'];
				
				$smarty = new mySmarty();
				$smarty->assign('tytul', $tytul);
				$smarty->assign('obraz', $obraz);
				$smarty->assign('opis', $opis);
				$smarty->assign('opisOferty', $opisOferty);
				$smarty->assign('id', $ofertaId);
				$smarty->assign('actionOferta', $actionOferta);
				$html .= $smarty->fetch('modules/searchResTowary.tpl');
				unset($smarty);	
			}
			if ($html == '')
			$html = 'Brak wyników wyszukiwania'; 
			return $html;
	}
	private function SzukajStrony($str)
	{
		$html = '';
		$query = "
			SELECT 
				content, 
				id 
			FROM 
				cmsSections 
			WHERE content LIKE '%$str%'
			";
		
		$result = $this->dbInt->ExecQuery($query);
		$ile = 0;
		$hmlt = '';
		while ($data = $result->fetchRow(DB_FETCHMODE_ASSOC))
		{
			$ile++;
			$sectionId = $data['id'];
			
			
			$queryPage = 
			"
			SELECT 
				m.id as MenuId,
				p.PageName
			FROM
				cmsPages p 
				INNER JOIN cmsSectionsToPages sp 
					ON p.id = sp.PK_PageId
				INNER JOIN cmsMenu m
					ON p.id = m.FK_PageId
			WHERE
				sp.PK_SectionId = $sectionId
			";
			$qResult = $this->dbInt->ExecQuery($queryPage);
			$res = $qResult->fetchRow(DB_FETCHMODE_ASSOC);
			$menuId = $res['MenuId'];
			$cont = strip_tags($data['content']);
			$searchContTmp = substr($cont, 0, 128);
			$ShortName = $res['PageName'];
			$ostatniaSpacja = strrpos($searchContTmp, ' ');
			
			if (($ostatniaSpacja) && (count($searchContTmp)>128))
			{
				$searchCont = substr($searchContTemp, 0, $ostatniaSpacja).'...';
			}
			else
			{
				$searchCont = $searchContTmp.'...';	
			}
			
			
			$smarty = new mySmarty();
			
			$smarty->assign('SearchRes', $searchCont);
			$smarty->assign('nazwa', $ShortName);
			$smarty->assign('MenuId', $menuId);
			
			$html.= $smarty->fetch('modules/searchResPages.tpl');
			unset($smarty);
			
						
		}
		if ($html == '')
			$html = 'Brak wyników';
		return $html;
		
	}
	public function Szukaj($str)
	{
		$html = ''; $res='';
		if (strlen($str)>2)
		{
		//1. Realizacje s�owa kluczowe
		
		//2. Strony (tresc)
			$resOferty = $this->SzukajOfert($str);
			$resTowary = $this->SzukajTowarow($str);
			$resStrony = $this->SzukajStrony($str);
		
	
	    	$smarty = new mySmarty();
			$smarty->assign('resOferty', $resOferty);
			$smarty->assign('resTowary', $resTowary);
			$smarty->assign('resStrony', $resStrony);
			$html = $smarty->fetch('modules/searchRes.tpl');
		}			
		//if ($html == '')
		//	$html = 'Brak wyników';
		unset($smarty);
		return $html;
	}
	public function ShowSzukajStatus()
	{
		$moduleTmp = new ModulesMgr();
		$moduleTmp->loadModule('Szukanie');
		$actionSzukaj = $moduleTmp->getModuleActionIdByName('Szukaj');
		 
		$text = $this->translator->translate('text');
		$smarty = new mySmarty();
		$smarty->assign('Text', $text);
		$smarty->assign('findAction', $actionSzukaj);
					
		$html = $smarty->fetch('modules/search.tpl');
		unset($smarty);
		return $html;
	}
}
?>
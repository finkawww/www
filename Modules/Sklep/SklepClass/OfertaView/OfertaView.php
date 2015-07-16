<?php
final class OfertaGroupItem
{
	public $idOferty;
	public $obraz;
	public $actionPokazOferte;
}
final class GrupyItem
{
	public $nazwaOferty;
	public $idOferty;
}
final class OfertaItem
{
	public $idTowaru;
	public $opisTowaru;
	public $cenaTowaru;
	public $cenaTowaruFormatted;
        public $cena2Towaru;
	public $cena2TowaruFormatted;
	public $rabat;

	public $obrazMin;
	public $obrazFull;
	public $nazwaTowaru;
	public $actionDoKoszyka;
	public $idOferty;
	public $algCeny; //alg liczenia ceny

}


class OfertaView
{
	private $Oferta;
	private $Konfiguracja;
	private $OfertyArr = array();
	private $AddKoszykAction;
	private $ofertaId;

	private function ShowAfterOfertaAdd($id)
	{
		$html = '';
		//$delQuery = "DELETE FROM cmsMenu WHERE id=$menuId";
		//$dbInt = DBSingleton::getInstance();
		//$dbInt->ExecQuery($delQuery);

		$module = new ModulesMgr();
		$module->loadModule('Sklep');
		$okAction = $module->getModuleActionIdByName('ShowTowaryAdmin');
		if ($id == 0)
		{
			$dialog = new dialog('Dodano ofertę' , 'Dodano ofertę', 'Info', 300, 150);
		}
		else
		{
			$dialog = new dialog('Zmieniono ofertę' , 'Zmieniono ofertę', 'Info', 300, 150);
		}
		$dialog->setAlign('center');
		$dialog->setOkCaption('Ok');
		$dialog->setOkAction($okAction);
		$html .= $dialog->show(1);

		return $html;
	}

	public function InitializeView($ofertaArr)
	{

	}
	public function ShowOfertaAdmin()
	{
		$html = '';
		$module = new modulesMgr();
		$module->loadModule('Sklep');
		$addAction = $module->getModuleActionIdByName('AddOfertaAdmin');
		$editAction = $module->getModuleActionIdByName('EditOfertaAdmin');
		$delAction =  $module->getModuleActionIdByName('DelOferta');
		unset($module);
		$addButton = new button(buttonAddIcon, 'Dodaj ofertę', $addAction, -1);

		$query = "
 				SELECT 
 					o.id, o.nazwa, o.opis, go.nazwa as nazwaGr 
				FROM
					Oferty o 
						LEFT JOIN GrupyOfert go ON go.id = o.FkGrupy
						 
				ORDER BY 
					go.nazwa, o.nazwa";
			
		$html .= '<table class="Grid" align="center" cellspacing=0>';
		$html .= '<tr>';
		$html .= '<td width=50><img src="./Cms/Files/Img/about-48x48.png" /></td>';
		$html .= '<td><br/></td>';
		$html .= '</tr>';
		$html .= '<tr><td align="right" colspan="2"><hr/>';
		$html .= $addButton->show(1);
		$html .= '</td></tr>';
		$html .= '<tr><td>';
		$grid = new gridRenderer();
		$grid -> setTitle('Grupy ofert');
		$grid -> setGridAlign('center');
		$grid -> setGridWidth(780);
		$grid -> addColumn('nazwa', 'Nazwa', 200, false, false, 'left');
		$grid -> addColumn('opis', 'Opis', 400, false, false, 'left');
		$grid -> addColumn('nazwaGr', 'Grupa', 200, false, false, 'left');
		$grid -> addColumn('id', '', 10, true, false, 'right');
		$grid -> enabledDelAction($delAction);
		$grid -> enabledEditAction($editAction);
		$grid -> setDataQuery($query);
		$html .= $grid->renderHtmlGrid(1);
		$html .= '</td></tr>';
		$html .= '<tr><td align="right" colspan="2">';
		$html .= $addButton->show(1);
		$html .= '</td></tr>';
		$html .= '</table>';
			
		return $html;
	}

	public function AddOfertaAdmin($id)
	{
		saveActionValue();
		$_SESSION['tmpOfertaId'] = $id;

		$this->ofertaId = $id;
		$html = '';
		$langs = array();
		$langNazwy = array();
		$langOpisy = array();

		$html = '';

		$rezerwacja = new Konfiguracja();
		$rezerwacje = $rezerwacja->Rezerwacje();
		unset($rezerwacja);

		$langQuery = "
    			SELECT DISTINCT
    			  ShortName
    			FROM
    			  cmsLang ORDER BY id
    				";
			
		$DBInt = DBSIngleton::getInstance();
		$qResult = $DBInt->ExecQuery($langQuery);
		$i = 0;
		while ($data = $qResult->fetchRow(DB_FETCHMODE_ASSOC))
		{
			$langs[] = $data['ShortName'];
		}

		if ($id == 0)
		{
			$hdrText = 'Dodawanie oferty';
		}
		else
		{
			$hdrText = 'Edycja oferty';
		}

                
		$html .= '<center><table width="580" align="center" cellpadding=0 cellspacing=0 border=0><tr><td>';

		$myForm = null;
		$myForm = new Form('dFORM', 'POST') ;
		$OfertaForm = null;
		$OfertaForm = $myForm->getFormInstance();
		$OfertaForm -> addElement('header', ' hdrTest', $hdrText);
		$moduleTmp = new ModulesMgr();
		$moduleTmp->loadModule('Sklep');
		//(tytul, opis, opisShort)*2 , obrazTyt
		if ($id == 0)
		{
			$action = $moduleTmp->getModuleActionIdByName('AddOfertaAdmin');
		}
		else
		{
			$action = $moduleTmp->getModuleActionIdByName('EditOfertaAdmin');
		}

		$OfertaForm->addElement('hidden', 'a', $action, null);
		$valId = $OfertaForm->addElement('hidden', 'id', $id);
			
		for($i = 0; $i < count($langs); $i++)
		{

			$langNazwy[$langs[$i]] =  $OfertaForm->addElement('text', 'nazwa'.$langs[$i], 'Nazwa ('.$langs[$i].')', array('size' => 50, 'maxlength'=> 200));

		}

		for($i = 0; $i < count($langs); $i++)
		{
			$langOpisySzczeg[$langs[$i]] = $OfertaForm->addElement('textarea', 'opis'.$langs[$i], 'Opis szczegółowy ('.$langs[$i].')', array('cols'=>50, 'rows'=>5, 'maxlength'=>300));
		}
		$obraz = $OfertaForm->addElement('file', "obraz", "Obraz");


		$action = $moduleTmp->getModuleActionIdByName('ChooseMenuOferta');
		unset($moduleTmp);

		$parentGrupa = $OfertaForm->addElement('text', 'txtNazwa', 'Przypisana do grupy', 'readonly="readonly"');
		$button = $OfertaForm->addElement('button', 'btnShortNazwa', 'wybierz...', '');
		$buttonattributes = array('title'=>'asdasd', 'onclick'=>"return window.open('?a=$action&onlycontent=1&idcol=hidden&namecol=txtNazwa', 'Wybór', 'menubar=0,location=0,directories=0,toolbar=0,scrollbars=1,resizable,dependent,width=720,height=500');");
		$button->updateAttributes($buttonattributes);

		$OfertaForm->addElement('reset', 'btnReset', 'Wyczyść');
		$OfertaForm->addElement('submit', 'btnSubmit', 'Zapisz');
			
		$OfertaForm->addRule('nazwaPL', 'Pole "Nazwa" musi być wypełnione', 'required', null, 'server');
		$OfertaForm->addRule('obraz', 'Maksymalny rozmiar pliku to 1 MB', 'maxfilesize', 1024000);
			
		$OfertaForm->applyFilter('__ALL__', 'trim');
		$myForm->setStyle(2);
			
		if ($OfertaForm->validate())
		{
			$this->Oferta = new Oferta();
			if ($id != 0)
			$this->Oferta->Load($id);



			$fileInf = $obraz->GetValue();
			if (($fileInf['name'] <> ''))
			{
				if ($obraz->isUploadedFile())
				{

					$nazwaObr = $fileInf['name'];


					$obraz->moveUploadedFile('./FrontPage/Files/ImgShop/');
					$this->Oferta->SetObraz($nazwaObr);
				}
			}
			//(tytul, opis, opisShort)
			//$tmpMenuMgr = MenuMgr::getInstance();
			//$parentMenuName = $parentMenu->getValue();
			//$menuItem = $tmpMenuMgr->getMenuIdByName($parentMenuName);
			$grName = $parentGrupa->GetValue();
			$gr = new GrupaOfert();
			$gr->LoadByName($grName);
			$idGr = $gr->GetId();
			unset($gr);

			//echo 'Menu:'.$menuItem;
			$this->Oferta->SetNazwa($langNazwy['PL']->GetValue());
			$this->Oferta->SetOpis($langOpisySzczeg['PL']->GetValue());

			$this->Oferta->SetIdGrupy($idGr);
			$this->Oferta->SetId($id);
			$this->Oferta->Save($id);

			$queryLang = "SELECT ShortName FROM cmsLang WHERE ShortName <>'PL'";
			$DBInt = DBSIngleton::getInstance();
			$qResult = $DBInt->ExecQuery($queryLang);

			$nazwaTmp = $langNazwy['PL']->GetValue();


			while ($data = $qResult->fetchRow(DB_FETCHMODE_ASSOC))
			{
				$updateQuery = 'UPDATE OfertyLang SET ';
				$lang = $data['ShortName'];
				$coma = false;
				if ((isset($langNazwy[$lang]))&&($langNazwy[$lang]->GetValue() <> ''))
				{
					$updateQuery .= ' nazwa="'.$langNazwy[$lang]->GetValue().'"';
					$coma = true;
				}
				if ((isset($langOpisySzczeg[$lang]))&&($langOpisySzczeg[$lang]->GetValue() <> ''))
				{
					if ($coma) $updateQuery.=',';
					$updateQuery .= ' opis="'.$langOpisySzczeg[$lang]->GetValue().'"';
					$coma=true;
				}

				$updateQuery .= " WHERE FKOferta=$id and lang='$lang'";
					
				$DBInt = DBSIngleton::getInstance();
				$DBInt->ExecQuery($updateQuery);

				$module = new ModulesMgr();
				$module->loadModule('Sklep');
				$okAction = $module->getModuleActionIdByName('ShowOfertyAdmin');
				$dialog = new dialog('Zapis oferty', 'Oferta zapisana prawidłowo', 'Info', 300, 150);
				$dialog->setAlign('center');
				$dialog->setOkCaption('Ok');
				$dialog->setOkAction($okAction);
				$html .=$dialog->show(1);
			}
		}//of if Validate
		else
		{
			if($_SESSION['tmpOfertaId']!=0)
			{
				$this->Oferta = new Oferta();
				$this->Oferta->Load($_SESSION['tmpOfertaId']);
				$langNazwy['PL']->setValue($this->Oferta->GetNazwa());
				$langOpisySzczeg['PL']->setValue($this->Oferta->GetOpis());


				if ($this->Oferta->GetIdGrupy()>0)
				{
					$gr = new GrupaOfert();
					$gr->Load($this->Oferta->GetIdGrupy(), 'PL');
					$parentGrupa->SetValue($gr->GetNazwa($this->Oferta->GetIdGrupy()));

				}

				$obraz->SetValue($this->Oferta->GetObraz());

				$queryLang = "SELECT ShortName FROM cmsLang WHERE ShortName <>'PL'";
				$DBInt = DBSIngleton::getInstance();
				$qResult = $DBInt->ExecQuery($queryLang);
				while ($data = $qResult->fetchRow(DB_FETCHMODE_ASSOC))
				{
					$lang = $data['ShortName'];

					$query = "
						SELECT nazwa, opis
						FROM OfertyLang
						WHERE FKOferta=$id AND lang='$lang'		
								";
					$qResult2 = $DBInt->ExecQuery($query);
					$data2 = $qResult2->fetchRow(DB_FETCHMODE_ASSOC);

					$langNazwy["$lang"]->setValue($data2['nazwa']);
					$langOpisySzczeg["$lang"]->setValue($data2['opis']);

				}
			}
			$html .= $OfertaForm->toHtml();
			$moduleTmp = new ModulesMgr();
			$moduleTmp->loadModule('Sklep');
			$actionBack = $moduleTmp->getModuleActionIdByName('ShowOfertyAdmin');
			$actionTowPrzypisane = $moduleTmp->getModuleActionIdByName('ShowPrzypiszTowarOfercie');
			unset($moduleTmp);
			$html .= '</td></tr><tr><td>
				  <table width = "100%" class="Grid" >';
			$html .= '<tr><td align="right">';

			$buttonPage = new button('../Cms/Files/Img/delete-16x16.png', 'Przypisane towary', $actionTowPrzypisane, $id);
			if ($id!=0)
			$html .=$buttonPage->show(1);

			$buttonPage2 = new button('../Cms/Files/Img/delete-16x16.png', 'Wróć do listy ofert', $actionBack, -1);
			$html .= $buttonPage2->show(1);
			$html .= '</td></tr>';
			$html .= '</table>';
		}
		//przyciski - pokaz towary przypisane, powrót do listy ofert
			

		$html .= '</td></tr></table>';

		return $html;



	}

	public function ShowPrzypiszTowarOfercieAdmin($id)
	{
		$html = '';
		$module = new modulesMgr();
		$module->loadModule('Sklep');
		$addAction = $module->getModuleActionIdByName('ChooseTowarOferta');
		//$editAction = $module->getModuleActionIdByName('EditPrzypisanie');
		$delAction =  $module->getModuleActionIdByName('DelPrzypisanie');
		$upAction = $module->getModuleActionIdByName('towOfertaUp');
		$downAction = $module->getModuleActionIdByName('towOfertaDown');
			
		unset($module);
		$addButton = new button(buttonAddIcon, 'Dodaj/edytuj przypisanie', $addAction, $id);
		$path = '/FrontPage/Files/ImgShop/';
		$query = "SELECT
 				OT.id, T.nazwa,  T.wersja, 
 				CONCAT('$path',T.obrazMin) AS obrazMin, OT.sortkey 
 			FROM Towary T
 				INNER JOIN OfertyTowary OT ON OT.FKTow = T.id
 				INNER JOIN Oferty O ON O.id = OT.FKOferta 
 			WHERE
 				O.id = $id
 			ORDER BY
 				OT.sortkey 
 				";
			
		$html .= '<table class="Grid" align="center" cellspacing=0>';
		$html .= '<tr>';
		$html .= '<td width=50><img src="./Cms/Files/Img/about-48x48.png" /></td>';
		$html .= '<td><br/></td>';
		$html .= '</tr>';
		$html .= '<tr><td align="right" colspan="2"><hr/>';
		$html .= $addButton->show(1);
		$html .= '</td></tr>';
		$html .= '<tr><td>';
		$grid = new gridRenderer();
		$grid -> setTitle('Przypisane towary');
		$grid -> setGridAlign('center');
		$grid -> setGridWidth(780);
		$grid -> addColumn('nazwa', 'Nazwa', 200, false, false, 'left');
		$grid -> addColumn('wersja', 'Wersja', 200, false, false, 'left');
		$grid -> addColumn('sortkey', 'Kolejność', 200, false, false, 'left');
		$grid -> addColumn('obrazMin', 'Miniatura', 200, false, false, 'center', true);
		$grid -> addColumn('id', '', 10, true, false, 'right');
		$grid -> enabledDelAction($delAction);
		//$grid -> enabledEditAction($editAction);
		$grid->addAction($upAction, '../Cms/Files/Img/up.gif');
		$grid->addAction($downAction, '../Cms/Files/Img/down.gif');
		$grid -> setDataQuery($query);
		$html .= $grid->renderHtmlGrid(1);
		$html .= '</td></tr>';
		$html .= '<tr><td align="right" colspan="2">';
		$html .= $addButton->show(1);
		$html .= '</td></tr>';
		$html .= '</table>';
		return $html;
	}
	public function ShowChooseTowar($id)
	{
		//tu pokazuje groda z chkboxami do wyboru towaru
		$licznik = 0;
		$result = '';
		$moduleTmp = new ModulesMgr();
		$moduleTmp->LoadModule('Sklep');
		$action = $moduleTmp->getModuleActionIdByName('PrzypiszTowaryDo');
		unset($moduleTmp);

		$query = "SELECT
		 			id, nazwa, opis, wersja, obrazMin
				  FROM
				    Towary
				  ORDER BY nazwa
					";


		$gridTableBegin = "<center><table class=\"Grid\" width=\"700\" align=\"center\" cellspacing=\"1\" cellpadding=\"0\">";
		$gridTableEnd = '</table></center>';
		$gridTitle = "<tr class=\"gridTitle\"><td colspan=\"7\" width=\"100%\" align=\"center\">";
		$gridTitle .= 'Przypisanie towaru do oferty'.'</td></tr>';
		$gridHeader = '<tr>
						<td width="35" align="center"></td>
						<td width="125" align="center">Nazwa</td>
						<td width="125" align="center">Opis</td>
						<td width="125" align="center">Wersja</td>
						<td width="125" align="center">Miniatura</td>
						</tr>
						';
		$DBInt = DBSingleton::getInstance();
		$queryResult = $DBInt->ExecQuery($query);
		$data = $queryResult->fetchRow(DB_FETCHMODE_ASSOC);
		$rowNr = 0;
		//jezeli puste dane to daje Brak danych
		if (count($data)==0)
		{
			$ileKolumn = 5;
			$result .= "<tr class=\"rowDark\"><td width =\"100%\" colspan=\"5\" align=\"center\">--- Brak danych ---</td></tr>";
		}
		else
		{
			$result .= '<form method="get" action="'.dnsPath.'/cms.php">';
			$result .= "<input type=\"hidden\" name=\"id\" value=\"$id\" />";
			$result .= "<input type=\"hidden\" name=\"a\" value=\"$action\" />";
			do
			{
				$idTow = $data['id'];
				$queryChecked = "SELECT count(1) AS Ile FROM OfertyTowary WHERE FKOferta=$id and FKTow=$idTow";
				$queryResult2 = $DBInt->ExecQuery($queryChecked);
				if (count($queryResult2)>0)
				{
					$data2 = $queryResult2->fetchRow(DB_FETCHMODE_ASSOC);
					$txtChecked = '';
					if ($data2['Ile'] > 0)
					$txtChecked = 'CHECKED';
				}

				if (($rowNr % 2)==0)
				{
					$rowColor = "rowDark";
					$bckColor = "#E0DEEF";
				}
				else
				{
					$rowColor = "rowLight";
					$bckColor = '#FFFFFF';
				}
				$activeColor = '#CCCC88';
				$result.= "<a name='1'>
					<tr class=\"$rowColor\" onmouseover=this.style.background='$activeColor' onmouseout=this.style.background='$bckColor'>";

				$result .= '<td align="center"><input type="checkbox" name="idTow'.$licznik.'" value="'.$data['id'].'" '.$txtChecked.'/></td>';
				$result .= '<td align="center">'.$data['nazwa'].'</td>';
				$result .= '<td align="center">'.$data['opis'].'</td>';
				$result .= '<td align="center">'.$data['wersja'].'</td>';
				$result .= '<td align="center"><img src="'.dnsPath.'/FrontPage/Files/ImgShop/'.$data['obrazMin'].'"/></td>';
				$result .= '</tr></a>';
				$licznik++;
			}
			while ($data = $queryResult->fetchRow(DB_FETCHMODE_ASSOC));
			$result .= '<tr><td colspan="5" align="right"><input type="submit" value="wybierz" /></td></tr>';
			$result .= '</form>';

		}
		$res = $gridTableBegin.$gridTitle.$gridHeader.$result.$gridTableEnd;
		return $res;
	}

	public function PokazOferty($Oferta)
	{

		$html = '';
		$moduleTmp = new ModulesMgr();
		$moduleTmp->loadModule('Sklep');
		$this->AddKoszykAction = $moduleTmp->getModuleActionIdByName('DodajDoKoszyka');
		unset($moduleTmp);
                
                $rabat = new Rabat();
                $rabat->Load();

		$this->Konfiguracja = new Konfiguracja();
		$ilObrNaStr = $this->Konfiguracja->TowNaStrone();
		$arrTowStr = array();
		$this->Oferta = $Oferta;
		$nazwaOferty = $this->Oferta->GetNazwa();
		$opis = $this->Oferta->GetOpis();
		$obraz = $this->Oferta->GetObraz();
		$arrTowStr = $this->Oferta->GetTowary(1, 1000000000);
		$idOferty = $this->Oferta->GetId();

		$tmpGrOf = new GrupaOfert();
		$tmpGrOf->Load($this->Oferta->GetIdGrupy(), $_SESSION['lang']);
		$nazwaGrupy = $tmpGrOf->GetNazwa();

		$arrViewTow = array();

		for ($i=0; $i<count($arrTowStr); $i++)
		{
			$towarTmp = new Towar();
			$towarTmp->Load($arrTowStr[$i], $_SESSION['lang']);
			$ofertaItem = new OfertaItem();
			$ofertaItem->idTowaru = $towarTmp->GetId();
			$ofertaItem->opisTowaru = $towarTmp->GetOpis();
			$ofertaItem->cenaTowaru = $towarTmp->GetCena(1,3);
			$ofertaItem->rabat = $towarTmp->GetRabat();
			$ofertaItem->obrazMin = pictPath.$towarTmp->GetObrazMin();
			$nazwa = $towarTmp->GetNazwa();
			$ofertaItem->nazwaTowaru = $nazwa;
			$ofertaItem->actionDoKoszyka = $this->AddKoszykAction;
			$arrViewTow[] = $ofertaItem;
		}

		//do wyswietlania stron pod spodem strony
			
		//$moduleTmp = new ModulesMgr();
		//$moduleTmp->loadModule('Sklep');
		//$nextPageAct = $moduleTmp->getModuleActionIdByName('PokazOferte');

		$smarty = new mySmarty();
		$smarty->assign('towar', $arrViewTow);
		$smarty->assign('nazwaOferty', $nazwaOferty);
		$smarty->assign('nazwaGrupy', $nazwaGrupy);
		$html .= $smarty->fetch('modules/Oferta.tpl');

		return $html;
	}
	public function PokazOfertyGrupy($idGrupa)
	{
		$html = '';
                
                $rabat = new Rabat();
                $rabat->Load();
                $rabatEnabled = $rabat->GetRabatEnabled();
                $rabatPierwszaNetwork = $rabat->GetParamPierwszeNetworkVerison();
                $rabatNastNetwork = $rabat->GetParamNetworkVersion();
                $rabatPierwszaZwykle = $rabat->GetParamPierwszeNormalVerison();
                $rabatNastZwykle = $rabat->GetParamNormalVerison();
                
		$moduleTmp = new ModulesMgr();
		$moduleTmp->loadModule('Sklep');
		$this->AddKoszykAction = $moduleTmp->getModuleActionIdByName('DodajDoKoszyka');
		unset($moduleTmp);

		$this->Konfiguracja = new Konfiguracja();

		//$ilObrNaStr = $this->Konfiguracja->TowNaStrone();

		$sql = "SELECT id FROM Oferty WHERE FkGrupy=$idGrupa ORDER BY SortOrder ";
		$DBInt = DBSingleton::getInstance();
		$queryResult = $DBInt->ExecQuery($sql);
		$arrViewTow = array();
		$arrViewGr = array();

		$tmpGrOf = new GrupaOfert();
		$tmpGrOf->Load($idGrupa, $_SESSION['lang']);
		$nazwaGrupy = $tmpGrOf->GetNazwa();

		while($data = $queryResult->fetchRow(DB_FETCHMODE_ASSOC))
		{
			$arrTowStr = array();
			$ofertaTmp = new Oferta();
			$ofertaTmp->Load($data['id']);

			$grupaItem = new GrupyItem();
			$grupaItem->nazwaOferty = $ofertaTmp->GetNazwa();
			$grupaItem->idOferty = $ofertaTmp->GetId();
			$arrViewGr[] = $grupaItem;

			$arrTowStr = $ofertaTmp->GetTowary(1, 1000000000);
			for ($i=0; $i<count($arrTowStr); $i++)
			{
                            
				$towarTmp = new Towar();
				$towarTmp->Load($arrTowStr[$i], $_SESSION['lang']);
				$ofertaItem = new OfertaItem();
				$ofertaItem->idTowaru = $towarTmp->GetId();
				$ofertaItem->opisTowaru = $towarTmp->GetOpis();
				$ofertaItem->cenaTowaru = $towarTmp->GetCena(1,3);                                
				$ofertaItem->cenaTowaruFormatted = number_format($towarTmp->GetCena(1,3), 2, ',', ' ');
                                $ofertaItem->cena2Towaru = $towarTmp->GetCenaParams(1,3);                                
				$ofertaItem->cena2TowaruFormatted = number_format($towarTmp->GetCenaParams(1,3), 2, ',', ' ');
				$ofertaItem->rabat = $towarTmp->GetRabat();
				$ofertaItem->obrazMin = pictPath.$towarTmp->GetObrazMin();
				$ofertaItem->idOferty = $ofertaTmp->GetId();
				$ofertaItem->nazwaTowaru = $towarTmp->GetNazwa();
				$ofertaItem->actionDoKoszyka = $this->AddKoszykAction;
				$ofertaItem->algCeny = $towarTmp->GetAlgCeny();
				$arrViewTow[] = $ofertaItem;
			}

			unset($ofertaTmp);
		}
		/*
                 * $rabatPierwszaNetwork = $rabat->GetParamPierwszeNetworkVerison();
                $rabatNastNetwork = $rabat->GetParamNetworkVersion();
                $rabatPierwszaZwykle = $rabat->GetParamPierwszeNormalVerison();
                $rabatNastZwykle 
                 */		
		$smarty = new mySmarty();
                $smarty->assign('param1Net', $rabatPierwszaNetwork);
                $smarty->assign('param2Net', $rabatNastNetwork);
                $smarty->assign('param1Zwykl', $rabatPierwszaZwykle);
                $smarty->assign('param2Zwykl', $rabatNastZwykle);
                $smarty->assign('rabat', $rabatEnabled);
		$smarty->assign('towar', $arrViewTow);
		$smarty->assign('grupy', $arrViewGr);
		
		$smarty->assign('nazwaGrupy', $nazwaGrupy);
		$html .= $smarty->fetch('modules/OfertyGrupy.tpl');

		return $html;
	}
	/*public function PokazGrupe($arrOferty)
	 {
		$arrView = array();
		for($i=0;$i<count($arrOferty);$i++)
		{
		//pokazuje oferte
		$this->Oferta = new Oferta();
		$this->Oferta->Load($arrOferty[$i]);
		$this->OfertyArr[] = $this->Oferta;

		}
		//tu wypelniam szablon z pe
		$moduleTmp = new ModulesMgr();
		$moduleTmp->loadModule('Sklep');
		$PokazOferte = $moduleTmp->getModuleActionIdByName('PokazOferte');
		unset($moduleTmp);
		$actionPokazOferte = $PokazOferte;

		//szablon glowny

		for ($i=0; $i<count($this->OfertyArr); $i++)
		{
		$ofertaItem = new OfertaGroupItem();
		$ofertaItem -> idOferty = $this->OfertyArr[$i]->GetId();
		$ofertaItem -> opisShort = $this->OfertyArr[$i]->GetOpisShort();
		$ofertaItem -> obraz = pictPath.$this->OfertyArr[$i]->GetObraz();
		$ofertaItem -> actionPokazOferte = $actionPokazOferte;
		$arrView[] = $ofertaItem;
		}
		$smarty = new mySmarty();
		$smarty->assign('grupa', $arrView);
		$html = $smarty->fetch('modules/GrupyOfert.tpl');

		return $html;
		}*/

	public function showGrupyChooseList()
	{
		//TODO BEDZIE TRZEBA DODAC W GRIDZIE TEXTACTION dla kazdego CLICK
		$query = "
					SELECT id, nazwa as Value, nazwa FROM GrupyOfert ORDER BY sortkey											
				";
		//----------------------------------------------------------
			
		$result = '';
		$result .= '<table class="Grid" align="center" cellspacing=0>';

		$result .= '<tr><td colspan="2">';

		$menuListGrid = new gridRenderer();
		$menuListGrid->setDataQuery($query);

		$menuListGrid -> setTitle('Lista grup');
		$menuListGrid->setGridAlign('center');
		$menuListGrid->setGridWidth(680);
			
		$menuListGrid->addColumn("nazwa", 'Nazwa', 200, false, false, 'left');
			
		$menuListGrid->addColumn("id", "", 200, true, false, 'right');
		$menuListGrid->addColumn('Value', '', 1, false, true, 'left');
		$menuListGrid->callBackAction('window.opener.document.dFORM.txtNazwa.value');
		//$menuListGrid->enabledEditAction(13);
		$result .= $menuListGrid->renderHtmlGrid(1);
		$result .= '</td></tr>';
		$result .= '</table>';
		restoreActionValue();
		return $result;
	}

}
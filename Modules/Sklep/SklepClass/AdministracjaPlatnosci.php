<?php
class AdministracjaPlatnosci
{
	private $platnosc = null;

	public function __construct($id)
	{

		$this->platnosc = new Platnosc();

		if ($id >0)
		{
			$this->platnosc->Load($id, 'PL');
		}

	}
	public function __destruct()
	{
		unset($this->platnosc);
	}
	public function ShowAdmin()
	{
		$html = '';
		$module = new modulesMgr();
		$module->loadModule('Sklep');
		$addAction = $module->getModuleActionIdByName('AddPlatnoscAdmin');
		$editAction = $module->getModuleActionIdByName('EditPlatnoscAdmin');
		$delAction =  $module->getModuleActionIdByName('DelPlatnoscAdmin');
		$upAction = $module->getModuleActionIdByName('PlatnoscUp');
		$downAction = $module->getModuleActionIdByName('PlatnoscDown');
		unset($module);
		$addButton = new button(buttonAddIcon, 'Dodaj platność', $addAction, -1);

		$query = "
 				SELECT 
 				   id, opis, nazwa, cena, sortkey
 				FROM
 					Platnosci
 				WHERE 
 				  Active='T'
 				ORDER BY
 					sortkey			  
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
		$grid -> setTitle('Płatności');
		$grid -> setGridAlign('center');
		$grid -> setGridWidth(780);
		$grid -> addColumn('nazwa', 'Nazwa', 200, false, false, 'left');
		$grid -> addColumn('opis', 'Opis', 400, false, false, 'left');
		$grid -> addColumn('sortkey', 'Kolejność', 200, false, false, 'left');
		$grid -> addColumn('cena', 'Cena', 200, false, false, 'right');
		$grid -> addColumn('id', '', 10, true, false, 'right');
		$grid -> enabledDelAction($delAction);
		$grid -> enabledEditAction($editAction);
		$grid -> addAction($upAction, '../Cms/Files/Img/up.gif');
		$grid -> addAction($downAction, '../Cms/Files/Img/down.gif');
		$grid -> setDataQuery($query);
		$html .= $grid->renderHtmlGrid(1);
		$html .= '</td></tr>';
		$html .= '<tr><td align="right" colspan="2">';
		$html .= $addButton->show(1);
		$html .= '</td></tr>';
		$html .= '</table>';
			
		return $html;
	}
	public function EditAdmin($id)
	{
		$_SESSION['tmpPlatnoscId']=$id;
		$html = '';
		$langs = array();
		$langNazwy = array();
		$langOpisy = array();
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
			$hdrText = 'Dodawanie rodzaju płatności';
		}
		else
		{
			$hdrText = 'Edycja rodzaju płatności';
		}
		$html .= '<center><table width="580" align="center" cellpadding=0 cellspacing=0 border=0><tr><td>';

		$myForm = null;
		$myForm = new Form('dForm', 'POST') ;
		$PlatnoscForm = null;
		$PlatnoscForm = $myForm->getFormInstance();
		$PlatnoscForm -> addElement('header', ' hdrTest', $hdrText);
		$valId = $PlatnoscForm->addElement('hidden', 'id', $id);
		for($i = 0; $i < count($langs); $i++)
		{
			$langNazwy[$langs[$i]] = $PlatnoscForm->addElement('text', 'nazwa'.$langs[$i], 'Nazwa ('.$langs[$i].')', array('size' => 50, 'maxlength'=> 200));
		}
		for($i = 0; $i < count($langs); $i++)
		{
			$langOpisy[$langs[$i]] = $PlatnoscForm->addElement('textarea', 'opis'.$langs[$i], 'Opis ('.$langs[$i].')', array('cols'=>50, 'rows'=>5, 'maxlength'=>300));
		}

		$cena = $PlatnoscForm->addElement('text', 'cena', 'Cena', array('size' => 20, 'maxlength'=> 200));
		$sortkey = $PlatnoscForm->addElement('text', 'sortkey', 'Kolejnosc', array('size' => 20, 'maxlength'=> 200));

		$option_list[1] = 'Przy odbiorze';
		$option_list[2] = 'Przelew';
		$option_list[3] = 'E-Płatności';

		$typ = $PlatnoscForm->addElement('select', 'typ' ,'Typ', $option_list);
		$PlatnoscForm->addElement('reset', 'btnReset', 'Wyczyść');
		$PlatnoscForm->addElement('submit', 'btnSubmit', 'Zapisz');
		$PlatnoscForm->registerRule('testUniqueSortkey', 'callback', 'testUniqueSortkey', 'AdministracjaPlatnosci');
		$PlatnoscForm->addRule('sortkey', 'Kolejność musi być unikalna', 'testUniqueSortkey');
		$PlatnoscForm->addRule('sortkey', 'Zła wartośc w polu "Kolejność" - musi być liczba', 'numeric', null, 'server');
		$PlatnoscForm->addRule('cena', 'Zła wartośc w polu "Cena" - musi być liczba', 'numeric', null, 'server');
		$PlatnoscForm->addRule('nazwa', 'Pole "Nazwa" musi być wypełnione', 'required', null, 'server');
		$PlatnoscForm->addRule('cena', 'Pole "Cena" musi być wypełnione', 'required', null, 'server');
		$PlatnoscForm->addRule('sortkey', 'Pole "Kolejność" musi być wypełnione', 'required', null, 'server');
		$PlatnoscForm->applyFilter('__ALL__', 'trim');
		$myForm->setStyle(2);
		if ($PlatnoscForm->validate())
		{
			$tmpPlatnosc = new Platnosc();
			$tmpPlatnosc->Load($id, 'PL');
			$tmpPlatnosc->SetOpis($langOpisy['PL']->GetValue());
			$tmpPlatnosc->SetNazwa($langNazwy['PL']->GetValue());
			$tmpPlatnosc->SetCena($cena->GetValue());
			$tmpPlatnosc->SetId($valId->GetValue());
			$tmpPlatnosc->SetSortkey($sortkey->GetValue());
			$typArr = $typ->GetValue();
			$tmpPlatnosc->SetTyp($typArr[0]);
			$tmpPlatnosc->Save($valId->GetValue());
			//update jezykow
			$queryLang = "SELECT ShortName FROM cmsLang WHERE ShortName <>'PL'";
			$DBInt = DBSIngleton::getInstance();
			$qResult = $DBInt->ExecQuery($queryLang);
			while ($data = $qResult->fetchRow(DB_FETCHMODE_ASSOC))
			{
				$updateQuery = 'UPDATE PlatnosciLang SET ';
				$lang = $data['ShortName'];
				$coma = false;
				if ((isset($langNazwy[$lang]))&&($langNazwy[$lang]->GetValue() <> ''))
				{
					$updateQuery .= ' nazwa="'.$langNazwy[$lang]->GetValue().'"';
					$coma = true;
				}
				if ((isset($langOpisy[$lang]))&&($langOpisy[$lang]->GetValue() <> ''))
				{
					if ($coma) $updateQuery.=',';
					$updateQuery .= ' opis="'.$langOpisy[$lang]->GetValue().'"';
					$coma=true;
				}

				$updateQuery .= " WHERE `FKPlatnosci`=$id and `lang`='$lang'";
				//echo $updateQuery;
				$DBInt = DBSIngleton::getInstance();
				$DBInt->ExecQuery($updateQuery);
			}
			
			$module = new modulesMgr();
			$module->loadModule('Sklep');
			$action = $module->getModuleActionIdByName('ShowPlatnosciAdmin');
			header("Location: ?a=$action");
		}
		else
		{
			if ($id!=0)
			{
				$tmpPlatnosc = new Platnosc();
				$tmpPlatnosc->Load($id, 'PL');
				$langNazwy["PL"]->setValue($tmpPlatnosc->GetNazwa());
				$langOpisy["PL"]->setValue($tmpPlatnosc->GetOpis());
				$valId->SetValue($id);
				$sortkey->SetValue($tmpPlatnosc->GetSortkey());
				$typ->SetValue($tmpPlatnosc->GetTyp());
				$cena->SetValue($tmpPlatnosc->GetCena());
				 
				//jezyki
				$queryLang = "SELECT ShortName FROM cmsLang WHERE ShortName <>'PL'";
				$DBInt = DBSIngleton::getInstance();
				$qResult = $DBInt->ExecQuery($queryLang);
				while ($data = $qResult->fetchRow(DB_FETCHMODE_ASSOC))
				{
					$lang = $data['ShortName'];
						
					$query = "
						SELECT nazwa, opis
						FROM PlatnosciLang
						WHERE FKPlatnosci=$id AND lang='$lang'		
								";
					$qResult2 = $DBInt->ExecQuery($query);
					$data2 = $qResult2->fetchRow(DB_FETCHMODE_ASSOC);
						
					$langNazwy["$lang"]->setValue($data2['nazwa']);
					$langOpisy["$lang"]->setValue($data2['opis']);
				}
			}
			$html .= $PlatnoscForm->toHtml();
		}
		$html .= '</td></tr></table>';

		return $html;
	}
	public function DelAdmin($id)
	{
		$html = '';
		$this->platnosc->Del($id);

		$module = new ModulesMgr();
		$module->loadModule('Sklep');
		$okAction = $module->getModuleActionIdByName('ShowPlatnosciAdmin');
		$dialog = new dialog('Usuwanie' , 'Usunięto pozycję', 'Info', 300, 150);
		$dialog->setAlign('center');
		$dialog->setOkCaption('Ok');
		$dialog->setOkAction($okAction);
		$html .= $dialog->show(1);

		return $html;
	}

	public function PlatnoscUp($id)
	{

		$dbInt = DBSingleton::getInstance();
		$query =
				"
				SELECT 
					id, sortkey
				FROM
					Platnosci
				WHERE id = $id and Active = 'T'
				";
		$res = $dbInt->ExecQuery($query);
		$data1 = $res->fetchRow(DB_FETCHMODE_ASSOC);

		$actId = $data1['id'];
		$actSortkey = $data1['sortkey'];

		$query =
		"
			SELECT
				id, sortkey
			FROM 
				Platnosci
			WHERE
				sortkey = (SELECT max(sortkey) FROM Platnosci WHERE sortkey<$actSortkey and Active='T')
				and Active ='T'
		";
		$res = $dbInt->ExecQuery($query);
		$data2 = $res->fetchRow(DB_FETCHMODE_ASSOC);

		$prevId = $data2['id'];
		$prevSortkey = $data2['sortkey'];

		$transQuery = 'START TRANSACTION';

		$update0="UPDATE Platnosci SET sortkey=-1 WHERE id in ($actId, $prevId)";
		$update1="UPDATE Platnosci SET sortkey=$actSortkey WHERE id=$prevId";
		$update2="Update Platnosci SET sortkey=$prevSortkey WHERE id=$actId";
		$transCommit = 'COMMIT';

		$module = new ModulesMgr();
		$module -> loadModule('Sklep');
		$okAction = $module->getModuleActionIdByName('ShowPlatnosciAdmin');

		$dbInt->ExecQuery($transQuery);
		$dbInt->ExecQuery($update0);
		$dbInt->ExecQuery($update1);
		$dbInt->ExecQuery($update2);
		$dbInt->ExecQuery($transCommit);
			
		header("Location: ?a=".$okAction);
	}
	public function PlatnoscDown($id)
	{
		//jw tylko na odwr
		$dbInt = DBSingleton::getInstance();
		$query =
				"
				SELECT 
					id, sortkey
				FROM
					Platnosci
				WHERE id = $id and Active = 'T'
				";
		$res = $dbInt->ExecQuery($query);
		$data1 = $res->fetchRow(DB_FETCHMODE_ASSOC);

		$actId = $data1['id'];
		$actSortkey = $data1['sortkey'];

		$query =
		"
			SELECT
				id, sortkey
			FROM 
				Platnosci
			WHERE
				sortkey = (SELECT min(sortkey) FROM Platnosci WHERE sortkey>$actSortkey and Active = 'T')
				and Active = 'T'
		";
		$res = $dbInt->ExecQuery($query);
		$data2 = $res->fetchRow(DB_FETCHMODE_ASSOC);

		$prevId = $data2['id'];
		$prevSortkey = $data2['sortkey'];

		$transQuery = 'START TRANSACTION';

		$update0="UPDATE Platnosci SET sortkey=-1 WHERE id in ($actId, $prevId)";
		$update1="UPDATE Platnosci SET sortkey=$actSortkey WHERE id=$prevId";
		$update2="Update Platnosci SET sortkey=$prevSortkey WHERE id=$actId";
		$transCommit = 'COMMIT';

		$module = new ModulesMgr();
		$module -> loadModule('Sklep');
		$okAction = $module->getModuleActionIdByName('ShowPlatnosciAdmin');

		$dbInt->ExecQuery($transQuery);
		$dbInt->ExecQuery($update0);
		$dbInt->ExecQuery($update1);
		$dbInt->ExecQuery($update2);
		$dbInt->ExecQuery($transCommit);
			
		header("Location: ?a=".$okAction);
	}

	public function testUniqueSortkey($val)
	{

		$id = $_SESSION['tmpPlatnoscId'];
		$str =$val['sortkey'];
		$sql = "SELECT COUNT(1) as ile FROM Platnosci WHERE sortkey='$str' and id<>$id and Active='T'";

		$DBInt = DBSingleton::getInstance();
		$dbResult = $DBInt->ExecQuery($sql);
		$recData = $dbResult->fetchRow(DB_FETCHMODE_ASSOC);
		$ile = $recData['ile'];

		return $ile==0;

	}

}
?>
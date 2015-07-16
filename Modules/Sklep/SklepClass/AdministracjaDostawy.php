<?php
class AdministracjaDostawy
{
	private $dostawa = null;
	
	public function __construct()
	{
		$this->dostawa = new Dostawa();
	}
	public function __destruct()
	{
		unset($this->dostawa);
	}
	public function ShowAdmin()
	{
		$html = '';
		$module = new modulesMgr();
 		$module->loadModule('Sklep');
 		$addAction = $module->getModuleActionIdByName('AddDostawaAdmin');
 		$editAction = $module->getModuleActionIdByName('EditDostawaAdmin');
 		$delAction =  $module->getModuleActionIdByName('DelDostawa');
 		$upAction = $module->getModuleActionIdByName('DostawaUp');
 	   	$downAction = $module->getModuleActionIdByName('DostawaDown');
 		unset($module);
 		$addButton = new button(buttonAddIcon, 'Dodaj rodzaj dostawy', $addAction, -1);
 		 		
 		$query = "
 				SELECT 
 				   id, opis, nazwa, cena, sortkey
 				FROM
 					Dostawy
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
 			$grid -> setTitle('Rodzaje dostaw');
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
		$_SESSION['tmpDostawaId']=$id;
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
			$hdrText = 'Dodawanie rodzaju dostawy';
		}
		else
		{
			$hdrText = 'Edycja rodzaju dostawy';
		}
		$html .= '<center><table width="580" align="center" cellpadding=0 cellspacing=0 border=0><tr><td>';
	
		$myForm = null;
		$myForm = new Form('dForm', 'POST') ;
		$DostawaForm = null;
		$DostawaForm = $myForm->getFormInstance();
		$DostawaForm -> addElement('header', ' hdrTest', $hdrText);
		$valId = $DostawaForm->addElement('hidden', 'id', $id);
		for($i = 0; $i < count($langs); $i++)
     	{
     		$langNazwy[$langs[$i]] = $DostawaForm->addElement('text', 'nazwa'.$langs[$i], 'Nazwa ('.$langs[$i].')', array('size' => 50, 'maxlength'=> 200));
    	}
		for($i = 0; $i < count($langs); $i++)
     	{
     		$langOpisy[$langs[$i]] = $DostawaForm->addElement('textarea', 'opis'.$langs[$i], 'Opis ('.$langs[$i].')', array('cols'=>50, 'rows'=>5, 'maxlength'=>300));
     	}
     	
     	$cena = $DostawaForm->addElement('text', 'cena', 'Cena', array('size' => 20, 'maxlength'=> 200));
     	$sortkey = $DostawaForm->addElement('text', 'sortkey', 'Kolejnosc', array('size' => 20, 'maxlength'=> 200));
		$DostawaForm->addElement('reset', 'btnReset', 'Wyczyść');
      	$DostawaForm->addElement('submit', 'btnSubmit', 'Zapisz');     	
     	$DostawaForm->registerRule('testUniqueSortkey', 'callback', 'testUniqueSortkey', 'AdministracjaDostawy');
     	$DostawaForm->addRule('sortkey', 'Kolejność musi być unikalna', 'testUniqueSortkey');
     	$DostawaForm->addRule('sortkey', 'Zła wartośc w polu "Kolejność" - musi być liczba', 'numeric', null, 'server');
     	$DostawaForm->addRule('cena', 'Zła wartośc w polu "Cena" - musi być liczba', 'numeric', null, 'server');
     	$DostawaForm->addRule('nazwa', 'Pole "Nazwa" musi być wypełnione', 'required', null, 'server');
     	$DostawaForm->addRule('cena', 'Pole "Cena" musi być wypełnione', 'required', null, 'server');
     	$DostawaForm->addRule('sortkey', 'Pole "Kolejność" musi być wypełnione', 'required', null, 'server');
     	$DostawaForm->applyFilter('__ALL__', 'trim');
		$myForm->setStyle(2);
      	if ($DostawaForm->validate())
        {
        	$tmpDostawa = new Dostawa();
        	$tmpDostawa->Load($id, 'PL');
        	$tmpDostawa->SetOpis($langOpisy['PL']->GetValue());
        	$tmpDostawa->SetNazwa($langNazwy['PL']->GetValue());
        	$tmpDostawa->SetCena($cena->GetValue());
        	$tmpDostawa->SetId($valId->GetValue());
        	$tmpDostawa->SetSortkey($sortkey->GetValue());
        	$tmpDostawa->Save($valId->GetValue());
        	 //update jezykow
            $queryLang = "SELECT ShortName FROM cmsLang WHERE ShortName <>'PL'";
            $DBInt = DBSIngleton::getInstance();
    		$qResult = $DBInt->ExecQuery($queryLang);
        	while ($data = $qResult->fetchRow(DB_FETCHMODE_ASSOC))
			 {
				$updateQuery = 'UPDATE DostawyLang SET ';
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
				$updateQuery .= " WHERE FKDostawy=$id and lang='$lang'";
					
				$DBInt = DBSIngleton::getInstance();
				$DBInt->ExecQuery($updateQuery);		
			 }
			 $module = new ModulesMgr();
			 $module->loadModule('Sklep');
			 $action = $module->getModuleActionIdByName('ShowDostawyAdmin');
			 header("Location: ?a=$action");
		}
        else
        {
        	if ($id!=0)
        	{
        		$tmpDostawa = new Dostawa();
        		$tmpDostawa->Load($id,'PL');
        		$langNazwy["PL"]->setValue($tmpDostawa->GetNazwa());
            	$langOpisy["PL"]->setValue($tmpDostawa->GetOpis());
            	$valId->SetValue($id);
            	$sortkey->SetValue($tmpDostawa->GetSortkey());
            	
            	$cena->SetValue($tmpDostawa->GetCena());
            	
            	//jezyki
        		$queryLang = "SELECT ShortName FROM cmsLang WHERE ShortName <>'PL'";
            	$DBInt = DBSIngleton::getInstance();
    			$qResult = $DBInt->ExecQuery($queryLang);
    			while ($data = $qResult->fetchRow(DB_FETCHMODE_ASSOC))
				{
					$lang = $data['ShortName'];
					
					$query = "
						SELECT nazwa, opis
						FROM DostawyLang
						WHERE FKDostawy=$id AND lang='$lang'		
								";
					$qResult2 = $DBInt->ExecQuery($query);
					$data2 = $qResult2->fetchRow(DB_FETCHMODE_ASSOC);
					
					$langNazwy["$lang"]->setValue($data2['nazwa']);
            	  	$langOpisy["$lang"]->setValue($data2['opis']);
				}
        	}
        	$html .= $DostawaForm->toHtml();
        }
        $html .= '</td></tr></table>';

        return $html;
	}
	public function Del($id)
	{
		$html = '';
 		$this->dostawa->Del($id);
		
 		$module = new ModulesMgr();
		$module->loadModule('Sklep');
		$okAction = $module->getModuleActionIdByName('ShowDostawyAdmin');
		$dialog = new dialog('Usuwanie' , 'Usunięto pozycję', 'Info', 300, 150);
		$dialog->setAlign('center');
		$dialog->setOkCaption('Ok');
		$dialog->setOkAction($okAction);
		$html .= $dialog->show(1);
 			
		return $html;	
	}
	public function DostawaUp($id)
	{
		
		$dbInt = DBSingleton::getInstance();
		$query = 
				"
				SELECT 
					id, sortkey
				FROM
					Dostawy
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
				Dostawy
			WHERE
				sortkey = (SELECT max(sortkey) FROM Dostawy WHERE sortkey<$actSortkey AND Active='T')
				and Active='T'
		";
		$res = $dbInt->ExecQuery($query);
        $data2 = $res->fetchRow(DB_FETCHMODE_ASSOC);
        
		$prevId = $data2['id'];
		$prevSortkey = $data2['sortkey'];
		
		$transQuery = 'START TRANSACTION';
		
		$update0="UPDATE Dostawy SET sortkey=-1 WHERE id in ($actId, $prevId)";
		$update1="UPDATE Dostawy SET sortkey=$actSortkey WHERE id=$prevId";
		$update2="Update Dostawy SET sortkey=$prevSortkey WHERE id=$actId";
		$transCommit = 'COMMIT';
		
		$module = new ModulesMgr();
        $module -> loadModule('Sklep');
        $okAction = $module->getModuleActionIdByName('ShowDostawyAdmin');
        
        $dbInt->ExecQuery($transQuery);
        $dbInt->ExecQuery($update0);
        $dbInt->ExecQuery($update1);
 		$dbInt->ExecQuery($update2);
 		$dbInt->ExecQuery($transCommit);
 		
 		header("Location: ?a=".$okAction);
	}
	public function DostawaDown($id)
	{
		//jw tylko na odwr
		$dbInt = DBSingleton::getInstance();
		$query = 
				"
				SELECT 
					id, sortkey
				FROM
					Dostawy
				WHERE id = $id and Active='T'
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
				Dostawy
			WHERE
				sortkey = (SELECT min(sortkey) FROM Dostawy WHERE sortkey>$actSortkey and Active='T')
				and Active='T'
		";
		$res = $dbInt->ExecQuery($query);
        $data2 = $res->fetchRow(DB_FETCHMODE_ASSOC);
        
		$prevId = $data2['id'];
		$prevSortkey = $data2['sortkey'];
		
		$transQuery = 'START TRANSACTION';
		
		$update0="UPDATE Dostawy SET sortkey=-1 WHERE id in ($actId, $prevId)";
		$update1="UPDATE Dostawy SET sortkey=$actSortkey WHERE id=$prevId";
		$update2="Update Dostawy SET sortkey=$prevSortkey WHERE id=$actId";
		$transCommit = 'COMMIT';
		
		$module = new ModulesMgr();
        $module -> loadModule('Sklep');
        $okAction = $module->getModuleActionIdByName('ShowDostawyAdmin');
        
        $dbInt->ExecQuery($transQuery);
        $dbInt->ExecQuery($update0);
        $dbInt->ExecQuery($update1);
 		$dbInt->ExecQuery($update2);
 		$dbInt->ExecQuery($transCommit);
 		
 		header("Location: ?a=".$okAction);
	}
	public function testUniqueSortkey($val)
	{	
		
		$id = $_SESSION['tmpDostawaId'];
		$str =$val['sortkey']; 
		$sql = "SELECT COUNT(1) as ile FROM Dostawy WHERE sortkey='$str' and id<>$id and Active='T'";
		
		$DBInt = DBSingleton::getInstance();
		$dbResult = $DBInt->ExecQuery($sql);
 	    $recData = $dbResult->fetchRow(DB_FETCHMODE_ASSOC);
		$ile = $recData['ile'];
 	    
		return $ile==0;
				
	}	
	
}
?>

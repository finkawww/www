<?php
class AdministracjaKraje
{
	private $kraj = null;
	
	public function __construct($id)
	{
		
		$this->kraj = new Kraj();
		
		if ($id >0)
		{
			$this->kraj->Load($id);	
		}
		
	}
	public function __destruct()
	{
		unset($this->kraj);
	}
	public function ShowAdmin()
	{
		$html = '';
		$module = new modulesMgr();
 		$module->loadModule('Sklep');
 		$addAction = $module->getModuleActionIdByName('AddKrajAdmin');
 		$editAction = $module->getModuleActionIdByName('EditKrajAdmin');
 		$delAction =  $module->getModuleActionIdByName('DelKrajAdmin');
 		$upAction = $module->getModuleActionIdByName('KrajUp');
 	   	$downAction = $module->getModuleActionIdByName('KrajDown');
 		unset($module);
 		$addButton = new button(buttonAddIcon, 'Dodaj kraj', $addAction, -1);
 		 		
 		$query = "
 				SELECT 
 				   id,nazwa,sortkey
 				FROM
 					Kraje
 				WHERE
 					active='T'
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
		$grid -> setDataQuery($query);
 		$grid -> setTitle('Kraje');
		$grid -> setGridAlign('center');
		$grid -> setGridWidth(780);
		$grid -> addColumn('nazwa', 'Nazwa', 200, false, false, 'left');
		$grid -> addColumn('sortkey', 'Kolejność', 200, false, false, 'left');					
		$grid -> addColumn('id', '', 10, true, false, 'right');
 		$grid -> enabledDelAction($delAction);
	 	$grid -> enabledEditAction($editAction);
	 	$grid -> addAction($upAction, 'http://www.galeria.idhost.pl/Cms/Files/Img/up.gif');
    	$grid -> addAction($downAction, 'http://www.galeria.idhost.pl/Cms/Files/Img/down.gif');
			
		$html .= $grid->renderHtmlGrid(1, false);
		$html .= '</td></tr>';
		$html .= '<tr><td align="right" colspan="2">';
		$html .= $addButton->show(1);			
		$html .= '</td></tr>';
		$html .= '</table>';
			
		return $html;
	}
	public function EditAdmin($id)
	{
		$_SESSION['tmpKrajId']=$id;
		$html = '';
		$langs = array();
		$langNazwy = array();
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
			$hdrText = 'Dodawanie kraju';
		}
		else
		{
			$hdrText = 'Edycja kraju';
		}
		$html .= '<center><table width="580" align="center" cellpadding=0 cellspacing=0 border=0><tr><td>';
	
		$myForm = null;
		$myForm = new Form('dForm', 'POST') ;
		$KrajForm = null;
		$KrajForm = $myForm->getFormInstance();
		$KrajForm -> addElement('header', ' hdrTest', $hdrText);
		$valId = $KrajForm->addElement('hidden', 'id', $id);
		for($i = 0; $i < count($langs); $i++)
     	{
     		$langNazwy[$langs[$i]] = $KrajForm->addElement('text', 'nazwa'.$langs[$i], 'Nazwa ('.$langs[$i].')', array('size' => 50, 'maxlength'=> 100));
    	}
	     	
     	$sortkey = $KrajForm->addElement('text', 'sortkey', 'Kolejnosc', array('size' => 20, 'maxlength'=> 200));
		$KrajForm->addElement('reset', 'btnReset', 'Wyczyść');
      	$KrajForm->addElement('submit', 'btnSubmit', 'Zapisz');
       	$KrajForm->registerRule('testUniqueSortkey', 'callback', 'testUniqueSortkey', 'AdministracjaKraje');
     	$KrajForm->addRule('sortkey', 'Kolejność musi być unikalna', 'testUniqueSortkey');
     	$KrajForm->addRule('sortkey', 'Zła wartośc w polu "Kolejność" - musi być liczba', 'numeric', null, 'server');
      	$KrajForm->addRule('nazwa', 'Pole "Nazwa" musi być wypełnione', 'required', null, 'server');
      	$KrajForm->addRule('sortkey', 'Pole "Kolejność" musi być wypełnione', 'required', null, 'server');
     	$KrajForm->applyFilter('__ALL__', 'trim');
     	
		$myForm->setStyle(2);
      	if ($KrajForm->validate())
        {
        	$tmpKraj = new Kraj();
        	$tmpKraj->Load($id, 'PL');
        	$tmpKraj->SetNazwa($langNazwy['PL']->GetValue());
        	$tmpKraj->SetId($valId->GetValue());
        	$tmpKraj->SetSortkey($sortkey->GetValue());
        	$tmpKraj->Save($valId->GetValue());
        	 //update jezykow
            $queryLang = "SELECT ShortName FROM cmsLang WHERE ShortName <>'PL'";
            $DBInt = DBSIngleton::getInstance();
    		$qResult = $DBInt->ExecQuery($queryLang);
        	while ($data = $qResult->fetchRow(DB_FETCHMODE_ASSOC))
			 {
				$updateQuery = 'UPDATE KrajeLang SET ';
				$lang = $data['ShortName'];
				$coma = false;
				if ((isset($langNazwy[$lang]))&&($langNazwy[$lang]->GetValue() <> ''))
				{
					$updateQuery .= ' name="'.$langNazwy[$lang]->GetValue().'"';
					$coma = true;
				}
			 	
				$updateQuery .= " WHERE FKKraj=$id and lang='$lang'";
					
				$DBInt = DBSIngleton::getInstance();
				$DBInt->ExecQuery($updateQuery);		
			 }
			 $module = new modulesMgr();
 			 $module->loadModule('Sklep');
			 $action = $module->getModuleActionIdByName('ShowKrajeAdmin');
			 header("Location:?a=$action");
		}
        else
        {
        	if ($id!=0)
        	{
        		$tmpKraj = new Kraj();
        		$tmpKraj->Load($id, 'PL');
        		$langNazwy["PL"]->setValue($tmpKraj->GetNazwa());
            	$valId->SetValue($id);
            	$sortkey->SetValue($tmpKraj->GetSortkey());
            	
            	//jezyki
        		$queryLang = "SELECT ShortName FROM cmsLang WHERE ShortName <>'PL'";
            	$DBInt = DBSIngleton::getInstance();
    			$qResult = $DBInt->ExecQuery($queryLang);
    			while ($data = $qResult->fetchRow(DB_FETCHMODE_ASSOC))
				{
					$lang = $data['ShortName'];
					 
					$query = "
						SELECT name as nazwa
						FROM KrajeLang
						WHERE FkKraj=$id AND lang='$lang'		
								";
					$qResult2 = $DBInt->ExecQuery($query);
					$data2 = $qResult2->fetchRow(DB_FETCHMODE_ASSOC);
					
					$langNazwy["$lang"]->setValue($data2['nazwa']);
            	  	
				}
        	}
        	$html .= $KrajForm->toHtml();
        }
        $html .= '</td></tr></table>';

        return $html;
	}	
	public function DelAdmin($id)
	{
		$html = '';
 		$this->kraj->Del($id);
		
 		$module = new ModulesMgr();
		$module->loadModule('Sklep');
		$okAction = $module->getModuleActionIdByName('ShowKrajeAdmin');
		$dialog = new dialog('Usuwanie' , 'Usunięto pozycję', 'Info', 300, 150);
		$dialog->setAlign('center');
		$dialog->setOkCaption('Ok');
		$dialog->setOkAction($okAction);
		$html .= $dialog->show(1);
 			
		return $html;	
	}
	public function KrajUp($id)
	{
		
		$dbInt = DBSingleton::getInstance();
		$query = 
				"
				SELECT 
					id, sortkey
				FROM
					Kraje
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
				Kraje
			WHERE
				sortkey = (SELECT max(sortkey) FROM Kraje WHERE sortkey<$actSortkey and Active = 'T')
				and Active = 'T'
		";
		$res = $dbInt->ExecQuery($query);
        $data2 = $res->fetchRow(DB_FETCHMODE_ASSOC);
        
		$prevId = $data2['id'];
		$prevSortkey = $data2['sortkey'];
		
		$transQuery = 'START TRANSACTION';
		$update0="UPDATE Kraje SET sortkey=-1 WHERE id in ($actId, $prevId)";
		$update1="UPDATE Kraje SET sortkey=$actSortkey WHERE id=$prevId";
		$update2="Update Kraje SET sortkey=$prevSortkey WHERE id=$actId";
		$transCommit = 'COMMIT';
		
		$module = new ModulesMgr();
        $module -> loadModule('Sklep');
        $okAction = $module->getModuleActionIdByName('ShowKrajeAdmin');
        
        $dbInt->ExecQuery($transQuery);
        $dbInt->ExecQuery($update0);
        $dbInt->ExecQuery($update1);
 		$dbInt->ExecQuery($update2);
 		$dbInt->ExecQuery($transCommit);
 		
 		 header("Location: ?a=".$okAction);
	}
	public function KrajDown($id)
	{
		//jw tylko na odwr
		$dbInt = DBSingleton::getInstance();
		$query = 
				"
				SELECT 
					id, sortkey
				FROM
					Kraje
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
				Kraje
			WHERE
				sortkey = (SELECT min(sortkey) FROM Kraje WHERE sortkey>$actSortkey and Active='T')
				and Active = 'T'
		";
		$res = $dbInt->ExecQuery($query);
        $data2 = $res->fetchRow(DB_FETCHMODE_ASSOC);
        
		$prevId = $data2['id'];
		$prevSortkey = $data2['sortkey'];
		
		$transQuery = 'START TRANSACTION';
		
		$update0="UPDATE Kraje SET sortkey=-1 WHERE id in ($actId, $prevId)";
		$update1="UPDATE Kraje SET sortkey=$actSortkey WHERE id=$prevId";
		$update2="Update Kraje SET sortkey=$prevSortkey WHERE id=$actId";
		$transCommit = 'COMMIT';
		
		$module = new ModulesMgr();
        $module -> loadModule('Sklep');
        $okAction = $module->getModuleActionIdByName('ShowKrajeAdmin');
        
        $dbInt->ExecQuery($transQuery);
        $dbInt->ExecQuery($update0);
        $dbInt->ExecQuery($update1);
 		$dbInt->ExecQuery($update2);
 		$dbInt->ExecQuery($transCommit);
 		
 		header("Location: ?a=".$okAction);
	}
	
	public function testUniqueSortkey($val)
	{	
		
		$id = $_SESSION['tmpKrajId'];
		$str =$val['sortkey']; 
		$sql = "SELECT COUNT(1) as ile FROM Kraje WHERE sortkey='$str' and id<>$id And Active='T'";
		
		$DBInt = DBSingleton::getInstance();
		$dbResult = $DBInt->ExecQuery($sql);
 	    $recData = $dbResult->fetchRow(DB_FETCHMODE_ASSOC);
		$ile = $recData['ile'];
 	    
		return $ile==0;
				
	}
}
?>
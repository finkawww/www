<?php
class AdministracjaOferta
{
	private $oferta = null;
	private $ofertaView = null;
	private $towar = null;
	
	public function DelOfertaDo($id)
	{
		$DBInt = DBSIngleton::getInstance();
		$delQuery = "DELETE FROM Oferty WHERE id=$id";
		$DBInt->ExecQuery($delQuery);
		
		$module = new ModulesMgr();
		$module->loadModule('Sklep');
		$okAction = $module->getModuleActionIdByName('ShowOfertyAdmin');
		$dialog = new dialog('Usuwanie oferty' , 'Usunięto ofertę', 'Info', 300, 150);
		$dialog->setAlign('center');
		$dialog->setOkCaption('Ok');
		$dialog->setOkAction($okAction);
		$html = $dialog->show(1);
		return $html;
	}
	
	public function __construct()
	{
		$this->towar = new Towar();
		$this->oferta = new Oferta();
		$this->ofertaView = new ofertaView();
	}
	public function ShowOfertyAdmin()
	{
		$html = $this->ofertaView->ShowOfertaAdmin();
		return $html;
	}
	public function AddOfertaAdmin($id)
	{
		$html = '';
		$html = $this->ofertaView->AddOfertaAdmin($id);
		return $html;
	}
	public function ChooseTowarOferta($id)
	{
		return $this->ofertaView->ShowChooseTowar($id);
	}
	public function DelOferta($id)
	{
		$html = '';
 		$module = new ModulesMgr();
		$module->loadModule('Sklep');
		$cancelAction = $module->getModuleActionIdByName('ShowOfertyAdmin');
		$okAction = $module->getModuleActionIdByName('DelOfertaDo');
		$dialog = new dialog('Usuwanie' , 'Czy usunąć ofertę?', 'Query', 300, 150);
		$dialog->setAlign('center');
		$dialog->setOkCaption('Tak');
		$dialog->setOkAction($okAction);
		$dialog->setCancelAction($cancelAction);
		$dialog->setCancelCaption('Nie');
		$dialog->setId($id);
		$html .= $dialog->show(1);
 			
		return $html;		
	}
	
	public function ChooseGrupyOferta()
	{
		return $this->ofertaView->showGrupyChooseList();
	}
	public function ShowPrzypiszTowarOfercieAdmin($id)
	{
		$html = $this->ofertaView->ShowPrzypiszTowarOfercieAdmin($id);
		return $html;
	}
	public function PrzypiszTowaryDo($idOferta, $towIdArr)
	{
		$dialogTxt = '';
		$arrTowToDelete = array();
		$arrTowToInsert = array();
		$arrTowToInsertTmp = array();
		try
		{
			$html = '';
			$DBInt = DBSIngleton::getInstance();
    		$queryTransStart = 'START TRANSACTION';
			$DBInt->ExecQuery($queryTransStart);
			$inTxt = '';$delTxt = '';
			print_r($towIdArr);
			foreach($towIdArr as $towId)
			{
				$inTxt .= $towId.',';
			}
			
			$inTxt = substr($inTxt, 0, -1);//obcina ostatni znak
			$queryToDelete = '';
			if ($inTxt == '')
			{
				$queryToDelete = "
					SELECT ot.id 
					FROM OfertyTowary ot
					WHERE 
						ot.FKOferta = $idOferta";
			}
			else
			{
			$queryToDelete = "
					SELECT ot.id 
					FROM OfertyTowary ot
					WHERE 
						ot.FKOferta = $idOferta and
						NOT EXISTS (SELECT 1 
									FROM OfertyTowary ot1 
									WHERE ot1.FKTow=ot.FKTow and ot1.FKOferta = ot.FKOferta and ot1.FKTow in ($inTxt))
					";
			}
			//echo $queryToDelete;
			$qResult = $DBInt->ExecQuery($queryToDelete);
			while($data = $qResult->fetchRow(DB_FETCHMODE_ASSOC))
			{
				$arrTowToDelete[] = $data['id'];
			}
			foreach($arrTowToDelete as $idDel)
			{
				$delTxt .= $idDel.',';
			}
			$delTxt = substr($delTxt, 0, -1);
			if (count($arrTowToDelete)>0)
			{
				$queryDel = "DELETE FROM OfertyTowary WHERE id IN ($delTxt)";
				
				$DBInt->ExecQuery($queryDel);
			}
			
			
		//	pobieram wszystkier, ktore sa juz w tabeli
		if ($inTxt != '')
		{
			$queryToInsert = "
				SELECT ot.FKTow
				FROM OfertyTowary ot
				WHERE FKOferta = $idOferta and ot.FKTow in ($inTxt)
			";
			//echo $queryToInsert;
			$qResult = $DBInt->ExecQuery($queryToInsert);
			while($data = $qResult->fetchRow(DB_FETCHMODE_ASSOC))
			{
				$arrTowToInsertTmp[] = $data['FKTow'];
			}
			//..i pobieram roznice zbiorow
			$arrTowToInsert = array_diff($towIdArr, $arrTowToInsertTmp);
						
			$querySortkey = "SELECT max(sortkey) as maxSort FROM OfertyTowary WHERE FKOferta = $idOferta";
			$qResult = $DBInt->ExecQuery($querySortkey);
			$data = $qResult->fetchRow(DB_FETCHMODE_ASSOC);
			
			$i = $data['maxSort'];
			foreach ($arrTowToInsert as $towId)
			{
				$i++;
				$queryInsert = "INSERT INTO `OfertyTowary`(`FKTow`, `FKOferta`, `sortkey`)	VALUES($towId,$idOferta,$i)";
				//echo $queryInsert;
				$DBInt->ExecQuery($queryInsert);
			}
			
		//	sprawdzenie
		
				
			$queryCheck = "SELECT COUNT(1) AS Ile FROM OfertyTowary WHERE FkTow IN ($inTxt) AND FkOferta=$idOferta";
			$DBInt = DBSIngleton::getInstance();
    		$qResult = $DBInt->ExecQuery($queryCheck);
    		$data = $qResult->fetchRow(DB_FETCHMODE_ASSOC);
    		$ile = $data['Ile'];
    		if ($ile == count($towIdArr))
    		{
	    		$dialogTxt .= "Dodano $ile towarów do oferty. Operacja zakończona powodzeniem";
       		}
    		else
    		{
	    		throw new Exception('AdministracjaOferta::PrzypiszTowaryDo - queryCheck');
    		}
		}
    		$queryCommitTrans = 'COMMIT';
			$DBInt->ExecQuery($queryCommitTrans);
			
    		$module = new ModulesMgr();
			$module->loadModule('Sklep');
			$okAction = $module->getModuleActionIdByName('ShowOfertyAdmin');
			$dialog = new dialog('Przypisanie towarów' , $dialogTxt, 'Info', 300, 150);
			$dialog->setAlign('center');
			$dialog->setOkCaption('Ok');
			$dialog->setOkAction($okAction);
			$html .= $dialog->show(1);
			return $html;
		}
		catch (exception $e)
  		{
  			$queryRollbackTrans = 'ROLLBACK';
  			$DBInt->ExecQuery($queryRollbackTrans);
  			$exc = new ExceptionClass($e, 'Sklep:AdministracjaOferta::PrzypiszTowaryDo');
   			return $exc->writeException();
  		}   
		
		
	}
	public function DelPrzypisanie($id)
	{
		$DBInt = DBSIngleton::getInstance();
		$querySelId = "SELECT FKOferta FROM OfertyTowary WHERE id=$id";
		$qResult = $DBInt->ExecQuery($querySelId);
		$data = $qResult->fetchRow(DB_FETCHMODE_ASSOC);
		$idOferty = $data['FKOferta'];
				
		$queryDel = 'DELETE FROM OfertyTowary WHERE id='.$id;
		$DBInt->ExecQuery($queryDel);
		$moduleTmp = new ModulesMgr();
		$moduleTmp->loadModule('Sklep');
		$action = $moduleTmp->getModuleActionIdByName('ShowPrzypiszTowarOfercie');
		unset($moduleTmp);
		header("Location: ?a=$action&id=$idOferty");
	}
	public function towOfertaUp($id)
	{
		
		$DBInt = DBSIngleton::getInstance();
		$querySelId = "SELECT FkOferta FROM OfertyTowary WHERE id=$id";
		$qResult = $DBInt->ExecQuery($querySelId);
		$data = $qResult->fetchRow(DB_FETCHMODE_ASSOC);
		$idOferty = $data['FkOferta'];
		
		$dbInt = DBSingleton::getInstance();
		$query = 
				"
				SELECT 
					id, sortkey
				FROM
					OfertyTowary
				WHERE id = $id
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
				OfertyTowary
			WHERE
				sortkey = (SELECT max(sortkey) FROM OfertyTowary WHERE sortkey<$actSortkey and FKOferta=$idOferty)
				and FKOferta = $idOferty
		";
		$res = $dbInt->ExecQuery($query);
        $data2 = $res->fetchRow(DB_FETCHMODE_ASSOC);
	    if ($data2==null)
        {
        	$moduleTmp = new ModulesMgr();
			$moduleTmp->loadModule('Sklep');
			$action = $moduleTmp->getModuleActionIdByName('ShowPrzypiszTowarOfercie');
			unset($moduleTmp);
			header("Location: ?a=$action&id=$idOferty");
        }
		$prevId = $data2['id'];
		$prevSortkey = $data2['sortkey'];
				
		$transQuery = 'START TRANSACTION';
		
		$update0="UPDATE OfertyTowary SET sortkey=-1 WHERE id in ($actId, $prevId)";
		$update1="UPDATE OfertyTowary SET sortkey=$actSortkey WHERE id=$prevId";
		$update2="Update OfertyTowary SET sortkey=$prevSortkey WHERE id=$actId";
		$transCommit = 'COMMIT';
		        
        $dbInt->ExecQuery($transQuery);
        $dbInt->ExecQuery($update0);
        $dbInt->ExecQuery($update1);
 		$dbInt->ExecQuery($update2);
 		$dbInt->ExecQuery($transCommit);
 		
 		//header("Location: ?a=".$okAction);
		
		
		
		$moduleTmp = new ModulesMgr();
		$moduleTmp->loadModule('Sklep');
		$action = $moduleTmp->getModuleActionIdByName('ShowPrzypiszTowarOfercie');
		unset($moduleTmp);
		header("Location: ?a=$action&id=$idOferty");	
	}
	public function towOfertaDown($id)
	{
		$DBInt = DBSIngleton::getInstance();
		$querySelId = "SELECT FkOferta FROM OfertyTowary WHERE id=$id";
		$qResult = $DBInt->ExecQuery($querySelId);
		$data = $qResult->fetchRow(DB_FETCHMODE_ASSOC);
		$idOferty = $data['FkOferta'];
		
		$dbInt = DBSingleton::getInstance();
		$query = 
				"
				SELECT 
					id, sortkey
				FROM
					OfertyTowary
				WHERE id = $id
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
				OfertyTowary
			WHERE
				sortkey = (SELECT min(sortkey) FROM OfertyTowary WHERE sortkey>$actSortkey and FKOferta=$idOferty)
				and FKOferta = $idOferty
		";
		$res = $dbInt->ExecQuery($query);
        $data2 = $res->fetchRow(DB_FETCHMODE_ASSOC);
        if ($data2==null)
        {
        	$moduleTmp = new ModulesMgr();
			$moduleTmp->loadModule('Sklep');
			$action = $moduleTmp->getModuleActionIdByName('ShowPrzypiszTowarOfercie');
			unset($moduleTmp);
			header("Location: ?a=$action&id=$idOferty");
        }
          
		$prevId = $data2['id'];
		$prevSortkey = $data2['sortkey'];
				
		$transQuery = 'START TRANSACTION';
		
		$update0="UPDATE OfertyTowary SET sortkey=-1 WHERE id in ($actId, $prevId)";
		$update1="UPDATE OfertyTowary SET sortkey=$actSortkey WHERE id=$prevId";
		$update2="Update OfertyTowary SET sortkey=$prevSortkey WHERE id=$actId";
		$transCommit = 'COMMIT';
		        
        $dbInt->ExecQuery($transQuery);
        $dbInt->ExecQuery($update0);
        $dbInt->ExecQuery($update1);
 		$dbInt->ExecQuery($update2);
 		$dbInt->ExecQuery($transCommit);
 		
 		//header("Location: ?a=".$okAction);
		
		
		
		$moduleTmp = new ModulesMgr();
		$moduleTmp->loadModule('Sklep');
		$action = $moduleTmp->getModuleActionIdByName('ShowPrzypiszTowarOfercie');
		unset($moduleTmp);
		header("Location: ?a=$action&id=$idOferty");		
	}
	
}

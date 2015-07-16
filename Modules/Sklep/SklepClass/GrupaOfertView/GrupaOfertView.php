<?php
final class GrupaOfertItem
{
	public $id;
	public $nazwa;
	public $idOferty;
	
}
class GrupaOfertView
{
	private $GrupaOfert = null;
	
	public function Show()
	{
		
		$html = '';
		$grupyOfert = array();
		
		$query = "
				SELECT DISTINCT
					go.id, go.nazwa, go.pict, go.opis  
				FROM 
					GrupyOfert go
				ORDER BY 
					go.sortkey";
		
		$DBInt = DBSingleton::getInstance();
		$dbResult = $DBInt->ExecQuery($query);
 	    while($data = $dbResult->fetchRow(DB_FETCHMODE_ASSOC))
 	    {
 	    	$tmpGrupaOfertItem = new GrupaOfertItem();
 	    	$tmpGrupaOfertItem->id = $data['id'];
 	    	$tmpGrupaOfertItem->nazwa = $data['nazwa'];
 	    	$tmpGrupaOfertItem->pict = $data['pict'];
 	    	$tmpGrupaOfertItem->opis = $data['opis'];
 	    	//$tmpGrupaOfertItem->idOferty = $data['idOferty'];
 	    	
			$grupyOfert[] = $tmpGrupaOfertItem;	
 	    }
 	    
 	    $moduleTmp = new ModulesMgr();
		$moduleTmp->loadModule('Sklep');
 	    $actionPokazOferte = $moduleTmp->getModuleActionIdByName('PokazOfertyGrupy');
 	    unset($moduleTmp);
 	     	    
 	    $smarty = new mySmarty();
 	    
		$smarty->assign('grupyOfert', $grupyOfert);
		$smarty->assign('actionPokazOferte', $actionPokazOferte);
				 		
		$html = $smarty->fetch('modules/GrupyOfertAll.tpl');
		return $html;
		
	}
	
}
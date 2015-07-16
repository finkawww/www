<?php

class AdministracjaTowar
{
	private $towar = null;
	private $towarView = null;
	public function __construct()
	{
		$this->towar = new Towar();
		$this->towarView = new TowarView();
	}
	public function ShowTowary()
	{
		return $this->towarView->ShowTowaryAdmin();	
	}
	public function AddTowar($id)
	{
		return $html = $this->towarView->ShowAddTowar($id);
	}
	public function DelTowar($id)
	{
		$query = "
			SELECT count(1) as ile FROM
				Towary T inner join OfertyTowary OT
					ON  T.id = OT.FKTow
				WHERE
					T.id=$id and T.zarezerwowany='T'
				 
				";
		
		$DBInt = DBSingleton::getInstance();
		$dbResult = $DBInt->ExecQuery($query);
 	    $recData = $dbResult->fetchRow(DB_FETCHMODE_ASSOC);
		$ile = $recData['ile'];
		
		if ($ile == 0)
		{
			return $this->towarView->DelTowar($id);
		}
		else
		{
			return $this->towarView->CannotDel();	
		}
	}
}
?>
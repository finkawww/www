<?php
class Kraj
{
	private $nazwa;
	private $sortkey;
	private $id;
	
	public function GetNazwa()
	{
		return $this->nazwa;
	}
	public function GetSortkey()
	{
		return $this->sortkey;
	}
	public function SetNazwa($nazwa)
	{
		$this->nazwa = $nazwa;
	}
	public function SetSortkey($sortkey)
	{
		$this->sortkey = $sortkey;		
	}
	public function SetId($id)
	{
		$this->id = $id;
	}
	public function Load($id, $lang)
	{
		if ($lang == 'PL')
		{
			$query = "
				SELECT
					id, sortkey, nazwa	
				FROM 
					Kraje
				WHERE 
					id=$id
			";
		}
		else
		{
			$query = "
				SELECT 
					k.id, k.sortkey, kl.name as nazwa
				FROM 
					Kraje d INNER JOIN KrajeLang dl ON d.id = dl.FKKraj
				WHERE
					id=$id 
			";
		}
		$DBInt = DBSIngleton::getInstance();
    	$qResult = $DBInt->ExecQuery($query);
    	$data = $qResult->fetchRow(DB_FETCHMODE_ASSOC);
    	
    	$this->nazwa = $data['nazwa'];
    	
    	$this->id = $id;
    	$this->sortkey = $data['sortkey'];
		
	}
	public function Save()
	{
		if ($this->id == 0)
		{
			//insert
			$query = 
			"INSERT INTO 
				Kraje (nazwa, sortkey)
			VALUES
				('$this->nazwa', $this->sortkey)
			";
		}
		else
		{
			//update
				$query = 
			"
			UPDATE Kraje SET
				nazwa = '$this->nazwa', 
				sortkey = $this->sortkey
			WHERE 
				id=$this->id
			";
		}
		try
		{
			//echo $query;
			$DBInt = DBSIngleton::getInstance();
			$DBInt->ExecQuery($query);
		}
		catch(exception $e)
		{
			$dialog = new dialog('Zapis danych kraju', 'Wystąpiły problemy. Dane nie zostały zmienione!', 'info', 200, 100);
	 		$dialog->setAlign('alert');
 			$html .=$dialog->show(1);
 			return $html;
		}
	}
	public function Del($id)
	{
		$query = "UPDATE Kraje SET Active='N' WHERE id=$id";
		$DBInt = DBSIngleton::getInstance();
		$DBInt->ExecQuery($query);
	}
	
}
?>
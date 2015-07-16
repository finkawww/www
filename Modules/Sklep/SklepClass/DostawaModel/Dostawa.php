<?php

class Dostawa
{
	private $DBInt = null;
	
	private $cena;
	private $nazwa;
	private $opis;
	private $sortkey;
	private $id;
	
	
	//Gettery i Settery
	public function GetNazwa()
	{
		return $this->nazwa; 
	}
	public function GetCena()
	{
		return $this->cena;
	}
	public function GetOpis()
	{
		return $this->opis;	
	}
	public function GetSortkey()
	{
		return $this->sortkey;	
	}
	public function GetId()
	{
		return $this->id;
	}
	//zwraca formy dostawy jako tablice stringow
	public function GetFormyDostawy()
	{
		return $arrFormyDostawy;
	}
	public function SetNazwa($nazwa)
	{
		$this->nazwa = $nazwa;
	} 
	public function SetCena($cena)
	{
		$this->cena = $cena;
	}
	public function SetOpis($opis)
	{
		$this->opis = $opis;	
	}
	public function SetSortkey($sortkey)
	{
		$this->sortkey = $sortkey;
	}
	public function SetId($id)
	{
		$this->id = $id;
	}
	// wczytuje dostaw po id
	public function Load($id, $lang)
	{
		if ($lang == 'PL')
		{
			$query = "
				SELECT
					id, cena, opis, sortkey, nazwa	
				FROM 
					Dostawy
				WHERE 
					id=$id
			";
		}
		else
		{
			$query = "
				SELECT 
					d.id, d.cena, d.sortkey, dl.opis, dl.nazwa
				FROM 
					Dostawy d INNER JOIN DostawyLang dl ON d.id = dl.FKDostawy
				WHERE
					id=$id 
			";
		}
		$DBInt = DBSIngleton::getInstance();
    	$qResult = $DBInt->ExecQuery($query);
    	$data = $qResult->fetchRow(DB_FETCHMODE_ASSOC);
    	$this->opis = $data['opis'];
    	$this->nazwa = $data['nazwa'];
    	$this->cena = $data['cena'];
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
				Dostawy (opis, nazwa, cena, sortkey)
			VALUES
				('$this->opis', '$this->nazwa', $this->cena, $this->sortkey)
			";
		}
		else
		{
			//update
				$query = 
			"
			UPDATE Dostawy SET
				opis = '$this->opis',
				nazwa = '$this->nazwa', 
				cena = '$this->cena', 
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
			$dialog = new dialog('Zapis dostawy', 'Wystąpiły problemy. Dane nie zostały zmienione!', 'info', 200, 100);
	 		$dialog->setAlign('alert');
 			$html .=$dialog->show(1);
 			return $html;
		}
	}
	
}
?>
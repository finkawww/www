<?php
class Platnosc
{
	private $opis, $nazwa;
	private $cena;
	private $id;
	private $sortkey;
	private $typ; //1-przy odbiorze,2-przelew,3- platnosc elektroniczna
	
	public function GetOpis()
	{
		return $this->opis;	
	}
	public function GetNazwa()
	{
		return $this->nazwa;
	}
	public function GetCena()
	{
		return $this->cena;
	}
	public function GetId()
	{
		return $this->id;	
	}
	public function GetSortkey()
	{
		return $this->sortkey;	
	}
	public function GetTyp()
	{
		return $this->typ;
	}
	
	public function GetFormyPlatnosci()
	{
		//tablica assoc posort po sortkey w jezyku lang
		return $arrNazwa;//posortowane po sortkey
	}
	
	public function SetOpis($opis)
	{
		$this->opis = $opis;
	}
	public function SetNazwa($nazwa)
	{
		$this->nazwa = $nazwa;	
	}
	public function SetCena($cena)
	{
		$this->cena = $cena;
	}
	public function SetId($id)
	{
		$this->id = $id;
	}
	public function SetSortkey($sortkey)
	{
		$this->sortkey = $sortkey;
	}
	public function SetTyp($typ)
	{
		$this->typ = $typ;
	}
	
	public function Load($id, $lang)
	{
		if ($lang == 'PL')
		{
			$query = 
			"
			SELECT opis, nazwa, cena, sortkey, typ
			FROM Platnosci
			WHERE id=$id
			";
		}
		else
		{
			$query = 
			"
				SELECT
					lp.opis, lp.nazwa, p.cena, p.sortkey, p.typ
				FROM 
					Platnosci p	INNER JOIN PlatnosciLang lp ON p.id = lp.FKPlatnosci
				WHERE id=$id  
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
    	$this->typ = $data['typ'];
	}
	
	public function Save($id)
	{
		if ($id == 0)
		{
			//insert
			$query = 
			"INSERT INTO 
				Platnosci (opis, nazwa, cena, sortkey, typ)
			VALUES
				('$this->opis', '$this->nazwa', $this->cena, $this->sortkey, $this->typ)
			";
		}
		else
		{
			//update
			$query = 
			"
			UPDATE Platnosci SET
				opis = '$this->opis',
				nazwa = '$this->nazwa', 
				cena = '$this->cena', 
				sortkey = $this->sortkey, 
				typ = $this->typ
			WHERE 
				id=$id
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
			$dialog = new dialog('Zapis płatności', 'Wystąpiły problemy. Dane nie zostały zmienione!', 'info', 200, 100);
	 		$dialog->setAlign('alert');
 			$html .=$dialog->show(1);
 			return $html;
		}
	}
	public function Del($id)
	{
		$query = "UPDATE Platnosci SET Active='N' WHERE id=$id";
		$DBInt = DBSIngleton::getInstance();
		$DBInt->ExecQuery($query);
	}
	
}
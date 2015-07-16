<?php

class Oferta
{
	private $id=0, $nazwa, $opis, $obraz,  $idGrupy;
	private $towaryIdArr = array();
	private $towaryOdDoArr = array();

	private $DBInt = null;
	//gettery i settery
	
	public function GetNazwa()
	{
		return $this->nazwa;
	}
	public function GetOpis()
	{
		return $this->opis;
	}
	
	public function GetTowaryAll()
	{
		return $this->towaryIdArr;
	}
	public function GetTowary($od, $do)
	{
		if ($do>$this->Count()) 
		{
			$do = $this->Count();
		}
		for ($i=$od; $i<=$do; $i++)
		{
			$this->towaryOdDoArr[] = $this->towaryIdArr[$i-1];
		}
		return $this->towaryOdDoArr;
	}
	
	public function GetId()
	{
		return $this->id;
	}
	public function GetObraz()
	{
		return $this->obraz;
	}
	public function GetIdGrupy()
	{
		return $this->idGrupy;
	}
		
	public function SetNazwa($nazwa)
	{
		$this->nazwa = $nazwa;
	}
	public function SetOpis($opis)
	{
		$this->opis = $opis;
	}
	
	public function SetId($id)
	{
		$this->id = $id;	
	}
	public function SetObraz($obraz)
	{
		$this->obraz = $obraz;	
	}
	public function SetTowary($towArr)
	{
		unset($this->towayIdArr);
		for ($i = 0; $i<count($towArr); $i++)
		{
			$this->towaryIdArr[] = $towArr[$i];
		}	
	}
	public function SetIdGrupy($grId)
	{
		$this->idGrupy = $grId;
	}
	
	//laduje oferte - tytul, opis, przypisanie i list� towar�w w kolenosci sort
	public function Load($id)
	{
		$lang = $_SESSION['lang'];
		if ($lang== 'PL')
		{
			
			$ofertaQuery = 
			'
				SELECT  
					nazwa, opis,  obrazTyt, FkGrupy FROM Oferty WHERE id = '.$id;
		}
		else
		{
			$ofertaQuery = "
				SELECT  
					ol.nazwa, ol.opis, o.obrazTyt, o.FkGrupy 
				FROM 
					Oferty o INNER JOIN OfertyLang ol ON o.id=ol.FKOferta 
				WHERE 
					o.id = $id and ol.lang='$lang'";
				
		}
		
		$DBInt = DBSIngleton::getInstance();
    	$qResult = $DBInt->ExecQuery($ofertaQuery);
    	$data = $qResult->fetchRow(DB_FETCHMODE_ASSOC);
    	$this->id = $id;
    	$this->nazwa = $data['nazwa'];
    	$this->opis = $data['opis'];
    	$this->obraz = $data['obrazTyt'];
    	$this->idGrupy = $data['FkGrupy'];
		
    	$rezerwacja = new Konfiguracja();
		$rezerwacje = $rezerwacja->Rezerwacje();
		unset($rezerwacja);
    	
		if ($rezerwacje)
		{
		
    	$queryIDTowary = 
    		"
    		SELECT
    			OT.FKTow
    		FROM 
    			Oferty O  
    				INNER JOIN OfertyTowary OT ON OT.FKOferta = O.id
    				INNER JOIN Towary T ON OT.FKTow = T.id
    		WHERE
    			O.id = $id and (T.zarezerwowany='N' OR T.zarezerwowany='') AND T.ilosc>0  
    		ORDER BY
    			OT.sortkey
    		";
		}
		else
		{
			$queryIDTowary = 
    		"
    		SELECT
    			OT.FKTow
    		FROM 
    			Oferty O  
    				INNER JOIN OfertyTowary OT ON OT.FKOferta = O.id
    				INNER JOIN Towary T ON OT.FKTow = T.id
    		WHERE
    			O.id = $id  
    		ORDER BY
    			OT.sortkey
    		";
		}
    	
		$qResult2 = $DBInt->ExecQuery($queryIDTowary);
		$i = 0;
		while ($data2 = $qResult2->fetchRow(DB_FETCHMODE_ASSOC))
		{
			$this->towaryIdArr[] = $data2['FKTow'];
		}    
		
	}
	//wczytuje grupe ofert przypisdanych do menu
	public function LoadGrupa($menuId)
	{
		$arrOferty = array();
		$ofertyQuery = 'SELECT id FROM `Oferty` WHERE idMenu = '.$menuId;
		$DBInt = DBSIngleton::getInstance();
    	$qResult = $DBInt->ExecQuery($ofertyQuery);
		$i = 0;
		while ($data = $qResult->fetchRow(DB_FETCHMODE_ASSOC))
		{
			$arrOferty[$i] = $data['id'];
			$i++;
		}
		
		return $arrOferty;
	}

	//zlicza ile jest w ofercie towarow
	public function Save($id)
	{
		if ($this->idGrupy==0)
		{
			$gr = 'NULL';		
		}
		else
		{
			$gr=$this->idGrupy;
		}
		if ($id == 0)
		{
			//insert
			$query = 
			"
			INSERT INTO Oferty (nazwa, opis, FkGrupy, obrazTyt)
			VALUES
			('$this->nazwa', '$this->opis', $gr, '$this->obraz')
			";
		}
		else
		{
			//update
			$query = "
				UPDATE Oferty SET
					nazwa='$this->nazwa',
					opis='$this->opis',
					FkGrupy=$gr,
					obrazTyt='$this->obraz'
				WHERE id=$id 
			";
		}
	
		$DBInt = DBSIngleton::getInstance();
		$DBInt->ExecQuery($query);
	}
	public function Count()
	{
	    return count($this->towaryIdArr);	
	}
	
	
}
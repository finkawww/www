<?php 
//final class KoszykItem
//{
//	public $towarId;
//	public $ilosc;
//} 
class Koszyk
{
	private $ilosc;
	private $towaryId=array(); //of KoszykItem
	private $ilosci=array();//ilosc egzemplarzy
	private $ilosciFirm=array();
	
	public $nic;
	public function ItemExists($idTowaru)
	{
		$result = false;
		for ($i=0;$i<count($this->towaryId);$i++)
		{
			if ($this->towaryId[$i] == $idTowaru)
			{
				$result = true;
				
			}
		}
		return $result;
	}
	
	public function GetTowaryId()
	{
		$arrTowaryId = array();
		for ($i=0;$i<count($this->towaryId);$i++)
		{
			$arrTowaryId[] = $this->towaryId[$i];
		}
	  	return $arrTowaryId;	
	}
	public function ItemsCount()
	{
		return count($this->towaryId);
	}
	public function GetIloscTowaru($idTowaru)
	{
		$ilosc = 1;
		/*for ($i=0; $i<count($this->towaryId); $i++)
		{
			if ($this->towaryId[$i] == $idTowaru)
			{
				$ilosc = $this->ilosci[$i];
			}
		}*/
		return $ilosc;
	}
	//public function GetTowary($koszykItems)
	//{
//		for ($i=0; $i<count($this->items); $i++)
//		{
//			$item = new KoszykItem();
//			$item->ilosc = $this->items[$i]->ilosc;
//			$item->towarID = $this->items[$i]->towarId;
//			$koszykItems[]= $item;
//		}
//  }
	public function GetTowarId($idx)
	{
		return $this->towaryId[$idx];
	}
	public function GetTowarIlosc($idx)
	{
		return $this->ilosci[$idx];
	}
	public function GetTowarIloscFirm($idx)
	{
		return $this->ilosciFirm[$idx];
	}
	public function AddTowar($idTowaru, $iloscEgz, $iloscFirm)
	{
		//jezlei juz jest - dodaje ilosc +1 do istniejacej
		
		/*if ($this->ItemExists($idTowaru))
		{
			for ($i=0; $i<count($this->towaryId); $i++)
			{
				if ($this->towaryId[$i] == $idTowaru)
				{
					$this->ilosci[$i] = $this->ilosci[$i]+$iloscEgz;
					$this->ilosciStanowisk[$i] = $this->ilosci[$i]+$iloscStan;
				}
			}
		}
		else*/
		{
			//echo 'Dodaje towarId:'.$idTowaru;
			
			if ($iloscEgz == 0)
			{
				$iloscEgz = 1;
			}
			if ($iloscFirm == 0)
			{
				$iloscFirm = 3;
			}
			$this->ilosci[]= $iloscEgz;
			$this->ilosciFirm[] = $iloscFirm;
			$this->towaryId[] = $idTowaru;
		}
		
	}
	public function WyczyscKoszyk()
	{
		//for ($i=count($this->towaryId)-1; $i==0; $i--)
		//{
			unset($this->towaryId);
			unset($this->ilosci);
			unset($this->ilosciFirm);
			
		//}
		//$this->towaryId = array_values($this->towaryId);
		//$this->ilosci = array_values($this->ilosci);
		
	}
	public function ZmienIloscPozycji($idTowaru, $ilosc, $iloscFirm)
	{
		if ($ilosc == 0)
		{
			$this->UsunPozycje($idTowaru);	
		}
		else
		{
			for ($i=0; $i<count($this->towaryId); $i++)
			{
				if ($this->towaryId[$i] == $idTowaru)
				  $this->ilosci[$i] = $ilosc;
				
			}
		}
		
		if ($iloscFirm == 0)
		{
			$iloscFrim = 3;
		}
		for ($i=0; $i<count($this->towaryId); $i++)
			{
				if ($this->towaryId[$i] == $idTowaru)
				  $this->ilosciFirm[$i] = $iloscFirm;
				
			}
		
	}
	public function UsunPozycje($idTowaru)
	{
		$i=0;
		foreach($this->towaryId as &$tow)
		{
			
			if ($tow == $idTowaru)
			{
				unset($this->towaryId[$i]);
				unset($this->ilosci[$i]);
				unset($this->ilosciFirm[$i]);
				break;
			}
			$i++;
		}
		/*
		for ($i=count($this->towaryId); $i==0; $i--)
		{
			if ($this->towaryId[$i] == $idTowaru)
			{
				unset($this->towaryId[$i]);
				unset($this->ilosci[$i]);
				
			}
		}*/
		$this->towaryId = array_values($this->towaryId);
		$this->ilosci = array_values($this->ilosci);
		$this->ilosciFirm = array_values($this->ilosciFirm);
		
			
	}
	public function GetIloscWszystkich()
	{		
		return count($this->towaryId);
	}
	
}

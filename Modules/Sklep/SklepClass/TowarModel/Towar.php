<?php

class Towar
{

    private $id, $cena, $ilosc = 0, $obrazMin, $status, $zarezerwowany;
    private $nazwa, $opis, $wersja, $uid, $rabat, $algCeny;

    //gettery i settery

    public function GetAlgCeny()
    {
        return $this->algCeny;
    }

    public function SetAlgCeny($algCeny)
    {
        $this->algCeny = $algCeny;
    }

    public function GetUID()
    {
        return $this->uid;
    }

    public function GetCenaParams($iloscEgz = 0, $iloscFirm = 0)
    {
        $rabat = new Rabat();
        $rabat->Load();
        $param2=0;
        $param1 = 0;
        if (($iloscEgz == 0) && ($iloscFirm == 0))
        {
            throw new Exception("Towar::GetCena;$iloscEgz;$iloscFirm");
        }
        else
        {

            if ($this->algCeny == 0)
            {                
                $param1 = $rabat->GetParamPierwszeNormalVerison();
                $param2 = $rabat->GetParamNormalVerison();
            }
            else
            {
                $param1 = $rabat->GetParamPierwszeNetworkVerison();
                $param2 = $rabat->GetParamNetworkVersion();
            }

            $defPrice = $this->cena;
            //egz
            $priceEgz = $defPrice*$param1 + (($iloscEgz - 1) * $defPrice * $param2);

            $price = 0;

            if ($iloscFirm <= 3)
            {
                $price = $priceEgz;
            }
            else
            {
                /* if ($iloscFirm <=10)
                  {
                  $iloscFirm = 10;
                  }
                  else */
                //{
                //	$iloscFirm = (floor(($iloscFirm-1)/10)+1)*10;
                //}
                $price = $priceEgz + $priceEgz * ((floor($iloscFirm / 10) + 1) * 0.1);
            }
            return $price;
        }
    }

    public function GetCena($iloscEgz = 0, $iloscFirm = 0)
    {
        if (($iloscEgz == 0) && ($iloscFirm == 0))
        {
            throw new Exception("Towar::GetCena;$iloscEgz;$iloscFirm");
        }
        else
        {

            if ($this->algCeny == 0)
            {
                $param = 0.7;
            }
            else
            {
                $param = 0.4;
            }

            $defPrice = $this->cena;
            //egz
            $priceEgz = $defPrice + (($iloscEgz - 1) * $defPrice * $param);

            $price = 0;

            if ($iloscFirm <= 3)
            {
                $price = $priceEgz;
            }
            else
            {
                /* if ($iloscFirm <=10)
                  {
                  $iloscFirm = 10;
                  }
                  else */
                //{
                //	$iloscFirm = (floor(($iloscFirm-1)/10)+1)*10;
                //}
                $price = $priceEgz + $priceEgz * ((floor($iloscFirm / 10) + 1) * 0.1);
            }
            return $price;
        }
    }

    public function GetIlosc()
    {

        if ($this->id != 0)
        {
            $query = "SELECT ilosc FROM Towary WHERE id=$this->id";

            $DBInt = DBSIngleton::getInstance();
            $dbRes = $DBInt->ExecQuery($query);
            $data = $dbRes->fetchRow(DB_FETCHMODE_ASSOC);
            $ilosc = $data['ilosc'];
            return $ilosc;
        }
        else
        {
            //throw new exception('PrĂłba pobrania ilosci na niezainicjownaym towarze');
            return 0;
        }
    }

    //on demand
    //on demand
    public function GetRabat()
    {
        return $this->rabat;
    }

    public function GetObrazMin()
    {
        return $this->obrazMin;
    }

    public function GetNazwa()
    {
        return $this->nazwa;
    }

    public function GetOpis()
    {
        return $this->opis;
    }

    public function GetWersja()
    {
        return $this->wersja;
    }

    public function GetStatus()
    {
        return $this->status;
    }

    public function GetZarezerwowany()
    {
        if ($this->id != 0)
        {
            $query = "SELECT zarezerwowany FROM Towary WHERE id=$this->id";

            $DBInt = DBSIngleton::getInstance();
            $dbRes = $DBInt->ExecQuery($query);
            $data = $dbRes->fetchRow(DB_FETCHMODE_ASSOC);
            $zarezerwowany = $data['zarezerwowany'];
            return $zarezerwowany;
        }
        else
        {
            throw new exception('PrĂłba odczytu rezerwacji na niezainicjownaym towarze');
            return '';
        }
    }

    public function GetId()
    {
        return $this->id;
    }

    public function Load($id, $lang)
    {
        try
        {
            if ($lang == 'PL')
            {
                $ofertaQuery = '
					SELECT
						uid, cena, ilosc, obrazMin, status, zarezerwowany, nazwa, opis,
						wersja, rabat, algCeny  
					FROM 
						Towary 
					WHERE id = ' . $id;
            }
            else
            {
                $ofertaQuery = "
					SELECT
						T.uid, T.cena, T.ilosc, T.obrazMin, T.status, T.zarezerwowany, T.rabat,
						TL.wersja, TL.nazwa, TL.opis, T.algCeny  
					FROM 
						Towary T INNER JOIN TowaryLang TL ON T.id = TL.FKTow
					WHERE T.id = $id AND TL.lang = '$lang'";
            }

            //echo $ofertaQuery;	
            $DBInt = DBSIngleton::getInstance();
            $qResult = $DBInt->ExecQuery($ofertaQuery);
            $data = $qResult->fetchRow(DB_FETCHMODE_ASSOC);
            if (count($data) == 0)
                throw new Exception('Towar::Load - pusty zbiĂłr danych');
            $this->uid = $data['uid'];
            $this->id = $id;
            $this->nazwa = $data['nazwa'];
            $this->opis = $data['opis'];
            $this->cena = $data['cena'];
            $this->algCeny = $data['algCeny'];
            $this->ilosc = $data['ilosc'];

            $this->obrazMin = $data['obrazMin'];
            $this->status = $data['status'];
            $this->zarezerwowany = $data['zarezerwowany'];
            $this->wersja = $data['wersja'];
            $this->rabat = $data['rabat'];
            return '';
        }
        catch (exception $e)
        {
            $exc = new ExceptionClass($e, 'Sklep::Towar::Load');
            return $exc->writeException();
        }
    }

    public function SetUID($uid)
    {
        $this->uid = $uid;
    }

    public function SetCena($cena)
    {
        $this->cena = $cena;
    }

    public function SetIlosc($ilosc)
    {
        $this->ilosc = $ilosc;
        $DBInt = DBSIngleton::getInstance();
        //to dla przypadku, istniejacego juz towaru
        if ($this->id != 0)
        {
            $queryUpdate = "UPDATE Towary SET ilosc=$ilosc WHERE id=$this->id";
            $DBInt->ExecQuery($queryUpdate);
        }
    }

    public function SetObrazMin($obr)
    {
        $this->obrazMin = $obr;
    }

    public function SetNazwa($nazwa)
    {
        $this->nazwa = $nazwa;
    }

    public function SetOpis($opis)
    {
        $this->opis = $opis;
    }

    public function SetStatus($status)
    {
        $this->status = $status;
    }

    public function SetZarezerwowany($val)
    {
        //FIXME Dodac, jezeli ilosc <=2
        $this->zarezerwowany = $val;
        if ($this->id != 0)
        {
            $queryIlosc = "SELECT ilosc FROM Towary WHERE id=$this->id";
            $DBInt = DBSIngleton::getInstance();
            $dbRes = $DBInt->ExecQuery($queryIlosc);
            $data = $dbRes->fetchRow(DB_FETCHMODE_ASSOC);
            $ilosc = $data['ilosc'];
            if (($ilosc == 1) && ($val == 'T'))
            {
                $queryUpdate = "UPDATE Towary SET Zarezerwowany='T' WHERE id=$this->id";
                $DBInt->ExecQuery($queryUpdate);
            }
            if ($val == 'N')
            {
                $queryUpdate = "UPDATE Towary SET Zarezerwowany='N' WHERE id=$this->id";
                $DBInt->ExecQuery($queryUpdate);
            }
        }
        else
        {
            
        }
    }

    public function SetId($id)
    {
        $this->id = $id;
    }

    public function SetWersja($wersja)
    {
        $this->wersja = $wersja;
    }

    public function SetRabat($rabat)
    {
        $this->rabat = $rabat;
    }

    public function GetTowarIdByUID($uid)
    {
        $DBInt = DBSIngleton::getInstance();
        $res = 0;
        if ($uid != '')
        {
            $sql = "SELECT id FROM Towary WHERE uid='$uid'";
            $dbResult = $DBInt->ExecQuery($sql);
            $data = $dbResult->fetchRow(DB_FETCHMODE_ASSOC);
            $res = $data['id'];
        }
        return $res;
    }

    public function Save($id)
    {

        if ($id == 0)
        {
            //insert
            $query = "
			INSERT INTO Towary
			  (uid, cena,ilosc,obrazMin,status,zarezerwowany,
			  nazwa,opis,wersja,rabat, algCeny)
			VALUES (
			'$this->uid', $this->cena, $this->ilosc, '$this->obrazMin',
			  '$this->status', '$this->zarezerwowany', '$this->nazwa',
			  '$this->opis',  '$this->wersja', $this->rabat, $this->algCeny)";
        }
        else
        {

            //update
            //$this->Load($id, 'PL');
            $uid = $this->uid;
            $cena = $this->cena;
            $il = $this->ilosc;
            $obrazMin = $this->obrazMin;
            $status = $this->status;
            $zarezerwowany = $this->zarezerwowany;
            $nazwa = $this->nazwa;
            $opis = $this->opis;
            $wersja = $this->wersja;
            $rabat = $this->rabat;
            $algCeny = $this->algCeny;


            $query = "UPDATE Towary SET uid = '$uid', cena = $cena,
			ilosc = $il, obrazMin = '$obrazMin', status = '$status',
			zarezerwowany = '$zarezerwowany',  nazwa = '$nazwa',opis = '$opis', wersja = '$wersja', rabat = $rabat, algCeny=$algCeny WHERE  id=$id";
        }

        $DBInt = DBSIngleton::getInstance();
        $DBInt->ExecQuery($query);
    }

}

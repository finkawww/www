<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Rabat
 *
 * @author pb
 */
class Rabat
{
    //put your code here
    private $dbInt;
    
    private $id;
    private $paramNaPierwszeNormalne;
    private $paramNaPierwszeSieciowe;
    private $paramNormalne;
    private $paramSieciowe;
    private $rabatEnabled;
    
    public function __construct()
    {
        $this->dbInt = DBSIngleton::getInstance();
    }
    
    public function Load()
    {
        //wczytuje rekord
        
        $sql = 'SELECT * FROM rabat';
        $qResult = $this->dbInt->ExecQuery($sql);
        $data = $qResult->fetchRow(DB_FETCHMODE_ASSOC);
        $this->id = $data["id"];
        $this->paramNaPierwszeNormalne = $data["paramNaPierwszeNormal"];
        $this->paramNaPierwszeSieciowe = $data["paramNaPierwszeNetwork"];
        $this->paramNormalne = $data["paramNormalne"];
        $this->paramSieciowe = $data["paramNetwork"];
        $this->rabatEnabled = $data["rabatEnabled"];
        
    }
    
    public function Save()
    {       
       
        $sql = "UPDATE rabat SET "
               ."paramNaPierwszeNormal=$this->paramNaPierwszeNormalne,"
               ."paramNaPierwszeNetwork=$this->paramNaPierwszeSieciowe,"
               ."paramNormalne=$this->paramNormalne,"
               ."paramNetwork=$this->paramSieciowe,"
               ."rabatEnabled=$this->rabatEnabled"
               ." WHERE id=$this->id ";
        
        $this->dbInt->ExecQuery($sql);
    }
    
    public function GetParamNormalVerison()
    {
        return $this->paramNormalne;
    }
    public function SetParamNormalVersion($value)
    {
        $this->paramNormalne = $value;
    }
        
    //wart parametru obl dla pierwszego stanowiska
    public function GetParamPierwszeNormalVerison()
    {
        return $this->paramNaPierwszeNormalne;
    }
    
    public function SetParamPierwszeNormalVersion($value)
    {
        $this->paramNaPierwszeNormalne = $value;
    }
    
    public function GetParamNetworkVersion()
    {
        return $this->paramSieciowe;
    }    
    
    public function SetParamNetworkVersion($value)
    {
        $this->paramSieciowe = $value;
    }
    
    //parametru obl dla pierwszego stanowiska
    public function GetParamPierwszeNetworkVerison()
    {
        return $this->paramNaPierwszeSieciowe;
    }
    
    public function SetParamPierwszeNetworkVersion($value)
    {
        $this->paramNaPierwszeSieciowe = $value;
    }  

    
    public function GetRabatEnabled()
    {
        return $this->rabatEnabled == 'T';
    }
    
    public function SetRabatEnabled($value)
    {
        $this->rabatEnabled = $value;
    }  
}

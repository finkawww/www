<?php



/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of NewsletterUser
 *
 * @author pb
 */
class NewsletterUser
{
    private $id;
    private $email = "";
    private $salt = "";
            
    
    private function SendMailAfterSave($email)
    {
          
    }
    
    public function Load($id)    
    {
        $sql = "";
        if ($id != 0)
        {
           $sql = "SELECT email, salt FROM NewsletterUsers WHERE id = $id";
           
        }
        $DBInt = DBSIngleton::getInstance();
    	$qResult = $DBInt->ExecQuery($sql);
    	$data = $qResult->fetchRow(DB_FETCHMODE_ASSOC);
    	$this->id = $id;
        $this->salt = $data['salt'];
    	$this->email = $data['email'];
                
    }
    public function DeleteByUser($uniqueIdentifier)
    {
        $sql = "SELECT id, salt FROM NewsletterUsers";
        $DBInt = DBSIngleton::getInstance();
    	$qResult = $DBInt->ExecQuery($sql);
    	while($data = $qResult->fetchRow(DB_FETCHMODE_ASSOC))
        {
            $hash = MD5($data["id"]+$data["salt"]);
            $id = $data["id"];
            if ($hash == $uniqueIdentifier)
            {
                
                $this->DeleteById($id);                
            }
                    
        }
    }
    
    public function DeleteById($id)
    {   
        $sqlCount = "SELECT COUNT(1) AS Ile FROM NewsletterUsers WHERE id=$id";
        $DBInt = DBSIngleton::getInstance();
        $qResult = $DBInt->ExecQuery($sqlCount);
        $data = $qResult->fetchRow(DB_FETCHMODE_ASSOC);
        $ile = $data["Ile"];
        if ($ile > 0)        
        {
            $sql = "DELETE FROM NewsletterUsers WHERE id=$id";
            $DBInt = DBSIngleton::getInstance();
            $DBInt->ExecQuery($sql);
            return true;
        }
        else
        {
            return  false;
        }
    }
    
    public function Delete()
    {   
        if($this->id != 0)
        {
            $sql = "DELETE FROM NewsletterUsers WHERE id=$this->id";
            $DBInt = DBSIngleton::getInstance();
            $DBInt->ExecQuery($sql);
        }
    }
    public function Edit($email)
    {
        
    }
    public function Save()
    {
        
        $sql = "";
        if ($this->id == 0)
        {
            $this->salt = rand(10, 50);
            
            $sql = "INSERT INTO NewsletterUsers(email, salt) VALUES (\"$this->email\", \"$this->salt\")";
        }
        else
        {
            $sql =  "UPDATE NewsletterUsers SET email=\"$this->email\" WHERE id=$this->id";
        }
        
        $DBInt = DBSIngleton::getInstance();
    	$qResult = $DBInt->ExecQuery($sql);
        
    }
    
    public function GetEmail()
    {
        return $this->email;
    }
    
    public function CountUsers($email)
    {
        $sql = "SELECT COUNT(1) AS Ile FROM NewsletterUsers WHERE email='$email'";
        $DBInt = DBSIngleton::getInstance();
    	$qResult = $DBInt->ExecQuery($sql);
        $data = $qResult->fetchRow(DB_FETCHMODE_ASSOC);
        return $data["Ile"];
        
    }
    
    public function SetEmail($email)
    {
        $this->email = $email;
    }
    
    public function GetSalt()
    {
        return $this->salt;
    }
    public function GenrateUqniueIdent()
    {
        return MD5($this->id+$this->salt);
    }
    
    public function GetAllUsersId()
    {
        
        $resArr = array();
        
        $sql = "SELECT id FROM NewsletterUsers";       
        
        $DBInt = DBSIngleton::getInstance();
    	$qResult = $DBInt->ExecQuery($sql);
        
        while($data = $qResult->fetchRow(DB_FETCHMODE_ASSOC))
        {
                       
            
            array_push($resArr, $data["id"]);
            //$resArr[] = $userObj;                
            
        }
        
        return $resArr;
        
    }
    public function GetId()
    {
        return $this->id;
    }
            
    

}

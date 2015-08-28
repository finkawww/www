<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class BlogItem
{

    private $id;
    private $name;
    private $title;
    private $headline;
    private $content;    
    private $date;    
    private $categoryName;
    
    public function Save()
    {
        try
        {
            $query = "";
            if ($id <= 0)
            {
                $query = "INSERT INTO `blogitems`(`name`, `title`, `headline`, `content`, `categoryName`, `itemdate`)"
                        . "VALUES ('$this->name', '$this->title', '$this->headline', '$this->content', '$this->categoryName', '$this->date')";
                
            }
            else
            {
                $query = "UPDATE blogitems SET "
                        . " `name` = '$this->name', "
                        . " `title`='$this->title', "
                        . " `headline` = '$this->headline', "
                        . " `content` = '$this->content', "
                        . " `categoryName` = '$this->categoryName', "
                        . " `itemdate` = '$this->date'"
                        . " WHERE id=$this->id";
            }
            echo "zapytanie $query";
            $dbInt = DBSingleton::GetInstance();
            $dbInt->ExecQuery($query);        
            return true;
        }
        catch(Exception $e)
        {
            return false;
        }
    }
    
    public function Delete()
    {
        $query = "DELETE BlogItems WHERE id=$this->id";
        $dbInt = DBSingleton::GetInstance();
        $dbInt->ExecQuery($query);        
        return true;       
    }
    
    public function Validate()
    {
        $result = array();
        
        return $result;
    }
    

    public function LoadById($id)
    {
        $query = " SELECT i.name, i.title, i.headline, i.content, i.categoryName, i.itemdate "
                . " FROM blogitems i"                
                . " WHERE i.id=$id";

        $dbInt = DBSingleton::GetInstance();
        $dbResult = $dbInt->ExecQuery($query);
        $recData = $dbResult->fetchRow(DB_FETCHMODE_ASSOC);

        $this->id = $id;
        $this->name = $recData['name'];
        $this->title = $recData['title'];
        $this->headline = $recData['headline'];
        $this->content = $recData['content'];        
        $this->date = $recData['itemdate'];
        $this->categoryName = $recData['categoryName'];
    }

    public function LoadByName($name)
    {
        $query = " SELECT i.id, i.name, i.title, i.headline, i.content,  i.categoryName, i.itemdate "
                . " FROM BlogItems i"                
                . " WHERE name=$name";

        $dbInt = DBSingleton::GetInstance();
        $dbResult = $dbInt->ExecQuery($query);
        $recData = $dbResult->fetchRow(DB_FETCHMODE_ASSOC);

        $this->id = $recData['id'];
        $this->name = $recData['name'];
        $this->title = $recData['title'];
        $this->headline = $recData['headline'];
        $this->content = $recData['content'];        
        $this->date = $recData['itemdate'];
        $this->categoryName = $recData['categoryName'];
    }

    public function GetId()
    {
        return $this->id;
    }
    
    public function SetId($id)
    {
        $this->id= $id;
    }

    public function GetName()
    {
        return $this->name;
    }

    public function SetName($name)
    {
        $this->name = $name;
    }

    public function GetTitle()
    {
        return $this->title;
    }

    public function SetTitle($title)
    {
        $this->title = $title;
    }

    public function GetHeadline()
    {
        return $this->headline;
    }

    public function SetHeadline($headline)
    {
        $this->headline = $headline;
    }

    public function GetContent()
    {
        return $this->content;
    }

    public function SetContent($content)
    {
        $this->content = $content;
    }    

    public function GetCategory()
    {
        return $this->categoryName;
    }
    
    public function SetCategory($name)
    {
        $this->categoryName = strtolower($name);
    }

    public function GetDate()
    {
        return $this->date;
    }

    public function SetDate($date)
    {
        $this->date = $date;
    }

}

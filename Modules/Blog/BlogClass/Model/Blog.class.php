<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Blog
{
        
    public function GetBlogItem($name)
    {
        $blogItemObj = new BlogItem();
        $blogItemObj->LoadByName($name);
        return $blogItemObj;
    }
    
    public function GetBlogItems($categoryId)
    {
        $query = "SELECT id FROM BlogItems WHERE categoryId=$categoryId";
        $dbInt = DBSingleton::GetInstance();
        $dbResult = $dbInt->ExecQuery($query);
        $blogItemsId = array();
 	$blogItems = array();
        while($recData = $dbResult->fetchRow(DB_FETCHMODE_ASSOC))
        {            
            $blogItemsId[]= $recData['id'];
        }
        
        foreach ($blogItemsId as $arrItem)
        {
            $blogItem = new BlogItem();
            $blogItem->LoadById($arrItem);
            $blogItems[]= $blogItem;
        }
        return $blogItems;
    }
    
    public function AddBlogItem($blogItem)
    {
        $blogItem.Save();    
    }
    public function DeleteBlogItem($blogId)
    {
        $blogItem = new BlogItem();
        $blogItem->LoadById($id);
        $blogItem->Delete();
    }
    
    public function UpdateBlogItem($blogItemObj)
    {
        /*
        $blogItem = new BlogItem();
        $blogItem->LoadById($blogItemObj->id);
        $blogItem->SetCategoryId($blogItemObj->GetCategoryId());
        $blogItem->SetContent($blogItemObj->GetContent());
        $blogItem->SetDate($blogItemObj->GetDate());
        $blogItem->SetHeadline($)
                . ''               
         * 
         */
        $blogItemObj->Save();
    }
    
    
    
}
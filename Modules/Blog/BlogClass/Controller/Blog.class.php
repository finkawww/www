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
    
    public function GetBlogItemsAdmin()
    {
        $view = new BlogItemsAdminListView();
        return $view->Render();
    }
    
    public function GetBlogItems($category)
    {
        $query = "";
        if ($category == "") //admin
        {
            $query = "SELECT id FROM BlogItems ORDER BY categoruName, date";
        }
        else
        {
            $query = "SELECT id FROM BlogItems WHERE categoryName='$category' ORDER BY date";
        }
        
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
        //$blogItem.Save();    
        $view = new BlogItemEditAdminView();
        return $view->Render(0);
    }
    
    public function DeleteBlogItem($blogId)
    {
        $blogItem = new BlogItem();
        $blogItem->LoadById($id);
        $blogItem->Delete();
    }
    
    public function UpdateBlogItem($blogItemObj)
    {        
        $blogItemObj->Save();
    }
}
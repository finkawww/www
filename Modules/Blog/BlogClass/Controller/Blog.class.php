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
        
        $view = new BlogItemView();
        return $view->Render($name);
        
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
            $query = "SELECT id FROM blogitems ORDER BY categoryName, itemdate";
        }
        else
        {
            $query = "SELECT id FROM blogitems WHERE categoryName='$category' ORDER BY itemdate";
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
        
        $view = new BlogItemsListView();
        return $view->Render($blogItems);
        
        
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
        $blogItem->LoadById($blogId);
        if ($blogItem->Delete())
        {
            $module = new ModulesMgr();
	    $module->loadModule('Blog');
	    $okAction = $module->getModuleActionIdByName('GetBlogItemsAdmin');
			
	    $dialog = new dialog('Ok', 'Usunięto rekord', 'Info', 300, 150);
            $dialog->setAlign('center');
            $dialog->setOkCaption('Ok');
            $dialog->setOkAction($okAction);
            return $dialog->show(1);
        }   
        else
        {
            $module = new ModulesMgr();
            $module->loadModule('Blog');
            $okAction = $module->getModuleActionIdByName('GetBlogItemsAdmin');

            $dialog = new dialog('Error', 'Błąd. Dane nie zostały usunięte.', 'Info', 300, 150);
            $dialog->setAlign('center');
            $dialog->setOkCaption('Ok');
            $dialog->setOkAction($okAction);
            return $dialog->show(1);
        }
        
    }
    
    public function UpdateBlogItem($blogItemObj)
    {        
        //$blogItemObj->Save();
        $view = new BlogItemEditAdminView();
        $id = $blogItemObj->GetId();
        return $view->Render($id);
    }
}
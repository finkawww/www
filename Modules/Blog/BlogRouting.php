<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Blog
 *
 * @author pb
 */
class BlogRouting  extends moduleTemplate
{
    
    private $blogController;
    //put your code here
    public function __construct()
    {
        require_once './Modules/Blog/BlogClass/Controller/Blog.class.php';    
        require_once './Modules/Blog/BlogClass/Model/BlogItem.class.php';    
        require_once './Modules/Blog/BlogClass/View/BlogItemEditAdminView.php';    
        require_once './Modules/Blog/BlogClass/View/BlogItemView.php';    
        require_once './Modules/Blog/BlogClass/View/BlogItemsAdminListView.php';    
        require_once './Modules/Blog/BlogClass/View/BlogItemsListView.php';    
        $this->blogController = new Blog();
    }
    
    public function executeAction($actionName, $l, $varArray)
    {
        if ($actionName == 'GetBlogItemAdmin')
        {            
            $name = $_REQUEST['name'];
            return $this->GetBlogItem($name);            
        }
        else if ($actionName == 'GetBlogItemsAdmin')
        {
            $name = $_REQUEST['name'];
            return $this->GetBlogItemsAdmin($name);
                    
        }
        else if ($actionName == 'AddBlogItemAdmin')
        {
            return $this->AddBlogItemAdmin(new BlogItem()); 
        }
        else if($actionName == 'DeleteBlogItemAdmin')        
        {
            $id = $_REQUEST['id'];
            return $this->DeleteBlogAdmin($id);
        }
        else if($actionName == 'UpdateBlogItemAdmin')
        {
            $logItemObj = new BlogItem();
            $logItemObj->SetCategory($_POST["category"]);
            $logItemObj->SetContent($_POST["content"]);
            $logItemObj->SetDate($_POST['date']);
            $logItemObj->SetHeadline($_POST['headline']);
            $logItemObj->SetName($_POST['name']);
            $logItemObj->SetTitle($_POST['title']);
            
            return $this->AddBlogItemAdmin($logItemObj); 
        }
        else if ($actionName == 'GetBlogItem')
        {           
            
            $name = strtolower($varArray[0]);
            
            return $this->GetBlogItem($name);            
        }
        else if ($actionName == 'GetBlogItems')
        {
            
            $category = strtolower($varArray[0]);
            return $this->GetBlogItems($category);
        }
        else
        {
            return "Brak akcji modułu Blog";
        }
        
    }
    
    private function GetBlogItemAdmin($name)
    {
        return $this->blogController->GetBlogItem($name);
    }
    
    private function GetBlogItemsAdmin()
    {
        return $this->blogController->GetBlogItemsAdmin();
        
    }
    
    private function AddBlogItemAdmin($logItemObj)
    {
        return $this->blogController->AddBlogItem($logItemObj);
    }
    
    private function DeleteBlogAdmin($id)
    {
        return $this->blogController->DeleteBlogItem();
    }
    
    private function GetBlogItems($categoryId)
    {
        return $this->blogController->GetBlogItems($categoryId);
    }
    
    
    
}

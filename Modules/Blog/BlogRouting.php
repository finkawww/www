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
            $id = $_REQUEST["id"];
            
            if($id == 0)
            {            
                return $this->AddBlogItemAdmin(new BlogItem()); 
            }
            else
            {
                
                return $this->UpdateBlogItemAdmin($id);
            }
            
        }
        else if($actionName == 'DeleteBlogItemAdmin')        
        {
            $id = $_REQUEST['id'];
            return $this->DeleteBlogAdmin($id);
        }
        else if($actionName == 'UpdateBlogItemAdmin')
        {
            $id= $_REQUEST["id"];
            
            return $this->UpdateBlogItemAdmin($id); 
        }
        else if ($actionName == 'GetBlogItem')
        {   
            $name = $_REQUEST["name"];
            
            return $this->GetBlogItem($name);            
        }
        else if ($actionName == 'GetBlogItems')
        {        
            if(isset($_REQUEST["category"]))
            {
                $category = $_REQUEST["category"];
            }
            else
            {
                $category = strtolower($varArray[0]);            
            }
            
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
    
    private function UpdateBlogItemAdmin($id)
    {
         $blog = new BlogItem();
          $blog->LoadById($id);
          
        return $this->blogController->UpdateBlogItem($blog);
    }
    
    private function DeleteBlogAdmin($id)
    {
        return $this->blogController->DeleteBlogItem($id);
    }
    
    private function GetBlogItems($categoryId)
    {
        return $this->blogController->GetBlogItems($categoryId);
    }
    
    private function GetBlogItem($name)
    {
        return $this->blogController->GetBlogItem($name);
    }
    
    
    
}

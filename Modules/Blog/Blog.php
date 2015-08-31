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
class Blog  extends moduleTemplate
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
            $this->GetBlogItemsAdmin($name);
                    
        }
        else if ($actionName == 'AddBlogItemAdmin')
        {
            $logItemObj = new BlogItem();
            $logItemObj->SetCategoryId($_POST["categoryId"]);
            $logItemObj->SetContent($_POST["content"]);
            $logItemObj->SetDate($_POST['date']);
            $logItemObj->SetHeadline($_POST['headline']);
            $logItemObj->SetName($_POST['name']);
            $logItemObj->SetTitle($_POST['title']);
            
            $this->AddBlogItemAdmin($logItemObj);
        }
        else if($actionName == 'DeleteBlogItemAdmin')        
        {
            $id = $_REQUEST['id'];
            $this->DeleteBlogAdmin($id);
        }
        else if($actionName == 'UpdateBlogItemAdmin')
        {
            $logItemObj = new BlogItem();
            $id = 0;
            if(isset($_REQUEST["id"]))
            {
                $id = $_REQUEST["id"];
            }
            /*$logItemObj->SetCategoryId($_POST["categoryId"]);
            $logItemObj->SetContent($_POST["content"]);
            $logItemObj->SetDate($_POST['date']);
            $logItemObj->SetHeadline($_POST['headline']);
            $logItemObj->SetName($_POST['name']);
            $logItemObj->SetTitle($_POST['title']);*/
            $logItemObj->Load($id);
            
            return "add3";//$this->AddBlogItemAdmin($logItemObj);
        }
        else if ($actionName == 'GetBlogItem')
        {           
            
            $name = strtolower($varArray[0]);            
            return $this->GetBlogItem($name);            
        }
        else if ($actionName == 'GetBlogItems')
        {
            
            $category = strtolower($varArray[0]);
            $this->GetBlogItems($category);
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
        return $this->blogController->GetBlogItems("");
    }
    
    private function AddBlogItemAdmin($logItemObj)
    {
        if ($logItemObj->id == 0)
        {
            
            return "add";//return $this->blogController->AddBlogItem($logItemObj) + "add";
        }
        else
        {
            
            return "adit";//return $this->blogController->UpdateBlogItem($logItemObj)+"edit";
        }
    }
    
    private function DeleteBlogAdmin($id)
    {
        return $this->blogController->DeleteBlogItem($id);
    }
    
    private function GetBlogItems($categoryId)
    {
        return $this->blogController->GetBlogItems($categoryId);
    }
    
    
    
}

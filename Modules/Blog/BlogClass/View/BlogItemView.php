<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class BlogItemView
{
    public function Render($name)
    {
        $blogItemObj = new BlogItem();
        $blogItemObj->LoadByName($name);
        
        $moduleTmp = new ModulesMgr();
        $moduleTmp->loadModule('Blog');
        $bckCategoryAction = $moduleTmp->getModuleActionIdByName('GetBlogItems');
        $category = $blogItemObj->GetCategory();
        
        //$bckCategoryAction = 
        //$bck
        $smarty = new mySmarty();
        $smarty->assign('bckAction', $bckCategoryAction);	
        $smarty->assign('parentCategory', $category);	
	$smarty->assign('blogItem', $blogItemObj);	
        if (isset($_GET["mp"]))
        {
            $mpTxt = $_GET['mp'];
            $smarty->assign('mpId', "&mp=$mpTxt");	
        }
        else
        {
            $smarty->assign('mpId', "");	
        }
	return $smarty->fetch('modules/BlogItemView.tpl');
    }
}
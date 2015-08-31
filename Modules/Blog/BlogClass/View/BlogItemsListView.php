<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class BlogItemsListView
{
    public function Render($blogItemsArr)
    {
        
        $moduleTmp = new ModulesMgr();
        $moduleTmp->loadModule('Blog');
        $itemViewAction = $moduleTmp->getModuleActionIdByName('GetBlogItem');                
        $backAction = $moduleTmp->getModuleActionIdByName('GetBlogItems');
        $smarty = new mySmarty();        
	$smarty->assign('blogItemsArray', $blogItemsArr);	
        $smarty->assign('itemViewAction', $itemViewAction);	        
        $smarty->assign('bckAction', $backAction);	        
        if (isset($_GET["mp"]))
        {
            $mpTxt = $_GET['mp'];
            $smarty->assign('mpId', "&mp=$mpTxt");	
        }
        else
        {
            $smarty->assign('mpId', "");	
        }
	return $smarty->fetch('modules/BlogItemsListView.tpl');
    }
}
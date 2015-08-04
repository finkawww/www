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
        $smarty = new mySmarty();        
	$smarty->assign('blogItemsArray', $blogItemsArr);	
        $smarty->assign('itemViewAction', $itemViewAction);	
	return $smarty->fetch('modules/BlogItemsListView.tpl');
    }
}
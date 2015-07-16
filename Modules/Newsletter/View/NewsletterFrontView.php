    <?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of NewsletterFrontView
 *
 * @author pb
 */
class NewsletterFrontView
{
    public function Render()
    {
        $moduleTmp = new ModulesMgr();
        $moduleTmp->loadModule('Newsletter');
	$action = $moduleTmp->getModuleActionIdByName('AddNewsUser');
                
        $smarty = new mySmarty();
        $smarty->assign('action', $action);
        return $smarty->fetch('modules/NewsletterFrontView.tpl');
    }
}

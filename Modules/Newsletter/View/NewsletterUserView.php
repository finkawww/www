<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of NewsletterUserView
 *
 * @author pb
 */
class NewsletterUserView
{

    public function ShowListAdmin()
    {
        $html = '';
        $module = new modulesMgr();
        $module->loadModule('Newsletter');
        $cancelAction = $module->getModuleActionIdByName('ShowMessageList');
        $cancelButton = new button(buttonAddIcon, 'Powrót', $cancelAction, -1);
        $delAction = $module->getModuleActionIdByName('DeleteUserId');
        unset($module);

        $query = 'SELECT id, email FROM NewsletterUsers';

        $html .= '<table class="Grid" align="center" cellspacing=0>';
        $html .= '<tr>';
        $html .= '<td width=50><img src="./Cms/Files/Img/about-48x48.png" /></td>';
        $html .= '<td><br/></td>';
        $html .= '</tr>';
        $html .= '<tr><td align="right" colspan="2"><hr/>';
        $html .= $cancelButton->show(1);
        $html .= '</td></tr>';
        $html .= '<tr><td>';
        $grid = new gridRenderer();
        $grid->setTitle('Zapisani użytkownicy');
        $grid->setGridAlign('center');
        $grid->setGridWidth(780);
        $grid->addColumn("email", 'Email', 360, false, false, 'center');
        $grid->addColumn("id", "", 10, true, false, 'right');
        $grid->enabledDelAction($delAction);
        $grid->setDataQuery($query);
        $html .=$grid->renderHtmlGrid(1, false, true);
        $html .= '</td></tr>';
        $html .= '<tr><td align="right" colspan="2">';
        $html .= $cancelButton->show(1);
        $html .= '</td></tr>';
        $html .= '</table>';

        return $html;
    }

    public function ShowDelAdmin()
    {
        
    }

}

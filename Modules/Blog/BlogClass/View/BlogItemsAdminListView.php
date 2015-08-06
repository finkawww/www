<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class BlogItemsAdminListView
{

    public function Render()
    {
        
        $query = "SELECT i.date, i.id, i.name, i.title, i.headline, i.categoryName "
                . " FROM blogitems i ORDER BY i.date";
               
                

        $html = '<table class="Grid" align="center" cellspacing=0>';
        if ($galeriaId == 0)
        {
            $html .= '<tr>';
            $html .= '<td width=130><img src="../Cms/Files/Img/about-48x48.png" /></td>';
            $html .= '<td><br/></td>';
            $html .= '</tr>';
        }
        $html .= '<tr><td align="right" colspan="2"><hr/>';

        $modules = new ModulesMgr();
        $modules->loadModule('BlogRouting');
        $action = $modules->getModuleActionIdByName('AddBlogItemAdmin');
        $editAction = $modules->getModuleActionIdByName('EditBlogItemAdmin');
        $delAction = $modules->getModuleActionIdByName('DeleteBlogItemAdmin');
        
        unset($modules);
        $addTopButton = new button(buttonAddIcon, 'Dodaj wpis', $action, 0);
        $html .=$addTopButton->show(1);

        $html .= '</td></tr>';
        $html .= '<tr><td colspan="2">';
        $realListGrid = new gridRenderer();
        $realListGrid->setDataQuery($query);
        if ($galeriaId > 0)
        {
            $nameGal = $this->GetName($galeriaId);
            $realListGrid->setTitle("Lista wpisów blog");
        }
        else
        {
            $realListGrid->setTitle("List wpisów blog");
        }

        $realListGrid->setGridAlign('center');
    	$realListGrid->setGridWidth(790);
    	
    	$realListGrid->addColumn("date", 'Data', 80, false, false, 'center');
    	$realListGrid->addColumn("name", 'Nazwa', 80, false, false, 'left');
        $realListGrid->addColumn("title", 'Tytuł', 80, false, false, 'left');        
    	$realListGrid->addColumn('categoryName', 'Kateogria', 150, false, false,  'left');
    	$realListGrid->addColumn("headline", 'Nagłówek', 250, false, false, 'left');            	
    	$realListGrid->addColumn("id", "", 200, true, false, 'right');
    	$realListGrid->enabledDelAction($delAction);
    	$realListGrid->enabledEditAction($editAction);
    	
    	$html .= $realListGrid->renderHtmlGrid(1);
    	echo "1";
        $html .= '</td></tr>';
    	$html .= '<tr><td align="left"></td><td align="right">';
    	$addTopButton = new button(buttonAddIcon, 'Dodaj wpis', $action, $galeriaId);
    	$html .=$addTopButton->show(1);
    	
    	$html .= '</td></tr>';
    	
    	$html .= '</table>';
        

        return $html;
    }

}

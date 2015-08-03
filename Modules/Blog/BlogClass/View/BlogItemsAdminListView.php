<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class BlogItemsAdminListView
{

    public function Show()
    {
        $query = "SELECT i.id, i.name, i.title, i.headline, i.content, i.categoryId, c.name AS categoryName "
                . " FROM BlogItems i"
                . " INNER JOIN BlogCategories c ON i.categoryId = c.id ";
                

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
        $modules->loadModule('Blog');
        $action = $modules->getModuleActionIdByName('AddBlogItem');
        $editAction = $modules->getModuleActionIdByName('EditBlogItem');
        $delAction = $modules->getModuleActionIdByName('DeleteBlogItem');
        $upAction = $modules->getModuleActionIdByName('realUpAction');
        $downAction = $modules->getModuleActionIdByName('realDownAction');
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
    	
    	$realListGrid->addColumn("opis", 'Opis realizacji', 250, false, false, 'left');
    	$realListGrid->addColumn("kolejnosc", 'Kolejność wyświetlania', 80, false, false, 'left');
    	$realListGrid->addColumn('slowa_kluczowe', 'Słowa kluczowe (wyszukiwanie)', 150, false, false,  'center');
    	$realListGrid->addColumn('priorytet', 'Priorytet (wyszukiwanie)', 100, false, false,  'center');
    	$realListGrid->addColumn('ileZdjec', 'Ilość zdjęć', 100, false, false,  'left');
    	$realListGrid->addColumn("id", "", 200, true, false, 'right');
    	$realListGrid->enabledDelAction($delAction);
    	$realListGrid->enabledEditAction($editAction);
    	
    	$html .= $realListGrid->renderHtmlGrid(1);
    	$html .= '</td></tr>';
    	$html .= '<tr><td align="left"></td><td align="right">';
    	$addTopButton = new button(buttonAddIcon, 'Dodaj realizację', $action, $galeriaId);
    	$html .=$addTopButton->show(1);
    		
    	$html .= '</td></tr>';
    	
    	$html .= '</table>';
        

        return $html;
    }

}

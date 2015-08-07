<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 * 
 */

class BlogItemEditAdminView
{

    public function __construct()
    {
        
    }

    public function Render($id)
    {

        $blogItem = new BlogItem();
        $txt = "Dodawanie wpisu blog";
        if ($id != 0)
        {
            $blogItem->LoadById($id);
            $txt = "Edycja wpisu blog";
        }

        $html .= '<center><table width="580" align="center" cellpadding=0 cellspacing=0 border=0><tr><td>';
        $myForm = null;
        $myForm = new Form('dFORM', 'POST');
        $form = null;
        $form = $myForm->getFormInstance();
        $form->addElement('header', ' hdrTest', $txt);
        $form->addElement('hidden', 'a', $action, null);
        $valId = $form->addElement('hidden', 'id', $id);
                
        //private $name;
        $txtName = $form->addElement('text', 'txtName', 'Nazwa techniczna' , array('size' => 90, 'maxlength'=> 255));        
        //private $title;
        $txtTitle = $form->addElement('text', 'txtTitle', 'Tytuł',array('size' => 90, 'maxlength'=> 255));                
        //private $headline;
        $txtHeadline = $form->addElement('textarea', 'txtHeadline', 'Nagłówek',  array('cols'=>80, 'rows'=>10));        
        //private $content;    
        $txtContent = $form->addElement('textarea', 'txtContent', 'Treść',  array('cols'=>80, 'rows'=>15));                
        //private $date;    
        $dateOptions = array('language' => 'pl', 'format' => 'dMY', 'minYear' => 2005, 'maxYear' => 2050);
        $date = $form->addElement('date', 'data', 'Data', $dateOptions);        
        //private $categoryName;
        $txtCategory = $form->addElement('text', 'txtCategory', 'Kategoria',array('size' => 90, 'maxlength'=> 255));                

        
        
        $form->addElement('reset', 'btnReset', 'Wyczyść');
        $form->addElement('submit', 'btnSubmit', 'Zapisz');
        $form->applyFilter('__ALL__', 'trim');
        $myForm->setStyle(2);

        if ($form->validate())
        {
            
        }
        else
        {
            $html .= $form->toHtml();
            $moduleTmp = new ModulesMgr();
            $moduleTmp->loadModule('BlogRouting');
            $actionBack = $moduleTmp->getModuleActionIdByName('GetBlogItemsAdmin');            
            unset($moduleTmp);
            $html .= '</td></tr><tr><td>
				  <table width = "100%" class="Grid" >';
            $html .= '<tr><td align="right">';            
            $buttonPage2 = new button('../Cms/Files/Img/delete-16x16.png', 'Wróć do listy wpisów', $actionBack, -1);
            $html .= $buttonPage2->show(1);
            $html .= '</td></tr>';
            $html .= '</table>';
        }
        
        $html .= '</td></tr></table>';

        return $html;
    }

}

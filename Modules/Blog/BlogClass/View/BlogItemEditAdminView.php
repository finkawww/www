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
        $blogItem->LoadById($id);
        
    }
}

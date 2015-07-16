<?php

/**
 * Description of NewsletterMessage
 *
 * @author pb
 * NewsLetterMessage ActiveRecord
 */

class NewsletterMessage
{
    private $content = "";
    private $title = "";    
    private $id = 0;
    private $header = "";
    
    public function Load($id)
    {
        $sql = "SELECT content, title, header FROM NewsletterMessages WHERE id=$id";
        $DBInt = DBSIngleton::getInstance();
    	$qResult = $DBInt->ExecQuery($sql);
    	$data = $qResult->fetchRow(DB_FETCHMODE_ASSOC);
    	$this->id = $id;
    	$this->content = $data['content'];
        $this->title = $data['title'];
        $this->header = $data['header'];
    }
    
    public function Save()
    {   
        $sql = "";          
        if ($this->id == 0)
        {
            $sql = "INSERT INTO NewsletterMessages(content, title, header) VALUES ('$this->content', '$this->title', '$this->header')";
        }
        else
        {
            $sql  = "UPDATE NewsletterMessages SET content='$this->content', title='$this->title', header='$this->header' WHERE id=$this->id";
        }
        $DBInt = DBSIngleton::getInstance();
    	$DBInt->ExecQuery($sql);        
    }
    
    public function SetContent($content)
    {
        $this->content = $content;
    }    
    public function SetHeader($header)
    {
        $this->header = $header;
    }    
    
    public function GetContent()
    {
        return $this->content;
    }
    public function SetTitle($title)
    {
        $this->title = $title;
    }
    public function GetTitle()
    {
        return $this->title;
    }
    public function GetHeader()
    {
        return $this->header;
    }
    
    
    public function Render($userId)
    {
        $uniqueUserIdent = "";
        
        $moduleTmp = new ModulesMgr();
        $moduleTmp->loadModule('Newsletter');
	$action = $moduleTmp->getModuleActionIdByName('DeleteUser');
        
        
        if($userId > 0)
        {
        
            $user = new NewsletterUser();
            $user->Load($userId);
            $uniqueUserIdent = $user->GenrateUqniueIdent();
        }
        else
        {
            $uniqueUserIdent = MD5("test");
        }
        
        
        
        $smarty = new mySmarty();
        $smarty->assign('title', $this->GetTitle());
        $smarty->assign('content', $this->GetContent());
        $smarty->assign('header', $this->GetHeader());
        $smarty->assign('footer', "");
        $smarty->assign('id', $uniqueUserIdent);
        $smarty->assign('action', $action);
        return $smarty->fetch('modules/newsletterMessageContent.tpl');
    }
}

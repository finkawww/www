<?php

/*
 * To change thi license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of newsLetter
 *
 * @author pb
 */
class newsLetter extends moduleTemplate
{
    //put your code here
    public function __construct()
    {
        require_once './Modules/Newsletter/Model/Newsletter.class.php';
        require_once './Modules/Newsletter/Model/NewsletterMessage.class.php';
        require_once './Modules/Newsletter/Model/NewsletterUser.php';
        require_once './Modules/Newsletter/Model/NewsletterConfig.class';
        
        require_once './Modules/Newsletter/View/NewsletterFrontView.php';
        require_once './Modules/Newsletter/View/NewsletterView.php';
        require_once './Modules/Newsletter/View/NewsletterMessageView.php';
        require_once './Modules/Newsletter/View/NewsletterUserView.php';
        
    }
    public function executeAction($actionName, $l, $varArray)
    {
        
        if ($actionName == 'AddNewsUser')
        {
            header('Access-Control-Allow-Origin: *'); //- See more at: http://www.yarpo.pl/2011/05/06/ajax-z-access-control-allow-origin/#sthash.0BoROm8z.dpuf
            $email = htmlentities($_REQUEST["email"]);
            if ($email != "")
            {                
                $newsLetterModel = new NewsletterUser();
                if ($newsLetterModel->CountUsers($email)==0)
                {
                    $newsLetterModel->SetEmail($email);
                    $newsLetterModel->Save();
                    $newsletter = new NewsletterObj();
                    $newsletter->SendInfoMail($email);
                }
            }
            return "";
        }        
        else if ($actionName == 'EditNewsUser')
        {
                    
        }
        else if($actionName == 'ShowNewsletterUsers')
        {
            $userView = new NewsletterUserView();
            return $userView->ShowListAdmin();
        }
        
        else if ($actionName == 'DeleteUser')
        {
            $hash = $_REQUEST["id"];
            $user = new NewsletterUser();
            $user->DeleteByUser($hash);
            return "Dane newsletter zostały usunięte. ";         
        }     
        else if ($actionName == 'DeleteUserId')
        {
            $id = $_REQUEST["id"];
            $user = new NewsletterUser();
            $user->DeleteById($id);            
            $userView = new NewsletterUserView();
            return $userView->ShowListAdmin();
            
        }     
        else if ($actionName == 'DeleteUserRemote')
        {
        
        }
        else if($actionName == 'ShowPreviewMessage')
        {
            
            $id = 0;
            if(isset($_REQUEST['id']))
            {
                $id = $_REQUEST['id'];
            }
            if ($id != 0)
            {
                $msgView = new NewsletterMessageView();
                return $msgView->ShowPreviewMessage($id);
            }
            else
            {
                $module = new ModulesMgr();
                $module->loadModule('Newsletter');
                $okAction = $module->getModuleActionIdByName('ShowMessageList');

                $dialog = new dialog('Błąd', 'Nie wskazano wiadomości do podglądu', 'Info', 300, 150);
        
                $dialog->setAlign('center');
                $dialog->setOkCaption('Ok');
                $dialog->setOkAction($okAction);
                return $dialog->show(1);
            }
        }
        else if ($actionName == 'ShowMessageList')
        {
           
            $msgView = new NewsletterMessageView();
           
            return $msgView->ShowMessagesListAdmin();
           
        }
        else if (($actionName == 'ShowAddMessage')||($actionName == 'ShowMessageAdd'))
        {
            $msgView = new NewsletterMessageView();
            return $msgView->ShowMessageEditAdmin(0);
                    
        }
        else if ($actionName == 'AddMessage')
        {
            //dodaje 
        }
        else if (($actionName == 'ShowEditMessage')||($actionName == 'ShowMessageEdit'))
        {
            $id = 0;
            
            if(isset($_REQUEST["id"]))
            {
                $id = $_REQUEST["id"];
            }
            else
            {
                $this->executeAction("ShowAddMessage", 0, null);
            }
            
            $msgView = new NewsletterMessageView();
            
            return $msgView->ShowMessageEditAdmin($id);
        }
        else if ($actionName == "EditMessage")
        {
            
        }
        
        else if ($actionName == 'SaveMessages')
        {
            
        }
        else if ($actionName == 'DeleteMessage')
        {
        
        }
        else if ($actionName == 'SendNewsletter')
        {
            
            $messageId = 0;
            if(isset($_REQUEST['id']))
            {
                $messageId = $_REQUEST['id'];
            } 
            
            if($messageId != 0)
            {
                $newsletterObj = new NewsletterObj();
                
                $newsletterObj->LoadByMessgeId($messageId);
                
                return $newsletterObj->Send();
            }
            
            
        }
        else if ($actionName == 'TestSendNewsletter')
        {
            
            $messageId = 0;
            if(isset($_REQUEST['id']))
            {
                $messageId = $_REQUEST['id'];
            } 
            
            if($messageId != 0)
            {
                $newsletterObj = new NewsletterObj();
                
                $newsletterObj->LoadByMessgeId($messageId);
                
                return $newsletterObj->TestSend();
            }
            
        }
        else if ($actionName == 'ShowNewsletterFrontRegist')
        {
            
            $view = new NewsletterFrontView();
            return $view->Render();
        }
        
        
        
    }
            
}

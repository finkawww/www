<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of NewsletterMessageView
 *
 * @author pb
 */
class NewsletterMessageView
{

    private function ShowAfterMessageAdd()
    {
        $html = '';
        //$delQuery = "DELETE FROM cmsMenu WHERE id=$menuId";
        //$dbInt = DBSingleton::getInstance();
        //$dbInt->ExecQuery($delQuery);

        $module = new ModulesMgr();
        $module->loadModule('Newsletter');
        $okAction = $module->getModuleActionIdByName('ShowMessageList');
        if ($id == 0)
        {
            $dialog = new dialog('Dodano wiadomość', 'Dodano wiadomość', 'Info', 300, 150);
        }
        else
        {
            $dialog = new dialog('Zmieniono wiadomość', 'Zmieniono wiadomość', 'Info', 300, 150);
        }
        $dialog->setAlign('center');
        $dialog->setOkCaption('Ok');
        $dialog->setOkAction($okAction);
        $html .= $dialog->show(1);

        return $html;
    }

    public function ShowMessagesListAdmin()
    {
        $view = "";
        $html = "";
        $sql = 'SELECT m.id, CONCAT(SUBSTR(content, 1, 100), "...") AS content, m.title, n.send_Date FROM 
                NewsletterMessages m INNER JOIN Newsletters n ON n.messageId = m.id
                ORDER BY send_Date DESC, id DESC';

        $module = new modulesMgr();
        $module->loadModule('Newsletter');
        $actionShowPreview = $module->getModuleActionIdByName('ShowPreviewMessage');
        $actionEditMessage = $module->getModuleActionIdByName('ShowEditMessage');
        $actionDelMessage = $module->getModuleActionIdByName('DeleteMessage');
        $actionAddMessage = $module->getModuleActionIdByName('ShowMessageAdd');
        
        $addButton = new button(buttonAddIcon, 'Dodaj', $actionAddMessage, 0);
        
        unset($module);        
        $grid = new GridRenderer();
        $grid->setTitle("Wiadomości Newsletter");
        $grid->setGridAlign('center');
        $grid->setGridWidth(780);
        $grid->setDataQuery($sql);
        $grid->enabledChooseAction($actionShowPreview);
        $grid->enabledEditAction($actionEditMessage);
        $grid->enabledDelAction($actionDelMessage);

        $grid->addColumn("id", "", 10, true, false, "right");
        $grid->addColumn("title", "<center>Tytuł</center>", 200, false, false, "center");
        $grid->addColumn("content", "Treść", 200, false, false, "left");
        $grid->addColumn("sendDate", "Data wysłania", 60, false, false, "left");

        $html .= '<table class="Grid" align="center" cellspacing=0>';
        $html .= '<tr>';
        $html .= '<td width=50><img src="./Cms/Files/Img/about-48x48.png" /></td>';
        $html .= '<td><br/></td>';
        $html .= '</tr>';
        $html .= '<tr><td align="right" colspan="2"><hr/>';
        $html .= $addButton->show(1);
        $html .= '</td></tr>';
        $html .= '<tr><td>';

        //render z zawartoscia html-owa
        $html .=$grid->renderHtmlGrid(1, false, true);
        $html .= '</td></tr>';
        $html .= '<tr><td align="right" colspan="2">';
        $html .= $addButton->show(1);
        $html .= '</td></tr>';
        $html .= '</table>';
        
        return $html;
    }

    public function ShowMessageEditAdmin($id)
    {
        echo('1');
        $html = "";
       
        $hdrText = "Edycja wiadomosći";

        if ($id == 0)
        {
            $hdrText = "Dodawanie wiadomosći";
        }

        $moduleTmp = new ModulesMgr();
        $moduleTmp->loadModule('Sklep');
        if ($id == 0)
        {
            $action = $moduleTmp->getModuleActionIdByName('ShowMessageAdd');
        }
        else
        {
            $action = $moduleTmp->getModuleActionIdByName('ShowMessageEdit');
        }
        
        $myForm = null;
        $myForm = new Form('MessageEditForm', 'POST');
        $MessageForm = null;
        $MessageForm = $myForm->getFormInstance();
        $MessageForm->addElement('header', 'hdrText', $hdrText);

        $MessageForm->addElement('hidden', 'a', $action, null);
	$valId = $MessageForm->addElement('hidden', 'id', $id);
        //$MessageForm->addElement('hidden', 'a', $action, null);
        //$MessageForm->addElement('hidden', 'id', $action, null);

        $title =$MessageForm->addElement('text', 'title', 'Tytuł', null);        
        $header =$MessageForm->addElement('textarea', 'header', 'Header', array('cols'=>50, 'rows'=>5, 'maxlength'=>1132000));
        $content =$MessageForm->addElement('textarea', 'content', 'Zawartość', array('cols'=>50, 'rows'=>5, 'maxlength'=>1132000));
        

        $MessageForm->addRule('title', 'Pole "Tytuł" musi być wypełnione', 'required', null, 'server');
        $MessageForm->addRule('content', 'Pole "Zawartość" musi być wypełnione', 'required', null, 'server');

        $MessageForm->addElement('reset', 'btnReset', 'Wyczyść');
        $MessageForm->addElement('submit', 'btnSubmit', 'Zapisz');

        $MessageForm->applyFilter('__ALL__', 'trim');
        $myForm->setStyle(2);

        if ($MessageForm->validate())
        {
            $messageObj = new NewsletterMessage();
            if ($id != 0)
            {

                $messageObj->Load($id);
            }
            echo('save');   
            $ttl = $title->GetValue();
            $cont = $content->GetValue();
            $head = $header->GetValue();
            
            
            $messageObj->SetTitle($ttl);
            $messageObj->SetContent($cont);
            $messageObj->SetHeader($head);
            $messageObj->Save();
            
            $html .= $this->ShowAfterMessageAdd($id);
        }
        else
        {
            $messageObj = new NewsletterMessage();
            if ($id != 0)
            {
                //wyperlniam pola formularza
                echo('1');
                $messageObj->Load($id);
                $content->setValue($messageObj->GetContent());
                $title->setValue($messageObj->GetTitle());
                $header->setValue($messageObj->GetHeader());
            }
            
            $html .= $MessageForm->toHtml();
        }

        return $html;
    }

    //Confirm
    public function ShowMessageDelAdmin()
    {
        
    }

    public function ShowPreviewMessage($id)
    {
        $html = "";
        
        $newsletterObj = new NewsletterMessage();
        $newsletterObj->Load($id);
        $content = $newsletterObj->Render(0);
        
        $html .= "
            <center><br/><br/><button onClick='Click();' >Podgląd Newsletter</button></center>
            <div style='display: none' id='testPreview'>
            $content
            </div>
            <script>
                  function Click()
                  {
                    var myWindow = window.open('Newsletter Preview', '_blank');            
                    myWindow.document.write(document.getElementById('testPreview').innerHTML);
                  }
            </script>";
        
        $module = new ModulesMgr();
        $module->loadModule('Newsletter');
        
        $cancelAction = $module->getModuleActionIdByName('ShowMessageList');
        $sendTestAction = $module->getModuleActionIdByName('TestSendNewsletter');
        $sendAction = $module->getModuleActionIdByName('SendNewsletter');
        
        $dialog = new dialog('Wysyłanie newsletter', 'Przed wysłaniem do klientów zalecane jest przesłanie na adres testowy. ', 'Info', 300, 150);
        
        $dialog->setAlign('center');
        $dialog->setId($id);
        $dialog->setOkCaption("Wyślij testowo");
        $dialog->setOkAction($sendTestAction);
        $dialog->setCancelCaption('Nie wysyłaj');
        $dialog->setCancelAction($cancelAction);
        $dialog->setOtherAction($sendAction);
        $dialog->setOtherCaption('<u><strong>Wyślij do klientów</strong></u>');
        $html .= $dialog->show(1);
        /*
        $html .= "<div>Podgląd:</div>
                <div style=\"border: 1 px; background-color: #FFFFFF; \" width='800px'>                
                    $content
                </div>
                ";
       */
        
        
        return $html;        
    }

}

<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class UserItem
{

    public $id;
    public $email;

}

class NewsletterObj
{

    private $id;
    private $messageId;
    private $sendDate;
    private $log;

    public function __construct()
    {
        require_once './Modules/Newsletter/Model/NewsletterMessage.class.php';
        require_once './Modules/Newsletter/Model/NewsletterUser.php';
        require_once './Modules/Newsletter/Model/NewsletterConfig.class';

        require_once './Modules/Newsletter/View/NewsletterFrontView.php';
        require_once './Modules/Newsletter/View/NewsletterView.php';
        require_once './Modules/Newsletter/View/NewsletterMessageView.php';
        require_once './Modules/Newsletter/View/NewsletterUserView.php';
    }

    private function GetUsers()
    {
        $sql = "SELECT * FROM NewsletterUsers";
        $DBInt = DBSIngleton::getInstance();
        $qResult = $DBInt->ExecQuery($sql);
        $res = array();


        while ($data = $qResult->fetchRow(DB_FETCHMODE_ASSOC))
        {
            $tmpUser = new UserItem();
            $tmpUser->email = $data["email"];
            $tmpUser->id = $data["id"];
            $res[] = $tmpUser;
        }
        return $res;
    }

    private function GetMessage($id)
    {
        $message = new NewsletterMessage();
        $message->Load($id);
    }

    private function GetMessagesToSend()
    {
        $res = array();
//NIe istnieje rekord Newsletter - ten powstaje gdy wysyłam. 
        $sql = "SELECT M.id FROM NewsLetterMessages M 
                    WHERE NOT EXISTS(SELECT 1 FORM Newsletters WHERE messageId = M.id) ";

        $DBInt = DBSIngleton::getInstance();
        $qResult = $DBInt->ExecQuery($sql);
        while ($data = $qResult->fetchRow(DB_FETCHMODE_ASSOC))
        {
            $tmpMessage = new NewsletterMessage();
            $tmpMessage . Load($data["id"]);
            $res[] = $tmpMessage;
        }
        return $res;
    }

    public function Load($id)
    {

        $sql = "SELECT * FROM Newsletters WHERE id=$id";
        $DBInt = DBSIngleton::getInstance();

        $qResult = $DBInt->ExecQuery($sql);

        $data = $qResult->fetchRow(DB_FETCHMODE_ASSOC);
        $this->id = $id;

        $this->messageId = $data['messageId'];
        $this->sendDate = $data['send_date'];
        $this->log = $data['log'];
    }

    public function SendInfoMail($email)
    {
        $sql = "SELECT id FROM NewsletterUsers WHERE email='$email'";
        $DBInt = DBSIngleton::getInstance();

        $qResult = $DBInt->ExecQuery($sql);

        $data = $qResult->fetchRow(DB_FETCHMODE_ASSOC);
        $id = $data["id"];
        $user = new NewsletterUser();
        $user->Load($id);
        $hash = $user->GenrateUqniueIdent();
        $msg = $this->RenderInfoMessage($hash);

        $mail = new PHPMailer(false); // the true param means it will throw exceptions on errors, which we need to catch
        $mail->IsSMTP(); // telling the class to use SMTP
        $mail->CharSet = "UTF-8";
        try
        {

            $newsConfig = new NewsletterConfig(false);
            $newsConfig->Load();

            $port = $newsConfig->GetPort();
            $smtp = $newsConfig->GetSmtpAdress();
            $pass = $newsConfig->GetSmtpPass();
            $login = $newsConfig->GetSmtpUser();
            $from = $newsConfig->GetFrom();

            $mail->Host = $smtp; // SMTP server
            $mail->SMTPDebug = 2;                     // enables SMTP debug information (for testing)
            $mail->SMTPAuth = false;                  // enable SMTP authentication
            $mail->Port = $port;                 // set the SMTP port for the GMAIL server
            $mail->Username = $login; // SMTP account username
            $mail->Password = $pass;        // SMTP account password
            $mail->SetFrom($from, 'TIK-SOFT Sp. z o.o.');
            $mail->AltBody = 'Mail w formacie HTML. Należy użyć odpowiedniego klienta poczty!'; // optional - MsgHTML will create an alternate automatically

            $mail->Subject = "Rejestracja w Newsletter";
            $mail->MsgHTML($msg);
            $mail->AddAddress($email, "");
            $mail->Send();


            unset($mail);
        }
        catch (phpmailerException $e)
        {
            return 'Dane nie wyslane: ' . $e->errorMessage(); //Pretty error messages from PHPMailer
        }
        catch (Exception $e)
        {
            return 'Dane nie wysłane: ' . $e->getMessage(); //Boring error messages from anything else!
        }
    }

    public function LoadByMessgeId($messId)
    {
        $sql = "SELECT id FROM Newsletters WHERE messageId=$messId ";
        $DBInt = DBSIngleton::getInstance();
        $qResult = $DBInt->ExecQuery($sql);
        $data = $qResult->fetchRow(DB_FETCHMODE_ASSOC);
        $id = $data['id'];
        $this->Load($id);
    }

    public function Send()
    {

        $newsConfig = new NewsletterConfig(false);
        $newsConfig->Load();

        $port = $newsConfig->GetPort();
        $smtp = $newsConfig->GetSmtpAdress();
        $pass = $newsConfig->GetSmtpPass();
        $login = $newsConfig->GetSmtpUser();
        $from = $newsConfig->GetFrom();

        return $this->SendMails($this->id, $smtp, $port, $login, $pass, $from);
    }

    private function RenderInfoMessage($hash)
    {
        $moduleTmp = new ModulesMgr();
        $moduleTmp->loadModule('Newsletter');
        $action = $moduleTmp->getModuleActionIdByName('DeleteUser');

        $smarty = new mySmarty();
        $smarty->assign('hash', $hash);
        $smarty->assign('action', $action);
        return $smarty->fetch('modules/newsletterInfoContent.tpl');
    }

    public function TestSend()
    {

        $newsConfig = new NewsletterConfig(true);

        $newsConfig->Load();

        $port = $newsConfig->GetPort();
        $smtp = $newsConfig->GetSmtpAdress();

        $pass = $newsConfig->GetSmtpPass();
        $login = $newsConfig->GetSmtpUser();
        $from = $newsConfig->GetFrom();


        $mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch
        $mail->CharSet = "UTF-8";
        $mail->IsSMTP(); // telling the class to use SMTP
        try
        {


            $mail->Host = $smtp; // SMTP server
//$mail->SMTPDebug= 2;                     // enables SMTP debug information (for testing)
            $mail->SMTPAuth = true;                  // enable SMTP authentication
            $mail->Port = $port;                 // set the SMTP port for the GMAIL server
            $mail->Username = $username; // SMTP account username
            $mail->Password = $password;        // SMTP account password
            $mail->SMTPAuth = false;

            $mail->SetFrom($from, 'TIK-SOFT Sp. z o.o.');

            $mail->AltBody = 'Mail w formacie HTML. Należy użyć odpowiedniego klienta poczty!'; // optional - MsgHTML will create an alternate automatically


            $deleteFooter = "";


            $newsletterMessage = new NewsletterMessage();
            $newsletterMessage->Load($this->messageId);
            $mail->Subject = $newsletterMessage->GetTitle();
            $userId = -1;
            $msg = $newsletterMessage->Render($userId);

            $mail->MsgHTML($msg);
            $mail->AddAddress("newsletter.test@finka.pl", 'TIK-Soft Sp. z o.o.');

            $mail->Send();
            unset($newsletterMessage);
            unset($mail);

            return "Wysłano";
        }
        catch (phpmailerException $e)
        {
            return 'Dane nie wyslane: ' . $e->errorMessage(); //Pretty error messages from PHPMailer
        }
        catch (Exception $e)
        {
            return 'Dane nie wysłane: ' . $e->getMessage(); //Boring error messages from anything else!
        }
    }

    private function SendMails($newsletterId, $smtp, $port, $username, $password, $from)
    {
        $userObj = new NewsletterUser();        
        $arr = array();
        $arr = $userObj->GetAllUsersId();

        foreach ($arr as $userId)
        {
            

            $user = new NewsletterUser();
            $user->Load($userId);
            
            $mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch
            
            $mail->CharSet = "UTF-8";
            $mail->IsSMTP(); // telling the class to use SMTP
            
            try
            {
                $mail->Host = $smtp; // SMTP server
                $mail->SMTPDebug = false;                     // enables SMTP debug information (for testing)
                $mail->SMTPAuth = false;                  // enable SMTP authentication
                $mail->Port = $port;                 // set the SMTP port for the GMAIL server
                $mail->Username = $username; // SMTP account username
                $mail->Password = $password;        // SMTP account password
                $mail->SetFrom($from, 'TIK-SOFT Sp. z o.o.');
                $mail->AltBody = 'Mail w formacie HTML. Należy użyć odpowiedniego klienta poczty!'; // optional - MsgHTML will create an alternate automatically
                
                $mail->AddAddress($user->GetEmail(),$user->GetEmail());
                
                //$mail->$deleteFooter = "";
                
                $newsletterMessage = new NewsletterMessage();
                $newsletterMessage->Load($this->messageId);
                $mail->Subject = $newsletterMessage->GetTitle();
                $userId = $user->GetId();
                $msg = $newsletterMessage->Render($userId);

                $mail->MsgHTML($msg);
                //mail->AddAddress("pbrodzinski@finka.pl", 'TIK-SOFT Sp. z o.o.');
                $mail->Send();
                
                unset($newsletterMessage);
                unset($mail);
                
            }
            catch (phpmailerException $e)
            {
                echo 'Dane nie wyslane: ' . $e->errorMessage(); //Pretty error messages from PHPMailer
                return 'Dane nie wyslane: ' . $e->errorMessage(); //Pretty error messages from PHPMailer
            }
            catch (Exception $e)
            {
                echo 'Dane nie wysłane: ' . $e->getMessage(); //Boring error messages from anything else!
                return 'Dane nie wysłane: ' . $e->getMessage(); //Boring error messages from anything else!
            }
        }

        return "Wysłano";
    }

}

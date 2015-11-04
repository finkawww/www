<?php

class KontaktHeaderClass
{
	public function Display()
	{
		
		$html = '';
		
		$smarty = new mySmarty();

 		
		$module = new ModulesMgr();
		$module->loadModule('KontaktHeader');
		$action = $module->getModuleActionIdByName('Send');
		unset($module);	

     	$smarty -> assign('action', $action);
	
			//wyswietlam
		$html = $smarty->fetch('modules/KontaktHeader.tpl');

		
		return $html;
	}
	public function Send()
	{
		
		$nazwa = htmlspecialchars($_GET["nazwa"]);
		$nrTel = htmlspecialchars($_GET["nrTel"]);
		$email = htmlspecialchars($_GET["email"]);
		$pytanie = htmlspecialchars($_GET["pytanie"]);
		$msg="<html>
				<head>
				<META HTTP-EQUIV=\"Content-type\" CONTENT=\"text/html; charset=UTF-8\" />
				</head>
				Nazwa: $nazwa<br />Nr tel: $nrTel<br/>Email: $email<br />Pytanie: $pytanie
				</html>";
		
		$mail = new PHPMailer(false); // the true param means it will throw exceptions on errors, which we need to catch
		$mail->IsSMTP(); // telling the class to use SMTP
				
			$mail->Host       = "poczta.finka.pl"; // SMTP server
		  	//$mail->SMTPDebug= 0;                     // enables SMTP debug information (for testing)
		  	$mail->SMTPAuth   = true;                  // enable SMTP authentication
			$mail->CharSet = "UTF-8";
		  	$mail->Port       = "25";                    // set the SMTP port for the GMAIL server
		  	$mail->Username   = "finka"; // SMTP account username
		  	$mail->Password   = "%6&Tik9";        // SMTP account password
		  	$mail->AddAddress("finka@finka.pl", 'TIK-SOFT zapytanie');
		  	$mail->SetFrom("formularz@no-reply", 'Formularz-pytanie on-line');
		  	$mail->Subject = "Zapytanie";
		  	$mail->AltBody = 'Mail w formacie HTML. Należy użyć odpowiedniego klienta poczty!';
			$mail->MsgHTML($msg);
					
		  	$mail->Send();
		
			unset($mail);
			$html = "";
			$html = "zapisane";
			return $html;
		
	}
}
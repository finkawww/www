<?php 
class KontaktOperator
{
	private $host;
	private $port;
	private $username;
	private $password;
	private $nadawca;
	private $subject;
	private $adresyArr = array();
	
	private $mailObj = null;
	
	//pobiera adresy operatorów
	private function GetAdresy()
	{
		$this->adresyArr[] = 'brodzinski@interia.pl';
		 
	}
	
	//ustaiwam wszelkie potrzebne pola klasy
	public function __construct()
	{
		try
		{
			$this->port=0;
			$konfiguracja = new Konfiguracja();
			$this->host = $konfiguracja->GetKontaktOperatorValue('host');
			$this->port = $konfiguracja->GetKontaktOperatorValue('port');
			$this->username = $konfiguracja->GetKontaktOperatorValue('user');
			$this->password = $konfiguracja->GetKontaktOperatorValue('pass');
			$this->nadawca = $konfiguracja->GetKontaktOperatorValue('sender');
			
			$this->GetAdresy();

			$this->mailObj = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch
			$this->mailObj->IsSMTP(); // telling the class to use SMTP
								
			$this->mailObj->Host       = $this->host; // SMTP server
			$this->mailObj->SMTPDebug = 0;
			$this->mailObj->CharSet = "UTF-8";
			
			//$mail->SMTPDebug= 2;                     // enables SMTP debug information (for testing)
			$this->mailObj->SMTPAuth   = true;                  // enable SMTP authentication
			//$this->mailObj->SMTPSecure = "ssl";
			$this->mailObj->Port       = 26;//$this->port;                    // set the SMTP port for the GMAIL server
			$this->mailObj->Username   = 'sklep+finka.pl';//$this->username; // SMTP account username
			$this->mailObj->Password   = 'wirt#$252';//$this->password;        // SMTP account password
			//$this->
			//foreach ($this->adresyArr as $adr)
			//{
			$this->mailObj->AddAddress("finka@finka.pl");
			//}			
			$this->mailObj->SetFrom('sklep@finka.pl');
			$this->mailObj->Subject = $this->subject;
					
		}
		catch(exception $e)
		{
			$action = 0;
			$exc = new ExceptionClass($e, 'KontaktOperator::__construct');
			$dialog = new dialog('Odczyt parametrów XML', $exc->writeException(), 'alert', 200, 100);
			$dialog->setAlign('center');
			$dialog->setOkAction($action);
			$dialog->setOkCaption('Ok');
			echo $dialog->show(1);
		}
	}
	
	public function Send($temat, $msg)
	{
		try
		{
			
			$txtMsg = htmlspecialchars($msg);
			$this->mailObj->AltBody = 'Problem z wyświeltniem treści html: '; // optional - MsgHTML will create an alternate automatically
			$this->mailObj->Subject = $temat;
			$this->mailObj->MsgHTML($msg);
			$this->mailObj->AltBody = $txtMsg;
			$this->mailObj->Send();
			
		}
		catch(exception $e)
		{
			$action=0;
			$exc = new ExceptionClass($e, 'KontaktOperator::Send');
   			$dialog = new dialog('Wysyłanie maila do operatora', $exc->writeException(), 'alert', 200, 100);
			$dialog->setAlign('center');
			$dialog->setOkAction($action);
			$dialog->setOkCaption('Ok');
			echo $dialog->show(1);
		}
		
	}
	
	
	
}
?>
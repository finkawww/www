<?php

  
  function authenticate() {
    header('WWW-Authenticate: Basic realm="Autoryzacja"');
    header('HTTP/1.0 401 Unauthorized');
    echo "Musisz poda� poprawny login i has�o by wej�� na t� stron�\n";
    exit;
  }
	
   if (!isset($_SERVER['PHP_AUTH_USER'])) authenticate(); 
	$login = 'admin';//$_SERVER['PHP_AUTH_USER'];
	$haslo = '251252';//$_SERVER['PHP_AUTH_PW'];

	 session_start();
	if (($Menu==-1)&&($fid!='')) {
		$fid='';
		session_unregister('fid');
		$login='';
		authenticate();
		//exit;
	}

	$sid=session_id();
	if (($login!='admin')||($haslo!='251252')) authenticate();
 ?>
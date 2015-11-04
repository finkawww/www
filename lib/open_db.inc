<?
	error_reporting(0);

	$link = mysql_connect("localhost",'finka_finka','dbfinka99') or die("B³±d podczas ³±czenia z baz± danych !");
	mysql_select_db('finka_finka', $link) or die("Baza danych nie istnieje");
function numform($Number)
{
	return number_format(round($Number,2), 2, ',', ' ')."&nbsp;z³";
}

function frmdate($Data)
{
		if (strlen($Data)>2) {
		$tok = strtok ($Data,"-");
		$Rok = $tok;
		$tok = strtok ("-");
		$Miesiac = $tok;
		$tok = strtok ("-");
	    $Dzien =$tok;
		} else
		{
			$Rok = date("Y");
			$Miesiac = date("m");
			$Dzien = date("d");
		}
	return $Dzien . "-" . $Miesiac . "-" . $Rok;
}

function refrmdate($Data)
{
		if (strlen($Data)>2) {
		$tok = strtok ($Data,"-");
	    $Dzien =$tok;
		$tok = strtok ("-");
		$Miesiac = $tok;
		$tok = strtok ("-");
		$Rok = $tok;
		} else
		{
			$Rok = date("Y");
			$Miesiac = date("m");
			$Dzien = date("d");
		}
	return $Rok . "-" . $Miesiac . "-" . $Dzien;
}

function online_users(){
	global $link,$REMOTE_ADDR,$PHP_SELF;
	$to_secs = 120;
	$t_stamp = time();                                                                                            
	$timeout = $t_stamp - $to_secs; 

	mysql_query("INSERT INTO online_users VALUES ('$t_stamp','$REMOTE_ADDR','$PHP_SELF')",$link); 
	mysql_query("DELETE FROM online_users WHERE timestamp<$timeout",$link) or die("Database DELETE Error");
$result = mysql_query("SELECT DISTINCT ip FROM online_users WHERE file='$PHP_SELF'",$link) or die("Database SELECT Error");
$user = mysql_num_rows($result);

if ($user == 1){
	echo "$user u¿ytkownik online";
} 
else{
	echo "$user u¿ytkowników online";
}
}

function checklogin($uid, $sid)
{
 		 global $link;
	$result = mysql_query("SELECT id_klubowicza FROM sesje WHERE id_klubowicza=$uid AND id_sesji='$sid'", $link);
	return mysql_num_rows($result)==1;
}

	function win2iso($str){
		return strtr($str, "\xA5\x8C\x8F\xB9\x9C\x9F","\xA1\xA6\xAC\xB1\xB6\xBC");
	}

?>
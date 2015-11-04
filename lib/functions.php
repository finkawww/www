<?
	include './lib/open_db.inc';


	$first_left_row=0;
	function menu_focus($m1, $p1, $l1){
		global $m, $p, $l,$first_left_row;
		
		if (!$l1 > 0) return;
		
		if ((($m==$m1)&&($p==$p1)&&($l==$l1))||(($first_left_row==0)&&($l==0))) { $first_left_row=1; return "style=background:'#e1e1e1'; onmouseover=style.cursor='pointer'; onclick=self.location.href='index.php?m=$m1&p=$p1&l=$l1'"; }
		else return "onmouseover=\"this.style.background='#800000'; this.style.color='#FFFFFF';style.cursor='pointer';\" onmouseout=\"this.style.background='#e1e1e1'; style.color='#5b5b5b';\" onclick=\"self.location.href='index.php?m=$m1&p=$p1&l=$l1'\"";
	}

	function getarticle_edit($m, $p, $l, $nadtytul, $tytul){
		global $link;
		$result = mysql_query("SELECT tytul, tresc, kategoria, id_artykulu FROM artykuly WHERE m=$m AND p=$p AND l=$l", $link);
		$row = mysql_fetch_row($result);

		// Tytul
		echo "<table cellpadding=0 cellspacing=0 border=0 width=100%><tr><td align=left width=50%>";
		echo "</td><td class=page_title>$nadtytul</td></tr></table>";
		echo "<div class=page_title_small>$tytul</div>";

		echo file_get_contents('./editor/editor_start.php');
		echo "<form method=post action=index.php><textarea name=editbox>$row[1]</textarea>";
		echo "<input type=hidden name=m value=$m>";
		echo "<input type=hidden name=p value=$p>";
		echo "<input type=hidden name=l value=$l>";
		echo "<input type=hidden name=id value=$row[3]>";
		echo "<input type=hidden name=adm value=1>";
		echo "<br><input type=submit value=Zapisz name=submit></form>";
		echo file_get_contents('./editor/editor_config.php');

		echo '<br><br>';

	}


function generate_pullmenu1() {
	global $link;
	$ret = 'menuBar(new Array(';
	$i=0;
	$result = mysql_query("SELECT id_topmenu, nazwa FROM topmenu ORDER BY pozycja", $link);
	while ($row = mysql_fetch_row($result)){
		$ret.="menuBarItem($i,'','".$row[1]."',"."'./index.php?m=$row[0]&p=0',";
		
		$result1 = mysql_query("SELECT id_pullmenu, nazwa FROM pullmenu WHERE topmenu=$row[0] ORDER BY pozycja", $link);
		if (mysql_num_rows($result1)>0) {
			$ret.='new Array(';
			while ($row1 = mysql_fetch_row($result1)){
				$ret.="menuItem('".$row1[1]."','./index.php?m=$row[0]&p=$row1[0]'),";
			}
			$ret=substr($ret,0,strlen($ret)-1);
			$ret.=')';
		} else 	$ret.="'./index.php?m=$row[0]&p=0'";
		$ret.='),';
		$i++;
	}
	$ret=substr($ret,0,strlen($ret)-1);
	return $ret.'));';
}

function generate_leftmenu1($topmenu, $pullmenu) {
	global $link, $tytul, $nadtytul, $l;
	$tytul='';
	$result = mysql_query("SELECT id_topmenu, nazwa FROM topmenu WHERE id_topmenu=$topmenu", $link);
	while ($row = mysql_fetch_row($result)){
		$result1 = mysql_query("SELECT id_pullmenu, nazwa FROM pullmenu WHERE topmenu=$row[0] ORDER BY pozycja", $link);
		if (mysql_num_rows($result1)>0) 
		while ($row1 = mysql_fetch_row($result1)){
			if (($pullmenu==$row1[0])&&($l!=0)) $nadtytul=$row1[1];
			if (($pullmenu==$row1[0])&&($l==0)) { $nadtytul=$row[1]; $tytul=$row1[1]; }
			if (($pullmenu==0)&&($l==0)) $nadtytul=$row[1];
			if (($pullmenu==0)&&($l==0)&&($tytul=='')) $tytul=$row1[1];

			echo "<tr><td class=menu_left_group ".menu_focus($row[0], $row1[0], $row2[0])."><b>".$row1[1]."</b></td></tr>";
			echo "<tr><td></td><td class=menu_left_item_end style='height=3'></td></tr>";
			$result2 = mysql_query("SELECT id_leftmenu, nazwa FROM leftmenu WHERE (topmenu=$row[0] AND pullmenu=$row1[0])OR(topmenu=$row[0] AND pullmenu=0) ORDER BY pozycja", $link);
			if (mysql_num_rows($result2)>0) 
			while ($row2 = mysql_fetch_row($result2)){
				if (($tytul=='')&&($l<=0)) $tytul=$row2[1];
				if (($tytul=='')&&($l==$row2[0])) $tytul=$row2[1];
				if (($tytul=='')&&($l==0)) $tytul=$row1[1];
				echo "<tr><td class=menu_left_item ".menu_focus($row[0], $row1[0], $row2[0]).">".$row2[1]."</td></tr>";
			} else if (($pullmenu==$row1[0])&&($l==0)) $tytul=$row1[1];
			echo "<tr><td></td><td class=menu_left_item_end style='height=10'></td></tr>";
		} else	{
			$nadtytul=$row[1];
			if ($row1[0]=='') $row1[0]=0;
			echo "<tr><td class=menu_left_group ".menu_focus($row[0], $row1[0], $row2[0])."><b>".$nadtytul."</b></td></tr>";
			echo "<tr><td style='height=3'></td></tr>";
			$result2 = mysql_query("SELECT id_leftmenu, nazwa FROM leftmenu WHERE (topmenu=$row[0] AND pullmenu=0) ORDER BY pozycja", $link);
			while ($row2 = mysql_fetch_row($result2)){
				if (($tytul=='')&&($l!=0)) $tytul=$row2[1];
				if ($l==$row2[0]) $tytul=$row2[1];
				echo "<tr><td class=menu_left_item ".menu_focus($row[0], $row1[0], $row2[0]).">".$row2[1]."</td></tr>";
			}
		}
	}
}


function getarticle($id, $nadtytul, $tytul){
	global $link, $print, $m, $p, $l;

	$result = mysql_query("SELECT tresc FROM artykuly WHERE id_artykulu=$id", $link);
	$row = mysql_fetch_row($result);

	// Tytul
	if ($print!=1) $al='left'; else $al='right';
	echo "<table cellpadding=0 cellspacing=0 border=0 width=100%><tr><td align=$al width=50%>";
	if ($print!=1) echo "<hr size=1 width=200><a href=index.php?m=$m&p=$p&l=$l&print=1 target=_blank><img src=./img/printer.gif hspace=20 border=0></a>";
	if ($print==1) {
		echo "<B><font SIZE=3>TiK-Soft Sp. z o.o.</B></FONT><BR>";
		echo "02-765 Warszawa<BR>";
		echo "Aleja Wilanowska 5 lok. 19<BR>";
		echo "tel./fax (022) 408-48-00<br>tel.: 0-602-274-377, 0-602-274-371<BR>";
		echo "email : <a HREF=mailto:finka@finka.pl>finka@finka.pl</A><BR><hr size=1 width=100%>";
	}
	echo "</td><td class=page_title>$nadtytul</td></tr></table>";
	echo "<div class=page_title_small>$tytul</div>";
	// Tresc
	echo strip_tags(win2iso($row[0]),'<a><b><ul><li><ol><u><i><br><center><right><img><table><td><tr><th><div><hr>');
	echo '<br>';
}

function get_page($m, $p, $l){
	global $link, $Strona, $tytul, $nadtytul;

  $result = mysql_query("SELECT ma.id_artykulu, t.nazwa, p.nazwa, l.nazwa FROM menu_artykul as ma, leftmenu as l, pullmenu as p, topmenu as t WHERE ma.topmenu=$m AND ma.pullmenu=$p AND ma.leftmenu=$l AND t.id_topmenu=ma.topmenu AND p.id_pullmenu=ma.pullmenu AND l.id_leftmenu=ma.leftmenu", $link);
	
  if (mysql_num_rows($result)>0) {
		$row = mysql_fetch_row($result);

		$result = mysql_query("SELECT tytul, data, modul, tresc, parametry FROM artykuly WHERE id_artykulu=$row[0]", $link);
		$row1 = mysql_fetch_row($result);		
		
		//if ($row[1]=='') $nadtytul=$row[2]; else $nadtytul=$row[1];
		//if ($row[3]=='') $tytul=$row[2]; else $tytul=$row[3];
		
		getarticle($row[0],$nadtytul,$tytul);
		$params = $row1[4];
		if ($row1[2]!='') include './modules/'.$row1[2].'.php';
		
		
	} else{
		echo '<center>STRONA W TRAKCIE AKTUALIZACJI<br>ZAPRASZAMY PìNIEJ</center>';
	}
}

?>

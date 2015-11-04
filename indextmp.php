<?php
if ($set_cookie!='') {
setcookie ($set_cookie, 'SET');
}
require './lib/functions.php';
if ($id!=0) 
  $result = mysql_query("UPDATE artykuly SET tresc='$editbox' WHERE id_artykulu=$id", $link);
$idart=0;
if ($Strona=='') 
	$Strona=1;
if ($m=='') 
	$m=2;                // Menu top
if ($p=='') 
	$p=0;                // Menu pulldown
if ($l=='') 
	$l=0;                // Menu left
?>
<html>
<head>
<title>TIKSOFT Programy dla firm i biur rachunkowych</title>
<META HTTP-EQUIV="Content-type" CONTENT="text/html; charset=iso-8859-2">
<META HTTP-EQUIV="Reply-to" CONTENT="finka@finka.pl">
<META HTTP-EQUIV="Content-Language" CONTENT="pl">
<META NAME="Keywords" CONTENT="finka, programy dla firm, program księgowy, program, oprogramowanie dla firm, programy, finanse i księgowość, księgowe, firm, tiksoft, rachunkowe, fk, kady i płace, płacowe, płace, księgowość, książka, przychodów, środki, magazynowy, faktury, fakturowanie">
<META NAME="Description" CONTENT="Programy dla firm i biur rachunkowych.">
<META NAME="Author" CONTENT="TIK-SOFT Sp. z o.o.">
<META NAME="Robots" CONTENT="ALL">
<!-- ::Programy dla Firm, ::Kadry, ::Płace, :: Faktury, :: Podatki, :: Finanse, ::: Księgowość, ::: Gospodarka Materiałowa, ::Budżet -->

        <LINK REL="stylesheet" HREF="style.css" TYPE="text/css">
        <script language="javascript" src="./js/biblioteka.js"></script><script language="javascript" src="./js/pp_menu.js"></script>
        </head>

<body <? if ($print==1) echo "onload=self.print();self.close();"; ?>>

<?
        if ($print!=1) {
?>
<table height="100%" width="950" align="center" border="1" color="#5b5b5b" cellpadding="0" cellspacing="0">
<tr>
<td>
	<table width="950" align="center" border="0" cellpadding="0" cellspacing="0" BGCOLOR="#777777" >
	<tr>
	<td align=center>
	  <img src='head_04.jpg' width="100%" border="0">
	
	
    </td>  
	</tr>
		
	<tr>
    <td colspan="2">
	<script language="JavaScript">
	<!--
	<?
        echo generate_pullmenu1();
	?>
	//-->
	</script>

    </td>
	</tr>

	<?
        }
	?>

	<table width="950" height="100%"  border="0" cellpadding="0" cellspacing="0" ALIGN=CENTER BORDER="1" bgcolor="#fafafa">
	<tr>
        <? if ($print!=1) { ?>
                <td align="center" class=left_panel><? include './modules/menu_left.php'; ?>
                </td>
        <? } ?>
        <td class=right_panel><?
                if ($adm!='1') get_page($m, $p, $l);
        ?>
        <font SIZE="1" color=#EAF3E9>TiK-Soft - Programy dla firm i biur rachunkowych</FONT>
        </td>
		</tr>
	</table>
</tr></td>
</table>	
</body>
</html>
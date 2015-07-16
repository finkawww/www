
<HTML>
	<HEAD>
    	<META HTTP-EQUIV="Content-type" CONTENT="text/html; charset=UTF-8" />
    	<META NAME="Keywords" CONTENT="{$keywords}" />
    	<META HTTP-EQUIV="Content-Language" CONTENT="PL" />
    	<META NAME="Author" CONTENT="{$author}" />
    	<META NAME="Robots" CONTENT="{$robots}" />
    	<META HTTP-EQUIV="Pragma" CONTENT="{$cache}" />
    	<META NAME="Description" CONTENT="{$desc}" />
    	<link rel="shortcut icon" href="/images/ico/favico.ico" type="image/x-icon" />
    	<LINK REL="Stylesheet" HREF="/FrontPage/Style/style.css" TYPE="text/css" />
    	<TITLE>{$title}</TITLE>
		<script type="text/javascript" src="/FrontPage/JS/scripts.js"></script>
		<script type="text/javascript" src="/FrontPage/JS/prototype.js"></script>
		<script type="text/javascript" src="/FrontPage/JS/scriptaculous.js?load=effects,builder"></script>
		<script type="text/javascript" src="/FrontPage/JS/lightbox.js"></script>
		<link rel="stylesheet" href="/FrontPage/JS/css/lightbox.css" type="text/css" media="screen" />
		<link rel="stylesheet" type="text/css" href="/FrontPage/JS/fancybox/jquery.fancybox-1.3.4.css" /> 
		<script type="text/javascript" src="/FrontPage/JS/fancybox/jquery.fancybox-1.3.4.pack.js"></script> 
		<script type="text/javascript" src="/FrontPage/JS/jquery-1.2.6.min.js"></script>


    	
    </HEAD>
	<BODY  bgcolor="white">
<center>
<table class="Content" width="100%" align="center">
<tr><td width="100%">
	<center>

	<table class="MainTbl" bgcolor="#FFFFFF" align="center" width="1000px">
				
		<tr>
			<td colspan="3" width="1000px" align="center" valign="middle">
				<table width="100%">
								<tr>
				<td align="left">				
					 <a href="/"><img src="/FrontPage/Files/Img/finka_logo.jpg" border="0"/></a> 	
				</td>
				<!--
				<td align="right">				
					 <a href="/Zmiany_VAT.htm"><img src="/FrontPage/Files/Img/gorna_belka.jpg" border="0"/></a> 	
				</td>
				-->
				</tr>
				<tr>
					<td colspan="2">				
					  	{$topMenu}<font face="Tahoma" font color="#454545">{$PokazKoszykStatus}
					</td>
				</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td valign="top" width="210px">			
				<table>
					<tr><td width="210px">
					{$leftMenu}<br>
					</td></tr>
					<!--
					<tr><td>
						<a href="?mp=103"><img src="/FrontPage/Files/Img/kontakt.jpg" border="0" align="left"></a>
					</td></tr>
					<tr><td>{$KontaktHeader}</td></tr>
					-->
				</table>	
			</td>
		
			<td valign="top" width = "600px" height="500" bgcolor="white">
				<table>
					
					<tr><td>{$content}</td></tr>
				</table>
			</td>
			
			<td valign="top" width="210px">
				<table width="210px">

					<tr><td width="210px">{$menuRight}</td></tr>
					<tr><td>
					<br><a href="/index.php?mp=47"><img src="./FrontPage/Files/Img/baner_promocje.png" border="0"></a><br><br>
					<a href="/index.php?mp=45"><img src="./FrontPage/Files/Img/baner_demo.png" border="0"></a><BR><BR>
				</td></tr>
				</table>
			</td>
		
		<tr>
			<td colspan="3" width="*" align="center">{$menuBottom}</td>
		</tr>
	<table>	
	</center>
</td></tr>
<tr><td width="100%" align="center"><a href="http://www.payu.pl"><img src="./images/banki.jpg" border="0"></td></tr>
</table>
</center>
   	</BODY>
</HTML>


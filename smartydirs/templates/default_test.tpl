
<HTML>
	<HEAD>
    	<META HTTP-EQUIV="Content-type" CONTENT="text/html; charset=UTF-8" />
    	<META NAME="Keywords" CONTENT="{$keywords}" />
    	<META HTTP-EQUIV="Content-Language" CONTENT="PL" />
    	<META NAME="Author" CONTENT="{$author}" />
    	<META NAME="Robots" CONTENT="{$robots}" />
    	<META HTTP-EQUIV="Pragma" CONTENT="{$cache}" />
    	<META NAME="Description" CONTENT="{$desc}" />
		<meta name=viewport content="width=device-width, initial-scale=1">
    	<link rel="shortcut icon" href="/images/ico/favico.ico" type="image/x-icon" />
    	<LINK REL="Stylesheet" HREF="/FrontPage/Style/style.css" TYPE="text/css" />
    	<TITLE>{$title}</TITLE>
                <script type="text/javascript" src="/FrontPage/JS/jquery-1.7.1.min.js"></script>
		<script type="text/javascript" src="/FrontPage/JS/scripts.js"></script>
		<script type="text/javascript" src="/FrontPage/JS/prototype.js"></script>
		<script type="text/javascript" src="/FrontPage/JS/scriptaculous.js?load=effects,builder"></script>
		<script type="text/javascript" src="/FrontPage/JS/lightbox.js"></script>
		<link rel="stylesheet" href="/FrontPage/JS/css/lightbox.css" type="text/css" media="screen" />

		<link rel="stylesheet" type="text/css" href="/FrontPage/JS/fancybox/jquery.fancybox-1.3.4.css" /> 
		<script type="text/javascript" src="/FrontPage/JS/fancybox/jquery.fancybox-1.3.4.pack.js"></script> 
    		
    </HEAD>
	<BODY  bgcolor="white">
<center>
<table class="Content" width="100%" align="center">
<tr><td width="100%">
	<center>
	<table class="MainTbl" bgcolor="#FFFFFF" align="center" width="1000">
		
		<tr>
			<td height="100" colspan=2>
				<a href="/">
				<img src="/FrontPage/Files/Img/baner_gora.jpg" width="1000" border="0"/>
				</a>
			</td>
		</tr>
		
		<tr>
			<td colspan=2 width="100%" align = "center" valign="middle">
				<table>
				<tr>
					<td>				
					  	{$topMenu}{$PokazKoszykStatus}
					</td>
				</tr>
				</table>
			</td>
		</tr>
		<tr><td></td></tr>
		<tr><td></td></tr>
		<tr>
			<td valign="top" width="200">	
				<TABLE><tr><td>
		
				{$leftMenu}
				</td></tr>
				<tr><Td>
					<br><br><a href="/index.php?mp=103"><img src="/images/twarz_finki.png" border="0"></a><br>					<!--<a href="http://tiksoft.idhost.pl/index.php?mp=95"><img src="./images/search.jpg" border="0"></a><br>--><br>
					<a href="/index.php?mp=49"><img src="/images/oferta_wstep1.png" border="0"></a><br><br>
					<a href="/index.php?mp=48"><img src="/images/oferta_wstep2.png" border="0"></a>
					
				</td></tr>
				</table>

			</td>
		
			<td valign="top" width = "800" height="500" bgcolor="white">
				<table>
					
					<tr><td>{$content}</td></tr>
				</table>
			</td>
		
	</table>	
	</center>
</td></tr>
<tr>
<td colspan="2" width="*" align="center"><br>{$menuBottom}</td>
<td colspan="2" width="*" align="center"><br>{$Newsletter}</td>
</tr>
<tr><td width="100%" align="center" colspan="2"><a href="http://www.payu.pl" rel="nofollow"><img src="/images/banki.jpg" border="0" alt="payu"></a></td></tr>
</table>
</center>
   	</BODY>
</HTML>


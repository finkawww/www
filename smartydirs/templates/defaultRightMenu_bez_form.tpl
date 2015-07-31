<!DOCTYPE HTML>
<html lang="PL-pl">
	<head>
		<meta charset="UTF-8">
    	<meta name="keywords" content="{$keywords}" />
    	<meta name="author" content="{$author}" />
    	<meta name="robots" content="{$robots}" />
    	<meta http-equiv="pragma" content="{$cache}" />
    	<meta name="description" content="{$desc}" />
    	<link rel="shortcut icon" href="/images/ico/favico.ico" type="image/x-icon" />

    	<link rel="stylesheet" href="/FrontPage/Style/newstyle.css" type="text/css" />
		<link rel="stylesheet" href="/FrontPage/JS/css/lightbox.css" type="text/css" media="screen" />
		<link rel="stylesheet" type="text/css" href="/FrontPage/JS/fancybox/jquery.fancybox-1.3.4.css" /> 
    	<title>{$title}</title>
		<script type="text/javascript" src="/FrontPage/JS/scripts.js"></script>
		<script type="text/javascript" src="/FrontPage/JS/prototype.js"></script>
		<script type="text/javascript" src="/FrontPage/JS/scriptaculous.js?load=effects,builder"></script>
		<script type="text/javascript" src="/FrontPage/JS/lightbox.js"></script>
		<script type="text/javascript" src="/FrontPage/JS/fancybox/jquery.fancybox-1.3.4.pack.js"></script> 
		<script type="text/javascript" src="/FrontPage/JS/jquery-1.7.1.min.js"></script>
		<script type="text/javascript" src="/FrontPage/JS/jquery.cycle.all.pack.js"></script>
		<script type="text/javascript" src="/FrontPage/JS/cookies.js"></script>
	</head>
	<body>
	
	<div id="wrapper">
	<div id="logo">
			<div id="main-logo"><a href="/"><img src="/FrontPage/Files/Img/finka_logo.jpg" border="0"/></a></div>
			<div id="facebook-top"><a href="https://www.facebook.com/programyFINKA"><img src="/FrontPage/Files/Img/fb_finka.png" border="0" title="Dołącz do fanów Tik-Soft na FaceBook'u"></a></div>
		</div>
		<div id="menu-box">
			<div id="topmenu">{$topMenu}</div>
			<div id="topcart">{$PokazKoszykStatus}</div>
		</div>
	<div style="float:left">	
	
<center>
<table class="Content" width="100%" align="center">
<tr><td width="100%">
	<center>

	<table class="MainTbl" bgcolor="#FFFFFF" align="center" width="1000px">
				
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
</div>
</div>
	</body>
</html>


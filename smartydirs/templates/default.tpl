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
    	<title>{$title}</title>
		<script type="text/javascript" src="/FrontPage/JS/jquery-1.7.1.min.js"></script>
		<script type="text/javascript" src="/FrontPage/JS/fancybox/jquery.fancybox-1.3.4.pack.js"></script> 
		<script type="text/javascript" src="/FrontPage/JS/jquery.cycle.all.pack.js"></script>
		<script type="text/javascript" src="/FrontPage/JS/scripts.js"></script>
		<script type="text/javascript" src="/FrontPage/JS/prototype.js"></script>
		<script type="text/javascript" src="/FrontPage/JS/scriptaculous.js?load=effects,builder"></script>
		<script type="text/javascript" src="/FrontPage/JS/lightbox.js"></script>
		<script type="text/javascript" src="/FrontPage/JS/cookies.js"></script>
		<link rel="stylesheet" href="/FrontPage/JS/css/lightbox.css" type="text/css" media="screen" />
		<link rel="stylesheet" type="text/css" href="/FrontPage/JS/fancybox/jquery.fancybox-1.3.4.css" /> 
	</head>
	<body>
		{literal}
		<!-- Google Tag Manager -->
			<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-TH7HWQ"
			height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
			<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
			new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
			j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
			'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
			})(window,document,'script','dataLayer','GTM-TH7HWQ');</script>
			<!-- End Google Tag Manager -->
		{/literal}
	<div id="wrapper" class="baza">
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

<!--
		<tr>
			<td colspan="3" >
			<div class="pics" id="banerSlider">
					<a href="./Programy.htm"><img src="/FrontPage/Files/Img/baner_gora1.jpg" width="800" border="0"/></a>
					<a href="./Promocje.htm"><img src="/FrontPage/Files/Img/baner_gora2.jpg" width="800" border="0"/></a>
					<a href="./WersjeProbne.htm"><img src="/FrontPage/Files/Img/baner_gora3.jpg" width="800" border="0"/></a>			
			</div>
			</td>	
			<td valign="top"><img src="/FrontPage/Files/Img/kontakt.jpg" border="0"></td>
		</tr>
-->		

		<tr><td></td></tr>
		<tr><td></td></tr>
		<tr>
			<td valign="top" width="210px">	
				<table>
					<tr><td width="210px">
					{$leftMenu}<br>
					</td></tr>
					<tr><td>
						<div class="font_sm"><big>Nasi Konsultanci</big><br /> 22 408 48 00<br />22 885 66 99
						</div>
					</td></tr>
					<tr><td>
						<div class="font_kontakt">Masz pytanie? Napisz<br />{$KontaktHeader}<br /><br /></div>
					</td></tr>
				</table>	
			</td>
		
		
			<td valign="top" width ="610px" height="500" bgcolor="white">
				<table>
					
					<tr><td>{$content}</td></tr>
				</table>
			</td>
		
	</table>	
	</center>
</td></tr>
<tr>
<td colspan="2" width="*" align="center"><br>{$menuBottom}</td>
</tr>
<tr><td width="100%" align="center" colspan="2"><a href="http://www.payu.pl" rel="nofollow"><img src="/images/banki.jpg" border="0" alt="payu"></a></td></tr>
</table>
</center>
	{literal}
		<script type="text/javascript">$('#banerSlider').cycle({fx:'fade',random:1,delay:-300,width:800,height:266});</script> 
	{/literal}
	</div>
	</div>
	</body>
</html>
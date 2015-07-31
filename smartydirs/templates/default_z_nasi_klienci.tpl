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

	<div id="wrapper" class="oferta-main">
<div id="logo">
			<div id="main-logo"><a href="/"><img src="/FrontPage/Files/Img/finka_logo.jpg" border="0"/></a></div>
			<div id="facebook-top"><a href="https://www.facebook.com/programyFINKA"><img src="/FrontPage/Files/Img/fb_finka.png" border="0" title="Dołącz do fanów Tik-Soft na FaceBook'u"></a></div>
		</div>
		<div id="menu-box">
			<div id="topmenu">{$topMenu}</div>
			<div id="topcart">{$PokazKoszykStatus}</div>
		</div>
	<div style="float:left">	
<table class="Content" width="100%" align="center">
<tr><td width="100%">
	
	<table class="MainTbl" bgcolor="#FFFFFF"  width="1000px" align="center">

		<tr><td></td></tr>
		<tr><td></td></tr>
		<tr>
			<td valign="top" width="210px">	

				<table align="left">
					<tr><td width="210px">
					{$leftMenu}<br>
					</td></tr>

					<tr><td>
						<div class="font_sm_left_small">	
							<center><big><b>Zapewniamy:</b></big></center><br/>
								<img src="./FrontPage/Files/Img/ptaszek.png" border="0">&nbsp;bieżące aktualizacje</br>
								<img src="./FrontPage/Files/Img/ptaszek.png" border="0">&nbsp;rozwój funkcjonalności</br>
								<img src="./FrontPage/Files/Img/ptaszek.png" border="0">&nbsp;wsparcie techniczne <br/>i merytoryzne</br>
								<img src="./FrontPage/Files/Img/ptaszek.png" border="0">&nbsp;zintegrowaną współpracę <br/>programów FINKA</br>
								<img src="./FrontPage/Files/Img/ptaszek.png" border="0">&nbsp;wdrożenia i szkolenia<br/>
								<img src="./FrontPage/Files/Img/ptaszek.png" border="0">&nbsp;program w kilku pakietach<br/>
								
								
												
						</div>
						<br/>
					</td></tr>
					<tr><td>
						<div class="font_sm_left">	
						<img src="./FrontPage/Files/Img/ikona_firma.png" border="0" hspace="0" vspace="0">&nbsp; &nbsp;<a class="jump" href="./Uslugi_abonamentowe.htm">  Opieka posprzedażna </a><br/>
						<img src="./FrontPage/Files/Img/ikona_firma.png" border="0" hspace="0" vspace="0">&nbsp; &nbsp; <a class="jump" href="./O_firmie.htm"> O firmie TIK-SOFT</a></br>
						 <img src="./FrontPage/Files/Img/ikona_kontakt.png" border="0" hspace="0" vspace="0">&nbsp;  &nbsp;<a class="jump" href="./KontaktONAS.htm"> Kontakt z Konsultantem</a></br>
						</div>
						<br/>
					</td></tr>
					
					<tr><td>
						<div class="font_sm_left_small">
						<center>
						<big><b>Aktualne promocje</b><big><br/>	<br/>
						<a href="./Promocje.htm"><img src="./FrontPage/Files/Img/baner_nowe_firmy.png" border="0" hspace="0" vspace="0"></a>
						</center>
						</div>
					</td></tr>
				</table>		
			</td>
		
		
			<td valign="top" width ="610px" height="500" bgcolor="white">
				<table>
					
					<tr><td>{$content}</td></tr>
				</table>
			</td>
		
	</table>	
	
</td></tr>
<tr>
<td colspan="2" width="*" align="center"><br>{$menuBottom}</td>
</tr>
<tr><td width="100%" align="center" colspan="2"><a href="http://www.payu.pl"><img src="./images/banki.jpg" border="0"></a></td></tr>
</table>
</div>
	</div>
	{literal}
		<script type="text/javascript">$('#banerSlider').cycle({fx:'fade',random:1,delay:-300,width:800,height:266});</script> 
	{/literal}
	</body>
</html>




					
				
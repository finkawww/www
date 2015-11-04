<!DOCTYPE html>
<html lang="pl-PL">
	<!--[if IE 7]><html lang="pl" class="ie7"><![endif]-->
	<!--[if IE 8]><html lang="pl" class="ie8"><![endif]-->
	<!--[if IE 9]><html lang="pl" class="ie9"><![endif]-->
	<!--[if (gt IE 9)|!(IE)]><html lang="pl"><![endif]-->
	<!--[if !IE]><html lang="pl-PL"><![endif]-->
	<head>
		<meta charset="UTF-8">
    	<meta name="keywords" content="{$keywords}" />
    	<meta name="author" content="{$author}" />
    	<meta name="robots" content="{$robots}" />
    	<meta http-equiv="pragma" content="{$cache}" />
    	<meta name="description" content="{$desc}" />
		<meta name=viewport content="width=device-width, initial-scale=1">
    	<link rel="shortcut icon" href="/images/ico/favico.ico" type="image/x-icon" />
    	<link rel="stylesheet" href="/FrontPage/Style/newstyle.css" type="text/css" />
    	<link rel="stylesheet" href="/FrontPage/Style/responsive.css" type="text/css" />
    	<title>{$title}</title>
		<script type="text/javascript" src="/FrontPage/JS/jquery-1.7.1.min.js"></script>
		<script type="text/javascript" src="/FrontPage/JS/jquery.cycle.all.pack.js"></script>
		<script type="text/javascript" src="/FrontPage/JS/cookies.js"></script>
		<script type="text/javascript" src="/FrontPage/JS/scripts.js"></script>
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

	<noscript>
	<div style="padding-top: 10px; height: 60px; width: 100%;background: #dddddd;line-height: 24px; 
	text-align: center; color: #042E64;font-size: 14px; font-family: sans-serif; font-weight: bold; 
	text-shadow: 0 1px 0 #94CAFF;  box-shadow: 0 0 15px #00214B; position: fixed; bottom: 0; z-index: 999">
	<div style="text-align: center; margin: auto; width: 960px;line-height: 24px">
	Strona korzysta z plik?w cookies w celu realizacji us?ug i zgodnie
	z <a style="text-decoration: underline" target="_blank" href="http://www.finka.pl/FrontPage/Files/OtherFiles/polityka_plikow_cookies.pdf">Polityk? Plik?w Cookies</a>.
	Mo?esz okre?li? warunki przechowywania lub dost?pu do plik?w cookies w Twojej przegl?darce. 
	</div>
	</div>
	</noscript>
	
	<div id="wrapper">
		<div id="logo">
			<div id="main-logo"><a href="/"><img src="/FrontPage/Files/Img/finka_logo.jpg" border="0"/></a></div>
			<div id="facebook-top"><a href="https://www.facebook.com/programyFINKA"><img src="/FrontPage/Files/Img/fb_finka.png" border="0" title="Dołącz do fanów Tik-Soft na FaceBook'u"></a></div>
		</div>
		<div id="menu-box">
			<div id="topmenu">{$topMenu}</div>
			<div id="topcart">{$PokazKoszykStatus}</div>
		</div>
		<div id="slider-box">
			<div id="slider">
				<div id="banerSlider">
					<a href="/promocje/" rel="nofollow"><img src="/FrontPage/Files/Img/promo_RABAT 15.png" width="800" border="0"/></a>		
					<a href="/oferta/" rel="nofollow"><img src="/FrontPage/Files/Img/baner_gora1.jpg" width="800" border="0"/></a>
					<a href="/wersje-probne/" rel="nofollow"><img src="/FrontPage/Files/Img/baner_gora3.jpg" width="800" border="0"/></a>
				</div>
			</div>
			<div id="slider-kontakt">
				<div class="font_sm"><big>Nasi Konsultanci</big><br /> 22 408 48 00<br />22 885 66 99</div>
				<div class="font_sm" style="margin-top: 10px;">
					{$KontaktHeader}
					<br/><br/>
				</div>
			</div>
		</div>
		<div id="content">
			{$content}
		</div>
		<div id="bottomMenu">
			{$menuBottom}
		</div>
		<div id="payment-img">
			<a href="http://www.payu.pl" rel="nofollow"><img src="/./images/banki.jpg" border="0" alt="payu">
		</div>
	</div>
	{literal}
		<script type="text/javascript">$('#banerSlider').cycle({fx:'fade',random:1,delay:-300,width:800,height:266, fit:1});</script> 
	{/literal}
	<script type='text/javascript'>
		var src = (('https:' == document.location.protocol) ? 'https://' : 'http://');
		new Image().src = src+'adsearch.adkontekst.pl/deimos/tracking/?tid=103377&reid=1387&expire=720&nc='+new Date().getTime();
	</script>
</body>
</html>